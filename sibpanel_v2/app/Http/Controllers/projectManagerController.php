<?php

namespace App\Http\Controllers;

use App\Api\Api;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class projectManagerController extends Controller
{
    var $api ;
    public function __construct()
    {
        $this->api = new Api;
    }

    public function index(){

        $GetProjectList = Cache::get('ProjectList');
        $SellerUserList = Cache::get('SellerUserList');
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
            Cache::forget('ProjectList');
            Cache::rememberForever('ProjectList', function(){
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
            Cache::forget('ProjectList');
            Cache::rememberForever('ProjectList', function(){
                $ProvinceList  = $this->api->ProjectList();
                return $ProvinceList['ContentData'];
            });
            return redirect()->back()->with("success" , " ویرایش با موفقیت اعمال شد .  ");
        }

        else if ($EditProject["Header"]["Message"] == "Permission Denied"){
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
            $image = base64_encode(file_get_contents($request->file('service_image')->path()));
//            return $image;
            $addPicture = $this->api->AddPicture($project_id , 0 , 0 , 0 , $image , "logo");
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

    private function fa2en($number){
        return strtr($number, array('۰'=>'0', '۱'=>'1', '۲'=>'2', '۳'=>'3', '۴'=>'4', '۵'=>'5', '۶'=>'6', '۷'=>'7', '۸'=>'8', '۹'=>'9', '٠'=>'0', '١'=>'1', '٢'=>'2', '٣'=>'3', '٤'=>'4', '٥'=>'5', '٦'=>'6', '٧'=>'7', '٨'=>'8', '٩'=>'9'));
    }

}
