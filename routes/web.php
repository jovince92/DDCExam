<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ResultsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Auth/Login', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/', function () {
    return Inertia::render('MainExam');
})->name('dashboard');



Route::get('/dashboard', function () {
    return redirect('/');
});


Route::middleware(['auth:sanctum', 'verified'])->get('/', function () {
    return Inertia::render('MainExam');
})->name('dashboard');


Route::group(['middleware'=>'auth'],function(){




    Route::group(['middleware'=> 'role:applicant','prefix'=>'applicant','as'=>'applicant.' ],function(){
        Route::get('/applicant',function(){
            return redirect('/');
        });
    });
    Route::group(['middleware'=> 'role:admin','prefix'=>'admin','as'=>'admin.' ],function(){
        Route::get('/dashboard',function(){
            return Inertia::render('Admin/Index');
        })->name('admin');
        Route::get('/exams',function(){
            return Inertia::render('Admin/Exams');
        })->name('exams');;
        Route::get('/results',function(){
            return Inertia::render('Admin/Results');
        })->name('results');;
        Route::get('/applicants',function(){
            return Inertia::render('Admin/Applicants');
        })->name('applicants');;


        

        Route::post('/api/exam/save',[ExamController::class,'add_exam']);
        Route::post('/api/exam/update',[ExamController::class,'update_exam']);
        Route::post('/api/exam/delete',[ExamController::class,'delete_exam']);
        Route::get('/api/exam/all',[ExamController::class,'index']);
        Route::post('/api/exam/filter',[ExamController::class,'filter']);


        Route::get('/api/dashboard/index',[DashboardController::class,'index']);
        


        Route::get('/api/applicant/all',[AdminController::class,'applicants']);
        Route::post('/api/applicant/filter',[AdminController::class,'filter_applicants']);
        Route::post('/api/applicant/update',[AdminController::class,'applicant_update']);



        Route::get('/api/score/all',[ResultsController::class,'scores']);

        Route::post('/api/score/filter',[ResultsController::class,'scores_filter']);

        Route::post('/api/score/statusupdate',[ResultsController::class,'update_status']);
        Route::post('/api/score/scoreupdate',[ResultsController::class,'update_score']);


        Route::post('/api/applicant_answer/scoreupdate',[ResultsController::class,'update_question_score']);

    });


    Route::get('/api/vaccancies',[ExamController::class,'getVaccancies']);




    /*******GET AVAILABLE EXAMS FOR APPLICANT */
    Route::post('/api/availableexams',[ApplicantController::class,'available_exams']);
    Route::post('/api/applicant/exam/save',[ApplicantController::class,'create_exam']);
    Route::get('/api/applicant/exam/check',[ApplicantController::class,'check']);

    /***********GET USER LEVEL**** */
    Route::get('/api/getuserlevel',[ApplicantController::class,'user_level']);

    
    //Route::get('/api/vaccancies/refresh',[CategoryController::class,'calibrate']);


});

Route::post('/api/applicant/create',[ApplicantController::class,'create']);
Route::post('/api/applicant/check',[ApplicantController::class,'email_check']);

    Route::post('/api/cities',[LocationController::class,'cities']);
    Route::post('/api/provinces',[LocationController::class,'provinces']);
    Route::get('/api/regions',[LocationController::class,'regions']);
    Route::get('/api/locations',[LocationController::class,'locations']);
