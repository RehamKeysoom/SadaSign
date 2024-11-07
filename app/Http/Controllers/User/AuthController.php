<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LogInRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Requests\Api\Auth\ResendCodeRequest;
use App\Http\Requests\Api\Auth\VerifyRequest;
use App\Models\User;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function registerNewCustomer(RegisterRequest $RegisterRequest)
    {
        $code = mt_rand(100000, 999999); // توليد كود التحقق العشوائي
        
        // عملنا اوبجكت من الكلاس SmsService لإرسال كود التحقق
        $smsService = new SmsService();
        $smsResponse = $smsService->sendVerificationCode($RegisterRequest->phone_number, $code);
    
        if (!$smsResponse) {
            return $this->sendError(__('auth.failed_code_sent'), 400);
        }
    
        // تحديد تاريخ البداية والنهاية للفترة التجريبية
        $startDate = now(); // تاريخ بداية الفترة التجريبية (اليوم)
        $endDate = now()->addDays(30); // تاريخ نهاية الفترة التجريبية (بعد 30 يوماً)
    
        // إنشاء المستخدم في قاعدة البيانات
        $user = User::create([
            'name' => $RegisterRequest->name,
            'phone_number' => $RegisterRequest->phone_number,
            'email' => $RegisterRequest->email,
            'password' => bcrypt($RegisterRequest->password),
            'code' => $code,
            'is_verified' => 0, // المستخدم لم يتم التحقق منه بعد
            'lesson_pass_count' => 0, // عدد الدروس المكتملة مبدئياً صفر
            'start_date_trailer' => $startDate, 
            'end_date_trailer' => $endDate, 
        ]);
    
        $success['user'] = $user;
    
        return $this->sendResponse(__('auth.verify_code'), $success);
    }

   public function logIn(LogInRequest $LogInRequest)
    {
        
        $credentials = ['phone_number' => $LogInRequest->phone_number, 'password' => $LogInRequest->password];
    
        if (!Auth::attempt($credentials)) {
            return $this->sendError(__('auth.failed'), 401);
        }
    
        $user = auth()->user(); 
    
        // إذا كان الحساب غير مفعل
        if ($user->is_verified == 0) {
            // إرسال كود التحقق عبر خدمة SMS
            $code = mt_rand(100000, 999999);
            $smsService = new SmsService();
            $smsResponse = $smsService->sendVerificationCode($LogInRequest->phone_number, $code);
    
            // تحديث الكود في الداتا بيز
            $user->update(['code' => $code]);
    
            if (!$smsResponse) {
                return $this->sendError(__('auth.failed_code_sent'), 500); 
            }
    
            return $this->sendError(__('auth.unverified_account'), 403); 
        }
    
        // إنشاء توكين جديد
        $token = $user->createToken("SadaSignToken")->plainTextToken;
    
        $success['token'] = $token;
        $success['user'] = $user;
    
        return $this->sendResponse(__('auth.login_success'), $success);
    }


    public function verifyCode(VerifyRequest $VerifyRequest)
{
    // تحقق من وجود المستخدم
    $user = User::where('phone_number', $VerifyRequest->phone_number)->first();

    if (!$user) {
        return $this->sendError(__('auth.user_not_found'), 404); 
    }

    // تحقق من الكود
    if ($user->code != $VerifyRequest->code) {
        return $this->sendError(__('auth.invalid_verification_code'), 400);
    }

    // تحديث حالة الحساب إلى مفعل
    $user->is_verified = 1;
    $user->code = null; // مسح الكود بعد التحقق
    $user->save(); // حفظ التغييرات في قاعدة البيانات

    
    $token = $user->createToken("SadaSignToken", )->plainTextToken;

    return $this->sendResponse(__('auth.verification_success'), [
        'user' => $user,
        'token' => $token,
        'message' => __('auth.account_verified')
    ]);
}

public function resendCode(ResendCodeRequest $ResendCodeRequest)
{
    // البحث عن المستخدم بواسطة رقم الهاتف
    $user = User::where('phone_number', $ResendCodeRequest->phone_number)->first();

    if (!$user) {
        return $this->sendError(__('auth.user_not_found'), 404); 
    }

    // التحقق إذا كان الحساب مفعل بالفعل
    if ($user->is_verified == 1) {
        return $this->sendError(__('auth.already_verified'), 400);
    } 
    //اذا مش مفعل 

    // رح ينشئلي كود تحقق جديد
    $code = mt_rand(100000, 999999);

    // 
    $smsService = new SmsService();
    $smsResponse = $smsService->sendVerificationCode($user->phone_number, $code);

    if (!$smsResponse) {
        return $this->sendError(__('auth.failed_code_sent'), 500); // فشل إرسال الكود
    }
    //في حال انبعت 

    // تحديث الكود في قاعدة البيانات
    $user->update(['code' => $code]);

    return $this->sendResponse(__('auth.code_resent_successfully'), [
        'message' => __('auth.verification_code_sent'),
        'code' => $code  
    ]);
}


    
    
}    