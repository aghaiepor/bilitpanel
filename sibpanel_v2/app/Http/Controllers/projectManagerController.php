<?php

namespace App\Http\Controllers;

use App\Api\Api;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class projectManagerController extends Controller
{
    var $api ;
    public function __construct()
    {
        $this->api = new Api;
    }

    public function index(){

        $GetProjectList = Cache::get('ProjectList' . session('UserInfo')['user_id']);
        $SellerUserList = Cache::get('SellerUserList' . session('UserInfo')['user_id']);
        $SellerUserList = array_filter($SellerUserList, function ($event) {
            return $event['type'] == "b2b user";
        });
        $array_keys = array_keys($SellerUserList) ;
//        return $GetProjectList ;
        return view("ProjectManager" ,["GetProjectList" => $GetProjectList , "SellerUserList" => $SellerUserList , "array_keys" =>$array_keys ] ) ;
    }

    public function AddProject(Request $request){
        $project_name = $request->get("project_name");
        $description = $request->get("description");
        if(is_null($description))
            $description = "";
        $AddProject = $this->api->AddProject($project_name , $description);
//        return $AddProject;
        if($AddProject["Header"]["Status"] == 0 ){
            Cache::forget('ProjectList' . session('UserInfo')['user_id']);
            Cache::rememberForever('ProjectList' . session('UserInfo')['user_id'], function(){
                $ProvinceList  = $this->api->ProjectList();
                return $ProvinceList['ContentData'];
            });
            return redirect()->back()->with("success" , " پروژه جدید ساخته شد .  ");
        }
        else if ($AddProject["Header"]["Message"] == "Permission Denied"){
            return redirect()->back()->with("error" , "منع دسترسی : شما مجاز به انجام چنین عملیاتی نیستید !   ");
        }
        else
            return redirect()->back()->with("error" , "خطا در ایجاد پروژه !   ");
    }
    public function EditProject(Request $request , $id=null){
        if(is_null($id))
            return redirect()->back();

        $project_id = $id;
        $project_name = $request->get("project_name");
        $description = $request->get("description");
        if(is_null($description))
            $description = "";

        $EditProject = $this->api->EditProject($project_id ,$project_name , $description);
//        return $EditProject;
        if($EditProject["Header"]["Status"] == 0 ){
            Cache::forget('ProjectList' . session('UserInfo')['user_id']);
            Cache::rememberForever('ProjectList' . session('UserInfo')['user_id'], function(){
                $ProvinceList  = $this->api->ProjectList();
                return $ProvinceList['ContentData'];
            });
            return redirect()->back()->with("success" , " ویرایش با موفقیت اعمال شد .  ");
        }

        else if ($EditProject['Header']['MessageCode'] == 133){
            return redirect()->back()->with("error" , "منع دسترسی : شما مجاز به انجام چنین عملیاتی نیستید !   ");
        }
        else
            return redirect()->back()->with("error" , "خطا در ایجاد پروژه !   ");
    }
    public function GetProject(Request $request){
        $project_id = $request->get("project_id");
        $GetProject = $this->api->GetProject($project_id , "ajax");

        return $GetProject["ContentData"] ;
    }
    public function AddProjectPicture(Request $request, $id){
        if(is_null($id))
            return redirect()->back();
        $project_id = (int)$id;
        if ($request->hasFile('service_image')){
            $file = $request->file('service_image') ;
            $mimeType = $file->getmimeType();
            $name = time() . "_" . $file->getClientOriginalName() ;
            $path = public_path() . "/tmp/" ;
            $file->move($path,$name) ;
            $addPicture = $this->api->AddPicture($project_id , "" , "" , "" , $path,$name , "logo" , "image" , $mimeType);
            // return for test and show api result
//            return $addPicture ;
            if($addPicture['Header']['Status'] == 0){
                $project_image = $addPicture['ContentData']['id'];
                $main_image_address = $this->api->GetImageAddress($project_image) ;
//                return  $main_image_address ;
                session(["logoAddress" =>  $main_image_address]);
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

    public function ProjectOff( Request $request , $id){
        $GetDiscountPolicyList = $this->api->GetDiscountPolicyList((int)$id ,0 ,0 , 0 ,0 );
//        return  $GetDiscountPolicyList ;
        return view("Project_off" , ["GetDiscountPolicyList" =>$GetDiscountPolicyList["ContentData"] , "id" => $id]);
    }

    public function AddProjectOff( Request $request , $id){
        $project_id = (int)$id ;
        $location_id = 0 ;
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
        else
            return redirect()->back()->with("error" , "خطا در ایجاد تخفیف !  ");


    }

    public function AddUserOff( Request $request ){
//        return json_encode($request->all());
        $project_id = (int)$request->get("sib_user_id");
        if(is_null($project_id))
            return redirect()->back()->with("error" , "خطا در ایجاد تخفیف : لطفا کاربر مورد نظر جهت اعمال تخفیف را انتخاب کنید .  ");
        $location_id = 0 ;
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
        else
            return redirect()->back()->with("error" , "خطا در ایجاد تخفیف !  ");


    }

    public function AddProjectSetting(Request $request , $id=null)
    {
        if (is_null($id))
            return redirect()->back();

        $type_of_service_sale = $request->get("TypeOfServiceSale");
        $project_id = $id;
        $AddProjectSetting = $this->api->AddProjectSetting($project_id  , $type_of_service_sale) ;

        if($AddProjectSetting["Header"]["MessageCode"] == 0 )
            return redirect()->back()->with("success" , " تنظیمات با موفقیت اعمال گردید . ");
        else if ($AddProjectSetting["Header"]["MessageCode"] == 133)
            return redirect()->back()->with('error' , " منع دسترسی : شما مجاز به انجام این عملیات نیستید ! ");
        else
            return redirect()->back()->with('error' , " خطا در اعمال تفییرات !");

    }

    public function GetProjectSetting(Request $request)
    {
        $project_id = $request->get("project_id");
        $GetProjectSetting = $this->api->GetProjectSetting($project_id );
        return $GetProjectSetting;
    }
    public function EditProjectSetting(Request $request )
    {
        $type_of_service_sale = $request->get("TypeOfServiceSale");
        $project_id = $request->get("project_id");
        $warehoff = $request->get("warehoff") ;
        $EditProjectSetting = $this->api->EditProjectSetting($project_id  , $type_of_service_sale , $warehoff) ;
        return $EditProjectSetting ;
    }

    private function fa2en($number){
        return strtr($number, array('۰'=>'0', '۱'=>'1', '۲'=>'2', '۳'=>'3', '۴'=>'4', '۵'=>'5', '۶'=>'6', '۷'=>'7', '۸'=>'8', '۹'=>'9', '٠'=>'0', '١'=>'1', '٢'=>'2', '٣'=>'3', '٤'=>'4', '٥'=>'5', '٦'=>'6', '٧'=>'7', '٨'=>'8', '٩'=>'9'));
    }

}
