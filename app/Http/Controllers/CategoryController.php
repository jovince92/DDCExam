<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function calibrate(){
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
				//
                //return  $output['message'][3];

            foreach($output['message'] as $job){
                // print_r($job);
                // print('<br>');
                
                $cats=Category::where('vacancy_name',$job['job_title'])->get();

                
                  

            }

                
			} else {
				return array(1, "");
			}

        

        
    }
}
