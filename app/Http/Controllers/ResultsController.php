<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\ApplicantAnswer;
use App\Models\Exam;
use App\Models\Score;
use Illuminate\Http\Request;

class ResultsController extends Controller
{
    public function scores(){
        $score= Score::with(['applicant','applicant.applicant_answer','applicant.applicant_contact','exam','exam.questions','exam.questions.answer'])
        ->limit(25)
        ->orderBy('created_at','DESC')
        ->get();
        //dd($score);
        return $score;
    }

    public function update_score(Request $request){
        Score::find($request->score_id)->update([
            'applicant_score'=>$request->score
        ]);
    }
    public function update_status(Request $request){
        Score::find($request->score_id)->update([
            'status'=>$request->status
        ]);
    }




    public function update_question_score(Request $request){
        $score=0;

        $applicant_answer=ApplicantAnswer::find($request->answer_id);
        $score_id=$applicant_answer->score_id;
        $applicant_answer->update([
            'score'=>$request->score,
            'checked'=>1
        ]);


        $score=ApplicantAnswer::where('score_id',$score_id)->get()->sum('score');
        
        Score::find($score_id)->update([
            'applicant_score'=>$score
        ]);

        return $score;

    }


    public function scores_filter(Request $request){

        $final_score=[];

        $applicant_answer=Applicant::select('id')->where('last_name','like',   '%'.$request->name.'%')
            ->orWhere('first_name','like',   '%'.$request->name.'%')
            ->orWhere('middle_name','like',   '%'.$request->name.'%')
            ->get();
        
        $exams=Exam::select('id')->where('name','like','%'.$request->name.'%')->get();

        $scores= Score::with(['applicant','applicant.applicant_answer','applicant.applicant_contact','exam','exam.questions','exam.questions.answer'])
            ->whereIn('applicant_id',$applicant_answer)
            ->orWhereIn('exam_id',$exams)
            ->orderBy('created_at','DESC')
            ->get();
        //dd($score);
        
        

        foreach($scores as $score){
            if($score->status=='Needs manual check'){
                if($request->needs_check==1){
                    array_push($final_score,$score);
                }
            }

            if($score->status=='Passed'){
                if($request->passed==1){
                    array_push($final_score,$score);
                }
            }

            if($score->status=='Failed'){
                if($request->failed==1){
                    array_push($final_score,$score);
                }
            }

            if(count($final_score)>=$request->limit){
                break;
            }

        }
        return $final_score;




        //return $applicant_answer;
    }
}
