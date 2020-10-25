<?php

namespace App\Http\Controllers;

use App\Api\Api;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Hekmatinasser\Verta\Verta;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{

    var $api = null;
    public function __construct()
    {
        $this->api = new Api();
        set_time_limit(8000000);
    }

    public function index(Request $request){
        $report_type = $request->get('reportType',0); // 0 normal ---- // 1 pre sale only
        if (!session('UserInfo')['presell'] )
            $report_type = 0;
        $SaleTypeList = Cache::get('SaleTypeList');
        $tikcetType = Cache::get('VoucherTypeList');
        $ProvinceList = Cache::get('ProvinceList');
        $SellerUsersList = Cache::get('SellerUserList');
        $Project_list = $this->api->ProjectList();
//        return $Project_list ;
//        return $SellerUsersList ;
        return view('Report' , ['ProvinceList'=>$ProvinceList , 'tikcetType'=>$tikcetType  ,'SellerUsersList'=> $SellerUsersList,'report_type'=>$report_type , 'data'=>null , 'SaleTypeList' => $SaleTypeList , "ProjectList" => $Project_list['ContentData']]);
    }
    public function CityList(Request $request){
        $id = (int)$request->get('province_id');
        $CityList = $this->api->CityList($id);
        $content = [
            'data' => $CityList['ContentData'],
        ];
        return $content ;
    }
    public function location_list(Request $request){
        $province_id = (int)$request->get('province_id');
        $city_id = (int)$request->get('city_id');
        $data = '';
        $location_list = $this->api->location_list($province_id , $city_id);
        $content = [
            'data' => $location_list['ContentData'],
        ];
        return $content ;
    }
    public function ServiceList(Request $request){
        $GetServices = Cache::get('ServiceList');
        $locationID = (int)$request->get('locationID');
        $GetServices = array_filter($GetServices, function ($event) use ($locationID ) {
            return $event['location_id'] == $locationID ;
        });
        $array_keys = array_keys($GetServices) ;

//        return $GetServices ;
        $content = [
            'array_keys' => $array_keys ,
            'data' => $GetServices,
        ];
        return $content ;
    }
    public function TerminalLocationList(Request $request){
        $locationID = (int)$request->get('locationID');
        $GetTerminal = $this->api->TerminalLocationList($locationID);
        $content = [
            'data' => $GetTerminal['ContentData'],
        ];
        return $content ;
    }
    public function GetStat(Request $request){

        $report_type = $request->get('reportType',0); // 0 normal ---- // 1 pre sale only
        if (!session('UserInfo')['presell'] )
            $report_type = 0;
        $project_id = $request->get("project_id");
        if(is_null($project_id))
            $project_id = "";

        $location_id = $request->get('location_id' , '');
        if($location_id == 0)
            $location_id = '';
        $key = $request->get('key' , 'province');
        $values = ['amount' , 'count'];
        $status_code= $request->get('status_code');
        $status_codeArray = [] ;
        if($status_code != 225 ){
            if($status_code == 1 ){
                $status_codeArray = [1,10];
            }else if($status_code == 5){
                $status_codeArray = [5,11];
            }else if ($status_code == 3){
                $status_codeArray = [3];
            }
        }
        else {
            $status_codeArray = ["1","10","5","11"];
        }
//        return $status_codeArray ;
        $service_id = (int)$request->get('service_id','');
        if($service_id == 0)
            $service_id = '';
        $operator_id = (int)$request->get('operator_id' , '');
        if($operator_id == 0)
            $operator_id = '';
        $sale_type_id = (int)$request->get('pre_sale') ; // type Forosh
        if($sale_type_id == 0)
            $sale_type_id = '';
        if($report_type == 1){
            $sale_type_id == 1 ;
        }

        $sell_type_id = (int)$request->get('sell_type_id' , ''); // type Pay
        if($sell_type_id == 0)
            $sell_type_id = '';

        $voucher_type_id = (int)$request->get('voucher_type_id' , '');
        if($voucher_type_id == 0)
            $voucher_type_id = '';

        $start_date = $request->get('startDate','');
        $end_date = $request->get('endDate','');

        if ($start_date !='')
        $start_date = Verta::parse($this->fa2en($start_date).' 00:00:00')->timestamp;
        if ($end_date !='')
            $end_date = Verta::parse($this->fa2en($end_date).' 23:59:59')->timestamp;

        $date = [$start_date,$end_date];
        $province_id = (int)$request->get('province_id' , '');
        if($province_id == 0)
            $province_id = '';
        $city_id = (int)$request->get('city_id' ,'') ;
        if($city_id == 0)
            $city_id = '';
        $GetStat = $this->api->GetStat($location_id, $key, $values, $status_codeArray, $service_id, $operator_id,  $sell_type_id , $sale_type_id, $voucher_type_id, $date, $province_id, $city_id , $project_id);
//        return redirect()->back()->with('data' , $GetStat['ContentData'])->withInput();
//        return $GetStat ;
        $SaleTypeList = Cache::get('SaleTypeList');

        $tikcetType = Cache::get('VoucherTypeList');
        $ProvinceList = Cache::get('ProvinceList');
        $SellerUsersList =  Cache::get('SellerUserList');
        $Project_list = $this->api->ProjectList();
//        return $GetStat ;
        if ($GetStat['Header']['Status'] == 0){
            return view('Report' , ['ProvinceList'=>$ProvinceList , 'tikcetType'=>$tikcetType  ,'SellerUsersList'=> $SellerUsersList,'report_type'=>$report_type , 'data'=>$GetStat['ContentData'], 'SaleTypeList'=>$SaleTypeList  , "ProjectList" => $Project_list['ContentData'] ] ) ;
        }else{
            return view('Report' , ['ProvinceList'=>$ProvinceList , 'tikcetType'=>$tikcetType  ,'SellerUsersList'=> $SellerUsersList,'report_type'=>$report_type ,'data'=>null , 'error'=>'خطا در دریافت گزارش!', 'SaleTypeList'=>$SaleTypeList , "ProjectList" => $Project_list['ContentData']]);
        }

    }

    // transaction
    public function transaction(Request $request){
        $report_type = $request->get('reportType',0); // 0 normal ---- // 1 pre sale only
        if (!session('UserInfo')['presell'] )
            $report_type = 0;
        $SaleTypeList = Cache::get('SaleTypeList');
        $tikcetType = Cache::get('VoucherTypeList');
        $ProvinceList = Cache::get('ProvinceList');
        $SellerUsersList = Cache::get('SellerUserList');
        $Project_list = $this->api->ProjectList();
//        return $SellerUsersList ;
        return view('transaction' , ['ProvinceList'=>$ProvinceList , 'tikcetType'=>$tikcetType  ,'SellerUsersList'=> $SellerUsersList , 'report_type'=>$report_type , 'data'=> null , 'SaleTypeList'=>$SaleTypeList , 'ProjectList' =>$Project_list['ContentData'] ]);
    }
    public function transactionToExcel(Request $request){
        $report_type = $request->get('reportType',0); // 0 normal ---- // 1 pre sale only
        if (!session('UserInfo')['presell'] )
            $report_type = 0;

        $location_id = $request->get('location_id' , '');
        if($location_id == 0)
            $location_id = '';

        $values = ['amount' , 'count'];
        $status_code= $request->get('status_code');
        $status_codeArray = [] ;
        if($status_code != 225 ){
            if($status_code == 1 ){
                $status_codeArray = [1,10];
            }else if($status_code == 5){
                $status_codeArray = [5,11];
            }else if ($status_code == 3){
                $status_codeArray = [3];
            }
        }
        else {
            $status_codeArray = ["1","10","5","11"];
        }
        $key = $request->get('key' , 'province');
        $service_id = (int)$request->get('service_id','');
        if($service_id == 0)
            $service_id = '';
        $operator_id = (int)$request->get('operator_id' , '');
        if($operator_id == 0)
            $operator_id = '';
        $sale_type_id = (int)$request->get('pre_sale');
        if($sale_type_id == 0)
            $sale_type_id = '';
        $sell_type_id = (int)$request->get('sell_type_id' , '');
        if($sell_type_id == 0)
            $sell_type_id = '';
        $voucher_type_id = (int)$request->get('voucher_type_id' , '');
        if($voucher_type_id == 0)
            $voucher_type_id = '';

        $start_date = $request->get('startDate','');
        $end_date = $request->get('endDate','');

        if ($start_date !='')
            $start_date = Verta::parse($this->fa2en($start_date).' 00:00:00')->timestamp;
        if ($end_date !='')
            $end_date = Verta::parse($this->fa2en($end_date).' 23:59:59')->timestamp;

        $date = [$start_date,$end_date];
        $province_id = (int)$request->get('province_id' , '');
        if($province_id == 0)
            $province_id = '';
        $city_id = (int)$request->get('city_id' ,'') ;
        if($city_id == 0)
            $city_id = '';

        /*
        $page = (int)$request->get('page',1);
        if($page == 0)
            $page = 1;
        */
        $test = [] ;
        $data = $this->api->GetTransaction(1,$location_id, $key, $values, $status_codeArray, $service_id, $operator_id, $sale_type_id, $sell_type_id, $voucher_type_id, $date, $province_id, $city_id);
//        echo  "ok";
        $total_page = (int)$data['ContentData']["total_pages"] ;
//        $data = $data['ContentData']["log"] ;
//        return $data['ContentData']["log"] ;

        for ($i = 1 ; $i <= $total_page  ;$i++ )
        {
            $GetStat = $this->api->GetTransaction($i,$location_id, $key, $values, $status_codeArray, $service_id, $operator_id, $sale_type_id, $sell_type_id, $voucher_type_id, $date, $province_id, $city_id);
            $test = array_merge($test,$GetStat['ContentData']["log"]);
        }
            return Excel::download(new UsersExport($test), 'tansacion.xlsx');

    }

    // GetTransaction
    public function GetTransaction(Request $request){
        $report_type     = $request->get('reportType',0); // 0 normal ---- // 1 pre sale only
        if (!session('UserInfo')['presell'] )
            $report_type = 0;

        $project_id = $request->get("project_id");
        if(is_null($project_id))
            $project_id = "";

        $location_id = $request->get('location_id' , '');
        if($location_id == 0)
            $location_id = '';

        $values = ['amount' , 'count'];
        $status_code= $request->get('status_code');
        $status_codeArray = [] ;
        if($status_code != 225){
            if($status_code == 1 ){
                $status_codeArray = [1,10];
            }else if($status_code == 5){
                $status_codeArray = [5,11];
            }else if ($status_code == 3){
                $status_codeArray = [3];
            }
        }
        else {
            $status_codeArray = ["1","10","5","11"];
        }
        $key = $request->get('key' , 'province');
        $service_id = (int)$request->get('service_id','');
        if($service_id == 0)
            $service_id = '';
        $operator_id = (int)$request->get('operator_id' , '');
        if($operator_id == 0)
            $operator_id = '';
        $sale_type_id = (int)$request->get('pre_sale');
        if($sale_type_id == 0)
            $sale_type_id = '';
        $sell_type_id = (int)$request->get('sell_type_id' , '');
        if($sell_type_id == 0)
            $sell_type_id = '';
        $voucher_type_id = (int)$request->get('voucher_type_id' , '');
        if($voucher_type_id == 0)
            $voucher_type_id = '';

        $start_date = $request->get('startDate','');
        $end_date = $request->get('endDate','');

        if ($start_date !='')
            $start_date = Verta::parse($this->fa2en($start_date).' 00:00:00')->timestamp;
        if ($end_date !='')
            $end_date = Verta::parse($this->fa2en($end_date).' 23:59:59')->timestamp;

        $date = [$start_date,$end_date];
        $province_id = (int)$request->get('province_id' , '');
        if($province_id == 0)
            $province_id = '';
        $city_id = (int)$request->get('city_id' ,'') ;
        if($city_id == 0)
            $city_id = '';

        $page = (int)$request->get('page',1);
        if($page == 0)
            $page = 1;

        $GetStat = $this->api->GetTransaction($page,$location_id, $key, $values, $status_codeArray, $service_id, $operator_id, $sell_type_id, $sale_type_id, $voucher_type_id, $date, $province_id, $city_id , $project_id);
//        return redirect()->back()->with('data' , $GetStat['ContentData'])->withInput();
//        return $GetStat ;
        $SaleTypeList = Cache::get('SaleTypeList');
        $tikcetType = Cache::get('VoucherTypeList');
        $ProvinceList = Cache::get('ProvinceList');
        $SellerUsersList = Cache::get('SellerUserList');
        $Project_list = $this->api->ProjectList();
        if ($GetStat['Header']['Status'] == 0){
//            return $GetStat ;
            return view('transaction' , ['ProvinceList'=>$ProvinceList , 'tikcetType'=>$tikcetType  ,'SellerUsersList'=> $SellerUsersList,'report_type'=>$report_type , 'data'=>$GetStat['ContentData'] , 'SaleTypeList'=>$SaleTypeList , "ProjectList" => $Project_list['ContentData']]);
        }else{
            return view('transaction' , ['ProvinceList'=>$ProvinceList , 'tikcetType'=>$tikcetType  ,'SellerUsersList'=> $SellerUsersList,'report_type'=>$report_type ,'data'=>null , 'error'=>'خطا در دریافت گزارش!' , 'SaleTypeList'=>$SaleTypeList , "ProjectList" => $Project_list['ContentData']]);
        }


    }

    private function fa2en($number){
        return strtr($number, array('۰'=>'0', '۱'=>'1', '۲'=>'2', '۳'=>'3', '۴'=>'4', '۵'=>'5', '۶'=>'6', '۷'=>'7', '۸'=>'8', '۹'=>'9', '٠'=>'0', '١'=>'1', '٢'=>'2', '٣'=>'3', '٤'=>'4', '٥'=>'5', '٦'=>'6', '٧'=>'7', '٨'=>'8', '٩'=>'9'));
    }

}
