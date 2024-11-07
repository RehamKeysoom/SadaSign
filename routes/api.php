<?php

use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\ExamController;
use App\Http\Controllers\User\LessonController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//****************************registerCustomer************************** */ */

Route::prefix("Auth")->group(function () {
    Route::post('/register',[AuthController::class,'registerNewCustomer']);
    Route::post('/verfiy',[AuthController::class,'verifyCode']);
    Route::post('/resendCode',[AuthController::class,'resendCode']);
    Route::post('/logIn',[AuthController::class,'logIn']);

});

//*********************************Profile************************************** */
Route::middleware('auth:sanctum')->prefix('user')->group(function () {
    Route::prefix("Profile")->group(function(){
    Route::get('/getProfile' ,[UserController::class,'getProfile']);
});


///**********************************Lesson_Api********************************** */
Route::prefix("Lesson")->group(function(){
    Route::get('/getLessonWithExam',[LessonController::class,'getLessonWithExam']);
    Route::get('/getSingelLesson',[LessonController::class,'getSingelLesson']);

});

///**********************************Exam_Api********************************** */
Route::prefix("Exam")->group(function(){
    Route::get('/getSingleExam',[ExamController::class,'getSingleExam']);
    Route::get('/passNewExam',[ExamController::class,'passNewExam']);

});



});









