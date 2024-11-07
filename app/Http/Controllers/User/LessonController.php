<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Lessons\LessonRequest;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
   public function getLessonWithExam(LessonRequest $lessonRequest){
    $lesson_id= $lessonRequest->lesson_id;
      $lesson= Lesson::with(relations: 'exam')->find($lesson_id);

      

      if(!$lesson){
        return $this->sendError('Lesson not found',400);
   }
   $lessonData = [
    'id' => $lesson->id,
    'title' => $lesson->title,
    'content' => $lesson->content,
    'exams' => $lesson->exam->map(function ($exam) {
        return [
            'id' => $exam->id,
            'title' => $exam->title,
            'description' => $exam->description,
        ];
    }),
];

return $this->sendResponse('Lesson with exams retrieved successfully', $lessonData);
}

public function getSingelLesson(LessonRequest $lessonRequest){
    $lesson_id= $lessonRequest->lesson_id;

    $lesson= Lesson::find($lesson_id);
       if(!$lesson){
    return $this->sendError('Lesson not found',400);   
}
$lessonData = [
    'id' => $lesson->id,
    'title' => $lesson->title,
    'content' => $lesson->content,

];

return $this->sendResponse('Lesson retrieved successfully', $lessonData);
}



}


