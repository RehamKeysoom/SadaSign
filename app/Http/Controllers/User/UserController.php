<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
  public function getProfile(Request $request){
    $user= Auth::user();
  
  if (!$user){
    return $this->sendError(__('auth.not_authenticated'),401);
    
  }
  $profile =[
    'name' => $user->name,
    'phone_number' => $user->phone_number,
    'email' => $user->email,
    'is_verified' => $user->is_verified,
    'start_date_trailer' => $user->start_date_trailer,
    'end_date_trailer' => $user->end_date_trailer,
    'lesson_pass_count' => $user->lesson_pass_count,
  ];

return $this->sendResponse(__('auth.profile_retrieved_successfully') , $profile);
  }
}
