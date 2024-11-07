<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Exams\ExamRequest;
use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function getSingleExam(ExamRequest $examRequest){

        $exam_id = $examRequest->exam_id;

        $exam = Exam::find($exam_id);
        if(!$exam){
            return $this->sendError(__('Exam not found'),400);
    }
    $examData = [
        'id' => $exam->id,
        'title' => $exam->title,
        'description' => $exam->description,
        'created_at' => $exam->created_at,
       'updated_at'=> $exam->updated_at,
    ];
    return $this->sendResponse(__('Exam retrieved successfully'), $examData);
}
public function passNewExam(ExamRequest $ExamRequest)
{
    $user = auth()->user(); 

    if (!$user) {
        return $this->sendError(__('auth.user_not_authenticated'), 401);
    }

    
    $user->increment('lesson_pass_count');//ليييش ضاربة؟؟ 
    $success = [
        'message' => __("Exam passed successfully. Total passed exams: {$user->lesson_pass_count}"),
        'lesson_pass_count' => $user->lesson_pass_count,
    ];

    return $this->sendResponse(__('Exam passed successfully'), $success);
}

}


