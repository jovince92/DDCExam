<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\City;
use App\Models\Exam;
use App\Models\User;
use App\Models\Region;
use App\Models\Category;
use App\Models\Province;
use App\Models\Applicant;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\ApplicantAnswer;
use App\Models\ApplicantContact;
use App\Models\Question;
use App\Models\Result;
use App\Models\Score;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApplicantController extends Controller
{

    public function user_level(){
        $user=User::select('user_level')->find(Auth::id());
        return $user->user_level;
    }

    public function create(Request $request){
        
        $region=Region::where('regCode',$request->region)->first();
        $province=Province::where('provCode',$request->province)->first();
        $city=City::where('citymunCode',$request->city)->first();
        
        $newUser=User::create([
            'name'=>Str::headline($request->fname),
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            // 'user_level'=>2,
            'is_active'=>0,
            'last_login'=>now()
        ]);


        $newApplicant=Applicant::create([
            'user_id'=>$newUser->id,
            'last_name'=>Str::headline($request->lname),
            'first_name'=>Str::headline($request->fname),
            'middle_name'=>Str::headline($request->mname),
            'birthday'=>Carbon::parse($request->dob),
            'civil_status'=>$request->civil_status,
            'gender'=>$request->gender,
            'highest_education_attainment'=>$request->education
        ]);

        ApplicantContact::create([
            'applicant_id'=>$newApplicant->id,
            'region'=>$region->regDesc,
            'province'=>$province->provDesc,
            'city'=>$city->citymunDesc,
            'address'=>$request->address,
            'zipcode'=>$request->zipcode,
            'phone_number'=>$request->phone,
            'email'=>$request->email
        ]);
    }



    public function email_check(Request $request){
        $exist=false;
        $user=User::where('email',$request->email)->first();
        if($user){
            $exist=true;
        }
        else{
            $exist=false;
        }
        return $exist;
    }

    public function available_exams(Request $request){
        

        $exam_ids=[];

        $categories=Category::select('exam_id')->where('job_id',$request->job_id)->where('is_deleted',0)
        ->get()->toArray();
        // dd($categories);
        // $categories=Category::select('exam_id')->where('is_deleted',0)->groupBy('exam_id')->get()->toArray();
        
        foreach($categories as $c) {
            array_push($exam_ids,$c);
        }

        $available = Exam::with('questions','questions.choices','questions.answer')->whereIn('id',$categories)->where('is_deleted',0)->orderBy('created_at','DESC')->get();
        
        return $available;
        
    }
    public function create_exam(Request $request){
        
        //dd($request);
        $applicant=Applicant::where('user_id',Auth::id())->first();
        $score=0;
        $need_manual_check=false;
        $checked=0;
        //dd($applicant);

        $newScore=Score::create([
            'exam_id'=>$request->exam_id,
            'applicant_id'=>$applicant->id,
            'job_id'=>$request->job_id,
            'job_title'=>$request->job_title
        ]);

        foreach($request->question_answer as $qa){
            
            $points=0;
            $checked=1;
            $answer=Answer::where('question_id',$qa['question_id'])->first();
            if($qa['question_type']=='Multiple Choice'||$qa['question_type']=='True or False'){
                if($qa['answer']==$answer->answer){
                    $points=$qa['question_points'];
                    
                }else{
                    $points=0;
                }
                $score=$score+$points;
                
            }

            if($qa['question_type']=='Enumeration'||$qa['question_type']=='Essay'){
                $need_manual_check=true;
                $checked=0;
            }
            
            

            ApplicantAnswer::create([
                'score_id'=>$newScore->id,
                'question_id'=>$qa['question_id'],
                'applicant_id'=>$applicant->id,
                'answer_id'=>($qa['question_type']!='Essay')?$answer->id:null,
                'applicant_answer'=>$qa['answer'],
                'score'=>$points,
                'checked'=>$checked
            ]);
        }

        if($score >= $request->passing_score){
            $status=($need_manual_check==false)?'Passed':'Needs manual check';
        }else{
            $status=($need_manual_check==false)?'Failed':'Needs manual check';
        }



        Score::find($newScore->id)
                ->update([
                    'applicant_score'=>$score,
                    'status'=>$status
                ]);

        
    }

    public function check(){
        $applicant=Applicant::select('id')->where('user_id',Auth::id())->get();
        $exams_taken=Score::whereIn('applicant_id',$applicant)->get();
        return count($exams_taken);
    }
}
