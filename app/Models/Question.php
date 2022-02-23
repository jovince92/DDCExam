<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function choices(){
        return $this->hasMany(Choice::class);
    }

    public function answer(){
        return $this->hasOne(Answer::class);
    }
}
