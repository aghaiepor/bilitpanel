<?php

namespace App\Http\Controllers;

use App\Api\Api;
use Carbon\Carbon;
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
        $locations = Cache::get('LocationList') ;
        $province = Cache::get('ProvinceList') ;
        $GetVoucherText = Cache::get("GetVoucherText");
        return view('places' , ['locations' => $locations, 'province' => $province , 'GetVoucherText' => $GetVoucherText ]);
    }
    public function AddLocation(Request $request){
        $location_name = $request->get('location_name') ;
        $location_english_name = $request->get('location_english_name') ;
        $location_address = $request->get('location_address') ;
        $location_english_address = $request->get('location_english_address') ;
        $province_id = $request->get('province_id') ;
        $city_id = $request->get('city_id');
        $text_id = $request->get('text_id');
        $longitude= $request->get('longitude');
        $latitude = $request->get('latitude');
        $mandatory_entrance = ($request->input('mandatory_entrance') == "on") ? true : false ;
//        Log::info( 'mandatory_entrance' . $mandatory_entrance);
        $addLocation = $this->api->AddLocation($location_name,$province_id,$text_id,$city_id,$location_english_name,$location_address,$location_english_address,$mandatory_entrance,$longitude, $latitude);

//        return $addLocation;
        if ($addLocation['Header']['MessageCode'] == 0){
            Cache::forget('LocationList');
            Cache::rememberForever('LocationList', function(){
                $Locations  = $this->api->LocationList();
                return $Locations['ContentData'];
            });

            if(env("HAS_OFFICE_NO")) {
                // **** for shahdari project *****
                $location_id = $addLocation['ContentData']['location_id'];
                $project_name = "shahrdari";
                $owner_name = "shahrdari";
                $shaba = "123";
                $payment_id = $request->get("officeNo");
                $AddClearingAccount = $this->api->AddClearingAccount($location_id, $project_name, $owner_name, $shaba, $payment_id);
                return $AddClearingAccount ;
            }
            return redirect()->back()->with('success' , ' مکان مورد نظر اضافه گردید . ');
        }

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
        $mandatory_entrance = ($request->input('mandatory_entrance') == "on") ? true : false ;
        $longitude= $request->get('longitude');
        $latitude = $request->get('latitude');
        $introduction = $getLoction['ContentData'][0]['introduction'];
        $description =  $getLoction['ContentData'][0]['description'];
        $EditLocation = $this->api->EditLocation($location_name,$text_id,$location_english_name,$location_english_address,$location_address,$location_id,$mandatory_entrance,$longitude, $latitude,$introduction,$description);
        if ($EditLocation['Header']['MessageCode'] == 0){
            Cache::forget('LocationList');
            Cache::rememberForever('LocationList', function(){
                $Locations  = $this->api->LocationList();
                return $Locations['ContentData'];
            });
            return redirect()->back()->with('success' , ' مکان مورد ویرایش گردید . ');
        }
        else
            return redirect()->back()->with('error' , ' خطا در ویرایش مکان ! ');


    }
    public function DeleteLocation($id){
        $DeleteLocation = $this->api->DeleteLocation($id);
        if ($DeleteLocation['Header']['MessageCode'] == 0){
            Cache::forget('LocationList');
            Cache::rememberForever('LocationList', function(){
                $Locations  = $this->api->LocationList();
                return $Locations['ContentData'];
            });
            return redirect()->back()->with('success' , ' مکان مورد حذف گردید . ');
        }
        else
            return json_encode($DeleteLocation);
    }

    public function LocationActivation( Request $request ){
        $data = [ 'data' => false ];
        $is_active = ($request->get('value') == 'true') ? True : False ;
        $location_id = $request->get('location') ;
        $LocationActivation = $this->api->LocationActivation($location_id , $is_active);
        if ($LocationActivation['Header']['MessageCode'] == 0){
            Cache::forget('LocationList');
            Cache::rememberForever('LocationList', function(){
                $Locations  = $this->api->LocationList();
                return $Locations['ContentData'];
            });
            return  $data = [ 'data' => true ];
        }
        else
            return $data;
    }
    public function PosPrintActivation( Request $request ){
        $data = [ 'data' => false ];
        $is_active = ($request->get('value') == 'true') ? True : False ;
        $location_id = $request->get('location') ;
        $PosPrintActivation = $this->api->PosPrintActivation($location_id , $is_active);
        if ($PosPrintActivation['Header']['MessageCode'] == 0){
            Cache::forget('LocationList');
            Cache::rememberForever('LocationList', function(){
                $Locations  = $this->api->LocationList();
                return $Locations['ContentData'];
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
            Cache::forget('LocationList');
            Cache::rememberForever('LocationList', function(){
                $Locations  = $this->api->LocationList();
                return $Locations['ContentData'];
            });
            return  $data = [ 'data' => true ];
        }
        else
            return $data;
    }

    public function getLocationFilter(Request $request){
        $city_id = $request->get("city_id");
        $province_id = $request->get("province_id");
        $locations = $this->api->location_list( $province_id , $city_id);
        $province = Cache::get('ProvinceList') ;
        $GetVoucherText = Cache::get("GetVoucherText");
//        return $locations;
        return view('places' , ['locations' => $locations['ContentData'], 'province' => $province , 'GetVoucherText' => $GetVoucherText ]);
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
        else if($AddDiscountPolicy["Header"]["Message"] == "Permission Denied")
            return redirect()->back()->with("error" , "منع دسترسی : شما مجاز به انجام چنین عملیاتی نیستید !   ");
        else if($AddDiscountPolicy["Header"]["MessageCode"] == 158)
            return redirect()->back()->with("error" , "خطا در ايجاد تخفيف : تاريخ وارد شده نامعتبر است !   ");
        else
            return redirect()->back()->with("error" , "خطا در ایجاد تخفیف !  ");


    }

    // ******* Service
    public function GetService($id){
        $GetServices = Cache::get('ServiceList');
        $projectList = $this->api->ProjectList();
        $locationID = $id ;
        $GetServices = array_filter($GetServices, function ($event) use ($locationID) {
            return $event['location_id'] == $locationID;
        });
        $array_keys = array_keys($GetServices) ;
        $service_pics = [];
        $service_id_image = [];
        for($i = 0 ; $i < count($array_keys) ; $i++){
            $GetPicturesInfo = $this->api->GetPicturesInfo(null,$GetServices[$array_keys[$i]]['service_id'],null,null);
            if(array_key_exists("service_pics" , $GetPicturesInfo['ContentData'])){
                $service_pics = $GetPicturesInfo['ContentData']['service_pics'];
                foreach ($service_pics as $pic){
                    if($pic['tag'] == 'main')
                    {
                        $image = [
                            'service_id' => $GetServices[$array_keys[$i]]['service_id'] ,
                            'picture_id' =>$pic['picture_id']
                        ];
                        array_push($service_id_image,$image);
                    }

                }
            }
        }
//        $image = $this->api->GetImageAddress($service_id_image[0]['picture_id']);
//        return $image;
//        return $GetServices ;
//        $GetPicturesInfo = $this->api->GetPicturesInfo($id,null,null,null);
//        $GetPicturesInfo = $this->api->GetPicturesInfo($id,263,null,null);
//        return $GetPicturesInfo;
//        if(array_key_exists("service_pics" , $GetPicturesInfo['ContentData'])){
//            $service_pics = $GetPicturesInfo['ContentData']['service_pics'];
//        }
        return view('services' , ['GetServices'=> $GetServices , 'array_keys' => $array_keys , 'service_pics'=>$service_id_image , 'location_id' => $locationID , 'projectList' => $projectList['ContentData'] ]);

    }
    public function AddService(Request $request ,$location_id ){

            $service_name = $request->get("service_name");
            $service_english_name = $request->get("service_english_name");
            $model_id = $request->get("model_id");
            $description = $request->get("description");
            if (is_null($description))
                $description = "" ;
            $capacity = (int)$request->get("capacity");
            if ($capacity == 0 )
                $capacity = "";
            $normal_sale = ($request->get("normal_sale") == 'on') ? 1 : 0 ;
            $AddService  = $this->api->AddService($service_name, $capacity, $service_english_name, $model_id, $description, $location_id, $normal_sale);
//            return $AddService;
            if ($AddService['Header']['Status'] == 0){
                Cache::forget('ServiceList');
                Cache::rememberForever('ServiceList', function(){
                    $Locations  = $this->api->ServiceList();
                    return $Locations['ContentData'];
                });
                return redirect()->back()->with('success' , 'جاذبه مورد نظر ایحاد گردید');
            }
            else
                return redirect()->back()->with('error' , 'خطا در ایجاد جاذبه جدید ');

    }
    public function EditService(Request $request ,$service_id,$location_id ){

            $service_name = $request->get("service_name");
            $service_english_name = $request->get("service_english_name");
            $model_id = $request->get("model_id");
            $description = $request->get("description");
            if(is_null($description))
                $description = "";
            $capacity = $request->get("capacity");
            if(is_null($capacity))
                $capacity = "" ;
            $normal_sale = ($request->get("normal_sale") == 'on') ? 1 : 0 ;

            $EditService  = $this->api->EditService($service_name, $capacity, $service_english_name, $model_id,$service_id, $description, $location_id, $normal_sale);
//            return $EditService;
                if ($EditService['Header']['Status'] == 0){
                    Cache::forget('ServiceList');
                    Cache::rememberForever('ServiceList', function(){
                        $Locations  = $this->api->ServiceList();
                        return $Locations['ContentData'];
                    });

                    return redirect()->back()->with('success' , 'تغییرات اعمال گردید');
                }
                else
                    return redirect()->back()->with('error' , 'خطا در اعمال تغییرات! ');
//        return $EditService ;

    }
    public function DeleteService(Request $request ,$service_id ){

            $EditService  = $this->api->DeleteService($service_id);
                if ($EditService['Header']['Status'] == 0){
                    Cache::forget('ServiceList');
                    Cache::rememberForever('ServiceList', function(){
                        $Locations  = $this->api->ServiceList();
                        return $Locations['ContentData'];
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
            $service_activation = $request->get('value');
            $ServiceActivation  = $this->api->ServiceActivation($service_id , $service_activation);
                if ($ServiceActivation['Header']['Status'] == 0){
                    Cache::forget('ServiceList');
                    Cache::rememberForever('ServiceList', function(){
                        $Locations  = $this->api->ServiceList();
                        return $Locations['ContentData'];
                    });
                    $data = [ 'data' => true ];
                    return $data ;
                }else
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
    // ******* Voucher
    public function VoucherInfoList($service_id , $location_id){
        $GetServices = Cache::get('ServiceList');
        $projectList = $this->api->ProjectList();
        $locationID = $location_id ;
        $GetServices = array_filter($GetServices, function ($event) use ($locationID , $service_id) {
            return $event['location_id'] == $locationID && $event['service_id'] == $service_id ;
        });
        $array_keys = array_keys($GetServices) ;
        $GetServices = $GetServices[$array_keys[0]] ;
        $VoucherInfoList = $this->api->VoucherInfoList($service_id);
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
        return view('VoucherInfoList' , ['VoucherInfo'=> $VoucherInfoList['ContentData'] ,
            'GetServices' =>$GetServices , 'service_id'=> $service_id , 'location_id' =>$location_id ,
            'voucher_id_image'=> $voucher_id_image ,  'projectList' => $projectList['ContentData'] ]);
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
//        return $expiration_date;
        $EditVoucherInfo = $this->api->EditVoucherInfo($id, $voucher_type_id, $service_id, $amount, $capacity, $location_id , $max_discount_percentage , $validity_period , $expiration_date) ;
//        return $EditVoucherInfo;
        if ($EditVoucherInfo['Header']['Status'] == 0){
            return redirect()->back()->with('success' , 'تغییرات اعمال گردید');
        }
        else
            return redirect()->back()->with('error' , 'خطا در اعمال تغییرات! ');

    }
    public function GetVoucherText(Request $request){
        $text = Cache::get("GetVoucherText");
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
            $projectList = $this->api->ProjectList();
//      $GetPicture = $this->api->GetPicture($id);
//       return $GetEvent;
            /*
            $image = $this->GetImageAddress($GetPicture['content'] , $GetPicture['type']);
            return '<img src="'.$image.'" alt="An elephant" />';
            */
            $locations = Cache::get('LocationList');
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
//            return $e->getMessage();
            abort(404);
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
            Cache::forget('LocationList');
            Cache::rememberForever('LocationList', function(){
                $Locations  = $this->api->LocationList();
                return $Locations['ContentData'];
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
            Cache::forget('LocationList');
            Cache::rememberForever('LocationList', function(){
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
            Cache::forget('LocationList');
            Cache::rememberForever('LocationList', function(){
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
    public function imageRemove($id){
        $del = $this->api->DeletePicture($id);
        if($del['Header']['Status'] == 0)
            return redirect()->back()->with('success' , ' تصویر مورد نظر حذف گردید . ');
        else
            return redirect()->back()->with('error' , ' خطا در حذف تصویر . ');
    }
}
