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
    public static function saveItem($request, $table = '')
    {
        if ($table) {
            $model = '\App\Models\\' . $table;
        } else {
            $model = self::class;
        }

        $data = [];
        foreach ($request->all() as $key => $value) {
            if (!in_array($key, ['_token', '_method', 'type'])) {
                if ($key === 'password') {
                    $data[$key] = bcrypt($value); // Mã hóa mật khẩu trước khi lưu
                } else {
                    $data[$key] = $value;
                }
            }
        }

        return $model::create($data);
    }
}
