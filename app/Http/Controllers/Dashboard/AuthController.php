<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
   public function logIn(AuthRequest $Request){

    $email = $Request->email;
    $password = $Request->password;

    $user = Admin::where('email',$email)->first();

     if(!$user){
        return $this->sendError(__('email not found'),400);
     }

     if(!Hash::check($password,$user->password)){
        return $this->sendResponse(__('Wrong Credential'),400);
   }

 $token = $user->createToken("admin", ['admin'])->plainTextToken;
 return [
    "token"=> $token,
    "user"=>$user
];
}

public function Register(AuthRequest $request){

    $email=$request->email;
    $password=$request->password;


    $user=Admin::where('email',$email)->first();

    if( $user){
        return $this->sendError (__('email is exist'),400);
    }
    $user=Admin::create([
        
        'email'=>$email,
        "password"=>Hash::make($password)

    ]);


    $token  =  $user->createToken("admin")->plainTextToken;




    return [
        "user" =>$user ,
        "token"=>$token
    ];


}



}
