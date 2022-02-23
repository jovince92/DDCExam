<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function applicant_contact(){
        return $this->hasOne(ApplicantContact::class);
    }

    public function scores(){
        return $this->hasMany(Score::class);
    }

    public function applicant_answer(){
        return $this->hasMany(ApplicantAnswer::class);
    }
}
