<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use App\Models\Region;
use App\Models\Province;
use App\Models\Applicant;
use Illuminate\Http\Request;
use App\Models\ApplicantContact;

class AdminController extends Controller
{
    public function applicants(){
        
        $applicants = User::with(['applicant','applicant.applicant_contact'])->where('user_level',2)
        ->limit(25)
        ->orderBy('created_at','DESC')
        ->get();
        return $applicants;
        // dd($applicants);

        

    }


    
    public function applicant_update(Request $request){
        $applicant = Applicant::find($request->applicant_id);


        $region=Region::where('regCode',$request->region)->first();
        $province=Province::where('provCode',$request->province)->first();
        $city=City::where('citymunCode',$request->city)->first();

        $applicant->update([
            'last_name'=>$request->last_name,
            'first_name'=>$request->first_name,
            'middle_name'=>$request->middle_name,
            'birthday'=>$request->birthday,
            'civil_status'=>$request->civil_status,
            'gender'=>$request->gender,
            'highest_education_attainment'=>$request->highest_education_attainment
        ]);


        $applicant_contact = ApplicantContact::where('applicant_id',$request->applicant_id)->first();

        $applicant_contact->update([
            'address'=>$request->address,
            'region'=>$region->regDesc,
            'province'=>$province->provDesc,
            'city'=>$city->citymunDesc,
            'zipcode'=>$request->zipcode,
            'phone_number'=>$request->phone_number,
        ]);
    }

    public function filter_applicants(Request $request){

        $applicants = Applicant::select('user_id')
            ->where('last_name','like','%'.$request->name.'%')
            ->orWhere('first_name','like','%'.$request->name.'%')
            ->orWhere('middle_name','like','%'.$request->name.'%')
            ->get();

        //return $applicants;
        // dd($applicants);

        $users=User::with(['applicant','applicant.applicant_contact'])->where('user_level',2)
            ->whereIn('id',$applicants)
            ->limit($request->limit)
            ->orderBy('created_at','DESC')
            ->get();

        return $users;

    }
}
