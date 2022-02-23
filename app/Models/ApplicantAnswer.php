<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantAnswer extends Model
{
    use HasFactory;
    protected $guarded=[];
    
    public function applicant(){
        return $this->belongsTo(Applicant::class);
    }
    public function question(){
        return $this->belongsTo(Question::class);
    }
    public function answer(){
        return $this->belongsTo(Answer::class);
    }
}
