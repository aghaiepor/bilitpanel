<?php

namespace App\Http\Controllers;

use App\Api\Api;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    var $Api = null ;
    public function __construct()
    {
        $this->Api = new Api();
    }

    public function index()
    {

        $loctionLidt = Cache::get('LocationList');
        return view('alerts' , ['Locations'=>$loctionLidt]);
    }

    public function getAlert(Request $request)
    {
        $Location_id = $request->get('Location_id');
        $AlertDetail = $this->Api->GetLocationAlerts($Location_id);
        return $AlertDetail['ContentData'];
    }
    public function DeleteAlert(Request $request , $id)
    {
        $DeleteAlert = $this->Api->DeleteAlert($id);
        if ($DeleteAlert['Header']['Status'] == 0)
            return redirect()->back()->with('success' , ' اعلان با موفقیت حذف شد . ');
        else
            return redirect()->back()->with('error' , ' خطا در حذف اعلان ! ');
    }
    public function EditAlert(Request $request , $id)
    {
        $title = $request->get('title');
        $start = $request->get('start');
        $end = $request->get('end');
        $description = $request->get('description');
        $importance = $request->get('importance');
        if ($start !='')
            $start = Carbon::instance(Verta::parse($this->fa2en($start).':00')->DateTime())->format('Y-m-d H:i') ;
        if ($end !='')
            $end = Carbon::instance(Verta::parse($this->fa2en($end).':00')->DateTime())->format('Y-m-d H:i');
        $EditAlert = $this->Api->EditAlert($id, $title, $start, $end, $description, $importance);

        if ($EditAlert['Header']['Status'] == 0)
            return redirect()->back()->with('success' , ' تغییرات با موفقیت اعمال گردید . ');
        else
            return redirect()->back()->with('error' , ' خطا در اعمال تفییرات ! ');
    }
    public function AddAlert(Request $request )
    {
        $location_id = $request->get('location_id');
        $title = $request->get('title');
        $start = $request->get('start');
        $end = $request->get('end');
        $description = $request->get('description');
        $importance = $request->get('importance');

        if ($start !='')
            $start = Carbon::instance(Verta::parse($this->fa2en($start).':00')->DateTime())->format('Y-m-d H:i') ;
        if ($end !='')
            $end = Carbon::instance(Verta::parse($this->fa2en($end).':00')->DateTime())->format('Y-m-d H:i');

        $AddAlert = $this->Api->AddAlert( $location_id, $title, $start, $end, $description, $importance);
        if ($AddAlert['Header']['Status'] == 0)
            return redirect()->back()->with('success' , ' اعلان با موفقیت ساخته شد . ');
        else
            return redirect()->back()->with('error' , ' خطا در ایجاد اعلان ! ');
    }

    private function fa2en($number){
        return strtr($number, array('۰'=>'0', '۱'=>'1', '۲'=>'2', '۳'=>'3', '۴'=>'4', '۵'=>'5', '۶'=>'6', '۷'=>'7', '۸'=>'8', '۹'=>'9', '٠'=>'0', '١'=>'1', '٢'=>'2', '٣'=>'3', '٤'=>'4', '٥'=>'5', '٦'=>'6', '٧'=>'7', '٨'=>'8', '٩'=>'9'));
    }
}
