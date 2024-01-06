<?php

namespace Modules\AdminUser\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\AdminModel as Model;
use Illuminate\Support\Str;

class Group extends Model
{
    use HasFactory;
    protected $table ='groups';
    protected $fillable = [
        'name',
    ];

    public static function saveItem($request,$table = ''){
        if($table){
            $model = '\App\Models\\' . $table;
        }else{
            $model = Group::class;
        }
        $data = $request->except(['_token', '_method','type']);

        if(!$request->slug && $request->name){
            $data['slug'] = Str::slug($request->name);
        }
        if ($request->hasFile('image')) {
            $data['image'] = Group::uploadFile($request->file('image'), Group::$upload_dir);
        } 
        $model::create($data);
    }

    public static function findItem($id,$table = ''){
        if($table){
            $model = '\App\Models\\' . $table;
        }else{
            $model = Group::class;
        }
        return $model::findOrFail($id);
    }

    public static function deleteItem($id,$table = ''){
        if($table){
            $model = '\App\Models\\' . $table;
        }else{
            $model = Group::class;
        }
        $item = $model::findItem($id);
        Group::deleteFile($item->image);
        return $item->delete();
    }


    public static function updateItem($id,$request,$table = ''){
        if($table){
            $model = '\App\Models\\' . $table;
        }else{
            $model = Group::class;
        }

        $item = $model::findOrFail($id);
        $data = $request->all();
        $data = $request->except(['_token', '_method','type']);
        if ($request->hasFile('image')) {
            Group::deleteFile($item->image);
            $data['image'] = $model::uploadFile($request->file('image'), Group::$upload_dir);
        } 
        $item->update($data);
    }


    public function users()
    {
        return $this->hasMany(User::class, 'group_id', 'id');
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class,'group_roles','group_id','role_id');
    }
}
