<?php

namespace App\Http\Controllers;

use App\Api\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class LoadingController extends Controller
{
    var $response_ok = ['status'=>0];
    var $response_error = ['status'=>1];
    var $api = null;
    public function __construct()
    {
        $this->api = new Api('loading');
    }

    public function index(){
        $num = 9 ;
        return view('loading' , ['num' => $num]);
    }
    public function locationCache(){

        // temp
        Cache::forget("GetSubUserList" . session('UserInfo')['user_id']);

        Cache::forget('LocationList' . session('UserInfo')['user_id'] );
        Cache::rememberForever('LocationList' . session('UserInfo')['user_id'] , function(){
            $Locations  = $this->api->LocationList(""    , "ajax");
            return $Locations['ContentData'];
        });
        return $this->response_ok;
    }
    public function ServiceList(){

        Cache::forget('ServiceList' . session('UserInfo')['user_id']);
        $value = Cache::rememberForever('ServiceList' . session('UserInfo')['user_id'], function(){
            $ServiceList  = $this->api->ServiceList(null, "ajax");
            return $ServiceList['ContentData'];
        });
        // notify success
        return $this->response_ok;
    }
    public function ProvinceList(){

        //cache ProvinceList
        Cache::forget('ProvinceList' . session('UserInfo')['user_id']);
        $value = Cache::rememberForever('ProvinceList' . session('UserInfo')['user_id'], function(){
            $ProvinceList  = $this->api->ProvinceList("ajax");
            return $ProvinceList['ContentData'];
        });
        // notify success
        return $this->response_ok;
    }
    public function SellerUserList(){

        //cache SellerUserList
        Cache::forget('SellerUserList' . session('UserInfo')['user_id']);
        $value = Cache::rememberForever('SellerUserList' . session('UserInfo')['user_id'], function(){
            $ProvinceList  = $this->api->SellerUserList("ajax");
            return $ProvinceList['ContentData'];
        });
        // notify success
        return $this->response_ok;
    }
    public function SaleTypeList(){

        //cache SaleTypeList
        Cache::forget('SaleTypeList' . session('UserInfo')['user_id']);
        $value = Cache::rememberForever('SaleTypeList' . session('UserInfo')['user_id'], function(){
            $ProvinceList  = $this->api->SaleTypeList("ajax");
            return $ProvinceList['ContentData'];
        });
        // notify success
        return $this->response_ok;
    }
    public function VoucherTypeList(){

        //cache SaleTypeList
        Cache::forget('VoucherTypeList' . session('UserInfo')['user_id']);
        $value = Cache::rememberForever('VoucherTypeList' . session('UserInfo')['user_id'], function(){
            $ProvinceList  = $this->api->VoucherTypeList("ajax");
            return $ProvinceList['ContentData'];
        });
        // notify success
        return $this->response_ok;
    }
    public function GetInfo(){
        //cache SaleTypeList
        Cache::forget('GetInfo' . session('UserInfo')['user_id']);
        $value = Cache::rememberForever('GetInfo' . session('UserInfo')['user_id'], function(){
            $GetInfo  = $this->api->GetInfo("ajax");
            return $GetInfo['ContentData'];
        });
        // notify success
        return $this->response_ok;
    }
    public function GetVoucherText(){
        //cache GetVoucherText
        Cache::forget('GetVoucherText' . session('UserInfo')['user_id']);
        $value = Cache::rememberForever('GetVoucherText' . session('UserInfo')['user_id'], function(){
            $GetInfo  = $this->api->GetVoucherText("ajax");
            return $GetInfo['ContentData'];
        });
        // notify success
        return $this->response_ok;
    }
    public function ProjectListCashe(){

        //cache SaleTypeList
        Cache::forget('ProjectList'. session('UserInfo')['user_id']);
        $value = Cache::rememberForever('ProjectList'. session('UserInfo')['user_id'], function(){
            $ProvinceList  = $this->api->ProjectList("ajax");
            return $ProvinceList['ContentData'];
        });
        // notify success
        return $this->response_ok;
    }


}
