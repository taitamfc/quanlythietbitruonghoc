<?php

namespace Modules\AdminUser\app\Models;

use App\Models\AdminModel as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\AdminUser\Database\factories\AdminUserFactory;

class AdminGroup extends Model
{
    use HasFactory;
    protected $table = 'groups';
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    
    protected static function newFactory(): AdminUserFactory
    {
        //return AdminUserFactory::new();
    }

    public function getUserCountAttribute(){
        return $this->users->whereNull('deleted_at')->count() ?? 0;
    }

    public function users(){
        return $this->hasMany(AdminUser::class,'group_id');
    }
}
