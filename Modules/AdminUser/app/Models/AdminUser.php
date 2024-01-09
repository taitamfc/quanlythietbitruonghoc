<?php

namespace Modules\AdminUser\app\Models;

use App\Models\AdminModel as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\AdminUser\Database\factories\AdminUserFactory;

class AdminUser extends Model
{
    use HasFactory;
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'phone',
        'gender',
        'image',
        'group_id',
        'nest_id',
        'birthday',
    ];
    
    protected static function newFactory(): AdminUserFactory
    {
        //return AdminUserFactory::new();
    }
    //Overrides
    public static function saveItem($request, $table = '')
    {
        $data = $request->except(['_token', '_method']);
        if(!empty($data['password'])){
            $data['password'] = bcrypt($data['password']);
        }
        return self::create($data);
    }
    public static function updateItem($id,$request, $table = '')
    {
        $item = self::findOrFail($id);
        $data = $request->except(['_token', '_method']);
        if(!empty($data['password'])){
            $data['password'] = bcrypt($data['password']);
        }else{
            unset($data['password']);
        }
        $item->update($data);
        return $item;
    }
    // Attributes
    // Relations
    public function group(){
        return $this->belongsTo(AdminGroup::class);
    }
}
