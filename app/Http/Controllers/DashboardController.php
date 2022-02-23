<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Exam;
use App\Models\User;
use App\Models\Score;
use App\Models\Applicant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){

        $dashboard=[];
        $date = Carbon::now()->subDays(7);

        $applicants = User::with('applicant')->where('user_level',2)->where('created_at', '>=', $date)->count();
        $exams = Exam::where('is_deleted',0)->count();
        $completed_exams = Score::with('applicant','applicant_answers')->count();

        $needs_check=Score::with('applicant','applicant_answers')->where('status','Needs manual check')->count();
        $passed=Score::with('applicant','applicant_answers')->where('status','Passed')->count();
        $failed=Score::with('applicant','applicant_answers')->where('status','Failed')->count();

        $passing_rate= ($passed/$completed_exams)*100;
        $passing_rate=round($passing_rate,2);

        $dashboard=[
            'applicants'=>$applicants,
            'exams'=>$exams,
            'completed_exams'=>$completed_exams,
            'passing_rate'=>$passing_rate,
            'results'=>[
                'needs_check'=>$needs_check,
                'passed'=>$passed,
                'failed'=>$failed,
            ]
        ];

        //dd(compact('dashboard'));
        
        return $dashboard;

    }
}
