<?php

namespace App\Http\Controllers;

use App\Api\Api;
use Illuminate\Http\Request;

class seanceController extends Controller
{
    var $api = null;
    public function __construct()
    {
        $this->api = new Api();
    }

    public function group_times(){
        $GetTimeGroup = $this->api->GetTimeGroup();
        $AllLocationServices = $this->api->AllLocationServiceList();
        return view('group_times' , ['locations'=>$AllLocationServices,'result_data' => $GetTimeGroup['ContentData']] );
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
    public function add_group_time_index(){
        return view('group_time_add');
    }

    public function add_group_time(Request $request){
        $service_times = $request->input('service_times');
        $time_templates = $this->api->AddTimeTemplate(json_decode($service_times,true));
        $time_templates_ids = $time_templates['ContentData']['time_template_ids'];
        $group_name = $request->input('group_name');
        $group_time = $this->api->AddTimeGroup($group_name,$time_templates_ids);
        if($group_time['Header']['Status'] == 0 )
            return redirect('group_times')->with('success' , "گروه سانس با موفقیت ایجاد شد .");
        else
            return redirect()->back()->with('error' , " خطا در ایجاد گروه سانس ");

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

    public function edit_group_time(Request $request){

        $data = $request->input('service_times');
        $data = json_decode($data,true);

        $response = $this->api->EditServiceTime($data);
        return redirect('group_times');

    }


}
