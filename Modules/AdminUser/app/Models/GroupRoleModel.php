<?php

namespace Modules\AdminUser\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\AdminUser\Database\factories\GroupRoleModelFactory;

class GroupRoleModel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'group_roles';
    protected $fillable = [];
    
    protected static function newFactory(): GroupRoleModelFactory
    {
        //return GroupRoleModelFactory::new();
    }
}
