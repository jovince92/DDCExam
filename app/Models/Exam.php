<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function questions(){
        return $this->hasMany(Question::class);
    }
    public function categories(){
        return $this->hasMany(Category::class);
    }
    
    public function score(){
        return $this->hasOne((Score::class));
    }

    

}
