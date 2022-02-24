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
    redirect()->route('dashboard');
});





Route::group(['middleware'=>'auth'],function(){




    Route::group(['middleware'=> 'role:applicant','prefix'=>'applicant','as'=>'applicant.' ],function(){
        Route::get('/applicant',function(){
            redirect()->route('dashboard');
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


        

        Route::post('/api/exam/save',[ExamController::class,'add_exam'])->name('add_exam');
        Route::post('/api/exam/update',[ExamController::class,'update_exam'])->name('update_exam');
        Route::post('/api/exam/delete',[ExamController::class,'delete_exam'])->name('delete_exam');
        Route::get('/api/exam/all',[ExamController::class,'index'])->name('exam');
        Route::post('/api/exam/filter',[ExamController::class,'filter'])->name('exam_filter');


        Route::get('/api/dashboard/index',[DashboardController::class,'index'])->name('admin_index');
        


        Route::get('/api/applicant/all',[AdminController::class,'applicants'])->name('applicants_all');
        Route::post('/api/applicant/filter',[AdminController::class,'filter_applicants'])->name('applicants_filter');
        Route::post('/api/applicant/update',[AdminController::class,'applicant_update'])->name('applicants_update');



        Route::get('/api/score/all',[ResultsController::class,'scores'])->name('scores');

        Route::post('/api/score/filter',[ResultsController::class,'scores_filter'])->name('scores_filter');

        Route::post('/api/score/statusupdate',[ResultsController::class,'update_status'])->name('scores_status');
        Route::post('/api/score/scoreupdate',[ResultsController::class,'update_score'])->name('scores_update');


        Route::post('/api/applicant_answer/scoreupdate',[ResultsController::class,'update_question_score'])->name('scores_update_2');

    });


    Route::get('/api/vaccancies',[ExamController::class,'getVaccancies'])->name('vaccancies');




    /*******GET AVAILABLE EXAMS FOR APPLICANT */
    Route::post('/api/availableexams',[ApplicantController::class,'available_exams'])->name('available_exams');
    Route::post('/api/applicant/exam/save',[ApplicantController::class,'create_exam'])->name('applicant_exams_save');
    Route::get('/api/applicant/exam/check',[ApplicantController::class,'check'])->name('exams_check');

    /***********GET USER LEVEL**** */
    Route::get('/api/getuserlevel',[ApplicantController::class,'user_level'])->name('level_check');

    
    //Route::get('/api/vaccancies/refresh',[CategoryController::class,'calibrate']);


});

Route::post('/api/applicant/create',[ApplicantController::class,'create'])->name('application');
Route::post('/api/applicant/check',[ApplicantController::class,'email_check'])->name('email_check');

Route::post('/api/cities',[LocationController::class,'cities'])->name('cities');
Route::post('/api/provinces',[LocationController::class,'provinces'])->name('provinces');
Route::get('/api/regions',[LocationController::class,'regions'])->name('regions');
Route::get('/api/locations',[LocationController::class,'locations'])->name('locations');
