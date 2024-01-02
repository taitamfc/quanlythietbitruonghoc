<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Lab extends WebsiteModel
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['id','name', 'quantity','department_id'];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
}