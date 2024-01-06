<?php

namespace Modules\AdminHome\app\Models;

use App\Models\AdminModel as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use Carbon\Carbon;

class AdminHome extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'borrows';
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'sort_description',
        'image',
        'gallery',
        'status',
        'position',
        'user_id'
    ];

    public static function getApprovedOnWeek($table){
        $model = '\App\Models\\' . $table;
        $currentWeek    = Carbon::now()->format('Y-\WW');
        $startDateEndDate = $model::getStartEndDateFromWeek($currentWeek);
        $startDateEndDate = array_values($startDateEndDate);
        $count_approved = $model::where('status',1)->whereBetween('borrow_date', $startDateEndDate)->count();
        $count_inapproved = $model::where('status',0)->whereBetween('borrow_date', $startDateEndDate)->count();
        $count_devides = \App\Models\BorrowDevice::whereBetween('borrow_date', $startDateEndDate)->count();
        $count_labs = \App\Models\BorrowDevice::whereBetween('borrow_date', $startDateEndDate)->where('lab_id','>',0)->groupBy('lab_id')->count();
        return $param = [
            'count_approved' => $count_approved,
            'count_inapproved' => $count_inapproved,
            'count_devides' => $count_devides,
            'count_labs' => $count_labs
        ];
    }
}