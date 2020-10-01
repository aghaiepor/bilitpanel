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

    public function loginPage(){
        if (!session()->has('SessionId') || !session()->has('UserInfo') ) {
            return view('Login');
        }else
            return redirect('/');
    }

    public function login(Request $request){


        $validator = Validator::make($request->all(), [
            'g-recaptcha-response' => new Captcha(),
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error' , 'لطفا قسمت امنیتی را تایید نماید.');
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

        $username = $request->get('username');
        $password = $request->get('password');
        $cont = new Api();
        $response = $cont->login($username,$password);
        if ($response['Header']['Status'] == 0 && $response['ContentData']['panel_access']){
            return redirect()->Route('loading');
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

    public function test(){


    }


}
