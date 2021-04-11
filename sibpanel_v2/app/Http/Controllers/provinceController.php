<?php

namespace App\Http\Controllers;

use App\Api\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class provinceController extends Controller
{
    var $api = null ;
    public function __construct()
    {
        $this->api = new Api();
    }

    public function index()
    {
        $ProvinceList = Cache::get('ProvinceList' . session('UserInfo')['user_id']);
//        return $ProvinceList ;
        $projectList = $this->api->ProjectList();
//        return $projectList ;
        return view('stateMg' , ['ProvinceList' => $ProvinceList , 'projectList' => $projectList['ContentData']]);
    }
    public function AddProvince(Request $request)
    {
        $name_fa = $request->get('name_fa');
        $name_en = $request->get('name_en');
//        $projects = $request->get('projects');
        $AddProvince = $this->api->AddProvince($name_fa, $name_en);
//        return $AddProvince ;
        if ($AddProvince['Header']['Status'] == 0 ){

            $data = [
                "id" => $AddProvince['ContentData']['province_id'] ,
                "province_name"=> $name_fa,
                "english_name"=> $name_en,
                "country_id"=> 1,
                "country_name"=> "ایران",
                "activation"=> true
            ];
            $ProvinceList = Cache::get('ProvinceList' . session('UserInfo')['user_id']);
            array_push($ProvinceList , $data);
            Cache::forget('ProvinceList' . session('UserInfo')['user_id']);
            Cache::rememberForever('ProvinceList' . session('UserInfo')['user_id'], function() use ($ProvinceList){
                return $ProvinceList;
            });

            return redirect()->back()->with('success' , ' استان مورد نظر با موفقیت ایجاد گردید . ');
        }else if($AddProvince['Header']['MessageCode'] == 42)
        {
            return redirect()->back()->with('error' , ' خطا : استان مورد نظر قبلا ثبت شده است ! ');
        }
        else
            return redirect()->back()->with('error' , ' خطا در ایجاد استان ! ');
    }

    public function EditProvince(Request $request , $id)
    {
        $name_fa = $request->get('name_fa');
        $name_en = $request->get('name_en');

        $EditProvince = $this->api->EditProvince($name_fa, $id ,$name_en);
//        return $EditProvince ;
        if ($EditProvince['Header']['Status'] == 0 ){
            $ProvinceList = Cache::get('ProvinceList' . session('UserInfo')['user_id']);
            $Index = array_filter($ProvinceList, function ($event) use ($id) {
                return $event['id'] == $id;
            });
            $Index = array_keys($Index) ;
            $ProvinceList[$Index[0]]["province_name"] = $name_fa ;
            $ProvinceList[$Index[0]]["english_name"] = $name_en ;
            Cache::forget('ProvinceList' . session('UserInfo')['user_id']);
            Cache::rememberForever('ProvinceList' . session('UserInfo')['user_id'], function() use ($ProvinceList){
                return $ProvinceList;
            });

            return redirect()->back()->with('success' , ' استان مورد نظر با موفقیت ویرایش گردید . ');
        }else
            return redirect()->back()->with('error' , ' خطا در اعمال تغییرات ! ');
    }

    public function CityList($id){
        $CityList = $this->api->CityList($id);
        return view('cityMg' , ['citys' => $CityList['ContentData'] , 'ProvinceId' => $id]);
    }
    public function AddCity(Request $request , $id){
        $city = $request->get('city') ;
        $city_english_name = $request->get('city_english_name') ;
        $province_id = $id ;
        $CityList = $this->api->AddCity($city, $city_english_name, $province_id);
        if($CityList['Header']['Status'] == 0){
            return redirect()->back()->with('success' , ' شهر مورد نظر با موفقیت ایجاد گردید . ');
        }
        else
            return redirect()->back()->with('error' , ' خطا در ایجاد شهر ! ');
    }
    public function EditCity(Request $request , $id){
        $city = $request->get('city') ;
        $city_english_name = $request->get('city_english_name') ;
        $city_id = $id ;
        $CityList = $this->api->EditCity($city_id, $city, $city_english_name);
        if($CityList['Header']['Status'] == 0){
            return redirect()->back()->with('success' , ' شهر مورد نظر با موفقیت ویرایش گردید . ');
        }
        else
            return redirect()->back()->with('error' , ' خطا در ویرایش شهر ! ');
    }
}
