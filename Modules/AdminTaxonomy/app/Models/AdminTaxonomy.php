<?php

namespace Modules\AdminTaxonomy\app\Models;

use App\Models\AdminModel as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class AdminTaxonomy extends Model
{
    use HasFactory;

    protected $table = 'taxonomies';
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'status',
        'position'
    ];

    // Relationships
    public function posts(){
        // return $this->hasMany(Post::class);
    }

    // Attributes
    
}
