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
        $location = Cache::get('LocationList');
        $province = Cache::get('ProvinceList');
        return view('terminals' , ['locations' => $location , 'provinces' => $province]) ;
    }
    public function AddClearingAccount(Request $request , $id){
        $location_id = $id ;
        $project_name = $$request->get('project_name');
        $owner_name = $$request->get('owner_name');
        $shaba = $$request->get('shaba');
        $payment_id= $$request->get('payment_id');
        $AddClearingAccount = $this->Api->AddClearingAccount($location_id, $project_name, $owner_name, $shaba, $payment_id);
        if($AddClearingAccount['Header']['Status'] == 0 ){
            return redirect()->back('success' , ' حساب مورد نظر ایجاد گردید . ');
        }else
        {
            return redirect()->back('error' , 'خطا در ایجاد  حساب ! ');
        }
    }
    public function TerminalInfo(Request $request , $id){
        $terminal_id = $id ;
        return view('terminalInfo');
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
}
