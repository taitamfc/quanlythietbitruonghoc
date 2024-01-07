<?php

namespace Modules\AdminBorrow\app\Models;

use App\Models\AdminModel as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
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
    // Ovrrides
    public static function getItems($request = null,$table = ''){
        $limit = $request->limit ?? 20;
        $query = self::query(true);
        if( $request->status === NULL ){
            $query->whereIn('status',[
                self::ACTIVE,
                self::INACTIVE,
                self::CANCELED
            ]);
        }else{
            $query->where('status',$request->status);
        }
        if( $request->user_id){
            $query->where('user_id',$request->user_id);
        }
        if($request->nest_id){
            $query->whereHas('user', function ($query) use ($request) {
                $query->where('nest_id', $request->nest_id );
            });
        }
        if ($request && $request->school_years) {
            $yearRange = explode('-', $request->school_years);
            if (count($yearRange) == 2) {
                $startYear = trim($yearRange[0]);
                $endYear = trim($yearRange[1]);
                // Tính toán ngày bắt đầu và ngày kết thúc dựa vào năm học
                $startDate = $startYear . '-08-01'; // Năm học bắt đầu từ tháng 8
                $endDate = $endYear . '-07-01'; // Năm học kết thúc vào tháng 7 năm sau
                $query->whereBetween('borrow_date', [$startDate, $endDate]);
            }
        }
        $query->orderBy('id','DESC');
        if( $request->week ){
            $week = $request->week;
            $year = substr($week, 0, 4);
            $weekNumber = substr($week, -2);
            $startDate = Carbon::now()->setISODate($year, $weekNumber)->startOfWeek();
            $endDate = Carbon::now()->setISODate($year, $weekNumber)->endOfWeek();
            $query->whereBetween('borrow_date', [$startDate, $endDate]);
            $query->orderBy('borrow_date','ASC');
        }
        
        $query->orderBy('id','DESC');
        $items = $query->paginate($limit);
        return $items;
    }
    public static function updateItem($id,$request = null,$table = ''){
        $item = self::findOrFail($id);
        $data = $request->all();
        $data = $request->except(['_token', '_method','type']);
        $item->update($data);
    } 
    public static function findItem($id,$table = ''){
        $model = self::class;
        $item = $model::findOrFail($id);
        $item->status = $item->deleted_at ? 0 : 1;
        return $item;
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
    
}
