<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;


       
class SmsService {

    public function sendVerificationCode($to, $message) {
        
        $url = "FROM_SMS_SERVICE";

        // $response = Http::get($url);
        // $response = $response->body();
        // check if response is correct of not 
        return true;
    }

    public function generateCode(){

        //$code = random_int(10000 , 99999);

        return "00000";
    }
}
