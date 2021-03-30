<?php

namespace App\Http\Controllers;

use App\Api\Api;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    var $api = null ;

    public function __construct()
    {
        $this->api = new Api();
    }

    public function VoucherTypeList()
    {
        $VoucherTypeList = $this->api->VoucherTypeList();
        return view('voucherTypeList' , ['voucherTypeList' => $VoucherTypeList['ContentData']]);
//        return $VoucherTypeList ;
    }
    public function CancelVoucher(Request $request){
        $voucher_number = $request->get("voucher_number");
        $CancelVoucher  = $this->api->CancelVoucher($voucher_number);
        return  $CancelVoucher ;
       /*
        if ($CancelVoucher['Header']['Status'] == 0){
            return redirect()->back()->with('success' , 'تغییرات اعمال گردید');
        }
       elseif($CancelVoucher['Header']['MessageCode'] == 72)
       {
           return redirect()->back()->with('error' , 'بلیط مورد نظر وجود ندارد . ');
       }
        else
            return redirect()->back()->with('error' , 'خطا در اعمال تغییرات! ');
       */
    }

    public function AddVoucherType(Request $request)
    {
        $name_fa = $request->get("name_fa");
        $name_en = $request->get("name_en");
        $language = $request->get("language");
        $is_free = $request->get("is_free");
        $min_count = (empty($request->get("min_count")) ? "" : $request->get("min_count") );
        $max_count = $request->get("max_count");
        if(is_null($max_count))
            $max_count= "";

        $AddVoucherType  = $this->api->AddVoucherType($name_fa, $name_en, $language, $is_free, $min_count, $max_count);
//        return  $AddVoucherType ;
        if ($AddVoucherType['Header']['Status'] == 0)
        {
            return redirect()->back()->with('success' , 'نوع بلیت ایجاد گردید.');
        }
        else
            return redirect()->back()->with('error' , 'خطا در ایجاد نوع بلیت تغییرات! ');
    }
    public function EditVoucherType(Request $request , $id)
    {
        $name_fa = $request->get("name_fa");
        $name_en = $request->get("name_en");
         $language = $request->get("language");
        $is_free = (int)$request->get("is_free");
        $min_count = (empty($request->get("min_count")) ? 0 : $request->get("min_count") );
        $max_count = $request->get("max_count");
        if(is_null($max_count))
            $max_count = "";

        $AddVoucherType  = $this->api->EditVoucherType($id ,$name_fa, $name_en, $language, $is_free, $min_count, $max_count) ;
//        return  $is_free ;
//        return  $AddVoucherType ;
        if ($AddVoucherType['Header']['Status'] == 0)
        {
            return redirect()->back()->with('success' , ' نوع بلیت ویرایش گردید. ');
        }
        else
            return redirect()->back()->with('error' , 'خطا در اعمال تغییرات! ');
    }

    // ---------- VoucherText ----------------

    public function GetVoucherText()
    {
        $GetVoucherText = Cache::get("GetVoucherText" . session('UserInfo')['user_id']);
//        return $GetVoucherText ;
        return view('voucherText' , ['voucherTexts' => $GetVoucherText]);

    }
    public function AddVoucherText(Request $request)
    {

        $top_text = $request->get("top_text");
        $english_top_text = $request->get("english_top_text");
        $bottom_text = $request->get("bottom_text");
        $english_bottom_text = $request->get("english_bottom_text");
        $AddVoucherText  = $this->api->AddVoucherText($top_text, $english_top_text, $bottom_text, $english_bottom_text);
//        return  $AddVoucherText ;
        if ($AddVoucherText['Header']['Status'] == 0)
        {
            $data = [
                'id' => $AddVoucherText["ContentData"]["voucher_text_id"] ,
                'top_text'=> $top_text,
                'english_top_text'=> $english_top_text,
                'bottom_text'=> $bottom_text,
                'english_bottom_text'=> $english_bottom_text,
                'activation'=> true,
            ];
            $GetVoucherText = Cache::get('GetVoucherText' . session('UserInfo')['user_id']);
            array_push($GetVoucherText , $data);
            Cache::forget('GetVoucherText' . session('UserInfo')['user_id']);
            Cache::rememberForever('GetVoucherText' . session('UserInfo')['user_id'], function() use ($GetVoucherText){
                return $GetVoucherText;
            });
            return redirect()->back()->with('success' , 'متن بلیت ایجاد گردید.');
        }
        else
            return redirect()->back()->with('error' , 'خطا در ایجاد متن بلیت! ');
    }
    public function EditVoucherText(Request $request , $id)
    {
        $top_text = $request->get("top_text");
        $english_top_text = $request->get("english_top_text");
        $bottom_text = $request->get("bottom_text");
        $english_bottom_text = $request->get("english_bottom_text");
        $EditVoucherText  = $this->api->EditVoucherText($top_text,$id ,$english_top_text, $bottom_text, $english_bottom_text);
//        return  $AddVoucherType ;
        if ($EditVoucherText['Header']['Status'] == 0)
        {
            $GetVoucherText = Cache::get('GetVoucherText' . session('UserInfo')['user_id']);
            $index = array_filter($GetVoucherText, function ($event) use ($id) {
                return $event['id'] == $id ;
            });
            $index = array_keys($index) ;
            $GetVoucherText[$index[0]]["id"] = $top_text ;
            $GetVoucherText[$index[0]]["english_top_text"] = $english_top_text ;
            $GetVoucherText[$index[0]]["bottom_text"] = $bottom_text ;
            $GetVoucherText[$index[0]]["english_bottom_text"] = $english_bottom_text ;

            Cache::forget('GetVoucherText' . session('UserInfo')['user_id']);
            Cache::rememberForever('GetVoucherText' . session('UserInfo')['user_id'], function() use ($GetVoucherText){
                return $GetVoucherText;
            });

            Cache::forget('GetVoucherText' . session('UserInfo')['user_id']);
            $value = Cache::rememberForever('GetVoucherText' . session('UserInfo')['user_id'], function(){
                $GetInfo  = $this->api->GetVoucherText();
                return $GetInfo['ContentData'];
            });
            return redirect()->back()->with('success' , 'متن بلیت ویرایش گردید.');
        }
        else
            return redirect()->back()->with('error' , 'خطا در اعمال تغییرات متن بلیت ! ');
    }
    public function DeleteVoucherText(Request $request , $id)
    {
        $id = (int) $id;
        $DelVoucherText  = $this->api->DeleteVoucherText($id);
//        return  $DelVoucherText ;
        if ($DelVoucherText['Header']['Status'] == 0)
        {

            $GetVoucherText = Cache::get('GetVoucherText' . session('UserInfo')['user_id']) ;
            $Index = array_filter($GetVoucherText, function ($event) use ($id) {
                return $event['id'] == $id;
            });
            $Index = array_keys($Index) ;
            unset($GetVoucherText[$Index[0]]);

            Cache::forget('GetVoucherText' . session('UserInfo')['user_id']);
            Cache::rememberForever('GetVoucherText' . session('UserInfo')['user_id'], function() use ($GetVoucherText){
                return $GetVoucherText;
            });
            return redirect()->back()->with('success' , 'متن بلیت حذف گردید');
        }
        else
            return redirect()->back()->with('error' , 'خطا در حذف بلیت ! ');
    }


}
