<?php

namespace App\Http\Controllers;

use App\Api\Api;
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
    // ******* Service
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

    // ******* Voucher
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
            $images = [];
            $GetPicturesInfo = $this->api->GetPicturesInfo($id,null,null,null);
//        return $GetPicturesInfo;
            if(array_key_exists("location_pics" , $GetPicturesInfo['ContentData'])){
                $location_pic = $GetPicturesInfo['ContentData']['location_pics'];
            }

            if(array_key_exists("project_pics" , $GetPicturesInfo['ContentData'])){
                $project_pics = $GetPicturesInfo['ContentData']['project_pics'];
                if($project_pics != null){
                    $project_pics_picture_id  = $this->GetImageAddress($project_pics[0]['picture_id']) ;
                    array_push($project_pics_picture_id,$images);
                }
            }
            if(array_key_exists("voucher_info_pics" , $GetPicturesInfo['ContentData'])){
                $voucher_info_pics = $GetPicturesInfo['ContentData']['voucher_info_pics'];
            }

            if(array_key_exists("service_pics" , $GetPicturesInfo['ContentData'])){
                $service_pics = $GetPicturesInfo['ContentData']['service_pics'];
            }
//        return $GetLocations[$index];
            return view("citizen" , ['GetLocations' => $GetLocations[$index] , 'location_pic' => $location_pic , 'images' => $images , 'GetEvents' => $GetEvent['ContentData'] , 'location_id'=>$id ] ) ;

        } catch (\Exception $e) {
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
        $data = [
            'id' => $id ,
            'tag' => 'main' ,
            'image' => base64_encode(file_get_contents($request->file('main_image')->path())),
        ];
        return $data ;
    }
    public function AddLogoPicture(Request $request, $id){
        $data = [
            'id' => $id ,
            'tag' => 'logo' ,
            'image' => base64_encode(file_get_contents($request->file('logo_image')->path())),
        ];
        return $data ;
    }
    public function AddGalleryPicture(Request $request, $id){
        $data = [
            'id' => $id ,
            'tag' => 'other' ,
            'image' => base64_encode(file_get_contents($request->file('location_imgae')->path())),
        ];
        return $data ;
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

    function GetImageAddress($id)
    {
        $GetPicture = $this->api->GetPicture($id);
        $mime = $GetPicture['type'];
        $content = $GetPicture['content'];
        $base64   = base64_encode($content);
        return ('data:' . $mime . ';base64,' . $base64);
    }

}
