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
        $model::create($data);
    }

    // Relationships
   
}
