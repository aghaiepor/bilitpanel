<?php

namespace App\Http\Controllers;

use App\Api\Api;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class UserManagerController extends Controller
{
    var $api = null ;

    public function __construct()
    {
        $this->api = new Api();
    }

    public function index(){
//        $SellerUserList = $this->api->GetSubUserList(); // GetSubUserList
        if(!Cache::has('GetSubUserList')){
            $SellerUserList = Cache::rememberForever('GetSubUserList' , function (){
                $data = $this->api->GetSubUserList() ;
                return $data['ContentData'];
            });
        }else
            $SellerUserList = Cache::get('GetSubUserList');

//        return $SellerUserList;
        $userList = $SellerUserList ;

        usort($SellerUserList, function($a, $b) {
//            echo '<script> console.log(' . preg_match($pattern, $a["first_name"]) . ' )</script>';
            if ($a["first_name"] == "" && $b["first_name"] != "" )
               return 1;
            elseif ( $a["first_name"] == "" && is_numeric($b["first_name"]))
                return 1 ;
            else if(is_numeric($a["first_name"]) && !is_numeric($b["first_name"]))
                return 1;
            else if(!is_numeric($a["first_name"]) && is_numeric($b["first_name"]))
                return -1;
            else
                return ($a["first_name"] < $b["first_name"]) ? -1 : 1;
       });
        // **************** Pagination ****************
        /*
         $SellerUserList = $this->paginate($SellerUserList);
        $SellerUserList->withPath('UserManager');
        */
        return view('UserManager' , ['Users' => $SellerUserList , 'userLists' => $userList]);
//        return $SellerUserList ;
    }
    public function getUserWithFilter(Request $request){
        $filter = $request->get('filter') ;
        $alphabet_index = $request->get('alphabet_index') ;
//        echo "<script> console.log( " . $alphabet_index . " )</script>" ;
//        if($alphabet_index == "")
//            $alphabet_index = null ;
        if ($alphabet_index == "الف")
            $alphabet_index = 'ا' ;

        if(is_null($filter) && is_null($alphabet_index))
        {
            $SellerUserList = Cache::get('GetSubUserList');
            $array_keys = -1;
        }else
        {
            $num = [];
            if($alphabet_index == "اعداد")
            {
                $alphabet_index =  null ;
                $num =  [1,2,3,4,5,6,7,8,9,0];
            }
            $SellerUserList = Cache::get('GetSubUserList');
            $SellerUserList = array_filter($SellerUserList, function ($event) use ($filter , $alphabet_index , $num) {
                return  ((is_null($filter)) ? true : str_replace("\n" , ''  , $event['account_type']) == $filter ) && ((is_null($alphabet_index)) ? true : strpos($event['first_name'], $alphabet_index) === 0) &&  ( (count($num) == 0) ? true : (is_numeric(substr($event['first_name'], 0, 1))) );
            });
            $array_keys = array_keys($SellerUserList) ;
        }

        $data = [
            'data' => $SellerUserList ,
            'array_key' => $array_keys
        ];
        return $data;
    }
    public function getUserWithAlphabet(Request $request){
        $filter = $request->get('filter') ;
//        return $filter ;
        $isActive = $request->get('isActive') ;
        $user_filter_value = $request->get('user_filter_value') ;
        /*if($user_filter_value == "")
            $user_filter_value = true ;*/

        if($isActive == "false")
            $filter = null ;

        if ($filter == "الف")
            $filter = 'ا' ;

        if(is_null($filter) && is_null($user_filter_value) )
        {
            $SellerUserList = Cache::get('GetSubUserList');
            $array_keys = -1;
        }else
        {
            $num = [];
            if($filter == "اعداد")
            {
                $filter =  null ;
                $num =  [1,2,3,4,5,6,7,8,9,0];
            }
//            return  ; //in_array(substr("کیوسک کاخ گلستان", 0, 1) , $num);
            $SellerUserList = Cache::get('GetSubUserList');
            usort($SellerUserList, function($a, $b) {
//            echo '<script> console.log(' . preg_match($pattern, $a["first_name"]) . ' )</script>';
                if ($a["first_name"] == "" && $b["first_name"] != "" )
                    return 1;
                elseif ( $a["first_name"] == "" && is_numeric($b["first_name"]))
                    return 1 ;
                else if(is_numeric($a["first_name"]) && !is_numeric($b["first_name"]))
                    return 1;
                else if(!is_numeric($a["first_name"]) && is_numeric($b["first_name"]))
                    return -1;
                else
                    return ($a["first_name"] < $b["first_name"]) ? -1 : 1;
            });

            $SellerUserList = array_filter($SellerUserList, function ($event) use ($filter , $user_filter_value , $num) {
                return  ((is_null($filter))  ? true : (strpos($event['first_name'], $filter) === 0) )  && ((is_null($user_filter_value)) ? true : str_replace("\n" , ''  , $event['account_type'])== $user_filter_value ) &&  ( (count($num) == 0) ? true : (is_numeric(substr($event['first_name'], 0, 1))) );
            });
            $array_keys = array_keys($SellerUserList) ;
        }

        $data = [
            'data' => $SellerUserList ,
            'array_key' => $array_keys
        ];
        return $data;
    }
    public function UserActivation(Request $request)
    {
        $sib_user_id = $request->get('id');
        $activation = $request->get('value');
        $user_activation = $this->api->UserActivation($sib_user_id , $activation);
        if ($user_activation['Header']['Status'] == 0 ){
            Cache::forget('GetSubUserList');
            Cache::rememberForever('GetSubUserList' , function (){
                $data = $this->api->GetSubUserList() ;
                return $data['ContentData'];
            });
        }
        return $user_activation ;
    }
    public function RegisterUser(Request $request , $id=null){
        if($id == null)
            $id="";
        $name = $request->get('name'); //
        $last_name = $request->get('last_name'); //
        $cellphone = $request->get('cellphone'); //
        $national_id = $request->get('national_id'); //
        $username = $request->get('username'); //
        $password = $request->get('password'); //
        $email = $request->get('email'); //
        $account_type_id = $request->get('account_type_id'); //
        $otp_verify = '0'; //$request->get('otp_verify');
        $subset_users ="";  /*$request->get('subset_users')*/
        $panel_access = false ;  /*$request->get('panel_access');*/
        $pre_sell = $request->get('pre_sell');
        $imei = $request->get('imei');

        $SellerUserList = $this->api->RegisterUser($name, $last_name, $cellphone, $national_id, $username, $password, $email, $account_type_id, $otp_verify, $subset_users, $panel_access, $pre_sell, $imei ,$id);
//       return $SellerUserList;
        $success_message = (is_null($id)) ?   "کاربر جدید اضافه گردید." : "کاربر مورد نظر ویرایش گردید .  ";
        $error_message = (is_null($id)) ?   "خطا در ایجاد کاربر !" : "خطا در ویرایش کاربر !  ";
        if($SellerUserList['Header']['Status'] == 0 ){
                Cache::forget('GetSubUserList');
                $SellerUserList = Cache::rememberForever('GetSubUserList' , function (){
                    $data = $this->api->GetSubUserList() ;
                    return $data['ContentData'];
                });
                return redirect()->back()->with('success' , $success_message);
        }
        else
            return redirect()->back()->with('error' , $error_message);
//            return  $SellerUserList ;
    }
    public function GetUserInfo(Request $request  ){
        $id = $request->get('UserId');
        $User_info = $this->api->GetUserInfo( $id);
       return $User_info['ContentData'];
    }
    public function setUserPermission($id=null){
        if( is_null($id))
            abort(404);

        $projectList = $this->api->ProjectList();
//        return $projectList;
        $TerminalTypeList = $this->api->TerminalTypeList();
        $SaleTypeList = $this->api->SaleTypeList();
        $GetUserPermission = $this->api->GetUserPermission($id);
//        return $GetUserPermission;
//        return $GetUserPermission['ContentData'];
//        http://127.0.0.1:8000/setUserPermission/533
//        return is_null($GetUserPer  ) ;
        $GetInfo = Cache::get('GetInfo');
//        return $GetInfo ;
        $VoucherTypeList = Cache::get('VoucherTypeList');
        $LocationList = Cache::get('ServiceList');
        return view('setUserPermission' , ['projectList'=> $projectList['ContentData'] , 'TerminalTypeList' => $TerminalTypeList['ContentData'] ,
            'VoucherTypeList'=> $VoucherTypeList , 'SaleTypeList'=>$SaleTypeList['ContentData'] ,
            'LocationList'=>$LocationList , 'GetInfo'=>$GetInfo ,'GetUserPermission' => $GetUserPermission['ContentData'] , 'userId'=>$id ] ) ;

    }
    public function AssignPermission(Request $request)
    {
        $province_id = (is_null($request->get('province_id'))) ? "" : implode(",",$request->get('province_id'));
        $city_id = (is_null($request->get('city_id'))) ? "" : implode(",",$request->get('city_id'));
        $location_id =  (is_null($request->get('location_id'))) ? "" : implode(",",$request->get('location_id'));
        $service_id = (is_null($request->get('service_id'))) ? "" : implode(",",$request->get('service_id'));
        $voucher_type_id = (is_null($request->get('voucher_type_id'))) ? "" : implode(",",$request->get('voucher_type_id'));
        $project_id = (is_null($request->get('project_id'))) ? "" : implode(",",$request->get('project_id'));
        $sale_type_id = (is_null($request->get('sale_type_id'))) ? "" : implode(",",$request->get('sale_type_id'));
        $terminal_type_id = (is_null($request->get('terminal_type_id'))) ? "" : implode(",",$request->get('terminal_type_id'));
        $sib_user_id = $request->get('sib_user_id');
        /*$data =  [
        '$province_id' => $province_id,
        '$city_id' => $city_id,
        '$location_id' => $location_id,
        '$service_id' => $service_id,
        '$voucher_type_id' => $voucher_type_id,
        '$project_id' => $project_id,
        '$sale_type_id' => $sale_type_id,
        '$terminal_type_id' => $terminal_type_id,
        '$sib_user_id' => $sib_user_id
        ];;
        return $data ;*/
        $AssignPermission = $this->api->AssignPermission($province_id, $city_id, $location_id, $service_id, $voucher_type_id, $project_id, $sale_type_id, $terminal_type_id, $sib_user_id);
        return $AssignPermission;

    }

    //************ methods ********************
    public function paginate($items, $perPage = 20, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

}
