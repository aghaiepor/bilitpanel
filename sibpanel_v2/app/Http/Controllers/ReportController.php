<?php

namespace App\Http\Controllers;

use App\Api\Api;
use App\Exports\UsersExport;
use App\Jobs\ExportToExel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Hekmatinasser\Verta\Verta;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Jobs\ReportJob;
use App\UserJob;
use App\QJobs;
use Illuminate\Support\Facades\Storage;

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
        $SellModelList = $this->api->SellModelList();
//        return $SellModelList ;
//        return $Project_list ;
//        return $SellerUsersList ;
        return view('Report' , [
            'ProvinceList'=>$ProvinceList ,
            'tikcetType'=>$tikcetType  ,
            'SellerUsersList'=> $SellerUsersList,
            'report_type'=>$report_type ,
            'data'=>null ,
            'SaleTypeList' => $SaleTypeList ,
            "ProjectList" => $Project_list['ContentData'] ,
            "SellModelList" => $SellModelList['ContentData'] ,
        ]);
    }
    public function ProvinceListReport(Request $request){
        $id = (int)$request->get('project_id');
        $ProvinceList = $this->api->ProvinceList( "ajax" , $id );
//        return $ProvinceList
        $content = [
            'data' => $ProvinceList['ContentData'],
        ];
        return $content ;
    }

    public function CityList(Request $request){
        $id = (int)$request->get('province_id');
        $CityList = $this->api->CityList($id , "ajax");
        $content = [
            'data' => $CityList['ContentData'],
        ];
        return $content ;
    }
    public function location_list(Request $request){
        $province_id = (int)$request->get('province_id');
        $city_id = (int)$request->get('city_id');
        $data = '';
        $location_list = $this->api->location_list($province_id , $city_id , "ajax");
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
        $GetTerminal = $this->api->TerminalLocationList($locationID , "ajax");
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
        $status_code = $request->get('status_code');
//        dd ($status_code , $status_code != 255) ;
        $status_codeArray = [] ;
        if ($status_code == 255 ) {
            $status_codeArray = ["1","10","5","11"];
        }
        else
        {
            if($status_code == 1 ){
                $status_codeArray = ["1","10"];
            }else if($status_code == 5){
                $status_codeArray = ["5","11"];
            }else if ($status_code == 3){
                $status_codeArray = ["3"];
            }
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
        $SellModelList = $this->api->SellModelList();
//        return $GetStat ;
        if ($GetStat['Header']['Status'] == 0){
            return view('Report' , ['ProvinceList'=>$ProvinceList , 'tikcetType'=>$tikcetType  ,'SellerUsersList'=> $SellerUsersList,'report_type'=>$report_type , 'data'=>$GetStat['ContentData'], 'SaleTypeList'=>$SaleTypeList  , "ProjectList" => $Project_list['ContentData'] ,   "SellModelList" => $SellModelList['ContentData']] ) ;
        }else{
            return view('Report' , ['ProvinceList'=>$ProvinceList , 'tikcetType'=>$tikcetType  ,'SellerUsersList'=> $SellerUsersList,'report_type'=>$report_type ,'data'=>null , 'error'=>'خطا در دریافت گزارش!', 'SaleTypeList'=>$SaleTypeList , "ProjectList" => $Project_list['ContentData'] ,   "SellModelList" => $SellModelList['ContentData']]);
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
        $SellModelList = $this->api->SellModelList();
//        return $SellerUsersList ;
        return view('transaction' , [
            'ProvinceList'=>$ProvinceList ,
            'tikcetType'=>$tikcetType  ,
            'SellerUsersList'=> $SellerUsersList ,
            'report_type'=>$report_type ,
            'data'=> null ,
            'SaleTypeList'=> $SaleTypeList ,
            'ProjectList' => $Project_list['ContentData'] ,
            "SellModelList" => $SellModelList['ContentData']
        ]);
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
        if ($status_code == 255 ) {
            $status_codeArray = ["1","10","5","11"];
        }
        else
        {
            if($status_code == 1 ){
                $status_codeArray = ["1","10"];
            }else if($status_code == 5){
                $status_codeArray = ["5","11"];
            }else if ($status_code == 3){
                $status_codeArray = ["3"];
            }
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
        $end_date = $request->get('endtDate','');

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

        $voucher_number = (int)$request->get('voucher_number',"");
        if($voucher_number == 0)
            $voucher_number = "";

        $rrn = $request->get('rrn',"");
        if(is_null($rrn))
            $rrn = "";

        $GetStat = $this->api->GetTransaction($page,$location_id, $key, $values, $status_codeArray, $service_id, $operator_id, $sell_type_id, $sale_type_id, $voucher_type_id, $date, $province_id, $city_id , $project_id ,$rrn , $voucher_number);
//        return redirect()->back()->with('data' , $GetStat['ContentData'])->withInput();
//        return $GetStat ;
        $SaleTypeList = Cache::get('SaleTypeList');
        $tikcetType = Cache::get('VoucherTypeList');
        $ProvinceList = Cache::get('ProvinceList');
        $SellerUsersList = Cache::get('SellerUserList');
        $Project_list = $this->api->ProjectList();
        $SellModelList = $this->api->SellModelList();
        if ($GetStat['Header']['Status'] == 0){
//            return $GetStat ;
            return view('transaction' , ['ProvinceList'=>$ProvinceList , 'tikcetType'=>$tikcetType  ,'SellerUsersList'=> $SellerUsersList,'report_type'=>$report_type , 'data'=>$GetStat['ContentData'] , 'SaleTypeList'=>$SaleTypeList , "ProjectList" => $Project_list['ContentData'] ,   "SellModelList" => $SellModelList['ContentData'] ]);
        }else{
            return view('transaction' , ['ProvinceList'=>$ProvinceList , 'tikcetType'=>$tikcetType  ,'SellerUsersList'=> $SellerUsersList,'report_type'=>$report_type ,'data'=>null , 'error'=>'خطا در دریافت گزارش!' , 'SaleTypeList'=>$SaleTypeList , "ProjectList" => $Project_list['ContentData'] ,   "SellModelList" => $SellModelList['ContentData']]);
        }

    }

    public function transactionToExcel(Request $request){

        $report_type = $request->get('reportType',0); // 0 normal ---- // 1 pre sale only
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
        $end_date = $request->get('endtDate','');

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


        $search_headers = [];

        $search_headers['تاریخ شروع'] = Verta::createTimestamp($start_date)->format('Y/n/j');
        $search_headers['تاریخ پایان'] = Verta::createTimestamp($end_date)->format('Y/n/j');

        $Project_list = $this->api->ProjectList()['ContentData'];
        if ($project_id != '')
            $search_headers['پروژه'] = $Project_list[array_search($project_id, array_column($Project_list, 'project_id'))]['project_name'];

        $ProvinceList = Cache::get('ProvinceList');
        if ($province_id == '')
            $search_headers['استان'] = 'همه';
        else
            $search_headers['استان'] = $ProvinceList[array_search($province_id, array_column($ProvinceList, 'id'))]['province_name'];

        $CityList = $this->api->CityList($province_id)['ContentData'];
        if ($location_id == '')
            $search_headers['شهر'] = 'همه';
        else
            $search_headers['شهر'] = $CityList[array_search($city_id, array_column($CityList, 'id'))]['city_name'];

        $ServiceList = Cache::get('ServiceList');
        if ($location_id == '')
            $search_headers['مکان'] = 'همه';
        else
            $search_headers['مکان'] = $ServiceList[array_search($location_id, array_column($ServiceList, 'location_id'))]['location_name'];


        if ($service_id == '')
            $search_headers['موزه'] = 'همه';
        else
            $search_headers['موزه'] = $ServiceList[array_search($service_id, array_column($ServiceList, 'service_id'))]['service_name'];

        $VoucherTypes = Cache::get('VoucherTypeList');
        if ($voucher_type_id == '')
            $search_headers['نوع بلیت'] = 'همه';
        else
            $search_headers['نوع بلیت'] = $VoucherTypes[array_search($voucher_type_id, array_column($VoucherTypes, 'voucher_type_id'))]['voucher_type'];


        $SaleTypeList = Cache::get('SaleTypeList');
        if ($sell_type_id == '')
            $search_headers['نوع پرداخت'] = 'همه';
        else
            $search_headers['نوع پرداخت'] = $SaleTypeList[array_search($sell_type_id, array_column($SaleTypeList, 'sale_type_id'))]['sale_type'];

        if($status_code == 255 )
            $search_headers['وضعیت بلیت'] = 'همه';
        else if($status_code == 1 )
            $search_headers['وضعیت بلیت'] = 'استفاده نشده';
        else if($status_code == 5)
            $search_headers['وضعیت بلیت'] = 'استفاده شده';
        else if ($status_code == 3)
            $search_headers['وضعیت بلیت'] = 'حذف شده';

        $Operators = Cache::get('SellerUserList');
        if ($operator_id == '')
            $search_headers['اپراتور'] = 'همه';
        else{
            $op = $Operators[array_search($operator_id, array_column($Operators, 'sib_user_id'))];
            $search_headers['اپراتور'] = $op['first_name'].' '.$op['last_name'];
        }


        if($sale_type_id == '' )
            $search_headers['نوع فروش'] = 'عادی';
        else if($sale_type_id == 1 )
            $search_headers['نوع فروش'] = 'پیش فروش';





        ReportJob::dispatch(session('user_name'),session('SessionId'),$search_headers,$location_id, $key, $values, $status_codeArray, $service_id, $operator_id, $sell_type_id, $sale_type_id, $voucher_type_id, $date, $province_id, $city_id , $project_id);
    }


    public function exports(){
        $jobs = UserJob::where('user_name',session('user_name'))->orderByDesc('id')->get()->toArray();

        $Qjons = QJobs::all();
        foreach ($Qjons as $qjob){

            $payload = json_decode($qjob->payload,true);
            $command=unserialize($payload['data']['command']);
            $jsn = json_encode((array)$command);
            $jsn = str_replace('\u0000*\u0000','',$jsn);
            $row=json_decode($jsn,true);

            // search in jobs
            if(!$this->job_exists($qjob['id'],$jobs)){

                $extra = [
                    'id'=>"-1",
                    'job_id'=>$qjob['id'],
                    'current_page'=>-2,
                    'total_pages' => -2,
                    'finished' => false,
                    'date' => $row['job_date'],
                    'search_headers' => json_encode($row['search_headers'])
                ];

                array_unshift($jobs,$extra);

            }

        }



//        return $jobs;

        $data = ['jobs'=>$jobs];
        return view('exports',$data);
    }

    private function job_exists($id,$jobs){
        foreach ($jobs as $job){
            if ($job['job_id'] == $id)
                return true;
        }
        return false;
    }

    public function download_file(Request $request){

        $job_id = $request->input('job_id');
        $user_name = session('user_name');
        $rand = rand(10000000,90000000);
        Storage::copy( "{$user_name}_{$job_id}.csv", "public/report/{$user_name}_{$job_id}_{$rand}.csv" );
        $data = ['link'=>url("/storage/report/")."/{$user_name}_{$job_id}_{$rand}.csv"];
        return $data;

    }

    private function fa2en($number){
        return strtr($number, array('۰'=>'0', '۱'=>'1', '۲'=>'2', '۳'=>'3', '۴'=>'4', '۵'=>'5', '۶'=>'6', '۷'=>'7', '۸'=>'8', '۹'=>'9', '٠'=>'0', '١'=>'1', '٢'=>'2', '٣'=>'3', '٤'=>'4', '٥'=>'5', '٦'=>'6', '٧'=>'7', '٨'=>'8', '٩'=>'9'));
    }

}
