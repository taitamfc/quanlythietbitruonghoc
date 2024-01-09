<?php

namespace Modules\Borrow\app\Models;

use App\Models\WebsiteModel as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\CarbonPeriod;
class Borrow extends Model
{
    use HasFactory;

    protected $table = 'borrows';
    const ACTIVE    = 1; //Đã duyệt
    const INACTIVE  = 0; //Chờ duyệt
    const DRAFT     = -1; //Nháp
    const CANCELED     = -2;//Đã hủy
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'borrow_date',
        'status'
    ];

    // Ovrrides
    public static function updateItem($id,$request){
        $item = self::findItem($id);
        if($request->borrow_date){
            $item->borrow_date = $request->borrow_date;
        }
        if($request->status !== ''){
            $item->status = $request->status;
        }
        dd($item->status);
        $item->save();

        
        // Xóa tiết dạy
        if( $request->task == 'delete-tiet' && $request->tiet !== NULL ){
            $tiet = $request->tiet;
            $item->borrow_devices()->where('tiet',$tiet)->delete();
        }

        // Thay đổi số lượng thiết bị
        if( $request->task == 'change-qty-device' && $request->tiet !== NULL && $request->device_id !== NULL ){
            $qty = $request->qty;
            $tiet = $request->tiet;
            $device_id = $request->device_id;
            $borrow_devices = $item->borrow_devices()
            ->where('tiet',$tiet)
            ->where('device_id',$device_id)
            ->update([
                'quantity' => $qty
            ]);
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
        if( $request->devices && in_array($request->task,['add-lab','show-labs']) ){
            foreach( $request->devices as $tiet => $device ){
                $borrow_devices = $item->borrow_devices()->where('tiet',$tiet);
                // Nếu có phòng thì cập nhật phòng, không thì tạo mới thiết bị rỗng
                if($borrow_devices->count()){
                    $borrow_devices->update([
                        'lab_id' => $device['lab_id'] ?? 0,
                        'lesson_name' => $device['lesson_name'],
                        'session' => $device['session'],
                        'lecture_name' => $device['lecture_name'],
                        'room_id' => $device['room_id'],
                        'lecture_number' => $device['lecture_number'],
                        'borrow_date' => $item->borrow_date,
                    ]);
                }else{
                    $borrow_devices->create([
                        'lesson_name' => $device['lesson_name'],
                        'session' => $device['session'],
                        'lecture_name' => $device['lecture_name'],
                        'room_id' => $device['room_id'],
                        'lecture_number' => $device['lecture_number'],
                        'lab_id' => $device['lab_id'],
                        'borrow_date' => $item->borrow_date,
                    ]);
                }
            }
        
        }
        // Xóa phòng bộ môn
        if( $request->devices && in_array($request->task,['delete-lab']) ){
            $tiet   = $request->tiet;
            $borrow_devices = $item->borrow_devices()->where('tiet',$tiet)->update([
                'lab_id' => 0
            ]);
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
                // Nếu thêm thiết bị thì xóa dữ liệu phòng bộ môn
                if( !empty($device['device_id']) ){
                    $item->borrow_devices()->where('tiet',$tiet)->where('device_id',0)->delete();
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
                    'lab_id' => $device['lab_id'],
                    'borrow_date' => $item->borrow_date
                ]);
            }

            // Xử lý phiếu có thiết bị + phòng bộ môn
            if( count($active_tiets) ){
                foreach( $active_tiets as $active_tiet ){
                    $number_devices = $item->borrow_devices()
                    ->where('tiet',$tiet)
                    ->count();
                    if( $number_devices > 1 ){
                        $item->borrow_devices()->where('tiet',$tiet)->where('device_id',0)->delete();
                    }
                }
            }

            // Hook xử lý sự kiện sau khi phiếu mượn tạo thành công
            if($request->task == 'save-form'){
                \App\Events\BorrowCreated::dispatch($item);
            }
        }
        
        return $item;
    }
    public static function deleteItem($id){
        $item = self::findItem($id);
        $item->borrow_devices()->delete();
        return $item->delete();
    }

    // Relationships
    public function borrow_devices(){
        return $this->hasMany(BorrowDevice::class);
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    // Attributes
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
                return '<span class="lable-table bg-success-subtle text-success rounded border border-success-subtle font-text2 fw-bold">Đã Duyệt</span>';
                break;
            case self::INACTIVE:
                return '<span class="lable-table bg-warning-subtle text-warning rounded border border-warning-subtle font-text2 fw-bold">Chờ Duyệt</span>';
                break;
            case self::CANCELED:
                return '<span class="lable-table bg-dark-subtle text-warning rounded border border-dark-subtle font-text2 fw-bold">Đã Hủy</span>';
                break;
        }
    }

    public function getCanEditAttribute(){
        $permissions = self::getPermissions();
        if(
            ($this->status == self::ACTIVE && $permissions['allow_edit_approved']) ||
            ($this->status == self::INACTIVE && $permissions['allow_edit_pending']) ||
            $this->status == self::DRAFT ||
            $this->status == self::CANCELED 
        ){
            return true;
        }
        return false;
    }
    public function getCanDeleteAttribute(){
        $permissions = self::getPermissions();
        if(
            ($this->status == self::ACTIVE && $permissions['allow_delete_approved']) ||
            ($this->status == self::INACTIVE && $permissions['allow_delete_pending']) ||
            $this->status == self::DRAFT ||
            $this->status == self::CANCELED 
        ){
            return true;
        }
        return false;
    }

    // Custom methods
    public static function getBorrowedLabs($request){
        $items = [];
        if( $request->week ){
            $startDayEndDate = self::getStartEndDateFromWeek($request->week);
            $periods = CarbonPeriod::create($startDayEndDate['startDate'],$startDayEndDate['endDate']);
            foreach ($periods as $date) {
                $date = $date->format('Y-m-d');
                $items[$date] = [];
                for($i = 1; $i <= 10; $i++){
                    $tietTKB = $i;
                    $session = 'Sáng';
                    if( $i > 5 ){
                        $session = 'Chiều';
                        $tietTKB = $i - 5;
                    }
                    $borrow_labs = BorrowDevice::select(['borrow_id','lab_id','session','lecture_number'])->where('borrow_date',$date);
                    $borrow_labs->where('lecture_number',$tietTKB);
                    $borrow_labs->where('session',$session);
                    $borrow_labs->where('lab_id','>',0);

                    if($request->session){
                        $session = $request->session == 'AM' ? 'Sáng' : 'Chiều';
                        $borrow_labs->where('session',$session);
                    }
                    if($request->lab_id){
                        $borrow_labs->where('lab_id',$request->lab_id);
                    }
                    if($request->department_id){
                        $borrow_labs->whereHas('device',function($query) use($request){
                            $query->where('department_id',$request->department_id);
                        });
                    }
                    if($request->user_id){
                        $borrow_labs->whereHas('borrow.user',function($query) use($request){
                            $query->where('user_id',$request->user_id);
                        });
                    }
                    $borrow_labs->whereHas('borrow',function($query) use($request){
                        $query->where('status','>',0);
                    });

                    $borrow_labs = $borrow_labs->get();

                    $labs = [];
                    foreach( $borrow_labs as $borrow_lab ){
                        $labs[] = [
                            'borrow_id' => $borrow_lab->borrow_id,
                            'lab_id'    => $borrow_lab->lab_id,
                            'session'    => $borrow_lab->session,
                            'lecture_number'    => $borrow_lab->lecture_number,
                            'lab_name'  => $borrow_lab->lab->name ?? '',
                            'user_name'  => $borrow_lab->borrow->user->name ?? '',
                        ];
                    }
                    $items[$date][$i] = [
                        'labs' => $labs
                    ];

                }
            }
        }
        return $items;
    }
    // Lấy danh sách phòng mượn theo tuần
    public static function getBorrowedLab($request){
        $items = [];
        if( $request->week && $request->lab_id ){
            $startDayEndDate = self::getStartEndDateFromWeek($request->week);
            $periods = CarbonPeriod::create($startDayEndDate['startDate'],$startDayEndDate['endDate']);
            foreach ($periods as $date) {
                $date = $date->format('Y-m-d');
                $items[$date] = [];
                for($i = 1; $i <= 10; $i++){
                    $tietTKB = $i;
                    $session = 'Sáng';
                    if( $i > 5 ){
                        $session = 'Chiều';
                        $tietTKB = $i - 5;
                    }
                    $borrow_labs = BorrowDevice::select(['borrow_id','lab_id','session','lecture_number'])->where('borrow_date',$date);
                    $borrow_labs->where('lecture_number',$tietTKB);
                    $borrow_labs->where('session',$session);
                    $borrow_labs->where('lab_id','>',0);

                    if($request->session){
                        $session = $request->session == 'AM' ? 'Sáng' : 'Chiều';
                        $borrow_labs->where('session',$session);
                    }
                    if($request->lab_id){
                        $borrow_labs->where('lab_id',$request->lab_id);
                    }
                    if($request->department_id){
                        $borrow_labs->whereHas('device',function($query) use($request){
                            $query->where('department_id',$request->department_id);
                        });
                    }
                    if($request->user_id){
                        $borrow_labs->whereHas('borrow.user',function($query) use($request){
                            $query->where('user_id',$request->user_id);
                        });
                    }
                    $borrow_labs->whereHas('borrow',function($query) use($request){
                        $query->where('status',self::ACTIVE);
                    });

                    $borrow_labs = $borrow_labs->get();

                    $labs = [];
                    foreach( $borrow_labs as $borrow_lab ){
                        $labs = [
                            'borrow_id' => $borrow_lab->borrow_id,
                            'lab_id'    => $borrow_lab->lab_id,
                            'session'    => $borrow_lab->session,
                            'lecture_number'    => $borrow_lab->lecture_number,
                            'lab_name'  => $borrow_lab->lab->name ?? '',
                            'user_name'  => $borrow_lab->borrow->user->name ?? '',
                        ];
                    }
                    $items[$date][$i] = $labs;
                }
            }
        }
        return $items;
    }
    public static function getPermissions(){
        $permissions = [
            'allow_edit_approved' => \App\Models\Option::get_option('borrow_device','allow_edit_approved',0),
            'allow_edit_pending' => \App\Models\Option::get_option('borrow_device','allow_edit_pending',0),
            'allow_delete_approved' => \App\Models\Option::get_option('borrow_device','allow_delete_approved',0),
            'allow_delete_pending' => \App\Models\Option::get_option('borrow_device','allow_delete_pending',0),
            'auto_approved' => \App\Models\Option::get_option('borrow_device','auto_approved',0),
            'check_duplicate' => \App\Models\Option::get_option('borrow_device','check_duplicate',0)
        ];
        return $permissions;
    }
    
}
