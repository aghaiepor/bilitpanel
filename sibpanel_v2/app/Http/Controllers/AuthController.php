<?php

namespace App\Http\Controllers;

use App\Api\Api;
use App\Rules\Captcha;
use Carbon\Carbon;
use Dotenv\Dotenv;
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

        if(isset($_SERVER['HTTP_REFERER']) )
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
//            if($response['ContentData']['otp_verify']){
//                return redirect()->route('otp');
//            }
//            else{
                if(session()->has("Per_UserId"))
                {
                    if((int)session()->get("Per_UserId") != (int)session('UserInfo')['user_id'] )
                        $previous_url = null ;

//                return $previous_url ;
                    session()->forget('Per_UserId');
                }

                // Get project logo
                $project_ids = $response['ContentData']['project_ids'] ;
//                return $project_ids ;
                if($project_ids[0] == "*" )
                    $logo_id = 1 ;
                else
                    $logo_id = min($project_ids) ;

                $address = $this->api->GetPicturesInfo(0,0,$logo_id,0) ;
//                return $address ;
                if($address["Header"]["Status"] == 0 )
                    $ImageInfo = $address["ContentData"]["project_pics"];
                else
                    $ImageInfo = [] ;

            if(count($ImageInfo) != 0 )
                {
                    foreach ($ImageInfo as $pic ) {
                        if($pic["tag"] == "logo")
                        {
                            $project_image = $pic['picture_id'];
                            $main_image_address = $this->api->GetImageAddress($project_image) ;
//                            return $main_image_address;
                        }
                    }
                }else
                {
                    $main_image_address = null ;
                }
//                return $main_image_address ;

                if($main_image_address == null )
                    $address = asset("") .  "assets/img/placeholder.jpg" ;
                else
                    $address = $main_image_address ;

                session(["logoAddress" =>  $address]);
                return redirect()->Route('loading')->with( ['previous_url' => $previous_url] );
//            }

        }else
        {
            return redirect()->back()->with('error' , ' نام کاربری یا رمز عبور وارد شده معتبر نیست . ');
        }
//        return json_encode($response);
    }

    public function logout(Request $request){


//        Cache::flush();
        if(session()->has("UserInfo"))
        {
        Cache::forget('LocationList' . session('UserInfo')['user_id'] );
        Cache::forget('ServiceList' . session('UserInfo')['user_id']);
        Cache::forget('ProvinceList' . session('UserInfo')['user_id']);
        Cache::forget('SellerUserList' . session('UserInfo')['user_id']);
        Cache::forget('SaleTypeList' . session('UserInfo')['user_id']);
        Cache::forget('VoucherTypeList' . session('UserInfo')['user_id']);
        Cache::forget('GetInfo' . session('UserInfo')['user_id']);
        Cache::forget('GetVoucherText' . session('UserInfo')['user_id']);
        Cache::forget('ProjectList'. session('UserInfo')['user_id']);

        session(["Per_UserId" => session('UserInfo')['user_id']]);
        }



        session()->forget('SessionId');
        session()->forget('sidebarState') ;
        session()->forget('logoAddress');
        session()->forget('UserInfo');
        session()->forget('otpAccept');
        session()->forget("expire_otp_time");
        session()->forget("expire_otp_time");
        session()->forget("backPlace");
        if(!session()->has('SessionId')){
            return redirect('login');
        } else
            return redirect()->back();

    }

    public function otpIndex()
    {
        $user_id = session('UserInfo')['user_id'] ;
        if(!session()->has("expire_otp_time")){
            $GenerateOtp = $this->api->GenerateOtp($user_id);
//            return $GenerateOtp;
            session(['expire_otp_time' => Carbon::now()->addMinutes(5)]);
        }
        else
            {
//                return Carbon::now()->secondsSinceMidnight() /*session()->get("expire_otp_time") * 100*/  ;
            if(session()->get("expire_otp_time")  < Carbon::now()){
                session()->forget("expire_otp_time");
                $GenerateOtp = $this->api->GenerateOtp($user_id);
                session(['expire_otp_time' => Carbon::now()->addMinutes(5)]);
            }
        }
        return view("otp");
    }
    public function VerifyOtp(Request $request)
    {
        $otp = (int)$request->get("number") ;
        $VerifyOtp = $this->api->VerifyOtp($otp);
        if($VerifyOtp["Header"]["Status"] == 0)
        {
            session(["otpAccept" => true]);
        }
        return $VerifyOtp ;
    }
    public function VerifyOtpNew(Request $request)
    {
        $user_id = session('UserInfo')['user_id'] ;
        session()->forget("expire_otp_time");
        $GenerateOtp = $this->api->GenerateOtp($user_id);
        session(['expire_otp_time' => Carbon::now()->addMinutes(5)]);
        return $GenerateOtp ;
    }
    public function test(){

        $logo_id = 1;
        $address = $this->api->GetPicturesInfo(0,0,$logo_id,0) ;
//                return $address ;
        if($address["Header"]["Status"] == 0 )
            $ImageInfo = $address["ContentData"]["project_pics"];
        else
            $ImageInfo = [] ;


        if(count($ImageInfo) != 0 )
        {
            foreach ($ImageInfo as $pic ) {
                if($pic["tag"] == "logo")
                {
                    $project_image = $pic['picture_id'];
                    $main_image_address = $this->api->GetImageAddress($project_image) ;

                }
            }
        }else
        {
            $main_image_address = null ;
        }

        return $main_image_address;

//        $test = [
//            [
//            "id" => 1 ,
//            "name" => "amirhossein" ,
//            "age" =>  20 ,
//            "car" => [
//                "model" => "206" ,
//                "model" => "pride" ,
//            ]
//            ] ,
//            [
//                "id" => 2 ,
//                "name" => "ali" ,
//                "age" =>  18 ,
//                "car" => [
//                    "model" => "bmw" ,
//                    "model" => "benz" ,
//                ]
//            ]
//        ];
//        Cache::rememberForever('test' . session('UserInfo')['user_id'] , function() use ($test) {
//            return $test;
//        });
//        return "Cashed !";
//        return $test;
//        Cache::forget("test" . session('UserInfo')['user_id'] );
//        Cache::rememberForever('test' . session('UserInfo')['user_id'] , function() use ($test) {
//            return $test;
//        });
//        $funList = Cache::get("test" . session('UserInfo')['user_id'] ) ;
//        $List = array_filter($funList, function ($event)  {
//            return $event['name'] == "ali" ;
//        });
//        $array_keys = array_keys($List) ;
//        $funList[$array_keys[0]]["name"] = "reza" ;

//        return $funList[$array_keys[0]]["name"];
//        Cache::rememberForever('test' . session('UserInfo')['user_id'] , function() use ($funList) {
//            return $funList;
//        }) ;
//        return  $array_keys ;
//        $funList = $List ;
//        return  $funList;


    }

    public function savestate(Request $request){
//        $mini = ($request->get("min") == "true") ? true : false ;
        if (session()->has('sidebarState')) {
            session()->forget('sidebarState') ;
        }
        else {
            session(["sidebarState" => "sidebar-mini" ]) ;
        }
    }
}
