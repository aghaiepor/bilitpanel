<?php

namespace App\Http\Controllers;

use App\Api\Api;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class terminalController extends Controller
{
    var $Api = null ;
    public function __construct()
    {
        $this->Api = new Api() ;
    }

    public function index(){
        $location = Cache::get('LocationList' . session('UserInfo')['user_id']);
        $province = Cache::get('ProvinceList' . session('UserInfo')['user_id']);

        return view('terminals' , ['locations' => $location , 'provinces' => $province]) ;
    }
    public function AddClearingAccount(Request $request , $id){
        $location_id = $id ;
        $project_name = $request->get('project_name');
        $owner_name = $request->get('owner_name');
        $shaba = $request->get('shaba');
        $payment_id = $request->get('payment_id');
        $AddClearingAccount = $this->Api->AddClearingAccount($location_id, $project_name, $owner_name, $shaba, $payment_id);
        if($AddClearingAccount['Header']['Status'] == 0 ){
            return redirect()->back()->with('success' , ' حساب مورد نظر ایجاد گردید . ');
        }else
        {
            return redirect()->back()->with('error' , 'خطا در ایجاد  حساب ! ');
        }
    }

    public function TerminalInfo(Request $request , $id){
        $terminal_id = $id ;
        $TerminalLocationList = $this->Api->TerminalLocationList($terminal_id);
        $projectList = $this->Api->ProjectList();
        $TerminalTypeList = $this->Api->TerminalTypeList();
//        return $TerminalLocationList;
        return view('terminalInfo' , ['TerminalLocationList' => $TerminalLocationList['ContentData'] , 'projectList' => $projectList['ContentData'] , 'id'=>$id , 'TerminalTypeList' => $TerminalTypeList['ContentData'] ]);
        /*$terminal_number = $$request->get('project_name');
        $serial_number = $$request->get('owner_name');
        $terminal_name = $$request->get('shaba');
        $terminal_address= $$request->get('payment_id');

        $AddClearingAccount = $this->Api->TerminalInfo($terminal_id, $terminal_number, $serial_number, $terminal_name, $terminal_address);
        if($AddClearingAccount['Header']['Status'] == 0 ){
            return redirect()->back('success' , ' حساب مورد نظر ایجاد گردید . ');
        }else
        {
            return redirect()->back('error' , 'خطا در ایجاد  حساب ! ');
        }*/
    }

    public function AssignTerminal(Request $request , $id){
        $terminal_id = $request->get("terminal_id") ;
        $imei = $request->get("imei") ;
        $domain = $request->get("domain") ;
        $serial_number = $request->get("serial_number") ;
        $type_id = $request->get("type_id") ;
        $location_id = $id ;
        $project_name = $request->get('project_name');
        $AssignTerminal = $this->Api->AssignTerminal($terminal_id, $imei, $domain, $serial_number, $type_id, $location_id, $project_name);
        if($AssignTerminal['Header']["Status"]){
            return redirect()->back()->with('success' , ' ترمینال با موفقیت ایجاد گردید .  ' );
        }else
        {
            return redirect()->back()->with('error' , ' خطا در ایجاد ترمینال !  ' );
        }
    }
    public function EditAssignTerminal(Request $request , $id){

        $location_terminal_id = $request->get("location_terminal_id") ;
        $terminal_id = $request->get("terminal_id") ;
        $serial_number = $request->get("serial_number") ;
        $type_id = $request->get("type_id") ;

        $AssignTerminal = $this->Api->EditAssignTerminal($location_terminal_id, $terminal_id, $serial_number, $type_id);
        if($AssignTerminal['Header']["Status"]){
            return redirect()->back()->with('success' , ' ترمینال با موفقیت ایجاد گردید .  ' );
        }else
        {
            return redirect()->back()->with('error' , ' خطا در ایجاد ترمینال !  ' );
        }
    }

    /*public function TerminalLocationList(Request $request, $id){
        $TerminalLocationList = $this->Api->TerminalLocationList($id);
        if($TerminalLocationList['Header']['Status'] == 0 ){
            return redirect()->back('success' , ' حساب مورد نظر ایجاد گردید . ');
        }
        else
        {
            return redirect()->back('error' , 'خطا در ایجاد  حساب ! ');
        }
    }*/
}
