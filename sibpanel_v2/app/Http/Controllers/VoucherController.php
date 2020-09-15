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
//        return  $CancelVoucher ;
       if ($CancelVoucher['Header']['Status'] == 0){
            return redirect()->back()->with('success' , 'تغییرات اعمال گردید');
        }
       elseif($CancelVoucher['Header']['MessageCode'] == 72)
       {
           return redirect()->back()->with('error' , 'بلیط مورد نظر وجود ندارد . ');
       }
        else
            return redirect()->back()->with('error' , 'خطا در اعمال تغییرات! ');
    }

    public function AddVoucherType(Request $request)
    {
        $name_fa = $request->get("name_fa");
        $name_en = $request->get("name_en");
        $language = $request->get("language");
        $is_free = $request->get("is_free");
        $min_count = (empty($request->get("min_count")) ? 0 : $request->get("min_count") );
        $max_count = $request->get("max_count");

        $AddVoucherType  = $this->api->AddVoucherType($name_fa, $name_en, $language, $is_free, $min_count, $max_count);
//        return  $AddVoucherType ;
        if ($AddVoucherType['Header']['Status'] == 0)
        {
            return redirect()->back()->with('success' , 'نوع بلیط ایجاد گردید');
        }
        else
            return redirect()->back()->with('error' , 'خطا در اعمال تغییرات! ');
    }
    public function EditVoucherType(Request $request , $id)
    {
        $name_fa = $request->get("name_fa");
        $name_en = $request->get("name_en");
         $language = $request->get("language");
        $is_free = (int)$request->get("is_free");
        $min_count = (empty($request->get("min_count")) ? 0 : $request->get("min_count") );
        $max_count = $request->get("max_count");
        $AddVoucherType  = $this->api->EditVoucherType($id ,$name_fa, $name_en, $language, $is_free, $min_count, $max_count) ;
//        return  $is_free ;
//        return  $AddVoucherType ;
        if ($AddVoucherType['Header']['Status'] == 0)
        {
            return redirect()->back()->with('success' , ' تغییرات اعمال گردید. ');
        }
        else
            return redirect()->back()->with('error' , 'خطا در اعمال تغییرات! ');
    }

    // ---------- VoucherText ----------------

    public function GetVoucherText()
    {
        $GetVoucherText = Cache::get("GetVoucherText");
        return view('voucherText' , ['voucherTexts' => $GetVoucherText]);
//        return $GetVoucherText ;
    }
    public function AddVoucherText(Request $request)
    {
        $top_text = $request->get("top_text");
        $english_top_text = $request->get("english_top_text");
        $bottom_text = $request->get("bottom_text");
        $english_bottom_text = $request->get("english_bottom_text");
        $AddVoucherText  = $this->api->AddVoucherText($top_text, $english_top_text, $bottom_text, $english_bottom_text);
//        return  $AddVoucherType ;
        if ($AddVoucherText['Header']['Status'] == 0)
        {
            return redirect()->back()->with('success' , 'نوع بلیط ایجاد گردید');
        }
        else
            return redirect()->back()->with('error' , 'خطا در اعمال تغییرات! ');
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
            return redirect()->back()->with('success' , 'نوع بلیط ایجاد گردید');
        }
        else
            return redirect()->back()->with('error' , 'خطا در اعمال تغییرات! ');
    }
    public function DeleteVoucherText(Request $request , $id)
    {
        $id = (int) $id;
        $DelVoucherText  = $this->api->DeleteVoucherText($id);
//        return  $DelVoucherText ;
        if ($DelVoucherText['Header']['Status'] == 0)
        {
            return redirect()->back()->with('success' , 'متن بلیط حذف گردید');
        }
        else
            return redirect()->back()->with('error' , 'خطا در حذف بلیت ! ');
    }


}
