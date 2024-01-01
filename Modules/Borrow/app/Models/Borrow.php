<?php

namespace Modules\Borrow\app\Models;

use App\Models\WebsiteModel as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Borrow extends Model
{
    use HasFactory;

    protected $table = 'borrows';
    const ACTIVE    = 1;
    const INACTIVE  = 0;
    const DRAFT     = -1;
    const CANCELED     = -2;
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'borrow_date',
        'status'
    ];

    // Ovrride
    public static function updateItem($id,$request){
        $item = self::findItem($id);
        if($request->borrow_date){
            $item->borrow_date = $request->borrow_date;
        }
        if($request->status !== ''){
            $item->status = $request->status;
        }
        $item->save();

        
        // Xóa tiết dạy
        if( $request->task == 'delete-tiet' && $request->tiet !== NULL ){
            $tiet = $request->tiet;
            $item->borrow_devices()->where('tiet',$tiet)->delete();
        }

        // Xóa thiết bị
        if( $request->task == 'delete-device' && $request->tiet !== NULL && $request->device_id !== NULL ){
            $tiet = $request->tiet;
            $device_id = $request->device_id;
            $borrow_devices = $item->borrow_devices()->where('tiet',$tiet);
            if($borrow_devices->count() > 1){
                $borrow_devices->where('device_id',$device_id)->delete();
            }else{
                $borrow_devices->update([
                    'device_id' => 0
                ]);
            }
        }
        // Chọn phòng bộ môn
        // Thêm thiết bị
        if( $request->devices && in_array($request->task,['add-device']) ){
            $index = 0;
            foreach( $request->devices as $tiet => $device ){
                $tiet = $index;
                $device['borrow_date'] = $item->borrow_date;
                $device['tiet'] = $tiet;
                $item->borrow_devices()->updateOrCreate([
                    'tiet' => $tiet,
                    'device_id' => $device['device_id'] ?? 0,
                ],$device);
                if( !empty($device['lab_id']) ){
                    $item->borrow_devices()->where('tiet',$tiet)->update([
                        'lab_id' => $device['lab_id']
                    ]);
                }
                $index++;
            }
        }
        // Lưu yêu cầu
        if( $request->devices && in_array($request->task,['save-form','save-draft']) ){
            $number_tiets = range(1, 10);
            $active_tiets = [];
            foreach( $request->devices as $tiet => $device ){
                $active_tiets[] = $tiet;
                $item->borrow_devices()->where('tiet',$tiet)->update([
                    'lesson_name' => $device['lesson_name'],
                    'session' => $device['session'],
                    'lecture_name' => $device['lecture_name'],
                    'room_id' => $device['room_id'],
                    'lecture_number' => $device['lecture_number'],
                    'lab_id' => $device['lab_id']
                ]);
            }
        }
        // Thêm tiết dạy mới
        if( $request->devices && $request->task == 'add-tiet' ){
            $request_arr = $request->toArray();
            $request_devices = $request_arr['devices'];
            $tiet = end($request_devices)['tiet'];
            $borrow_devices = $item->borrow_devices()->where('tiet',$tiet)->get()->toArray();
            foreach( $borrow_devices as $borrow_device ){
                unset($borrow_device['id']);
                $borrow_device['tiet'] = $tiet + 1;
                $item->borrow_devices()->create($borrow_device);
            }
        }
        return $item;
    }
    public static function deleteItem($id){
        $item = self::findItem($id);
        // $item->borrow_devices()->delete();
        $item->deleted_at = date('Y-m-d H:i:s');
        return $item->save();
        // return self::deleteItem($id);
    }

    // Relationships
    public function borrow_devices(){
        return $this->hasMany(BorrowDevice::class);
    }

    public function getBorrowItemsAttribute(){
        $item = self::findItem($this->id);
        $results = [];
        if( count($item->borrow_devices) ){
            foreach( $item->borrow_devices as $borrow_device ){
                $results[$borrow_device->tiet][] = $borrow_device;
            }
        }
        return $results;
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    // Attributes
    public function getBorrowDateFmAttribute(){
        return $this->borrow_date ?  date('d-m-Y',strtotime($this->borrow_date)) : '';
    }
    public function getCreatedAtFmAttribute(){
        return $this->created_at ?  date('d-m-Y H:i',strtotime($this->created_at)) : '';
    }
    public function getUserNameAttribute(){
        return $this->user->name ?? 'Chưa xác định';
    }
    public function getNumberDevicesAttribute(){
        return $this->borrow_devices ? $this->borrow_devices->count() : 0;
    }
    public function getLabNamesAttribute(){
        $lab_ids = $this->borrow_devices->pluck('lab_id','lab_id');
        $names = '';
        if($lab_ids){
            $lab_ids = $lab_ids->toArray();
            $labs = \App\Models\Lab::whereIn('id',$lab_ids)->pluck('name')->toArray();
            $names = implode('<br>',$labs);
        }
        return $names;
    }
    public function getDeviceNamesAttribute(){
        $device_ids = $this->borrow_devices->pluck('device_id','device_id');
        $names = '';
        if($device_ids){
            $device_ids = $device_ids->toArray();
            $labs = \App\Models\Device::whereIn('id',$device_ids)->pluck('name')->toArray();
            $names = implode('<br>',$labs);
        }
        return $names;
    }
    public function getStatusFmAttribute(){
        switch ($this->status) {
            case self::DRAFT:
                return '<span class="lable-table bg-danger-subtle text-danger rounded border border-danger-subtle font-text2 fw-bold">Phiếu Nháp</span>';
                break;
            case self::ACTIVE:
                return '<span class="lable-table bg-success-subtle text-success rounded border border-success-subtle font-text2 fw-bold">Đã Xét Duyệt</span>';
                break;
            case self::INACTIVE:
                return '<span class="lable-table bg-warning-subtle text-warning rounded border border-warning-subtle font-text2 fw-bold">Chờ Xét Duyệt</span>';
                break;
            case self::CANCELED:
                return '<span class="lable-table bg-dark-subtle text-warning rounded border border-dark-subtle font-text2 fw-bold">Đã Hủy</span>';
                break;
        }
    }
    
}
