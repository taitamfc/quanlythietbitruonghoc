<?php

namespace Modules\Borrow\app\Models;

use App\Models\WebsiteModel as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Borrow extends Model
{
    use HasFactory;

    protected $table = 'borrows';
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'borrow_date',
        'status'
    ];

    // Relationships
    public function posts(){
        // return $this->hasMany(Post::class);
    }

    // Attributes
    
}
