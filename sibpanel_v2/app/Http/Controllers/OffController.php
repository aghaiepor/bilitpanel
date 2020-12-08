<?php

namespace App\Http\Controllers;

use App\Api\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class OffController extends Controller
{
    var  $api ;
    public function __construct()
    {
        $this->api = new Api();
    }

    public function index(){
        $Project_list = Cache::get('ProjectList');
        $locations = Cache::get('LocationList') ;
        $ServiceList = Cache::get('ServiceList') ;
//        $VoucherTypeList = Cache::get('VoucherTypeList');
//        $VoucherTypeList = $this->api->VoucherInfoList();
        $SellerUserList = Cache::get('SellerUserList');
//        return $GetSibUser ;
//        return $SellerUserList ;
        $SellerUserList = array_filter($SellerUserList, function ($event) {
            return $event['type'] == "b2b user";
        });
        $array_keys = array_keys($SellerUserList) ;
        $service_pics = [];
//        return $SellerUserList ;
        return view('off' , ["ProjectList" => $Project_list , "locations" => $locations ,
            "ServiceList" => $ServiceList , "SellerUserList" => $SellerUserList] ) ;
    }
    public function AddDiscountPolicy(Request $request){
        $project_id = (int)$request->get("project_id") ;
        $location_id = (int)$request->get("location_id") ;
        $service_id = (int)$request->get("service_id" ) ;
        $voucher_info_id = (int)$request->get("voucher_info_id" ) ;
        $sib_user_id = (int)$request->get("sib_user_id") ;
        $description = $request->get("description") ;
        $percentage = (int)$request->get("percentage") ;
        if(is_null($percentage))
            return redirect()->back()->with("error" , "خطا در ایجاد تخفیف : لطفا درصد تخفیف را وارد نمایید .  ");

        if($project_id == 0 && $location_id == 0 && $service_id == 0 && $voucher_info_id == 0 && $sib_user_id ==0  ){
            return redirect()->back()->with("error" , "خطا در ایجاد تخفیف : پرکردن حداقل یکی از فیلد ها الزامیست .  ");
        }

        $AddDiscountPolicy = $this->api->AddDiscountPolicy($project_id ,$location_id ,$service_id , $voucher_info_id ,$sib_user_id ,$description ,$percentage);
//        return $AddDiscountPolicy;
        if($AddDiscountPolicy["Header"]["Status"] == 0 )
            return redirect()->back()->with("success" , " تخفیف مورد نظر ایجاد گردید ");
        else if($AddDiscountPolicy["Header"]["Message"] == "Permission Denied")
            return redirect()->back()->with("error" , "منع دسترسی : شما مجاز به انجام چنین عملیاتی نیستید !   ");
        else
            return redirect()->back()->with("error" , "خطا در ایجاد تخفیف !  ");

    }
    public function GetDiscountPolicyList(Request $request){

        $project_id = (int)$request->get("project_id") ;
        $location_id = (int)$request->get("location_id") ;
        $service_id = (int)$request->get("service_id" ) ;
        $voucher_info_id = (int)$request->get("voucher_info_id" ) ;
        $sib_user_id = (int)$request->get("sib_user_id") ;


        $GetDiscountPolicyList = $this->api->GetDiscountPolicyList($project_id ,$location_id ,$service_id , $voucher_info_id ,$sib_user_id , "ajax") ;
        return $GetDiscountPolicyList;
    }
    public function GetSibUser(Request $request)
    {
        $id = $request->get("id") ;
        $userInfo = $this->api->GetSibUser($id , "ajax");
        return $userInfo ;
    }
    public function EditDiscountPolicy(Request $request , $id){
        if(is_null($id))
            return redirect()->back();

        $discount_policy_id = (int)$id;
        $active = (($request->get("active") == "true") ? true : false) ;
        $description = $request->get("description");
        if(is_null($description))
            $description = "";
        $percentage = (int)$request->get("percentage");
        $EditDiscountPolicy = $this->api->EditDiscountPolicy($discount_policy_id ,$active ,$description ,$percentage );
//        return $EditDiscountPolicy;
        if($EditDiscountPolicy["Header"]["Status"] == 0 ){
            return redirect()->back()->with("success" , " ویرایش تخفیف انجام شد .  ");
        }else
            return redirect()->back()->with("error" , " خطا در ویرایش تخفیف ! ");
    }
    public function GetDiscountPolicy(Request $request){
        $discount_policy_id = $request->get("id");
        $GetDiscountPolicy = $this->api->GetDiscountPolicy($discount_policy_id , "ajax") ;
        return $GetDiscountPolicy;

    }
    public function DiscountPolicyَActivaion(Request $request ){

        $discount_policy_id = (int)$request->get("id");
        $active = (($request->get("active") == "true") ? true : false) ;
        $description = $request->get("description");
        if(is_null($description))
            $description = "";
        $percentage = (int)$request->get("percentage");
        $EditDiscountPolicy = $this->api->EditDiscountPolicy($discount_policy_id ,$active ,$description ,$percentage );
        return $EditDiscountPolicy;
        if($EditDiscountPolicy["Header"]["Status"] == 0 ){
            return redirect()->back()->with("success" , " ویرایش تخفیف انجام شد .  ");
        }else
            return redirect()->back()->with("error" , " خطا در ویرایش تخفیف ! ");
    }
//    public function VoucherTypeList(Request $request)
//    {
//        $id = $request->get("id") ;
//        $userInfo = $this->api->VoucherTypeList($id , "ajax");
//        return $userInfo ;
//    }
}
