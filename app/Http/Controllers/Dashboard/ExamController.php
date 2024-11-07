<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Exam\CreateExamRequest;
use App\Http\Requests\Exam\UpDeleteExamRequest;
use App\Models\Exam;
use App\Services\ImageService;
use Illuminate\Http\Request;

class ExamController extends Controller
{

    public function Test(){
        return 'hi';
    }

    public function getallExam(Request $request){
        $exam = Exam::paginate(3);
        return $exam;
    }

   // public function getAllExam(Request $request){
      //  $exam = Exam::all();
       // return $exam;
   // }  

    public function creatExam(CreateExamRequest $CreateExamRequest){
        $exam =new Exam();
        $exam->lesson_id = $CreateExamRequest->lesson_id;
       $exam->the_right_choice = $CreateExamRequest->the_right_choice;
        $exam->choose1= $CreateExamRequest->choose1;
        $exam->choose2= $CreateExamRequest->choose2;
        $exam->choose3= $CreateExamRequest->choose3;
        $exam_video_url =ImageService::upload_image($CreateExamRequest->video_url , 'exam') ;
        $exam->video_url=$exam_video_url;
        $exam->save();
        return $exam;
}    

public function updateExam(UpDeleteExamRequest $upDeleteExamRequest){
    $exam = Exam::where('id',$upDeleteExamRequest->id)->first();
    $exam->lesson_id = $upDeleteExamRequest->lesson_id;
    $exam->the_right_choice = $upDeleteExamRequest->the_right_choice;
    $exam->choose1 = $upDeleteExamRequest->choose1;
        $exam->choose2 = $upDeleteExamRequest->choose2;
            $exam->choose3 = $upDeleteExamRequest->choose3;
            $exam_video_url = ImageService::upload_image(  $upDeleteExamRequest->video_url,'exam');
            $exam->video_url=$exam_video_url;
            $exam->save();
            return $exam;
}

public function deleteExam(UpDeleteExamRequest $upDeleteExamRequest){
    $exam = Exam::where('id',$upDeleteExamRequest->id)->first();
    if($exam){
        $exam->delete();
        return $this->sendResponse('the exam is deleted',200);}
        else
        return $this->sendError('There is no exam to delete',400);

    }
}
