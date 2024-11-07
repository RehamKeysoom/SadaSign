<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
     protected $guarded = ['id'];

     public function lesson(){
          return $this->belongsTo(Lesson::class);
     }
}
