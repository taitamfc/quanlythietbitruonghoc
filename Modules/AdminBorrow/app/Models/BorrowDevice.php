<?php

namespace Modules\AdminBorrow\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\AdminBorrow\Database\factories\BorrowDeviceFactory;
use App\Models\Device;

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
    
    protected static function newFactory(): BorrowDeviceFactory
    {
        //return BorrowDeviceFactory::new();
    }
    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id', 'id');
    }
}
