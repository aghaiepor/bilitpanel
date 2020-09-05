<?php

namespace App\Http\Controllers;

use App\Api\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{

    public function loginPage(){
        if (!session()->has('SessionId') || !session()->has('UserInfo') ) {
            return view('Login');
        }else
            return redirect('/');
    }

    public function login(Request $request){
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
        Cache::forget('LocationList');
        $value = Cache::rememberForever('LocationList', function(){
            $Api = new Api();
            $Locations  = $Api->LocationList();
            return $Locations;
        });
        return Cache::get('LocationList') ;

        /*$value = Cache::rememberForever('LocationList', function(){

        });*/
//        return $Locations ;


    }


}
