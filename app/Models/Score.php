<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function applicant(){
        return $this->belongsTo(Applicant::class);
    }


    public function exam(){
        return $this->belongsTo(Exam::class);
    }

    public function applicant_answers(){
        return $this->hasMany(ApplicantAnswer::class);
    }

}
