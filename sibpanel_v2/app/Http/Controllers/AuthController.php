<?php

namespace App\Http\Controllers;

use App\Api\Api;
use App\Rules\Captcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use ReCaptcha\ReCaptcha;

class AuthController extends Controller
{
    var $api;
    public function __construct()
    {
        $this->api = new Api();
    }

    public function loginPage(){
        if(isset($_SERVER['HTTP_REFERER']))
            $previous_url = $_SERVER['HTTP_REFERER'];
        else
            $previous_url = null;

        if (!session()->has('SessionId') || !session()->has('UserInfo') ) {
            return view('Login' , ['previous_url'=>$previous_url]);
        }else
            return redirect('/');
    }

    public function login(Request $request){

        if (env('HAS_CAPTCHA')){
            $validator = Validator::make($request->all(), [
                'g-recaptcha-response' => new Captcha(),
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error' , 'لطفا قسمت امنیتی را تایید نماید.');
            }
        }

/*
        $secret = "6LfvIZUUAAAAAPfAyHi5Gm1hzTEQkUo5c0v0uQzj";
//        return $request->get('captcha') ;
        $response = (new ReCaptcha($secret))
            ->setExpectedAction('login')
            ->verify($request->get('g-captcha-response'), $request->ip());

        if (!$response->isSuccess()) {
            return redirect()->back()->with('error' , 'لطفا قسمت امنیتی را تایید نماید . ');
        }*/
    /*    if ($response->getScore() < 0.6) {
            return "not ok !";
        }*/
        $previous_url = $request->get('previous_url');
        $username = $request->get('username');
        $password = $request->get('password');
        $cont = new Api();
        $response = $cont->login($username,$password);
//        return $response ;
        if ($response['Header']['Status'] == 0 && $response['ContentData']['panel_access']){
            if($response['ContentData']['otp_verify']){
                return redirect()->route('otp');
            }
            else{
                return redirect()->Route('loading')->with( ['previous_url' => $previous_url] );
            }

        }else
        {
            return redirect()->back()->with('error' , ' نام کاربری یا رمز عبور وارد شده معتبر نیست . ');
        }
//        return json_encode($response);
    }

    public function logout(Request $request){
        Cache::flush();
        session()->forget('SessionId');
        session()->forget('UserInfo');
        if(!session()->has('SessionId')){
            return redirect('login');
        } else
            return redirect()->back();

    }

    public function otpIndex()
    {
        return view("otp");
    }
    public function VerifyOtp(Request $request)
    {
        $otp = $request->get("number") ;
        $VerifyOtp = $this->api->VerifyOtp($otp);
        return $VerifyOtp ;
    }

    public function test(){


    }


}
