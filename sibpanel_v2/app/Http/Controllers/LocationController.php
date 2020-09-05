<?php

namespace App\Http\Controllers;

use App\Api\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class LocationController extends Controller
{
    var $api = null ;

    public function __construct()
    {
        $this->api = new Api();
    }

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
        $city_id = $request->get('city_id') ;
        $text_id = $request->get('text_id') ;
        $mandatory_entrance = ($request->input('mandatory_entrance') == "on") ? true : false ;
//        Log::info( 'mandatory_entrance' . $mandatory_entrance);
        $addLocation = $this->api->AddLocation($location_name,$province_id,$text_id,$city_id,$location_english_name,$location_address,$location_english_address,$mandatory_entrance);
        /*
        // **** for shahdari project *****
        $location_id = (int)locationId;
        $project_name = "shahrdari";
        $owner_name = "shahrdari";
        $shaba = "123";
       $payment_id = $request->get("officeNo"); ;
        $AddClearingAccount = $this->api->AddClearingAccount($location_id,$project_name,$owner_name,$shaba,$payment_id);
*/
        if ($addLocation['Header']['MessageCode'] == 0){
            $api = new Api();
            Cache::forget('LocationList');
            Cache::rememberForever('LocationList', function(){
                $Locations  = $this->api->LocationList();
                return $Locations['ContentData'];
            });
            return redirect()->back()->with('success' , ' مکان مورد نظر اضافه گردید . ');
        }

        else
          return redirect()->back()->with('error' , ' خطا در ایجاد مکان . ');


//            return redirect()->back()->with('error' , ' خطا در ایجاد مکان . ');
//        return json_encode($addLocation);
    }

    public function EditLocation(Request $request , $id){

        $location_name = $request->get('location_name') ;
        $location_english_name = $request->get('location_english_name') ;
        $location_address = $request->get('location_address') ;
        $location_english_address = $request->get('location_english_address') ;
        $location_id = $id ;
        $text_id = $request->get('text_id') ;
        $mandatory_entrance = ($request->input('mandatory_entrance') == "on") ? true : false ;

        $EditLocation = $this->api->EditLocation($location_name,$text_id,$location_english_name,$location_english_address,$location_address,$location_id,$mandatory_entrance);
        if ($EditLocation['Header']['MessageCode'] == 0){
            Cache::forget('LocationList');
            Cache::rememberForever('LocationList', function(){
                $Locations  = $this->api->LocationList();
                return $Locations['ContentData'];
            });
            return redirect()->back()->with('success' , ' مکان مورد ویرایش گردید . ');
        }

        else
            return json_encode($EditLocation);


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

    public function GetService($id){
        $GetServices = Cache::get('ServiceList');
        $locationID = $id ;
        $GetServices = array_filter($GetServices, function ($event) use ($locationID) {
            return $event['location_id'] == $locationID;
        });

        $array_keys = array_keys($GetServices) ;
        return view('services' , ['GetServices'=> $GetServices , 'array_keys' => $array_keys , 'location_id'=>$locationID  ]);

    }
    public function AddService(Request $request ,$location_id ){

            $service_name = $request->get("service_name");
            $service_english_name = $request->get("service_english_name");
            $model_id = $request->get("model_id");
            $description = $request->get("description");
            $capacity = $request->get("capacity");
            $normal_sale = ($request->get("normal_sale") == 'on') ? 1 : 0 ;

            $AddService  = $this->api->AddService($service_name, $capacity, $service_english_name, $model_id, $description, $location_id, $normal_sale);
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
            $capacity = $request->get("capacity");
            $normal_sale = ($request->get("normal_sale") == 'on') ? 1 : 0 ;

            $EditService  = $this->api->EditService($service_name, $capacity, $service_english_name, $model_id,$service_id, $description, $location_id, $normal_sale);
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
    public function VoucherInfoList($service_id , $location_id){

        $GetServices = Cache::get('ServiceList');
        $locationID = $location_id ;
        $GetServices = array_filter($GetServices, function ($event) use ($locationID , $service_id) {
            return $event['location_id'] == $locationID && $event['service_id'] == $service_id ;
        });
        $array_keys = array_keys($GetServices) ;
        $GetServices = $GetServices[$array_keys[0]] ;
        $VoucherInfoList = $this->api->VoucherInfoList($service_id);
        return view('VoucherInfoList' , ['VoucherInfo'=> $VoucherInfoList['ContentData'] , 'GetServices' =>$GetServices , 'service_id'=> $service_id , 'location_id' =>$location_id ]);
//        return $VoucherInfoList ;

    }
    public function AddVoucherInfo(Request $request , $service_id , $location_id){

        $amount = $request->get("amount");
        $voucher_type_id = $request->get("voucher_type_id");
        $capacity = $request->get("capacity");

        $AddVoucherInfo  = $this->api->AddVoucherInfo($service_id, $amount, $voucher_type_id, $capacity, $location_id);
        if ($AddVoucherInfo['Header']['Status'] == 0){
            return redirect()->back()->with('success' , 'تغییرات اعمال گردید');
        }
        else
            return redirect()->back()->with('error' , 'خطا در اعمال تغییرات! ');

    }
    public function EditVoucherInfo(Request $request , $service_id , $location_id ,$id ){

        $amount = $request->get("amount");
        $voucher_type_id = $request->get("voucher_type_id");
        $capacity = $request->get("capacity");

        $AddVoucherInfo  = $this->api->EditVoucherInfo($id, $voucher_type_id, $service_id, $amount, $capacity, $location_id);
        if ($AddVoucherInfo['Header']['Status'] == 0){
            return redirect()->back()->with('success' , 'تغییرات اعمال گردید');
        }
        else
            return redirect()->back()->with('error' , 'خطا در اعمال تغییرات! ');

    }





}
