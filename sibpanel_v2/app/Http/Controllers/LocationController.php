<?php

namespace App\Http\Controllers;

use App\Api\Api;
use Carbon\Carbon;
use Facade\Ignition\Support\Packagist\Package;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Exceptions\CustomException;

class LocationController extends Controller
{
    var $api = null ;

    public function __construct()
    {
        $this->api = new Api();
    }
    // ******* Location
    public function index()
    {
        $locations = Cache::get('LocationList' . session('UserInfo')['user_id']) ;
//        return $locations ;
        $locations = array_filter($locations, function ($event) {
            return $event['project_id'] == 1;
        });
        $locations = array_values($locations) ;

        $province = Cache::get('ProvinceList' . session('UserInfo')['user_id']) ;
        $GetProjectList = Cache::get('ProjectList' . session('UserInfo')['user_id']);
        $GetVoucherText = Cache::get("GetVoucherText" . session('UserInfo')['user_id']);
        $city_id_list = null ;
        return view('places' , ['locations' => $locations,  'province' => $province , 'GetVoucherText' => $GetVoucherText , "GetProjectList"=> $GetProjectList , "city_id_list"=>$city_id_list ]);
    }
    public function AddLocation(Request $request){
//        return json_encode($request->all());

        $location_name = $request->get('location_name') ;
        $location_english_name = $request->get('location_english_name') ;
        $location_address = $request->get('location_address') ;
        $location_english_address = $request->get('location_english_address') ;
        $province_id = $request->get('province_id') ;
        $location_priority = $request->get('location_priority') ;
        $city_id = $request->get('city_id');
        $text_id = $request->get('text_id');
        $longitude= $request->get('longitude');
        $latitude = $request->get('latitude');
        $project_id = $request->get('project_id');
        $mandatory_entrance = ($request->input('mandatory_entrance') == "on") ? true : false ;
//        Log::info( 'mandatory_entrance' . $mandatory_entrance);
        $addLocation = $this->api->AddLocation($location_name,$province_id,$text_id,$city_id,$location_english_name,$location_address,$location_english_address,$mandatory_entrance,$longitude, $latitude ,$project_id ,$location_priority );
//        return $addLocation;
        if ($addLocation['Header']['MessageCode'] == 0){
            $data = [
                "id" => $addLocation['ContentData']['location_id'] ,
                "payment_id" => "",
                "warehoff" => false,
                "has_QR"=> false,
                "bulky_sale"=> false,
                "print_pos"=> false,
                "location_name"=> $location_name,
                "activation"=> true,
                "location_english_name"=> $location_english_name,
                "location_address"=> $location_address,
                "location_english_address"=> $location_english_address,
                "province_id"=> $province_id,
                "city_id"=> $city_id,
                "mandatory_entrance"=> $mandatory_entrance,
                "presell_activation"=> false,
                "latitude" => $latitude ,
                "longitude" => $longitude ,
                "project_id" => $project_id ,
                "location_priority" => $location_priority,
                "text" => [
                "id" => $text_id,
                "top_text" => $request->get('top_text'),
                "bottom_text" => $request->get('bottom_text'),
                "english_top_text" =>  $request->get('english_top_text'),
                "english_bottom_text" => $request->get('english_bottom_text')
                ]
            ];
            Log::info($data);
            $locations = Cache::get('LocationList' . session('UserInfo')['user_id']) ;
            array_push($locations , $data);
            Cache::forget('LocationList' . session('UserInfo')['user_id']);
            Cache::rememberForever('LocationList' . session('UserInfo')['user_id'], function() use ($locations){
                return $locations;
            });

           /* if(env("HAS_OFFICE_NO")) {
                // **** for shahdari project *****
                $location_id = $addLocation['ContentData']['location_id'];
                $project_name = "shahrdari";
                $owner_name = "shahrdari";
                $shaba = "123";
                $payment_id = $request->get("officeNo");
                $AddClearingAccount = $this->api->AddClearingAccount($location_id, $project_name, $owner_name, $shaba, $payment_id);
//                return $AddClearingAccount ;
            }*/
            return redirect()->back()->with('success' , ' مکان مورد نظر اضافه گردید . ');
        }
        elseif ($addLocation['Header']['MessageCode'] ==36)
            return redirect()->back()->with('error' , ' مکان مورد نظر در استان و شهر انتخابي تعريف شده است . ');
        else
          return redirect()->back()->with('error' , ' خطا در ایجاد مکان . ');


//            return redirect()->back()->with('error' , ' خطا در ایجاد مکان . ');
//        return json_encode($addLocation);
    }
    public function EditLocation(Request $request , $id){
        $getLoction = $this->api->GetLocation($id);
        $location_name = $request->get('location_name') ;
        $location_english_name = $request->get('location_english_name') ;
        $location_address = $request->get('location_address') ;
        $location_english_address = $request->get('location_english_address') ;
        $location_id = $id ;
        $text_id = $request->get('text_id') ;
//        return $request->all() ;
        $mandatory_entrance = ($request->input('mandatory_entrance') == "on") ? true : false ;
        $location_priority = $request->get('location_priority') ;
        $longitude= $request->get('longitude');
        $latitude = $request->get('latitude');
        $introduction = $getLoction['ContentData'][0]['introduction'];
        $description =  $getLoction['ContentData'][0]['description'];
        $EditLocation = $this->api->EditLocation($location_name,$text_id,$location_english_name,$location_english_address,$location_address,$location_id,$mandatory_entrance,$longitude, $latitude,$introduction,$description , $location_priority);
//        return $EditLocation;
        if ($EditLocation['Header']['MessageCode'] == 0){

            $locations = Cache::get('LocationList' . session('UserInfo')['user_id']) ;
            $locationIndex = array_filter($locations, function ($event) use ($id) {
                return $event['id'] == $id;
            });
            $locationIndex = array_keys($locationIndex) ;
            $locations[$locationIndex[0]]["location_name"] = $location_name ;
            $locations[$locationIndex[0]]["location_english_name"] = $location_english_name ;
            $locations[$locationIndex[0]]["location_address"] = $location_address ;
            $locations[$locationIndex[0]]["location_english_address"] = $location_english_address ;
            $locations[$locationIndex[0]]["mandatory_entrance"] = $mandatory_entrance ;
            $locations[$locationIndex[0]]["latitude"] = $latitude ;
            $locations[$locationIndex[0]]["longitude"] = $longitude ;
            $locations[$locationIndex[0]]["introduction"] = $introduction ;
            $locations[$locationIndex[0]]["description"] = $description ;
            $locations[$locationIndex[0]]["location_priority"] = $location_priority ;
            $locations[$locationIndex[0]]["text"] = [
                "id" => $text_id,
                "top_text" => $request->get('top_text'),
                "bottom_text" => $request->get('bottom_text'),
                "english_top_text" =>  $request->get('english_top_text'),
                "english_bottom_text" => $request->get('english_bottom_text')
            ] ;

            Cache::forget('LocationList' . session('UserInfo')['user_id']);
            Cache::rememberForever('LocationList' . session('UserInfo')['user_id'], function() use ($locations){
                return $locations;
            });

            return redirect()->back()->with('success' , ' مکان مورد ویرایش گردید . ');
        }
        else
            return redirect()->back()->with('error' , ' خطا در ویرایش مکان ! ');


    }
    public function DeleteLocation($id){
        $DeleteLocation = $this->api->DeleteLocation($id);
//        return $DeleteLocation ;
        if ($DeleteLocation['Header']['MessageCode'] == 0){
            $locations = Cache::get('LocationList' . session('UserInfo')['user_id']) ;
            $locationIndex = array_filter($locations, function ($event) use ($id) {
                return $event['id'] == $id;
            });
            $locationIndex = array_keys($locationIndex) ;
            unset($locations[$locationIndex[0]]);
            Cache::forget('LocationList' . session('UserInfo')['user_id']);
            Cache::rememberForever('LocationList' . session('UserInfo')['user_id'], function() use ($locations){
                return $locations;
            });
            return redirect()->back()->with('success' , ' مکان مورد حذف گردید . ');
        }
        else if ($DeleteLocation['Header']['MessageCode'] == 133){
            return redirect()->back()->with('error' , ' شما مجاز به انجام این عملیات نیستید . ');
        }
        else
            return redirect()->back()->with('error' , ' خطا در حدف مکان . ');

    }

    public function LocationActivation( Request $request ){
        $data = [ 'data' => false ];
        $is_active = ($request->get('value') == 'true') ? True : False ;
        $location_id = $request->get('location') ;
        $LocationActivation = $this->api->LocationActivation($location_id , $is_active);
        if ($LocationActivation['Header']['MessageCode'] == 0){

            $locations = Cache::get('LocationList' . session('UserInfo')['user_id']) ;
            $locationIndex = array_filter($locations, function ($event) use ($location_id) {
                return $event['id'] == $location_id;
            });
            $locationIndex = array_keys($locationIndex) ;
            $locations[$locationIndex[0]]["activation"] = $is_active ;
            Cache::forget('LocationList' . session('UserInfo')['user_id']);
            Cache::rememberForever('LocationList' . session('UserInfo')['user_id'], function() use ($locations){
                return $locations;
            });
        }
//        else if ($LocationActivation['Header']['MessageCode'] == 133){
//            return  $data = [ 'data' => "Permission Denied" ];
//        }
//        else
            return $LocationActivation;
    }
    public function PosPrintActivation( Request $request ){
        $data = [ 'data' => false ];
        $is_active = ($request->get('value') == 'true') ? True : False ;
        $location_id = $request->get('location') ;
        $PosPrintActivation = $this->api->PosPrintActivation($location_id , $is_active);
        if ($PosPrintActivation['Header']['MessageCode'] == 0){

            $locations = Cache::get('LocationList' . session('UserInfo')['user_id']) ;
            $locationIndex = array_filter($locations, function ($event) use ($location_id) {
                return $event['id'] == $location_id;
            });
            $locationIndex = array_keys($locationIndex) ;
            $locations[$locationIndex[0]]["print_pos"] = $is_active ;
            Cache::forget('LocationList' . session('UserInfo')['user_id']);
            Cache::rememberForever('LocationList' . session('UserInfo')['user_id'], function() use ($locations){
                return $locations;
            });

            return  $data = [ 'data' => true ];
        }
        else
            return $data;
    }
    public function QRActivation( Request $request ){
        $data = [ 'data' => false ];
        $is_active = ($request->get('value') == 'true') ? True : False ;
        $location_id = $request->get('location') ;
        $PosPrintActivation = $this->api->QRActivation($location_id , $is_active);
        if ($PosPrintActivation['Header']['MessageCode'] == 0){
            $locations = Cache::get('LocationList' . session('UserInfo')['user_id']) ;
            $locationIndex = array_filter($locations, function ($event) use ($location_id) {
                return $event['id'] == $location_id;
            });
            $locationIndex = array_keys($locationIndex) ;
            $locations[$locationIndex[0]]["has_QR"] = $is_active ;
            Cache::forget('LocationList' . session('UserInfo')['user_id']);
            Cache::rememberForever('LocationList' . session('UserInfo')['user_id'], function() use ($locations){
                return $locations;
            });
            return  $data = [ 'data' => true ];
        }
        else
            return $data;
    }

    public function getLocationFilter(Request $request){
        $project_id = $request->get("project_id");
        $city_id = $request->get("city_id");
        $province_id = $request->get("province_id");

        $locations = $this->api->location_list( $province_id , $city_id , null ,$project_id);
        $province = Cache::get('ProvinceList' . session('UserInfo')['user_id']) ;
        $GetVoucherText = Cache::get("GetVoucherText" . session('UserInfo')['user_id']);
        $GetProjectList = Cache::get('ProjectList' . session('UserInfo')['user_id']);
        if(is_null($province_id))
            $city_id_list = null ;
        else{
            $city_id_list = $this->api->CityList($province_id , null ) ;
            $city_id_list = $city_id_list["ContentData"] ;
        }
//        return $city_id_list;

        return view('places' , ['locations' => $locations['ContentData'], 'province' => $province , 'GetVoucherText' => $GetVoucherText , "GetProjectList" => $GetProjectList , "city_id_list"=>$city_id_list ]);
    }

    public function AddLocationOff( Request $request , $id){
//        return json_encode($request->all());
        $project_id = 0 ;
        $location_id = (int)$id ;
        $service_id = 0 ;
        $voucher_info_id =  0;
        $sib_user_id = 0 ;
        $description = $request->get("description") ;
        if(is_null($description))
            $description = "";

        $percentage = (int)$request->get("percentage") ;
        if(is_null($percentage))
            return redirect()->back()->with("error" , "خطا در ایجاد تخفیف : لطفا درصد تخفیف را وارد نمایید .  ");

        $activation_date = $request->get("activation_date") ;
        $activation_date = $this->fa2en($activation_date);
        $activation_date = Verta::parse($activation_date)->timestamp;
        $activation_date = Carbon::createFromTimestamp($activation_date)->format('Y-m-d h:i');

        $expiration_date = $request->get("expiration_date") ;
        $expiration_date = $this->fa2en($expiration_date);
        $expiration_date = Verta::parse($expiration_date)->timestamp;
        $expiration_date = Carbon::createFromTimestamp($expiration_date)->format('Y-m-d h:i');

            $AddDiscountPolicy = $this->api->AddDiscountPolicy($project_id ,$location_id ,$service_id , $voucher_info_id ,$sib_user_id ,$description ,$percentage ,$activation_date ,$expiration_date);
//        return $AddDiscountPolicy;
        if($AddDiscountPolicy["Header"]["Status"] == 0 )
            return redirect()->back()->with("success" , " تخفیف مورد نظر ایجاد گردید ");
        else if($AddDiscountPolicy['Header']['MessageCode'] == 133)
            return redirect()->back()->with("error" , "منع دسترسی : شما مجاز به انجام چنین عملیاتی نیستید !   ");
        else if($AddDiscountPolicy["Header"]["MessageCode"] == 158)
            return redirect()->back()->with("error" , "خطا در ايجاد تخفيف : تاريخ وارد شده نامعتبر است !   ");
        else
            return redirect()->back()->with("error" , "خطا در ایجاد تخفیف !  ");


    }

    // ******* Service
    public function GetService($id){
        $locationID = $id ;
        $projectList = $this->api->ProjectList();
        $GetServices = Cache::get('ServiceList' . session('UserInfo')['user_id']);

        $LocationList = Cache::get('LocationList' . session('UserInfo')['user_id']);
        $LocationList = array_filter($LocationList, function ($event) use ($locationID) {
            return $event['id'] == $locationID;
        });
        $LocationList = array_values($LocationList) ;
        if(count($LocationList) == 0)
            return abort("404");

        $info = $LocationList[0] ;
//        return $info ;

        $GetServices = array_filter($GetServices, function ($event) use ($locationID) {
            return $event['location_id'] == $locationID;
        });
        $GetServices = array_values($GetServices) ;

        $service_pics = [];
        $service_id_image = [];

        foreach($GetServices as $Service){
            $GetPicturesInfo = $this->api->GetPicturesInfo(null,$Service['service_id'],null,null);
            if(array_key_exists("service_pics" , $GetPicturesInfo['ContentData'])){
                $service_pics = $GetPicturesInfo['ContentData']['service_pics'];
                foreach ($service_pics as $pic){
                    if($pic['tag'] == 'main')
                    {
                        $image = [
                            'service_id' => $Service['service_id'] ,
                            'picture_id' =>$pic['picture_id']
                        ];
                        array_push($service_id_image,$image);
                    }

                }
            }
        }
        return view('services' , [
            'GetServices'=> $GetServices ,
            'service_pics'=>$service_id_image ,
            'location_id' => $locationID ,
            'projectList' => $projectList['ContentData'] ,
            'info' => $info ,
        ]);

    }
    public function AddService(Request $request ,$location_id ){
            $service_name = $request->get("service_name");
            $service_english_name = $request->get("service_english_name");
            $model_id = $request->get("model_id");
            $TypeOfServiceSale = $request->get("TypeOfServiceSale");
            if(is_null($TypeOfServiceSale))
                $TypeOfServiceSale = "";
            $description = $request->get("description");
            if (is_null($description))
                $description = "" ;
            $capacity = (int)$request->get("capacity");
            if ($capacity == 0 )
                $capacity = "";
            $normal_sale = ($request->get("normal_sale") == 'on') ? 1 : 0 ;
            $AddService  = $this->api->AddService($service_name, $capacity, $service_english_name, $model_id, $description, $location_id , $TypeOfServiceSale);
//            return $AddService;
            if ($AddService['Header']['Status'] == 0){

                $data = [
                    "service_id"=> $AddService["ContentData"]["service_id"],
                    "type_of_service_sale" => $TypeOfServiceSale,
                    "location_id" => $location_id,
                    "service_name"=> $service_name,
                    "english_name" => $service_english_name,
                    "description"=> $description,
                    "activation" => false,
                    "capacity" => $capacity,
                    "model_id" => $model_id,
                    "normal_sale"=> ($request->get("normal_sale") == 'on') ? true : false,
                ];

                $GetServices = Cache::get('ServiceList' . session('UserInfo')['user_id']);
                array_push($GetServices , $data);
                Cache::forget('ServiceList' . session('UserInfo')['user_id']);
                Cache::rememberForever('ServiceList' . session('UserInfo')['user_id'], function() use ($GetServices){
                    return $GetServices;
                });

                return redirect()->back()->with('success' , 'جاذبه مورد نظر ایحاد گردید');
            }
            else if ($AddService['Header']['MessageCode'] == 133){
                return redirect()->back()->with('error' , 'خطا : شما مجاز به انجام این عملیات نیستید  !  ');
            }
            else if ($AddService['Header']['MessageCode'] == 15){
                return redirect()->back()->with('error' , 'خطا : سرویس ایجاد شده تکراریست !  ');
            }
            else if ($AddService['Header']['MessageCode'] == 183){
                return redirect()->back()->with('error' , 'خطا : ورودی قبلا وارد شده است !  ');
            }
            else
                return redirect()->back()->with('error' , 'خطا در ایجاد جاذبه جدید ');

    }
    public function EditService(Request $request ,$service_id,$location_id ){
//            return $request->all();
            $service_name = $request->get("service_name");
            $service_english_name = $request->get("service_english_name");
            $model_id = $request->get("model_id");
            $TypeOfServiceSale = $request->get("TypeOfServiceSale");
            if(is_null($TypeOfServiceSale))
                $TypeOfServiceSale = "";
            $description = $request->get("description");
            if(is_null($description))
                $description = "";
            $capacity = $request->get("capacity");
            if(is_null($capacity))
                $capacity = "" ;
            $normal_sale = ($request->get("normal_sale") == 'on') ? 1 : 0 ;

            $EditService  = $this->api->EditService($service_name, $capacity, $service_english_name, $model_id,$service_id, $description, $location_id, $normal_sale , $TypeOfServiceSale);
//            return $EditService;
                if ($EditService['Header']['Status'] == 0){
                    $GetServices = Cache::get('ServiceList' . session('UserInfo')['user_id']);
                    $Service = array_filter($GetServices, function ($event) use ($location_id , $service_id) {
                        return $event['location_id'] == $location_id && $event['service_id'] == $service_id ;
                    });
                    $Service = array_keys($Service) ;
                    $GetServices[$Service[0]]["service_name"] = $service_name ;
                    $GetServices[$Service[0]]["english_name"] = $service_english_name ;
                    $GetServices[$Service[0]]["capacity"] = $capacity ;
                    $GetServices[$Service[0]]["description"] =$description ;
                    $GetServices[$Service[0]]["type_of_service_sale"] =$TypeOfServiceSale ;
                    $GetServices[$Service[0]]["normal_sale"] =($request->get("normal_sale") == 'on') ? true : false ;

                    Cache::forget('ServiceList' . session('UserInfo')['user_id']);
                    Cache::rememberForever('ServiceList' . session('UserInfo')['user_id'], function() use ($GetServices){
                        return $GetServices;
                    });

                    return redirect()->back()->with('success' , 'تغییرات اعمال گردید');
                }
                else if ($EditService['Header']['MessageCode'] == 133){
                    return redirect()->back()->with('error' , 'خطا : شما مجاز به انجام این عملیات نیستید  !  ');
                }
                else if ($EditService['Header']['MessageCode'] == 183){
                    return redirect()->back()->with('error' , 'خطا : ورودی قبلا وارد شده است !  ');
                }
                else
                    return redirect()->back()->with('error' , 'خطا در اعمال تغییرات! ');
//        return $EditService ;

    }
    public function DeleteService(Request $request ,$service_id ){

            $EditService  = $this->api->DeleteService($service_id);
                if ($EditService['Header']['Status'] == 0){

                    $GetServices = Cache::get('ServiceList' . session('UserInfo')['user_id']);
                    $Service = array_filter($GetServices, function ($event) use ($service_id) {
                        return $event['service_id'] == $service_id ;
                    });
                    $Service = array_keys($Service) ;
                    unset($GetServices[$Service[0]]);
                    Cache::forget('ServiceList' . session('UserInfo')['user_id']);
                    Cache::rememberForever('ServiceList' . session('UserInfo')['user_id'], function() use ($GetServices){
                        return $GetServices;
                    });

                    return redirect()->back()->with('success' , 'تغییرات اعمال گردید');
                }
                else
                    return redirect()->back()->with('error' , 'خطا در اعمال تغییرات! ');
//        return $EditService ;

    }
    public function ServiceActivation(Request $request){
            $data = [ 'data' => false ];
            $service_id = $request->get('service');
            $service_activation = ($request->get('value') == 'true') ? True : False;
            $ServiceActivation  = $this->api->ServiceActivation($service_id , $service_activation);
                if ($ServiceActivation['Header']['Status'] == 0){

                    $GetServices = Cache::get('ServiceList' . session('UserInfo')['user_id']);
                    $Service = array_filter($GetServices, function ($event) use ( $service_id) {
                        return $event['service_id'] == $service_id ;
                    });
                    $Service = array_keys($Service) ;
                    $GetServices[$Service[0]]["activation"] = $service_activation ;

                    Cache::forget('ServiceList' . session('UserInfo')['user_id']);
                    Cache::rememberForever('ServiceList' . session('UserInfo')['user_id'], function() use ($GetServices){
                        return $GetServices;
                    });

                    $data = [ 'data' => true ];
                    return $data ;
                }
                else if ($ServiceActivation['Header']['MessageCode'] == 133){
                    return  $data = [ 'data' => "Permission Denied" ];
                }
                else
                    return $data ;
//        return $EditService ;
    }
    public function AddServicePicture(Request $request, $id){
        $location_id = $request->get('location_id');
        $service_id = $id ;
        $project_id = (int)$request->get('project_id');
        if ($request->hasFile('service_image')){
            $image = base64_encode(file_get_contents($request->file('service_image')->path()));
//            return $image;
            $addPicture = $this->api->AddPicture($project_id , 0 , $service_id , 0 , $image , "main");
//            return $addPicture;
            if($addPicture['Header']['Status'] == 0){
                return redirect()->back()->with('success' , ' تصویر مورد نظر آپلود گردید . ');
//                return $addPicture['ContentData']['picture_id'];
            }
            else if($addPicture['Header']['Status'] == 2){
                return redirect()->back()->with('error' , ' تصویر موجود می باشد . برای تعویض تصویر ، تصویر قبلی را حذف نمایید .');
            }
            else
                return redirect()->back()->with('error' , 'خطا در آپلود تصویر !');
        }
        else
            return redirect()->back()->with('error' , 'فایلی جهت آپلود موجود نمی باشد .');

    }
    public function AddServiceOff( Request $request , $id){
//        return json_encode($request->all());
        $project_id = 0 ;
        $location_id = 0 ;
        $service_id = (int)$id ;
        $voucher_info_id =  0;
        $sib_user_id = 0 ;
        $description = $request->get("description") ;
        if(is_null($description))
            $description = "";

        $percentage = (int)$request->get("percentage") ;
        if(is_null($percentage))
            return redirect()->back()->with("error" , "خطا در ایجاد تخفیف : لطفا درصد تخفیف را وارد نمایید .  ");

        $activation_date = $request->get("activation_date") ;
        $activation_date = $this->fa2en($activation_date);
        $activation_date = Verta::parse($activation_date)->timestamp;
        $activation_date = Carbon::createFromTimestamp($activation_date)->format('Y-m-d h:i');

        $expiration_date = $request->get("expiration_date") ;
        $expiration_date = $this->fa2en($expiration_date);
        $expiration_date = Verta::parse($expiration_date)->timestamp;
        $expiration_date = Carbon::createFromTimestamp($expiration_date)->format('Y-m-d h:i');

        $AddDiscountPolicy = $this->api->AddDiscountPolicy($project_id ,$location_id ,$service_id , $voucher_info_id ,$sib_user_id ,$description ,$percentage ,$activation_date ,$expiration_date);
//        return $AddDiscountPolicy;
        if($AddDiscountPolicy["Header"]["Status"] == 0 )
            return redirect()->back()->with("success" , " تخفیف مورد نظر ایجاد گردید ");
        else if($AddDiscountPolicy["Header"]["Message"] == "Permission Denied")
            return redirect()->back()->with("error" , "منع دسترسی : شما مجاز به انجام چنین عملیاتی نیستید !   ");
        else if($AddDiscountPolicy["Header"]["MessageCode"] == 158)
            return redirect()->back()->with("error" , "خطا در ايجاد تخفيف : تاريخ وارد شده نامعتبر است !   ");
        else
            return redirect()->back()->with("error" , "خطا در ایجاد تخفیف !  ");


    }

    //******* Package
    public function PackageList($id){
        $locationID = $id ;
        $Packages = $this->api->GetPackageList($locationID) ;
//        return $Packages ;
        $LocationList = Cache::get('LocationList' . session('UserInfo')['user_id']);
        $LocationList = array_filter($LocationList, function ($event) use ($locationID) {
            return $event['id'] == $locationID;
        });
        $LocationList = array_values($LocationList) ;
        if(count($LocationList) == 0)
            return abort("404");

        $info = $LocationList[0] ;
        $GetServices = Cache::get('ServiceList' . session('UserInfo')['user_id']);
        $GetServices = array_filter($GetServices, function ($event) use ($locationID) {
            return $event['location_id'] == $locationID;
        });
        $GetServices = array_values($GetServices) ;
//        return $GetServices ;
        $VoucherTypes = Cache::get('VoucherTypeList' . session('UserInfo')['user_id']);
//        return  $VoucherTypes ;
//      return $GetServices ;
        return view('Package' , [
            'GetServices'=> $GetServices ,
            'location_id' => $locationID ,
            'Packages' => $Packages["ContentData"] ,
            'VoucherTypes' => $VoucherTypes ,
            'info' => $info ,
        ]);

    }
    public function getServiceWtihVoucherType(Request $request){
        $locationID = $request->get("location_id") ;
        $voucher_type_id = $request->get("voucher_type_id") ;

        $GetServices = Cache::get('ServiceList' . session('UserInfo')['user_id']);
        $GetServices = array_filter($GetServices, function ($event) use ($locationID) {
            return $event['location_id'] == $locationID;
        });
        $service_voucher = [];
        foreach ($GetServices as $Services)
        {
            $VoucherInfoList = $this->api->VoucherInfoList($Services["service_id"]);
            foreach ($VoucherInfoList["ContentData"] as $VoucherInfo)
            {
                if($voucher_type_id == $VoucherInfo["voucher_type_id"])
                {
                    array_push($service_voucher ,  [
                        "ServicesName" => $Services["service_name"] ,
                        "ServicesId" => $Services["service_id"] ,
                        "VoucherAmount" => $VoucherInfo["amount"]
                    ]) ;
                }
            }
        }
        return $service_voucher ;
    }

    public function AddPackage(Request $request , $location_id)
    {
//      return $request->all();
        $name = $request->get("name") ;
        $voucher_type_id = $request->get("voucher_type_id") ;
        $amount = $request->get("amount") ;
        $service_ids = $request->get("service_ids") ;
        if($request->has("service_ids"))
            $service_ids = array_map('intval', $service_ids);
        else
            return redirect()->back()->with("error" , " خطا : سرويس پيکج مورد نظر را وارد نماييد ! ");

        $AddPackage = $this->api->AddPackage($name , $location_id , $service_ids , $amount , $voucher_type_id);
        if($AddPackage["Header"]["Status"] == 0)
        {
            return redirect()->back()->with("success" , " پکیج مورد نظر ايجاد گردید ");
        }
        else
            return redirect()->back()->with("error" , " خطا در ايجاد پيکج ! ");

    }
    public function EditPackage(Request $request , $location_id , $package_id)
    {
//      return $request->all();
        $name = $request->get("name") ;
        $voucher_type_id = $request->get("voucher_type_id") ;
        $amount = $request->get("amount") ;
        $service_ids = $request->get("service_ids") ;
        if($request->has("service_ids"))
            $service_ids = array_map('intval', $service_ids);
        else
            return redirect()->back()->with("error" , " خطا : سرويس پيکج مورد نظر را وارد نماييد ! ");

        $AddPackage = $this->api->EditPackage("" ,$package_id , $name  , $service_ids , $amount , $voucher_type_id);
        if($AddPackage["Header"]["Status"] == 0)
        {
            return redirect()->back()->with("success" , "تغييرات با موفقيت اعمال گرديد . ");
        }
        else
            return redirect()->back()->with("error" , " خطا در اعمال تغييرات ! ");

    }
    public function PackageActivation(Request $request){
        $active = ($request->get("active")) ;
        Log::info($active);
        $package_id = $request->get("package_id");
        $location_id = $request->get("location_id");
        $getPackage = $this->api->GetPackage($package_id);
        $Activation = $this->api->EditPackage($active , $package_id , "" , "", "" , "" , "" ,"ajax") ;
        return $Activation ;
    }
    public function GetPackage(Request $request)
    {
        $id = $request->get("id") ;
        $GetPackage = $this->api->GetPackage($id);
        return $GetPackage ;
    }
    public function DeletePackage($id)
    {
        $DeletePackage = $this->api->DeletePackage($id);
        if($DeletePackage["Header"]["Status"] == 0)
        {
            return redirect()->back()->with("success" , " پکیج مورد نظر حذف گردید ");
        }
        else
            return redirect()->back()->with("error" , " خطا در حذف پيکج ! ");

    }

    // ******* Voucher
    public function VoucherInfoList($service_id , $location_id)
    {
        $GetServices = Cache::get('ServiceList' . session('UserInfo')['user_id']);
        $projectList = $this->api->ProjectList();
        $locationID = $location_id ;
        $GetServices = array_filter($GetServices, function ($event) use ($locationID , $service_id) {
            return $event['location_id'] == $locationID && $event['service_id'] == $service_id ;
        });
        $array_keys = array_keys($GetServices) ;
        $GetServices = $GetServices[$array_keys[0]] ;
        $VoucherInfoList = $this->api->VoucherInfoList($service_id);
        $VoucherTypeList = $this->api->VoucherTypeList();
//        return $VoucherInfoList ;
//        return $VoucherInfoList['ContentData'][0]['id']; // 985 for 147 service_id
        $voucher_id_image = [];
        foreach ($VoucherInfoList['ContentData'] as $voucher){
            $GetPicturesInfo = $this->api->GetPicturesInfo(null,null,null,$voucher['id']);
            if(array_key_exists("voucher_info_pics" , $GetPicturesInfo['ContentData'])){
                $voucher_pics = $GetPicturesInfo['ContentData']['voucher_info_pics'];
                foreach ($voucher_pics as $pic){
                    if($pic['tag'] == 'main')
                    {
                        $image = [
                            'voucher_id' => $voucher['id'] ,
                            'picture_id' =>$pic['picture_id']
                        ];
                        array_push($voucher_id_image,$image);
                    }

                }
            }
        }
//        return $voucher_id_image;
//        return $VoucherInfoList;
        return view('VoucherInfoList' , [
            'VoucherInfo'=> $VoucherInfoList['ContentData'] ,
            'GetServices' =>$GetServices ,
            'service_id'=> $service_id ,
            'location_id' =>$location_id ,
            'voucher_id_image'=> $voucher_id_image ,  'projectList' => $projectList['ContentData'] ,
            'VoucherTypeList' =>$VoucherTypeList["ContentData"]
        ]);
//        return $VoucherInfoList ;

    }
    public function AddVoucherInfoOff( Request $request , $id){
        $project_id = 0 ;
        $location_id = 0 ;
        $service_id = 0 ;
        $voucher_info_id = (int)$id ;
        $sib_user_id = 0 ;
        $description = $request->get("description") ;
        $percentage = (int)$request->get("percentage") ;
        if(is_null($percentage))
            return redirect()->back()->with("error" , "خطا در ایجاد تخفیف : لطفا درصد تخفیف را وارد نمایید .  ");
        $activation_date = $request->get("activation_date") ;
        $activation_date = $this->fa2en($activation_date);
        $activation_date = Verta::parse($activation_date)->timestamp;
        $activation_date = Carbon::createFromTimestamp($activation_date)->format('Y-m-d h:i');

        $expiration_date = $request->get("expiration_date") ;
        $expiration_date = $this->fa2en($expiration_date);
        $expiration_date = Verta::parse($expiration_date)->timestamp;
        $expiration_date = Carbon::createFromTimestamp($expiration_date)->format('Y-m-d h:i');

        $AddDiscountPolicy = $this->api->AddDiscountPolicy($project_id ,$location_id ,$service_id , $voucher_info_id ,$sib_user_id ,$description ,$percentage ,$activation_date ,$expiration_date);
//        return $AddDiscountPolicy;
        if($AddDiscountPolicy["Header"]["Status"] == 0 )
            return redirect()->back()->with("success" , " تخفیف مورد نظر ایجاد گردید ");
        else if($AddDiscountPolicy["Header"]["Message"] == "Permission Denied")
            return redirect()->back()->with("error" , "منع دسترسی : شما مجاز به انجام چنین عملیاتی نیستید !   ");
        else if($AddDiscountPolicy["Header"]["MessageCode"] == 158)
            return redirect()->back()->with("error" , "خطا : زمان وارد شده نامعتبر است !   ");
        else
            return redirect()->back()->with("error" , "خطا در ایجاد تخفیف !  ");


    }
    public function VoucherInfoOff( Request $request , $id){
        $GetDiscountPolicyList = $this->api->GetDiscountPolicyList(0 ,0 ,0 , $id ,0 );
        return view("VoucherInfo_off" , ["GetDiscountPolicyList" =>$GetDiscountPolicyList["ContentData"] , "id" => $id]);
    }
    public function AddVoucherPicture(Request $request, $id){
        $location_id = $request->get('location_id');
        $voucher_id = $id ;
        $project_id = (int)$request->get('project_id');
        if ($request->hasFile('service_image')){
            $image = base64_encode(file_get_contents($request->file('service_image')->path()));
//            return $image;
            $addPicture = $this->api->AddPicture($project_id , 0 , 0 , $voucher_id , $image , "main");
//            return $addPicture;
            if($addPicture['Header']['Status'] == 0){
                return redirect()->back()->with('success' , ' تصویر مورد نظر آپلود گردید . ');
//                return $addPicture['ContentData']['picture_id'];
            }
            else if($addPicture['Header']['Status'] == 2){
                return redirect()->back()->with('error' , ' تصویر موجود می باشد . برای تعویض تصویر ، تصویر قبلی را حذف نمایید .');
            }
            else
                return redirect()->back()->with('error' , 'خطا در آپلود تصویر !');
        }
        else
            return redirect()->back()->with('error' , 'فایلی جهت آپلود موجود نمی باشد .');

    }
    public function AddVoucherInfo(Request $request , $service_id , $location_id){

        $amount = $request->get("amount");
        $voucher_type_id = $request->get("voucher_type_id");
        $exprieMode = $request->get("exprieMode");
        $timetype = $request->get("timetype");
        $max_discount_percentage = (int)$request->get("max_discount_percentage");
        $validity_period = $request->get("validity_period");
        $expiration_date = $request->get("expiration_date");
        $capacity = (int)$request->get("capacity");
        if($capacity == 0 )
            $capacity = '';

        if($exprieMode == "time"){
            $expiration_date = null;
            if($timetype == "min")
                $validity_period *= 60 ;
            else if ($timetype == "hour" )
                $validity_period *= 3600 ;
            else if ($timetype == "day" )
                $validity_period *= 86400 ;
            else if ($timetype == "week" )
                $validity_period *= 604800 ;
            else if ($timetype == "month" )
                $validity_period *= 2419200 ;
            else if ($timetype == "year" )
                $validity_period *= 29030400 ;
        }
        else if($exprieMode == "date" ){
            $validity_period = null;
            $expiration_date = $this->fa2en($expiration_date);
            $expiration_date = Verta::parse($expiration_date)->timestamp;
            $expiration_date = Carbon::createFromTimestamp($expiration_date)->format('Y-m-d h:i');

        }
//        return $expiration_date ;

        $AddVoucherInfo  = $this->api->AddVoucherInfo($service_id, $amount, $voucher_type_id, $capacity, $location_id , $max_discount_percentage , $validity_period , $expiration_date);
//        return $AddVoucherInfo;
        if ($AddVoucherInfo['Header']['Status'] == 0){
            return redirect()->back()->with('success' , 'تغییرات اعمال گردید');
        }
        else if( $AddVoucherInfo['Header']['Message'] == "Repetitious Voucher Info"){
            return redirect()->back()->with('error' , 'نوع بلیت انتخابی موجود است ! ');
        }
        else if( $AddVoucherInfo['Header']['MessageCode'] == 158){
            return redirect()->back()->with('error' , 'خطا : تاریخ نامتعبر است ! ');
        }
        else
            return redirect()->back()->with('error' , 'خطا در اعمال تغییرات! ');

    }
    public function EditVoucherInfo(Request $request , $service_id , $location_id ,$id ){

        $amount = $request->get("amount");
        $voucher_type_id = $request->get("voucher_type_id");
        $exprieMode = $request->get("exprieMode");
        $timetype = $request->get("timetype");
        $max_discount_percentage = (int)$request->get("max_discount_percentage");
        $validity_period = $request->get("validity_period");
        $expiration_date = $request->get("expiration_date");
        $capacity = (int)$request->get("capacity");
        if($capacity == 0 )
            $capacity = '' ;

        if($exprieMode == "time"){
            $expiration_date = null;
            if($timetype == "min")
                $validity_period *= 60 ;
            else if ($timetype == "hour" )
                $validity_period *= 3600 ;
            else if ($timetype == "day" )
                $validity_period *= 86400 ;
            else if ($timetype == "week" )
                $validity_period *= 604800 ;
            else if ($timetype == "month" )
                $validity_period *= 2628000 ;
            else if ($timetype == "year" )
                $validity_period *= 31536000   ;
        }
        else if($exprieMode == "date" ){
            $validity_period = null;
            $expiration_date = $this->fa2en($expiration_date);
            $expiration_date = Verta::parse($expiration_date)->timestamp;
            $expiration_date = Carbon::createFromTimestamp($expiration_date)->format('Y-m-d h:i');

        }
//        return $expiration_date;
        $EditVoucherInfo = $this->api->EditVoucherInfo($id, $voucher_type_id, $service_id, $amount, $capacity, $location_id , $max_discount_percentage , $validity_period , $expiration_date) ;
//        return $EditVoucherInfo;
        if ($EditVoucherInfo['Header']['Status'] == 0){
            return redirect()->back()->with('success' , 'تغییرات اعمال گردید');
        }
        else if( $EditVoucherInfo['Header']['MessageCode'] == 158){
            return redirect()->back()->with('error' , 'خطا : تاریخ نامتعبر است ! ');
        }
        else
            return redirect()->back()->with('error' , 'خطا در اعمال تغییرات! ');

    }
    public function GetVoucherText(Request $request){
        $text = Cache::get("GetVoucherText" . session('UserInfo')['user_id']);
        $text_id = $request->get("id") ;
        $GetText = array_filter($text, function ($event) use ($text_id) {
            return $event['id'] == $text_id;
        });
        $array_keys = array_keys($GetText) ;
        return [
            "GetText" =>$GetText ,
            "array_keys"=>$array_keys
        ] ;
//        return $text ;
    }

    // ***** Citizen
    public function citizenPanel(Request $request , $id){

        try {
            $GetEvent = $this->api->GetEvent($id);
//            return $GetEvent ;
            $projectList = $this->api->ProjectList();
//      $GetPicture = $this->api->GetPicture($id);
//       return $GetEvent;
            /*
            $image = $this->GetImageAddress($GetPicture['content'] , $GetPicture['type']);
            return '<img src="'.$image.'" alt="An elephant" />';
            */
            $locations = Cache::get('LocationList' . session('UserInfo')['user_id']);
            $GetLocations = array_filter($locations, function ($event) use ($id) {
                return $event['id'] == $id;
            });
            $array_keys = array_keys($GetLocations) ;
            $index =  $array_keys[0];
//            return $GetEvent['ContentData'][0]['services'];
            $GetPicturesInfo = $this->api->GetPicturesInfo($id,null,null,null);
//            return $GetPicturesInfo;
//        return $GetPicturesInfo;
            if(array_key_exists("location_pics" , $GetPicturesInfo['ContentData'])){
                $location_pic = $GetPicturesInfo['ContentData']['location_pics'];
//                return $location_pic;
            }

//            return $GetEvent['ContentData']['service_id'];
            $service_id_image = [];
            $services = $GetEvent['ContentData'];
//            return $services ;
            foreach ($services as $service){

                $GetPicturesInfo = $this->api->GetPicturesInfo(null,$service['service_id'],null,null);
                if(array_key_exists("service_pics" , $GetPicturesInfo['ContentData'])){
                    $service_pics = $GetPicturesInfo['ContentData']['service_pics'];
                    foreach ($service_pics as $pic){
                        if($pic['tag'] == 'main')
                        {
                            $image = [
                                'service_id' => $service['service_id'] ,
                                'picture_id' =>$pic['picture_id']
                            ];
                            array_push($service_id_image,$image);
                        }

                    }
                }
            }
            return view("citizen" , ['GetLocations' => $GetLocations[$index] , 'location_pic' => $location_pic , 'service_id_image' =>$service_id_image ,
                    'GetEvents' => $GetEvent['ContentData'] , 'location_id'=>$id , 'projectList' => $projectList['ContentData'] ] ) ;

        } catch (\Exception $e) {
            return $e->getMessage();
//            abort(404);
        }
    }
    public function AddLatLong(Request $request , $id){
        $GetLocation = $this->api->GetLocation($id);
//        return $GetLocation['ContentData'][0]['text']['id'];
        $data = [
            'location' => $GetLocation['ContentData'] ,
            'location_id' => $id,
            'lat' => $request->get('latitude'),
            'long' => $request->get('longitude')
        ];
        $location_name = $GetLocation['ContentData'][0]['location_name'] ;
        $location_english_name = $GetLocation['ContentData'][0]['location_english_name'] ;
        $location_address = $GetLocation['ContentData'][0]['address'] ;
        $location_english_address = $GetLocation['ContentData'][0]['location_address'] ;
        $location_id = $id ;
        $text_id = $GetLocation['ContentData'][0]['text']['id'] ;
        $mandatory_entrance = $GetLocation['ContentData'][0]['mandatory_entrance'] ;
        $longitude= $request->get('longitude');
        $latitude = $request->get('latitude');
        $introduction =  $GetLocation['ContentData'][0]['introduction'] ;
        $description = $GetLocation['ContentData'][0]['description'];
        $EditLocation = $this->api->EditLocation($location_name,$text_id,$location_english_name,$location_english_address,$location_address,$location_id,$mandatory_entrance,$longitude, $latitude,$introduction,$description);
        if ($EditLocation['Header']['MessageCode'] == 0){
            $locations = Cache::get('LocationList' . session('UserInfo')['user_id']) ;
            $locationIndex = array_filter($locations, function ($event) use ($id) {
                return $event['id'] == $id;
            });
            $locationIndex = array_keys($locationIndex) ;
            $locations[$locationIndex[0]]["latitude"] = $latitude ;
            $locations[$locationIndex[0]]["longitude"] = $longitude ;
            Cache::forget('LocationList' . session('UserInfo')['user_id']);
            Cache::rememberForever('LocationList' . session('UserInfo')['user_id'], function() use ($locations){
                return $locations;
            });
            return redirect()->back()->with('success' , ' طول و عرض جغرافیایی ویرایش گردید . ');
        }
        else
            return redirect()->back()->with('error' , ' خطا در ویرایش طول و عرض جغرافیایی ! ');

    }
    public function FullDescription(Request $request , $id)
    {
        $GetLocation = $this->api->GetLocation($id);
//        return $GetLocation;
        $data = [
            'location' => $GetLocation['ContentData'] ,
            'location_id' => $id,
            'lat' => $request->get('latitude'),
            'long' => $request->get('longitude')
        ];
        $location_name = $GetLocation['ContentData'][0]['location_name'] ;
        $location_english_name = $GetLocation['ContentData'][0]['location_english_name'] ;
        $location_address = $GetLocation['ContentData'][0]['address'] ;
        $location_english_address = $GetLocation['ContentData'][0]['location_address'] ;
        $location_id = $id ;
        $text_id = $GetLocation['ContentData'][0]['text']['id'] ;
//      $introduction =  htmlentities($request->get('ShortDescription')) ;
        $introduction =  $GetLocation['ContentData'][0]['introduction'];
        $description =  htmlentities($request->get('FullDescription'));
        $mandatory_entrance = $GetLocation['ContentData'][0]['mandatory_entrance'] ;
        $longitude = $GetLocation['ContentData'][0]['longitude'];
        $latitude = $GetLocation['ContentData'][0]['latitude'];

        $EditLocation = $this->api->EditLocation($location_name,$text_id,$location_english_name,$location_english_address,$location_address,$location_id,$mandatory_entrance,$longitude, $latitude,$introduction,$description);
//        return $EditLocation;
        if ($EditLocation['Header']['MessageCode'] == 0){
            Cache::forget('LocationList' . session('UserInfo')['user_id']);
            Cache::rememberForever('LocationList' . session('UserInfo')['user_id'], function(){
                $Locations  = $this->api->LocationList();
                return $Locations['ContentData'];
            });
            return redirect()->back()->with('success' , ' توضیحات کامل ویرایش گردید . ');
        }
        else
            return redirect()->back()->with('error' , ' خطا در ویرایش توضیحات کامل ! ');

//        $FullDescription =$request->get('ShortDescription');
//        return $FullDescription ;


    }
    public function ShortDescription(Request $request , $id)
    {
        $GetLocation = $this->api->GetLocation($id);
//        return $GetLocation;
        $data = [
            'location' => $GetLocation['ContentData'] ,
            'location_id' => $id,
            'lat' => $request->get('latitude'),
            'long' => $request->get('longitude')
        ];
        $location_name = $GetLocation['ContentData'][0]['location_name'] ;
        $location_english_name = $GetLocation['ContentData'][0]['location_english_name'] ;
        $location_address = $GetLocation['ContentData'][0]['address'] ;
        $location_english_address = $GetLocation['ContentData'][0]['location_address'] ;
        $location_id = $id ;
        $text_id = $GetLocation['ContentData'][0]['text']['id'] ;
//        $introduction =  htmlentities($request->get('ShortDescription')) ;
        $introduction =  htmlentities($request->get('ShortDescription'));
        $description = $GetLocation['ContentData'][0]['description'];
        $mandatory_entrance = $GetLocation['ContentData'][0]['mandatory_entrance'] ;
        $longitude = $GetLocation['ContentData'][0]['longitude'];
        $latitude = $GetLocation['ContentData'][0]['latitude'];

        $EditLocation = $this->api->EditLocation($location_name,$text_id,$location_english_name,$location_english_address,$location_address,$location_id,$mandatory_entrance,$longitude, $latitude,$introduction,$description);
//        return $EditLocation;
        if ($EditLocation['Header']['MessageCode'] == 0){
            Cache::forget('LocationList' . session('UserInfo')['user_id']);
            Cache::rememberForever('LocationList' . session('UserInfo')['user_id'], function(){
                $Locations  = $this->api->LocationList();
                return $Locations['ContentData'];
            });
            return redirect()->back()->with('success' , ' توضیحات کوتاه ویرایش گردید . ');
        }
        else
            return redirect()->back()->with('error' , ' خطا در ویرایش توضیحات کوتاه ! ');

//        $FullDescription =$request->get('ShortDescription');
//        return $FullDescription ;
    }
    public function AddMainPicture(Request $request, $id){

        $project_id = (int)$request->get('project_id');
        if ($request->hasFile('main_image')){
            $image = base64_encode(file_get_contents($request->file('main_image')->path()));
            $addPicture = $this->api->AddPicture($project_id , $id , 0 , 0 , $image , "main");
            if($addPicture['Header']['Status'] == 0){
                return redirect()->back()->with('success' , ' تصویر مورد نظر آپلود گردید . ');
//                return $addPicture['ContentData']['picture_id'];
            }
            else if($addPicture['Header']['Status'] == 2){
                return redirect()->back()->with('error' , ' تصویر موجود می باشد . برای تعویض تصویر ، تصویر قبلی را حذف نمایید .');
            }
            else
                return redirect()->back()->with('error' , 'خطا در آپلود تصویر !');
        }
        else
            return redirect()->back()->with('error' , 'فایلی جهت آپلود موجود نمی باشد .');

    }
    public function AddLogoPicture(Request $request, $id){

        $project_id = (int)$request->get('project_id');
//            return base64_encode(file_get_contents($request->get('logo_image')->path())) ;
        if ($request->hasFile('logo_image')){
            $image = base64_encode(file_get_contents($request->file('logo_image')->path()));
            $addPicture = $this->api->AddPicture($project_id , $id , 0 , 0 , $image , "logo");
//            return $addPicture ;
            if($addPicture['Header']['Status'] == 0){
                return redirect()->back()->with('success' , ' تصویر مورد نظر آپلود گردید . ');
//                return $addPicture['ContentData']['picture_id'];
            }
            else if($addPicture['Header']['Status'] == 2){
                return redirect()->back()->with('error' , ' تصویر موجود می باشد . برای تعویض تصویر ، تصویر قبلی را حذف نمایید .');
            }
            else
                return redirect()->back()->with('error' , 'خطا در آپلود تصویر !');
        }
        else
            return redirect()->back()->with('error' , 'فایلی جهت آپلود موجود نمی باشد .');
    }
    public function AddGalleryPicture(Request $request, $id){

        $project_id = (int)$request->get('project_id');
//            return base64_encode(file_get_contents($request->get('logo_image')->path())) ;
        if ($request->hasFile('location_imgae')){
            $image = base64_encode(file_get_contents($request->file('location_imgae')->path()));
            $addPicture = $this->api->AddPicture($project_id , $id , 0 , 0 , $image , "other");
//            return $addPicture ;
            if($addPicture['Header']['Status'] == 0){
                return redirect()->back()->with('success' , ' تصویر مورد نظر آپلود گردید . ');
            }
            else if($addPicture['Header']['Status'] == 2){
                return redirect()->back()->with('error' , ' تصویر موجود می باشد . برای تعویض تصویر ، تصویر قبلی را حذف نمایید .');
            }
            else
                return redirect()->back()->with('error' , 'خطا در آپلود تصویر !');
        }
        else
            return redirect()->back()->with('error' , 'فایلی جهت آپلود موجود نمی باشد .');

        /*
         $data = [
            'id' => $id ,
            'tag' => 'other' ,
            'image' => base64_encode(file_get_contents($request->file('location_imgae')->path())),
        ];
        return $data ;
        */
    }
    public function AddMainEventPicture(Request $request, $id){
        $data = [
            'id' => $id ,
            'tag' => 'main' ,
            'event_id' => $request->get('event_id'),
            'image' => base64_encode(file_get_contents($request->file('main_image_event')->path())),
        ];
        return $data ;
    }
    private function fa2en($number){
        return strtr($number, array('۰'=>'0', '۱'=>'1', '۲'=>'2', '۳'=>'3', '۴'=>'4', '۵'=>'5', '۶'=>'6', '۷'=>'7', '۸'=>'8', '۹'=>'9', '٠'=>'0', '١'=>'1', '٢'=>'2', '٣'=>'3', '٤'=>'4', '٥'=>'5', '٦'=>'6', '٧'=>'7', '٨'=>'8', '٩'=>'9'));
    }
    public function imageRemove($id , $area=null , $project_id=null){
        $del = $this->api->DeletePicture($id);

        if($del['Header']['Status'] == 0)
        {
            if($area == "project")
            {
                if (session('UserInfo')['projects'][0]["id"] == $project_id)
                {
                    $address = asset("") .  "assets/img/placeholder.jpg" ;
                    session(["logoAddress" =>  $address]);
                }
            }
            return redirect()->back()->with('success' , ' تصویر مورد نظر حذف گردید . ');
        }
        else
            return redirect()->back()->with('error' , ' خطا در حذف تصویر . ');
    }
}
