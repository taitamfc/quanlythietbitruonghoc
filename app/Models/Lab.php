<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lab extends WebsiteModel
{
    use HasFactory;
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
}