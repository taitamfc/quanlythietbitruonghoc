<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeviceType extends AdminModel
{
    use HasFactory;
    protected $table = "device_types";
    protected $fillable = [
        'id','name','deleted_at'
    ];
    public function devices()
    {
        return $this->hasMany(Device::class);
    }
    public function assets()
    {
        return $this->hasMany(Asset::class);
    }
}