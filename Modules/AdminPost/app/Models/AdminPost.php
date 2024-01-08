<?php

namespace Modules\AdminPost\app\Models;

use App\Models\AdminModel as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminPost extends Model
{
    use HasFactory;

    protected $table = 'posts';
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
    // Ovrride methods
    public static function getItems($request = null,$table = ''){
        $limit = $request->limit ? $request->limit : 20;
        if($table){
            $modelClass = '\App\Models\\' . $table;
            $query = $modelClass::query(true);
            $query = $modelClass::handleSearch($request,$query);
        }else{
            $query = self::query(true);
            $query = self::handleSearch($request,$query);
        }
        if ($request->department_id) {
            $query->where('department_id',$request->department_id);
        }
        if ($request->device_type_id) {
            $query->where('device_type_id',$request->device_type_id);
        }
        if ($request->name) {
            $name = trim($request->name);
            $query->where('name',$name);
        }
        $items = $query->paginate($limit);
        return $items;
    }
    public static function saveItem($request,$table = ''){
        if($table){
            $model = '\App\Models\\' . $table;
        }else{
            $model = self::class;
        }
        $data = $request->except(['_token', '_method','type']);
        if(Auth::id()){
            $data['user_id'] = Auth::id();
        }
        if(!$request->slug && $request->name){
            $data['slug'] = Str::slug($request->name);
        }
        if ($request->hasFile('image')) {
            $data['image'] = self::uploadFile($request->file('image'), self::$upload_dir);
        } 
        return $model::create($data);
    }

    // Relationships
   
}