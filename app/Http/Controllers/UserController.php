<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Mail\OTPMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class UserController extends Controller
{

    public function loginPage() {
        return Inertia::render('Auth/LoginPage');
    }

    public function registrationPage(){
        return Inertia::render('Auth/RegistrationPage');
    }

    public function sendOtpPage(){
        return Inertia::render('Auth/OTPSendPage');
    }

    public function verifyOtpPage(){
        return Inertia::render('Auth/VerifyOTPPage');
    }

    public function resetPasswordPage(){
        return Inertia::render('Auth/ResetPasswordPage');
    }

    public function userRegistration(Request $request) {
        try{
            $user=$request->validate([
                'name'=>'string|required',
                'email'=>'string|required|unique:users',
                'password'=>'string|required',
                'mobile'=>'string|required',
            ]);

              User::create($user);
              $data=['message'=>'User registered Successfully','status'=>true,'error'=>''];
              return redirect()->route('registrationPage')->with($data);

        }catch(Exception $e){
            $data=['message'=>'User registered Fail','status'=>false,'error'=>$e->getMessage()];
            return redirect()->route('registrationPage')->with($data);
        }


    }

    public function userLogin(Request $request) {
           $request->validate([
               'email'=>'string|required',
               'password'=>'string|required',
           ]);
           $count=User::where('email','=',$request->email)
                    ->where('password','=',$request->password)->first();
           if($count != null){
                $request->session()->put('email',$count->email);
                $request->session()->put('user_id',$count->id);
               $data=['message'=>'User login Successfully','status'=>true,'error'=>''];
               return redirect()->route('loginPage')->with($data);
           }else{
                return redirect()->route('loginPage')->with(['message'=>'User login Fail','status'=>false,'error'=>'something went wrong']);
           }
    }

    public function userLogout(Request $request) {
         $request->session()->flush();
         return redirect()->route('loginPage');
    }

    public function sendOtp(Request $request){
        $request->validate([
            'email'=>'string|required',
        ]);
        $email=$request->email;
        $count=User::where('email','=',$email)->count();
        if($count==1){
            $otp=rand(1000,9999);
            Mail::to($email)->send(new OTPMail($otp));
            User::where('email','=',$email)->update(['otp'=>$otp]);
            $request->session()->put('email',$email);
            return redirect()->route('sendOtpPage')->with(['status'=>true,'message'=>'OTP sent successfully','error'=>'']);

        }else{
            return redirect()->route('sendOtpPage')->with(['status'=>false,'message'=>'OTP sent failed','error'=>'something went wrong']);
        }
    }

    public function verifyOtp(Request $request){

        $email=$request->session()->get('email');
        $otp=$request->otp;
        $count=User::where('email','=',$email)->where('otp','=',$otp)->count();
        if($count==1){
            User::where('email','=',$email)->update(['otp'=>'0']);
            $request->session()->put('otp_verified','yes');
            return redirect()->route('verifyOtpPage')->with(['status'=>true,'message'=>'OTP verified successfully','error'=>'']);

        }else{
            return redirect()->route('verifyOtpPage')->with(['status'=>false,'message'=>'OTP verified failed','error'=>'something went wrong']);
        }
    }

    public function resetPassword(Request $request){
        try{
            $request->validate([
                'password'=>'string|required',
            ]);
            $password=$request->password;
            $userEmail=$request->header('email');
            if($request->session()->get('otp_verified')=='yes'){
                User::where('email','=',$userEmail)->update(['password'=>$password]);
                $request->session()->flush();
               return redirect()->route('resetPasswordPage')->with(['status'=>true,'message'=>'Password reset successfully','error'=>'']);
            }

        }catch(Exception $e){
            return redirect()->route('resetPasswordPage')->with(['status'=>false,'message'=>'Password reset failed','error'=>'something went wrong']);
        }

    }
}
