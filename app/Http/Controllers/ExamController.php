<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Category;
use App\Models\Choice;
use App\Models\Exam;
use App\Models\Question;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index(){
        $exams=Exam::with(['questions','questions.choices','questions.answer','categories'])->where('is_deleted', 0)
		->limit(25)
		->orderBy('created_at','DESC')
		->get();
		//dd($exams);
		return $exams->toJson();
    }

    public function getVaccancies(){

        $url = "http://idcsi-officesuites.com:8080/hrms/api.php";
        $data = array(
            'what' => 'getinfo', 'field' => 'vacancy',
            'apitoken' => 'IUQ0PAI7AI3D162IOKJH'
        );

        $curl = curl_init();
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

			$result = curl_exec($curl);
			curl_close($curl);
			$output = json_decode($result, true);
			if ($output['code'] === 0) { /* Handle error */
				return array($output['code'], $output['message']);
			} else {
				return array(1, "");
			}
    }


	public function add_exam(Request $request){
		//dd($request);
		$newExam = Exam::create([
			'name'=>$request->name,
			'score'=>$request->score,
			'passing_score'=>$request->passing_score,
			'is_deleted'=>0
		]);

		foreach($request->jobs as $category){
			$job=explode(',', $category);
			$newCategory = Category::create([				
				'exam_id'=>$newExam->id,
				'job_id'=>$job[0],				
				'vacancy_name'=>$job[1],
				'is_deleted'=>0
			]);
		}


		foreach($request->questions as $question){
			/* *
			 * * question[0]=question name
			 * * question[1]=question type (string)
			 * * question[2]=choices(array) if any
			 * * question[3]=answer(if not an essay)
			 * * question[4]=question type (int)
			 * * question[5]=question part
			 * * question[5]=question point
			 */
			
			$newQuestion = Question::create([
				'exam_id'=>$newExam->id,
				'question'=>$question[0],
				'type'=>$question[1],
				'part'=>$question[5],
				'points'=>$question[6],
				'is_deleted'=>0
			]);

			if($question[4]==1){			
				foreach($question[2] as $choice){
					Choice::create([
						'question_id'=>$newQuestion->id,
						'choice'=>$choice
					]);
				}
			}

			if($question[4]!=3){
				$newAnswer=Answer::create([
					'question_id'=>$newQuestion->id,
					'answer'=>$question[3]
				]);
			}

		}

	}

	public function delete_exam(Request $request){
		
		$exam=Exam::find($request->id);
		$exam->update([
			'is_deleted'=>1
		]);
	}

	public function update_exam(Request $request){
		
		$exam=Exam::find($request->exam_id);
		$exam->update([
			'name'=>$request->name,
			'score'=>$request->score,
			'passing_score'=>$request->passing_score,
		]);

		$categories=Category::where('exam_id',$request->exam_id)->get();
		$categories->each->delete();

		$questions=Question::where('exam_id',$request->exam_id)->get();
		$questions->each->delete();
		
		foreach($request->jobs as $category){
			$job=explode(',', $category);
			$newCategory = Category::create([				
				'exam_id'=>$request->exam_id,
				'job_id'=>$job[0],				
				'vacancy_name'=>$job[1],
				'is_deleted'=>0
			]);
		}


		foreach($request->questions as $question){
			/* *
			 * * question[0]=question name
			 * * question[1]=question type (string)
			 * * question[2]=choices(array) if any
			 * * question[3]=answer(if not an essay)
			 * * question[4]=question type (int)
			 * * question[5]=question part
			 * * question[6]=question point
			 */
			
			$newQuestion = Question::create([
				'exam_id'=>$request->exam_id,
				'question'=>$question[0],
				'type'=>$question[1],
				'part'=>$question[5],
				'points'=>$question[6],
				'is_deleted'=>0
			]);

			if($question[4]==1){			
				foreach($question[2] as $choice){
					Choice::create([
						'question_id'=>$newQuestion->id,
						'choice'=>$choice
					]);
				}
			}

			if($question[4]!=3){
				$newAnswer=Answer::create([
					'question_id'=>$newQuestion->id,
					'answer'=>$question[3]
				]);
			}

		}

	}

	public function filter(Request $request){

		$categories=Category::select('exam_id')->where('vacancy_name','like','%'.$request->name.'%')->groupBy('exam_id')->get();

        $exams=Exam::with(['questions','questions.choices','questions.answer','categories'])
			->where('is_deleted', 0)->where(function ($q) use($request,$categories){
				$q->where('name','like','%'.$request->name.'%')
				->orWhereIn('id',$categories);
			})
			->limit($request->limit)
			->orderBy('created_at','DESC')
			->get();

		
		
		return $exams;
    }

    
}
