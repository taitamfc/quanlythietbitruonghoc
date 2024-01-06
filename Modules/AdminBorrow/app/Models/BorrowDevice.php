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
        if ($request->school_years) {
            $startDateEndDate = \App\Models\Borrow::getStartEndDateFromYear(request()->school_years);
            $startDateEndDate = array_values($startDateEndDate);
            $query->whereBetween('borrow_date', $startDateEndDate);
        }
        if( $request->week ){
            $startDateEndDate = self::getStartEndDateFromWeek($request->week);
            $startDateEndDate = array_values($startDateEndDate);
            $query->whereBetween('borrow_date', $startDateEndDate);
        }
        $query->orderBy('borrow_date','asc');
        $items = $query->get();
        $items = \App\Models\BorrowDevice::groupBorrowDevices($items);
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
