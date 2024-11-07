<?php

use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\ExamController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\LessonController;



Route::prefix('/auth')->group(function(){
  Route::post('/logIn', [AuthController::class, 'logIn']);
  Route::post('/register', [AuthController::class, 'Register']);
});


Route::prefix('admin')->middleware(['abilities:admin','auth:sanctum'])->group(function(){
  Route::prefix("/lesson")->group(function () {
   Route::get('/getAllLesson',[LessonController::class,'getAllLesson']);
   Route::post('/creatLesson',[LessonController::class,'creatLesson']);
   Route::post('/updateLesson',[LessonController::class,'updetLesson']);
   Route::post('/deleteLesson',[LessonController::class,'deleteLesson']);
   Route::get('/test',[LessonController::class,'Test']);
});

Route::prefix("/exam")->group(function(){
  Route::get('/test',[ExamController::class,'Test']);
  Route::post('/creatExam',[ExamController::class,'creatExam']);
  Route::get('/getAllExam',[ExamController::class,'getAllExam']);
  Route::post('/updateExam',[ExamController::class,'updateExam']);
  Route::post('/deleteExam',[ExamController::class,'deleteExam']);

});




});
