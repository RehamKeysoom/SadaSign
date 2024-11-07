<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $guarded = ['id'];

    public function exam()
{
    return $this->hasMany(Exam::class);
}
}

