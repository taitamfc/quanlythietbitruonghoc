<?php

namespace Modules\AdminUser\app\Models;

use App\Models\AdminModel as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\AdminUser\Database\factories\AdminUserFactory;

class AdminRole extends Model
{
    use HasFactory;
    protected $table = 'roles';
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    
    protected static function newFactory(): AdminUserFactory
    {
        //return AdminUserFactory::new();
    }

    // public static function getAll(){
    //     return [
    //         'manage-admin-borrows',
    //         'view-admin-borrow'
    //     ];
    // }
}
