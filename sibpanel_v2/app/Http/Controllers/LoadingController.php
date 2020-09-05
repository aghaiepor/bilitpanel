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
        $num = 8 ;
        return view('loading' , ['num' => $num]);

    }
    public function locationCache(){

        Cache::forget('LocationList');
        Cache::rememberForever('LocationList', function(){
            $Locations  = $this->api->LocationList();
            return $Locations['ContentData'];
        });
        return $this->response_ok;
    }
    public function ServiceList(){

        Cache::forget('ServiceList');
        $value = Cache::rememberForever('ServiceList', function(){
            $ServiceList  = $this->api->ServiceList();
            return $ServiceList['ContentData'];
        });
        // notify success
        return $this->response_ok;
    }
    public function ProvinceList(){

        //cache ProvinceList
        Cache::forget('ProvinceList');
        $value = Cache::rememberForever('ProvinceList', function(){
            $ProvinceList  = $this->api->ProvinceList();
            return $ProvinceList['ContentData'];
        });
        // notify success
        return $this->response_ok;
    }
    public function SellerUserList(){

        //cache SellerUserList
        Cache::forget('SellerUserList');
        $value = Cache::rememberForever('SellerUserList', function(){
            $ProvinceList  = $this->api->SellerUserList();
            return $ProvinceList['ContentData'];
        });
        // notify success
        return $this->response_ok;
    }
    public function SaleTypeList(){

        //cache SaleTypeList
        Cache::forget('SaleTypeList');
        $value = Cache::rememberForever('SaleTypeList', function(){
            $ProvinceList  = $this->api->SaleTypeList();
            return $ProvinceList['ContentData'];
        });
        // notify success
        return $this->response_ok;
    }
    public function VoucherTypeList(){

        //cache SaleTypeList
        Cache::forget('VoucherTypeList');
        $value = Cache::rememberForever('VoucherTypeList', function(){
            $ProvinceList  = $this->api->VoucherTypeList();
            return $ProvinceList['ContentData'];
        });
        // notify success
        return $this->response_ok;
    }
    public function GetInfo(){
        //cache SaleTypeList
        Cache::forget('GetInfo');
        $value = Cache::rememberForever('GetInfo', function(){
            $GetInfo  = $this->api->GetInfo();
            return $GetInfo['ContentData'];
        });
        // notify success
        return $this->response_ok;
    }
    public function GetVoucherText(){
        //cache GetVoucherText
        Cache::forget('GetVoucherText');
        $value = Cache::rememberForever('GetVoucherText', function(){
            $GetInfo  = $this->api->GetVoucherText();
            return $GetInfo['ContentData'];
        });
        // notify success
        return $this->response_ok;
    }


}
