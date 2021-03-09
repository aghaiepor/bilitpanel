<?php

namespace App\Http\Controllers;

use App\Api\Api;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class seanceController extends Controller
{
    var $api = null;
    public function __construct()
    {
        $this->api = new Api();
    }

    public function group_times($show=null){
//        $GetTimeGroup = $this->api->GetTimeGroup();
//        $AllLocationServices = $this->api->AllLocationServiceList();
//        return view('group_times' , ['locations'=>$AllLocationServices,'result_data' => $GetTimeGroup['ContentData']] );
        $show = true ;
        $GetServiceListFromServicetime = $this->api->GetServiceListFromServicetime($show);
//        return $GetServiceListFromServicetime ;
        return view('group_times' , ["GetServiceListFromServicetime" => $GetServiceListFromServicetime["ContentData"]] ) ;
    }


    public function edit_time_group(Request $request){
        $data = $request->input('service_times');
        $data = json_decode($data,true);

        $response = $this->api->EditServiceTime($data);
//        return redirect('group_times');
        if ($response['Header']['Status'] == 0)
            return redirect()->back()->with('success' , 'گروه سانس با موفقیت ویرایش شد');
        else if ($response['Header']['MessageCode'] == 168)
            return redirect()->back()->with('error' , 'خطا : ظرفیت سانس های گروهی پایین تر از حد مجاز است');
        else
            return redirect()->back()->with('error' , 'خطا در ویرایش گروه سانس');
    }


    // new group time
    public function add_group_time_index($service_id=null , $location_id=null , $province_id=null)
    {

        $VoucherTypeList = Cache::get('VoucherTypeList');
        $LocationList = Cache::get("LocationList") ;
        $GetServices = Cache::get('ServiceList');
        $GetServices = array_filter($GetServices, function ($event) use ($location_id , $service_id) {
            return $event['location_id'] == $location_id && $event['service_id'] == $service_id ;
        });
        $array_keys = array_keys($GetServices) ;
        $Info = $GetServices[$array_keys[0]] ;
//        return $LocationList ;
        $GetServiceTimeList = $this->api->GetServiceTimeList($service_id);
        $VoucherInfoList = $this->api->VoucherInfoList($service_id);
        $ProvinceList = Cache::get('ProvinceList');
//        return $ProvinceList ;
//        return $GetServiceTimeList["ContentData"] ;
        return view('group_time_add' , [
            "VoucherTypeList" => $VoucherTypeList ,
            "id" => $service_id ,
            "location_id"=> $location_id  ,
            "province_id"=> $province_id  ,
            "GetServiceTimeList"=> $GetServiceTimeList["ContentData"] ,
            "VoucherInfoList" => $VoucherInfoList["ContentData"] ,
            "LocationList" => $LocationList ,
            "ProvinceList" => $ProvinceList ,
            "Info" => $Info ,
        ]);
    }

    public function GetServiceTimeList(Request $request)
    {
        $service_id = $request->get("service_id");
        $GetServiceTimeList = $this->api->GetServiceTimeList($service_id);
        return $GetServiceTimeList ;
    }

    public function add_group_time(Request $request){
//        return json_encode($request->all());
        $service_id = (int)$request->get("serviceId");
        $service_times = json_decode($request->input('service_times') , true) ;
//        $service_times = json_decode($service_times) ;
//        $service_times =   json_encode($service_times) ;
//        return  $service_times;
//        return  gettype($service_times);
//        dd($service_times );

        try {
            foreach($service_times as $service_time)
            {
                $day = $service_time["day"] ;
                $times = $service_time["times"] ;
                foreach ($times as $time) {
                    $start = $day . " " . $time["start"] ;
                    $end = $day . " " . $time["end"] ;
                    $sex = $time["sex"] ;
                    $total_capacity = $time["total_capacity"] ;
                    $voucher_infos = $time["voucher_infos"] ;
                    $voucher_infos_data = [] ;
                    foreach ($voucher_infos as $voucher_info ) {
                        $voucher = [
                            "total_capacity" => ($voucher_info["capacity"] == "") ? -1 : (int)$voucher_info["capacity"],
                            "amount" => (int)$voucher_info["seance_amount"],
                            "voucher_type_id" => (int)$voucher_info["vouchersInfo"],
                            "max_discount_percentage" => "" /*$voucher_info["seance_percent"]*/
                        ];
                        array_push( $voucher_infos_data ,  $voucher) ;
                    }
//                    return $voucher_infos_data ;
                    $test = $this->api->AddServiceTime($service_id , $start , $end , $sex ,$total_capacity ,$voucher_infos_data  ) ;
//                    return $test ;
                    if($test["Header"]["MessageCode"] == 158) {
                        return redirect()->back()->with('error' , " خطا : تاریخ انتخاب شده نامعتبر است . ");
                     }
                    else if ($test["Header"]["MessageCode"] == 133) {
                        return redirect()->back()->with('error' , " منع دسترسی : شما مجاز به انجام این عملیات نیستید ! . ");
                    }
                    else if ($test["Header"]["MessageCode"] == 120) {
                        return redirect()->back()->with('error' , " خطا : بلیت ایجاد شده قبلا ساخته شده است  . ");
                    }
                    else if ($test["Header"]["MessageCode"] == 166) {
                        return redirect()->back()->with('error' , " خطا : سانس دیگری در این زمان وجود دارد  . ");
                    }
                    else if ($test["Header"]["MessageCode"] == 32) {
                        return redirect()->back()->with('error' , " خطا : بلیتی جهت ایجاد وارد نشده است ");
                    }
                    else if ($test["Header"]["MessageCode"] == 32) {
                        return redirect()->back()->with('error' , " خطا : سرویسی جهت ایجاد وارد نشده است ");
                    }
                    else if ($test["Header"]["MessageCode"] == 168) {
                        return redirect()->back()->with('error' , " خطا : طرفیت بلیت های وارد شده از ظرفیت سانس بیشتر . ");
                    }
                }
            }
            return redirect()->back()->with('success' , " سانس با موفقیت ایجاد شد .");
        }catch (\Exception $e) {
//            return redirect()->back()->with('error' , " خطا در ایجاد سانس ");
            return redirect()->back()->with('error' , $e->getMessage());
//            return $e->getMessage();
        }


    }

    public function EditServiceTime(Request $request){
//        return json_encode($request->all());

        $service_times = $request->get('times') ;
//        $service_times = json_decode($service_times) ;
//        $service_times =   json_encode($service_times) ;
//        return  $service_times[0]["end"];
//        return  gettype($service_times);
//        dd($service_times );
            $service_times = $service_times[0];
            $service_time_id =  $service_times["service_time_id"] ;
            $start =  $service_times["start"] ;
            $end =  $service_times["end"] ;
            $sex =  $service_times["sex"] ;
            $total_capacity = $service_times["total_capacity"] ;
            $vouchers = $service_times["voucher_infos"];

            $voucher_infos_data = [] ;
            foreach ($vouchers as $voucher_info ) {
                $voucher = [
                    "total_capacity" => ($voucher_info["capacity"] == "") ? -1 : (int)$voucher_info["capacity"] ,
                    "amount" => (int)$voucher_info["seance_amount"],
                    "voucher_type_id" => (int)$voucher_info["vouchersInfo"],
                    "max_discount_percentage" => (is_null($voucher_info["seance_percent"])) ? "" :  $voucher_info["seance_percent"] ,
                ];
                if(array_key_exists("deleted",$voucher_info))
                {
                    $del_value = ($voucher_info["deleted"] == "true" ) ? true : false ;
                    if($del_value)
                    {
                        $deleted = ["deleted" => $del_value]  ;
                        $voucher = array_merge( $voucher ,  $deleted ) ;
                    }
                }
                Log::info("voucher : " , $voucher);
                array_push( $voucher_infos_data ,  $voucher) ;
    //                    return $voucher_infos_data ;
    //                    $test = $this->api->EditServiceTime($service_id , $start , $end,$sex ,$voucher_infos_data  ) ;


                /*if($test["Header"]["MessageCode"] == 158) {
                    return redirect()->back()->with('error' , " خطا : تاریخ انتخاب شده نامعتبر است . ");
                }*/
            }
            $test = $this->api->EditServiceTime($service_time_id , $start , $end , $sex , $total_capacity , $voucher_infos_data, "ajax") ;
            return $test ;
    //                return redirect()->back()->with('success' , " سانس با موفقیت ویرایش شد .");




    }

    public function GetServiceTimes(Request $request) {
        $service_id = [(int)$request->get("service_id")] ;
        $service_info = $this->api->GetServiceTimes($service_id);
        return $service_info["ContentData"] ;
    }

    public function edit_group_time_index(Request $request){

        $voucher_info_ids = $request->input('voucher_info_ids');
        $group_times = $request->input('group_times');
        $group_name = $request->input('group_name');
        $group_id = $request->input('group_id');

        return view('group_time_edit' , [
            'voucher_info_ids'=>$voucher_info_ids,
            'group_times' => $group_times,
            'group_name' => $group_name,
            'group_id' => $group_id,
        ]);

    }

    /*public function edit_group_time(Request $request){

        $data = $request->input('service_times');
        $data = json_decode($data,true);

        $response = $this->api->EditServiceTime($data);
        return redirect('group_times');

    }*/
    public function DeleteServiceTime(Request $request)
    {
        $service_times_id = (int)$request->get('service_time_id');
        $response = $this->api->DeleteServiceTime($service_times_id , "ajax");
        return  $response;
    }

    public function ImportExportServiceTimes(Request $request , $service_id){
        $import_service_id = $request->get("serviceList");
        $export_service_id = $service_id;

        $start = $request->get("start");
        $start = $this->fa2en($start . " 00:00:00");
        $start = Verta::parse($start)->timestamp;
        $start = Carbon::createFromTimestamp($start)->format('Y-m-d H:i');

        $end = $request->get("end");
        $end = $this->fa2en($end . " 23:59:59");
        $end = Verta::parse($end)->timestamp;
        $end = Carbon::createFromTimestamp($end)->format('Y-m-d H:i');

        $ImportExportServiceTimes = $this->api->ImportExportServiceTimes($import_service_id,$export_service_id ,$start , $end , "");
        // return $ImportExportServiceTimes ;
        if($ImportExportServiceTimes["Header"]["MessageCode"] == 0 )
        {
            return redirect()->back()->with("success" , "عمليات با موفقيت انجام گرديد ") ;
        }
        else if ($ImportExportServiceTimes["Header"]["MessageCode"] == 75) {
            return redirect()->back()->with("error" , " سرويس نامعتبر است !  ") ;
        }
        else if ($ImportExportServiceTimes["Header"]["MessageCode"] == 158) {
            return redirect()->back()->with("error" , "خظا : تاريخ وارد شده نامعتبر است !   ") ;
        }
        else if ($ImportExportServiceTimes["Header"]["MessageCode"] == 133) {
            return redirect()->back()->with("error" , "خظا : شما مجاز به انحام اين عمليات نمي باشيد  !   ") ;
        }
        else {
            return redirect()->back()->with("error" , "خطا در انجام عمليات ! ") ;
        }
    }
    public function ExtendtServiceTimes(Request $request , $service_id){
//        return json_encode($request->all());
        $import_service_id = $service_id;
        $export_service_id = $service_id;

        $start = $request->get("start");
        $start = $this->fa2en($start . " 00:00:00");
        $start = Verta::parse($start)->timestamp;
        $start = Carbon::createFromTimestamp($start)->format('Y-m-d H:i');

        $end = $request->get("end");
        $end = $this->fa2en($end . " 23:59:59");
        $end = Verta::parse($end)->timestamp;
        $end = Carbon::createFromTimestamp($end)->format('Y-m-d H:i');
//        return $end ;

        $days_extend = $request->get("days_extend");

        $ImportExportServiceTimes = $this->api->ImportExportServiceTimes($import_service_id,$export_service_id ,$start , $end , $days_extend) ;
//        return $ImportExportServiceTimes ;
        if($ImportExportServiceTimes["Header"]["MessageCode"] == 0 )
        {
            return redirect()->back()->with("success" , "عمليات با موفقيت انجام گرديد ") ;
        }
        else if ($ImportExportServiceTimes["Header"]["MessageCode"] == 75) {
            return redirect()->back()->with("error" , " سرويس نامعتبر است !  ") ;
        }
        else if ($ImportExportServiceTimes["Header"]["MessageCode"] == 158) {
            return redirect()->back()->with("error" , "خظا : تاريخ وارد شده نامعتبر است !   ") ;
        }
        else if ($ImportExportServiceTimes["Header"]["MessageCode"] == 133) {
            return redirect()->back()->with("error" , "خظا : شما مجاز به انحام اين عمليات نمي باشيد  !   ") ;
        }
        else if ($ImportExportServiceTimes["Header"]["MessageCode"] == 166) {
            return redirect()->back()->with('error' , " خطا : سانس دیگری در این زمان وجود دارد  . ");
        }
        else {
            return redirect()->back()->with("error" , "خطا در انجام عمليات ! ") ;
        }
    }

    public function ServiceTimeActivation(Request $request){
        $service_time_id = $request->get("service_time_id") ;
        $activation = ( $request->get("activation") == "true" ) ? true : false  ;
        $ServiceTimeActivation = $this->api->ServiceTimeActivation($service_time_id , $activation , "ajax") ;
        return $ServiceTimeActivation ;
    }

    private function fa2en($number){
        return strtr($number, array('۰'=>'0', '۱'=>'1', '۲'=>'2', '۳'=>'3', '۴'=>'4', '۵'=>'5', '۶'=>'6', '۷'=>'7', '۸'=>'8', '۹'=>'9', '٠'=>'0', '١'=>'1', '٢'=>'2', '٣'=>'3', '٤'=>'4', '٥'=>'5', '٦'=>'6', '٧'=>'7', '٨'=>'8', '٩'=>'9'));
    }




}
