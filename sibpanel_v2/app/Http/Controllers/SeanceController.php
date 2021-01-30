<?php

namespace App\Http\Controllers;

use App\Api\Api;
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

    public function group_times(){
//        $GetTimeGroup = $this->api->GetTimeGroup();
//        $AllLocationServices = $this->api->AllLocationServiceList();
//        return view('group_times' , ['locations'=>$AllLocationServices,'result_data' => $GetTimeGroup['ContentData']] );
        return view('group_times' );
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
    public function add_group_time_index($service_id , $location_id){
        $VoucherTypeList = Cache::get('VoucherTypeList');
//        return $VoucherTypeList ;
        $GetServiceTimeList = $this->api->GetServiceTimeList($service_id);
        $VoucherInfoList = $this->api->VoucherInfoList($service_id);
//        return $GetServiceTimeList["ContentData"] ;
        return view('group_time_add' , ["VoucherTypeList" => $VoucherTypeList , "id" => $service_id , "location_id"=> $location_id  , "GetServiceTimeList"=> $GetServiceTimeList["ContentData"] , "VoucherInfoList" => $VoucherInfoList["ContentData"] ]);
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
                    $voucher_infos = $time["voucher_infos"] ;
                    $voucher_infos_data = [] ;
                    foreach ($voucher_infos as $voucher_info ) {
                        $voucher = [
                            "total_capacity" => (int)$voucher_info["capacity"],
                            "amount" => (int)$voucher_info["seance_amount"],
                            "voucher_type_id" => (int)$voucher_info["vouchersInfo"],
                            "max_discount_percentage" => (int)$voucher_info["seance_percent"]
                        ];
                        array_push( $voucher_infos_data ,  $voucher) ;
                    }
//                    return $voucher_infos_data ;
                    $test = $this->api->AddServiceTime($service_id , $start , $end,$sex ,$voucher_infos_data  ) ;
//                    return $test ;
                    if($test["Header"]["MessageCode"] == 158) {
                        return redirect()->back()->with('error' , " خطا : تاریخ انتخاب شده نامعتبر است . ");
                     }
                }

                return redirect()->back()->with('success' , " سانس با موفقیت ایجاد شد .");
            }
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
            $vouchers = $service_times["voucher_infos"];
            $voucher_infos_data = [] ;
            foreach ($vouchers as $voucher_info ) {
                $voucher = [
                    "total_capacity" => (int)$voucher_info["capacity"],
                    "amount" => (int)$voucher_info["seance_amount"],
                    "voucher_type_id" => (int)$voucher_info["vouchersInfo"],
                    "max_discount_percentage" => (int)$voucher_info["seance_percent"]
                ];
                array_push( $voucher_infos_data ,  $voucher) ;
    //                    return $voucher_infos_data ;
    //                    $test = $this->api->EditServiceTime($service_id , $start , $end,$sex ,$voucher_infos_data  ) ;


                /*if($test["Header"]["MessageCode"] == 158) {
                    return redirect()->back()->with('error' , " خطا : تاریخ انتخاب شده نامعتبر است . ");
                }*/
            }
            $test = $this->api->EditServiceTime($service_time_id , $start , $end , $sex , $voucher_infos_data, "ajax") ;
            return $test ;
    //                return redirect()->back()->with('success' , " سانس با موفقیت ویرایش شد .");




    }

    public function GetServiceTimes(Request $request) {
        $service_id = [$request->get("service_id")] ;
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
    public function DeleteServiceTime(Request $request){

        $service_times_id = (int)$request->get('service_time_id');
        $response = $this->api->DeleteServiceTime($service_times_id , "ajax");
        return  $response;

    }

    /*public function TimeVoucherInfoList($service_id){
        $VoucherInfoList = $this->api->VoucherInfoList($service_id);
        return $VoucherInfoList["ContentData"] ;
    }*/

}
