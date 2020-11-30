<?php

namespace App\Http\Controllers;

use App\Api\Api;
use Illuminate\Http\Request;

class projectManagerController extends Controller
{
    var $api ;
    public function __construct()
    {
        $this->api = new Api;
    }

    public function index(){
        $GetProjectList = $this->api->ProjectList();
//        return $GetProjectList ;
        return view("ProjectManager" ,["GetProjectList" => $GetProjectList["ContentData"]]) ;
    }

    public function AddProject(Request $request){
        $project_name = $request->get("project_name");
        $description = $request->get("description");
        if(is_null($description))
            $description = "";
        $AddProject = $this->api->AddProject($project_name , $description);
//        return $AddProject;
        if($AddProject["Header"]["Status"] == 0 )
            return redirect()->back()->with("success" , " پروژه جدید ساخته شد .  ");
        else if ($AddProject["Header"]["Message"] == "Permission Denied"){
            return redirect()->back()->with("error" , "منع دسترسی : شما مجاز به انجام چنین عملیاتی نیستید !   ");
        }
        else
            return redirect()->back()->with("error" , "خطا در ایجاد پروژه !   ");
    }
    public function EditProject(Request $request , $id=null){
        if(is_null($id))
            return redirect()->back();

        $project_id = $id;
        $project_name = $request->get("project_name");
        $description = $request->get("description");
        if(is_null($description))
            $description = "";

        $EditProject = $this->api->EditProject($project_id ,$project_name , $description);
//        return $EditProject;
        if($EditProject["Header"]["Status"] == 0 )
            return redirect()->back()->with("success" , " پروژه جدید ساخته شد .  ");
        else if ($EditProject["Header"]["Message"] == "Permission Denied"){
            return redirect()->back()->with("error" , "منع دسترسی : شما مجاز به انجام چنین عملیاتی نیستید !   ");
        }
        else
            return redirect()->back()->with("error" , "خطا در ایجاد پروژه !   ");
    }
    public function GetProject(Request $request){
        $project_id = $request->get("project_id");
        $GetProject = $this->api->GetProject($project_id , "ajax");

        return $GetProject["ContentData"] ;
    }
    public function AddProjectPicture(Request $request, $id){
        if(is_null($id))
            return redirect()->back();
        $project_id = (int)$id;
        if ($request->hasFile('service_image')){
            $image = base64_encode(file_get_contents($request->file('service_image')->path()));
//            return $image;
            $addPicture = $this->api->AddPicture($project_id , 0 , 0 , 0 , $image , "logo");
//            return $addPicture;
            if($addPicture['Header']['Status'] == 0){
                return redirect()->back()->with('success' , ' تصویر مورد نظر آپلود گردید . ');
//                return $addPicture['ContentData']['picture_id'];
            }
            else if($addPicture['Header']['Status'] == 2){
                return redirect()->back()->with('error' , ' تصویر موجود می باشد . برای تعویض تصویر ، تصویر قبلی را حذف نمایید .');
            }
            else
                return redirect()->back()->with('error' , 'خطا در آپلود تصویر !');
        }
        else
            return redirect()->back()->with('error' , 'فایلی جهت آپلود موجود نمی باشد .');

    }


}
