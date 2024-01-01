<?php

namespace Modules\AdminBorrow\app\Models;

use App\Models\AdminModel as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\AdminBorrow\Database\factories\BorrowDeviceFactory;
use App\Models\Device;
use Carbon\Carbon;
use Illuminate\Support\Str;
class BorrowDevice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        "lesson_name",
        "session",
        "lecture_name",
        "room_id",
        "lecture_number",
        "device_id",
        "borrow_date",
        "quantity",
        "lab_id",
        "tiet",
    ];
    
    // Ovrrides
    public static function getItems($request = null,$table = ''){
        $limit = $request->limit ?? 100;
        $query = self::query(true);
        $query->whereHas('borrow', function ($query){
            $query->where('status','>=',0);
        });
        if( $request->lab_id){
            $query->where('lab_id', $request->lab_id );
        }
        if( $request->session){
            $query->where('session', $request->session == 'AM' ? 'Sáng' : 'Chiều' );
        }
        if( $request->user_id){
            $query->whereHas('borrow', function ($query) use ($request) {
                $query->where('user_id', $request->user_id );
            });
        }
        if($request->nest_id){
            $query->whereHas('borrow.user', function ($query) use ($request) {
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
        if( $request->week ){
            $startDateEndDate = self::getStartEndDateFromWeek($request->week);
            $startDateEndDate = array_values($startDateEndDate);
            $query->whereBetween('borrow_date', $startDateEndDate);
        }
        $query->orderBy('borrow_date','asc');
        $items = $query->get();
        $nitems = [];
        foreach( $items as $BorrowDevice ){
            $nitems[$BorrowDevice->borrow_date.'-'.$BorrowDevice->room_id.'-'.Str::slug($BorrowDevice->lesson_name).'-'.$BorrowDevice->session.'-'.$BorrowDevice->lecture_number][] = $BorrowDevice;
        }
        $items = [];
        foreach( $nitems as $item ){
            $departmentName = '';
            $lab_name = '';
            if( empty($item[0]) ){
                continue;
            }
            $device_names = [];
            foreach( $item as $key => $device_item ){
                if(empty($lab_name)){
                    $lab_name = $device_item->lab->name ?? '';
                }
                if(@$device_item->device->name){
                    $device_names[$key] = '- '.@$device_item->device->name . ' ('. $device_item->quantity .')';
                }
                if (empty($departmentName)) {
                    $departmentName = @$device_item->device->department->name;
                }
            }
            $device_names = implode(' <br> ', $device_names);
            $items[] = [
                'borrow_date' => $item[0]->borrow ? date('d/m/Y',strtotime($item[0]->borrow->borrow_date)) : '',
                'return_date' => $item[0]->return_date ? date('d/m/Y',strtotime($item[0]->return_date)) : '',
                'created_at' => $item[0]->return_date ? date('d/m/Y',strtotime($item[0]->created_at)) : '',
                'device_name' => $device_names,
                'quantity' => $item[0]->quantity,
                'session' => $item[0]->session,
                'lecture_name' => $item[0]->lecture_name,
                'lesson_name' => $item[0]->lesson_name,
                'lecture_number' => $item[0]->lecture_number,
                'room_name' => !empty($item[0]->room->name) ? $item[0]->room->name : '',
                'user_name' => !empty($item[0]->borrow->user) ? $item[0]->borrow->user->name : '',
                'nest_name' => !empty($item[0]->borrow->user) ? $item[0]->borrow->user->nest->name : '',
                'department'    => $departmentName, // Sử dụng giá trị đơn lẻ
                'lab_name'      => $lab_name, // Sử dụng giá trị đơn lẻ
            ];
        }
        return $items;
    }
    public function room()
    {
        return $this->belongsTo(\App\Models\Room::class, 'room_id', 'id');
    }
    public function device()
    {
        return $this->belongsTo(\App\Models\Device::class, 'device_id', 'id');
    }
    public function borrow()
    {
        return $this->belongsTo(\App\Models\Borrow::class, 'borrow_id', 'id');
    }
    public function lab()
    {
        return $this->belongsTo(\App\Models\Lab::class, 'lab_id', 'id');
    }
    public static function getStartEndDateFromWeek($week){
        $year           = substr($week, 0, 4);
        $weekNumber     = substr($week, -2);
        $startDate      = Carbon::now()->setISODate($year, $weekNumber)->startOfWeek();
        $endDate        = Carbon::now()->setISODate($year, $weekNumber)->endOfWeek();
        return [
            'startDate' => $startDate,
            'endDate' => $endDate
        ];
    }
}
