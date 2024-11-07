<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lesson\CreateLessoneRequest;
use App\Http\Requests\Lesson\UpDeLessoneRequest;
use App\Models\Lesson;
use App\Services\ImageService;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function Test(){
        return 'hiii';
    }

   
 public function getAllLesson(Request $request){
  $lesson =Lesson::paginate(3);
  return $lesson;
 }

 public function creatLesson(CreateLessoneRequest $CreateLessoneRequest ){
  $lesson= new Lesson();
  $lesson->title = $CreateLessoneRequest->title;
  $lesson->description = $CreateLessoneRequest->description;
 $lesson_video_url =ImageService::upload_image($CreateLessoneRequest->video_url , 'lesson') ;
 $lesson->video_url=$lesson_video_url;
 $lesson->save();
return $lesson;

 }


 public function updetLesson(UpDeLessoneRequest $UpDeLessoneRequest ){
   $lesson=Lesson::where('id',$UpDeLessoneRequest->id)->first();
    $lesson->title= $UpDeLessoneRequest->title ;
   
    $lesson_video_url=ImageService::upload_image($UpDeLessoneRequest->video_url , 'lesson');
   // dd($UpDeLessoneRequest->all());

    $lesson->video_url=$lesson_video_url;
    $lesson->save();
    return $this->sendResponse(__('lesson updateed'),201);
  } 

  public function deleteLesson(UpDeLessoneRequest $UpDeLessoneRequest ){
    $lesson = Lesson::where('id', $UpDeLessoneRequest->id)->first();
    if($lesson){
    $lesson->delete();
    return $this->sendResponse('the lesson is deleted ',200);
  }
  else
    return $this->sendResponse('the lesson already not found ',400);
  }

}
