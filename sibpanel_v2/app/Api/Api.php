<?php


namespace App\Api;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use App\UserJob;

class Api
{
//    protected $url = "http://213.207.198.106:8021/";
    protected $url  ; // for test use this address
//    protected $url =  "http://192.168.171.2:5002/";
//    protected $url = "http://185.129.170.10:5001/";
    private $CONTENT_TYPE = 'application/json';
    private $AUTHORIZATION = 'basic aG9zc2VpbjpAZG1pbjEyMw==';
    public $session_id;
    protected $session_from_job;
    protected $from;

    function __construct($from='') {
        $this->url = env('API_ADDRESS') ;
        $this->from = $from ;
    }

    public function set_session_id($session_from_job=''){
        $this->session_from_job = $session_from_job;
    }

    public function login($username, $password, $debug = false)
    {
        $client = new Client();
        $result = $client->post($this->url.'Login',[
            'headers'=>[
                'Content-Type'=>$this->CONTENT_TYPE,
                'Authorization'=>$this->AUTHORIZATION
            ],'json'=>[
                'username'=>$username,
                'password'=>$password
            ]
        ]);
        $response = json_decode($result->getBody(),true);

//        Log::debug($response);
        if ($response['Header']['Status'] == 0 && $response['ContentData']['panel_access']){
            session(['SessionId' => $response['ContentData']['SessionId']]);
            session(['UserInfo' => $response['ContentData']] );
            session(['user_name' => $username] );
            //update session for jobs
            UserJob::where('user_name',$username)
                ->where('finished',false)
                ->update(['session_id'=>$response['ContentData']['SessionId']]);
        }
        return $response;
    }
    public function GetLocation($location_id){
        $data = [
            'location_id' => $location_id,
        ];
        $client = new Client();
        $result = $client->post($this->url . 'GetLocation' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        ) ;
        $response = json_decode($result->getBody(),true);
        $this->checkError($response);
        return $response;
    }
    public function LocationList($id = 1 , $type=null){
        $data = ['project_id'=>$id];
        $client = new Client();
        $result = $client->post($this->url . 'LocationList' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);
        $this->checkError($response , $type);
        Log::info("LocationList : " , $data);
        return $response;
    }
    public function ServiceList($id = null , $type = null){
        $data=null;
        if ( $id != null )
            $data = ['location_id'=>$id];

        $client = new Client();
//        $result = $client->post($this->url . 'ServiceListNew' ,[
        $result = $client->post($this->url . 'ServiceList' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
         ) ;
        $response = json_decode($result->getBody(),true);

        $this->checkError($response , $type);
        return $response;
    }
    public function AddServiceTime($service_id , $start , $end , $sex , $total_capacity  , $voucher_infos ,  $type = null){
        $data= [
            "service_id" => $service_id,
            "start" => $start,
            "end" => $end,
            "sex" => $sex,
            "total_capacity" => $total_capacity,
            "voucher_infos" => $voucher_infos
        ];
        Log::info("AddServiceTime => " , $data);
//        Log::info(gettype($voucher_infos) );
        $client = new Client();
        $result = $client->post($this->url . 'AddServiceTime' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
         ) ;
        $response = json_decode($result->getBody(),true);

        $this->checkError($response , $type);
        return $response;
    }

    public function AllLocationServiceList($id = null){
        $data=null;
        if ( $id != null )
            $data = ['location_id'=>$id];

        $client = new Client();
        $result = $client->post($this->url . 'ServiceList' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        ) ;
        $response = json_decode($result->getBody(),true);

        $this->checkError($response);

        $response = $response['ContentData'];
        $locations = [];
        foreach ($response as $item){
            $id = $item['location_id'];
            $name = $item['location_name'];
            $services = $item;
            if (!array_key_exists($id,$locations))
                $locations[$id] = ['id'=>$id,'name'=>$name,'services'=>[$services]];
            else
                array_push($locations[$id]['services'],$services);

        }


        return array_values($locations);
    }
    public function AddLocation($location_name, $province_id, $text_id, $city_id, $location_english_name, $location_address, $location_english_address,$mandatory_entrance ,$longitude , $latitude , $project_id){
        $data = [
            "location_name"=> $location_name,
            "location_english_name"=> $location_english_name,
            "location_address"=> $location_address,
            "location_english_address"=> $location_english_address,
            "province_id"=> $province_id,
            "city_id"=> $city_id,
            "text_id"=> $text_id,
            "mandatory_entrance"=> $mandatory_entrance,
            "latitude" => $latitude ,
            "longitude" => $longitude ,
            "project_id" => $project_id ,
        ];
        $client = new Client();
        $result = $client->post($this->url . 'AddLocation' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
         );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response);
        return $response;
    }
    public function EditLocation($location_name, $text_id, $location_english_name, $location_english_address, $location_address, $location_id,$mandatory_entrance , $longitude , $latitude , $introduction,$description){
        $data = [
            "location_name"=> $location_name,
            "location_english_name"=> $location_english_name,
            "location_address"=> $location_address,
            "location_english_address"=> $location_english_address,
            "location_id"=> $location_id,
            "text_id"=> $text_id,
            "mandatory_entrance"=> $mandatory_entrance,
            "longitude"=> $longitude,
            "latitude"=> $latitude,
            "introduction"=> $introduction,
            "description"=> $description,
        ];
        $client = new Client();
        $result = $client->post($this->url . 'EditLocation' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response);
        return $response;


    }
    public function DeleteLocation($location_id){
        $data = [
            "location_id"=> $location_id,
        ];
        $client = new Client();
        $result = $client->post($this->url . 'DeleteLocation' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response);
        return $response;

    }
    public function LocationActivation($location_id, $is_active){
        $data = [
            "location_id"=> $location_id,
            "location_activation"=> $is_active,
        ];
        $client = new Client();
        $result = $client->post($this->url . 'LocationActivation' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response , "ajax");
        return $response;

    }
    public function PosPrintActivation($location_id, $is_active){
        $data = [
            "location_id"=> $location_id,
            "pos_print_activation"=> $is_active,
        ];
        $client = new Client();
        $result = $client->post($this->url . 'PosPrintActivation' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response , "ajax");
        return $response;

    }
    public function QRActivation($location_id, $is_active){
        $data = [
            "location_id"=> $location_id,
            "QR_activation"=> $is_active,
        ];
        $client = new Client();
        $result = $client->post($this->url . 'QRActivation' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response , "ajax");
        return $response;

    }
    public function GetService($service_id){
        $data = [
            "service_id" => $service_id
        ];
        $client = new Client();
        $result = $client->post($this->url . 'GetService' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response);
        return $response;

    }
    public function VoucherInfoList($service_id){
        $data = [
            "service_id" => $service_id
        ];
        $client = new Client();
        $result = $client->post($this->url . 'VoucherInfoList' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response);
        return $response;

    }

    public function GetVoucherInfo($voucher_info_id){
        $data = [
            "voucher_info_id" => $voucher_info_id
        ];
        $client = new Client();
        $result = $client->post($this->url . 'GetVoucherInfo' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response);
        return $response;
    }
    public function AddService($service_name, $capacity, $service_english_name, $model_id, $description, $location_id , $TypeOfServiceSale){
        $data = [
            "service_name"=> $service_name,
            "service_english_name" => $service_english_name,
            "model_id" => $model_id,
            "description"=> $description,
            "location_id" => $location_id,
            "capacity" => $capacity,
            "type_of_service_sale" => $TypeOfServiceSale,
        ];
        $client = new Client();
        $result = $client->post($this->url . 'AddService' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response);
        return $response;

    }
    public function EditService($service_name, $capacity, $service_english_name, $model_id,$service_id, $description, $location_id, $normal_sale , $TypeOfServiceSale){
        $data = [
            "service_name"=> $service_name,
            "service_english_name" => $service_english_name,
            "model_id" => $model_id,
            "service_id" => $service_id,
            "description"=> $description,
            "location_id" => $location_id,
            "capacity" => $capacity,
            "normal_sale" => $normal_sale ,
            "type_of_service_sale" => $TypeOfServiceSale,
        ];
        Log::info("EditService : " , $data);
        $client = new Client();
        $result = $client->post($this->url . 'EditService' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response);
        return $response;

    }
    public function DeleteService($service_id){
        $data = [
            "service_id" => $service_id,
        ];
        Log::info("DeleteService => " , $data);
        $client = new Client();
        $result = $client->post($this->url . 'DeleteService' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response);
        return $response;

    }
    public function ServiceActivation($service_id, $service_activation){
        $data = [
            "service_id" => $service_id,
            "service_activation"=> $service_activation,
        ];
        Log::info("erviceActivation" , $data);
        $client = new Client();
        $result = $client->post($this->url . 'ServiceActivation' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response , "ajax");
        return $response;

    }
    public function AddVoucherInfo($service_id, $amount, $voucher_type_id, $capacity, $location_id , $max_discount_percentage , $validity_period , $expiration_date){
        $data = [
            "service_id" => $service_id,
            "amount"=> $amount,
            "voucher_type_id"=> $voucher_type_id,
            "capacity"=> $capacity,
            "location_id"=> $location_id,
            "max_discount_percentage"=> $max_discount_percentage,
            "validity_period"=> $validity_period,
            "expiration_date"=> $expiration_date,
        ];

        $client = new Client();
        $result = $client->post($this->url . 'AddVoucherInfo' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response);
        return $response;

    }
    public function EditVoucherInfo($voucher_info_id, $voucher_type_id, $service_id, $amount, $capacity, $location_id , $max_discount_percentage , $validity_period , $expiration_date){
        $data = [
            "service_id" => $service_id,
            "amount"=> $amount,
            "voucher_type_id"=> $voucher_type_id,
            "voucher_info_id"=> $voucher_info_id,
            "capacity"=> $capacity,
            "location_id"=> $location_id,
            "max_discount_percentage"=> $max_discount_percentage,
            "validity_period"=> $validity_period,
            "expiration_date"=> $expiration_date,
        ];
        Log::info("EditVoucherInfo " , $data);
        $client = new Client();
        $result = $client->post($this->url . 'EditVoucherInfo' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response);
        return $response;

    }
    public function AddClearingAccount($location_id, $project_name, $owner_name, $shaba, $payment_id){
        $data = [
            "location_id" => $location_id,
            "project_name"=> $project_name,
            "owner_name"=> $owner_name,
            "shaba" => $shaba,
            "payment_id" => $payment_id
        ];
        $client = new Client();
        $result = $client->post($this->url . 'AddClearingAccount' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response);
        return $response;
    }

    // ******************* citizen panel *******************
    public  function GetPicture($location_id){
        $data = null;
        $client = new Client();
        $result = $client->get($this->url . 'GetPicture/'.$location_id ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
//        $response = json_decode($result->getBody(),true);
//        $this->checkError($response);
//        return $result->getBody()->getContents();
        return $result = [
            'type' => $result->getHeader("Content-Type")[0] ,
            'content' => $result->getBody()->getContents() ,
        ];
    }
    public  function GetPicturesInfo($location_id,$service_id,$project_id,$voucher_info_id){
        $data = [
            "project_id"=> $project_id,
            "location_id"=> $location_id,
            "service_id"=> $service_id,
            "voucher_info_id"=> $voucher_info_id
        ];
        $client = new Client();
        $result = $client->Post($this->url . 'GetPicturesInfo' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response);
        return $response;
    }
    public  function GetEvent($location_id){
        $data = [
            "location_id" => $location_id ,
        ];
        $client = new Client();
        $result = $client->Post($this->url . 'GetEvent',[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);
        $this->checkError($response);
        return $response;
    }
    public  function AddPicture($project_id , $location_id , $service_id , $voucher_info_id , $pic_str , $tag){
        $data = [
            "project_id" => $project_id,
            "location_id" => $location_id,
            "service_id" => $service_id,
            "voucher_info_id" => $voucher_info_id,
            "pic_str" => $pic_str ,
            "tag" => $tag ,
        ];
        $client = new Client();
        $result = $client->Post($this->url . 'AddPicture',[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);
        $this->checkError($response);
        return $response;
    }
    public  function DeletePicture($picture_id){
        $data = [
            "picture_id" => $picture_id,
        ];
        $client = new Client();
        $result = $client->Post($this->url . 'DeletePicture',[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);
        $this->checkError($response);
        return $response;
    }

    // ******************* CancelVoucher *******************
    public function CancelVoucher($voucher_number){
        $data = [
            "voucher_number" => $voucher_number,
        ];
        $client = new Client();
        $result = $client->post($this->url . 'CancelVoucher' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response);
        return $response;
    }

    // ******************* voucherTypeList *******************
    public function VoucherTypeList($type=null){
        $data = null ;
        $client = new Client();
        $result = $client->post($this->url . 'VoucherTypeList' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response , $type);
        return $response;
    }
    public function AddVoucherType($name_fa, $name_en, $language, $is_free, $min_count, $max_count){
        $data = [
            'voucher_type' =>$name_fa,
            'english_name' =>$name_en,
            'language' =>$language,
            'is_free' =>$is_free,
            'min_ticket_count' =>$min_count,
            'max_ticket_count' =>$max_count,
        ] ;
        $client = new Client();
        $result = $client->post($this->url . 'AddVoucherType' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);
        $this->checkError($response);
        return $response;
    }
    public function EditVoucherType($voucher_type_id,$name_fa, $name_en, $language, $is_free, $min_count, $max_count){
        $data = [
            'voucher_type_id' =>$voucher_type_id,
            'voucher_type' =>$name_fa,
            'english_name' =>$name_en,
            'language' =>$language,
            'is_free' =>$is_free,
            'min_ticket_count' =>$min_count,
            'max_ticket_count' =>$max_count,
        ] ;
//        return $data ;
        $client = new Client();
        $result = $client->post($this->url . 'EditVoucherType' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);
        $this->checkError($response);
        return $response;
    }

    // ******************* VoucherText *******************
    public function GetVoucherText($type=null){
        $data = null ;
        $client = new Client();
        $result = $client->post($this->url . 'GetVoucherText' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response , $type);
        return $response;
    }
    public function AddVoucherText($top_text, $english_top_text, $bottom_text, $english_bottom_text){
        $data = [
            'top_text'=> $top_text,
            'english_top_text'=> $english_top_text,
            'bottom_text'=> $bottom_text,
            'english_bottom_text'=> $english_bottom_text,
        ] ;
        $client = new Client();
        $result = $client->post($this->url . 'AddVoucherText' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response);
        return $response;
    }
    public function EditVoucherText($top_text, $text_id,  $english_top_text, $bottom_text, $english_bottom_text){
        $data = [
            'text_id' => $text_id ,
            'top_text'=> $top_text,
            'english_top_text'=> $english_top_text,
            'bottom_text'=> $bottom_text,
            'english_bottom_text'=> $english_bottom_text,
        ] ;
        $client = new Client();
        $result = $client->post($this->url . 'EditVoucherText' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response);
        return $response;
    }
    public function DeleteVoucherText($text_id){
        $data = [
            "text_id" => $text_id,
        ];
        $client = new Client();
        $result = $client->post($this->url . 'DeleteVoucherText' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);
        $this->checkError($response);
        return $response;
    }

    // ******************* UserManagement *******************
    public function GetSubUserList($ajax=null){
        $data = null ;
        $client = new Client();
        $result = $client->post($this->url . 'GetSubUserList' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response , $ajax);
        return $response;
    }
    public function AccountTypeList($ajax=null){
        $data = null ;
        $client = new Client();
        $result = $client->post($this->url . 'AccountTypeList' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response , $ajax);
        return $response;
    }
    public function RegisterUser($name, $last_name, $cellphone, $national_id, $username, $password,
                                 $email, $account_type_id, $otp_verify, $subset_users, $panel_access, $pre_sell, $imei, $user_id=""){
        if (is_null($email) ||  $email == ""){
            $data = [
                'name'=> $name,
                'last_name'=> $last_name,
                'cellphone'=> $cellphone,
                'national_id'=> $national_id,
                'username'=> $username,
                'password'=> $password,
                'account_type_id'=> $account_type_id,
                'otp_verify'=> $otp_verify,
                'subset_users'=> $subset_users,
                'presell'=> $pre_sell,
                'imei'=> $imei,
                'sib_user_id'=> $user_id
            ];
        }
        else {
            $data = [
                'name'=> $name,
                'last_name'=> $last_name,
                'cellphone'=> $cellphone,
                'national_id'=> $national_id,
                'username'=> $username,
                'password'=> $password,
                'email'=> $email,
                'account_type_id'=> $account_type_id,
                'otp_verify'=> $otp_verify,
                'subset_users'=> $subset_users,
                'presell'=> $pre_sell,
                'imei'=> $imei,
                'sib_user_id'=> $user_id
            ];
        }
        Log::info("user data => " , $data);
        $client = new Client();
        $result = $client->post($this->url . 'RegisterUser' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response);
        return $response;
    }
    public function UserActivation($sib_user_id , $activation){
        $data= [
            'sib_user_id' =>  (int)$sib_user_id,
            'activation' => $activation ,
        ];
        Log::info(json_encode(gettype($data["activation"])));
        Log::info(json_encode($data["activation"]));
        $client = new Client();
        $result = $client->post($this->url . 'UserActivation' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response , "ajax");
        return $response;
    }
    public function GetUserInfo($user_id , $type=null){
        $data= [
            'sib_user_id' => $user_id ,
        ];
        $client = new Client();
        $result = $client->post($this->url . 'GetUserInfo' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response , $type);
        return $response;
    }
    public function GetSibUser($user_id , $type=null){
        $data= [
            'sib_user_id' => $user_id ,
        ];
        $client = new Client();
        $result = $client->post($this->url . 'GetSibUser' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response , $type);
        return $response;
    }
    public function GetInfo($type=null){
        $data=null;
        $client = new Client();
        $result = $client->post($this->url . 'GetInfo' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response , $type);
        return $response;
    }
    public function GetUserPermission($sib_user_id=""){
        $data=null;
        $data = [
            'sib_user_id'=> $sib_user_id
        ];
        $client = new Client();
        $result = $client->post($this->url . 'GetUserPermission' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response);
        return $response;
    }
    public function AssignPermission($province_id, $city_id, $location_id, $service_id, $voucher_type_id, $project_id, $sale_type_id, $terminal_type_id, $sib_user_id , $switch_web_service_id){
        $data= [
            'province_id' => $province_id,
            'city_id' => $city_id,
            'location_id' => $location_id,
            "voucher_type_id" => $voucher_type_id,
            'service_id' => $service_id,
            'project_id' => $project_id,
            'sale_type_id' => $sale_type_id,
            'sib_user_id' => $sib_user_id,
            'terminal_type_id' => $terminal_type_id,
            'switch_web_service_ids' => $switch_web_service_id
        ];
        $client = new Client();
        $result = $client->post($this->url . 'AssignPermission' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response , "ajax");
        return $response;
    }
    public function GetSwitchWebServiceList(){
        $data = null ;
        $client = new Client();
        $result = $client->post($this->url . 'GetSwitchWebServiceList' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response);
        return $response;
    }

    // ******************* Get Report Lists *******************
    public function SellModelList($type=null){
        $data=null;
        $client = new Client();
        $result = $client->post($this->url . 'SellModelList' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);
        $this->checkError($response , $type);
        return $response;
    }
    public function ProvinceList($type=null , $project_id=null){
        if(is_null($project_id))
            $data=null;
        else
        {
            $data= [
                'project_id' => $project_id
            ];
        }
        $client = new Client();
        $result = $client->post($this->url . 'ProvinceList' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response , $type);
        return $response;
    }
    public function CityList($province_id  , $type=null , $project_id=1){
        $data = [
            'province_id' => $province_id ,
            'project_id' => $project_id ,
        ];
        $client = new Client();
        $result = $client->post($this->url . 'CityList' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);
        $this->checkError($response , $type);
        return $response;
    }
    public function location_list($province_id , $city_id , $type=null , $project_id=1){
        $data = [
            "province_id" => $province_id,
            "city_id" => $city_id ,
            "project_id" => $project_id
        ];
        $client = new Client();
        Log::info("location data => " , $data);
        $result = $client->post($this->url . 'LocationList' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);
        Log::info("CityList => " , $this->getHeader());
        $this->checkError($response , $type);
        return $response;
    }
    public function SellerUserList($type=null){
        $data = null ;
        $client = new Client();
        $result = $client->post($this->url . 'SellerUserList' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response , $type);
        return $response;
    }
    public function SaleTypeList($type=null){
        $data = null ;
        $client = new Client();
        $result = $client->post($this->url . 'SaleTypeList' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);
        $this->checkError($response , $type);
        return $response;
    }
    public function GetStat($location_id, $key, $values, $status_code, $service_id, $operator_id, $sale_type_id, $sell_type_id, $voucher_type_id, $date, $province_id, $city_id , $project_id){
        $conditions = [
            'location_id'=> $location_id,
            'procedure_status' => $status_code,
            'service_id'=> $service_id,
            'operator_id'=> $operator_id,
            'voucher_type_id'=> $voucher_type_id,
            'sale_type_id'=> $sale_type_id,
            'sell_model_id'=> $sell_type_id,
            'date'=> $date,
            'province_id'=> $province_id,
            'city_id'=> $city_id,
            'project_id'=> $project_id,
        ];
        $data = [
            "conditions" => $conditions,
            "key"=> $key,
            "values"=> $values,
        ] ;
        Log::info('req get stat : ',$data);

        $client = new Client();
        $result = $client->post($this->url . 'GetStat' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response);
        return $response;
    }
    public function GetTransaction($page , $location_id, $key, $values, $status_code, $service_id,
     $operator_id, $sale_type_id, $sell_type_id, $voucher_type_id, $date, $province_id, $city_id , $project_id,$rrn , $voucher_number){
        $conditions = [
            'location_id'=> $location_id,
            'procedure_status' =>$status_code,
            'service_id'=> $service_id,
            'operator_id'=> $operator_id,
            'voucher_type_id'=> $voucher_type_id,
            'sale_type_id'=> $sale_type_id,
            'sell_model_id'=> $sell_type_id,
            'date'=> $date,
            'province_id'=> $province_id,
            'city_id'=> $city_id,
            'project_id'=> $project_id,
            'rrn'=> $rrn ,
            'voucher_number'=> $voucher_number,
        ];
        $data = [
            "page" => $page ,
             "conditions" => $conditions,
            "key"=> $key,
            "values"=> $values,
        ] ;
        Log::info('req get stat : ',$data);

        $client = new Client();
        $result = $client->post($this->url . 'GetTransaction' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response);
        return $response;
    }

    // ******************* Province and City *******************
    public function AddProvince($name_fa, $name_en, $projects){
        $data = [
            'province'=> $name_fa,
            'province_english_name'=> $name_en,
            'project_id' => $projects,
        ] ;
        $client = new Client();
        $result = $client->post($this->url . 'AddProvince' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response);
        return $response;
    }
    public function EditProvince($name_fa, $province_id, $name_en, $projects){
        $data = [
            'province_id' => $province_id,
            'province'=> $name_fa,
            'province_english_name'=> $name_en,
            'project_id' => $projects,
        ] ;
        $client = new Client();
        $result = $client->post($this->url . 'EditProvince' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response);
        return $response;
    }
    public function AddCity($city, $city_english_name, $provinceId){
        $data = [
            'city' => $city,
            'city_english_name'=> $city_english_name,
            'province_id'=> $provinceId,
        ] ;
        $client = new Client();
        $result = $client->post($this->url . 'AddCity' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response);
        return $response;
    }
    public function EditCity($city_id, $city, $city_english_name){
        $data = [
            'city_id'=> $city_id,
            'city' => $city,
            'city_english_name'=> $city_english_name,
        ];
        $client = new Client();
        $result = $client->post($this->url . 'EditCity' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response);
        return $response;
    }

    // ******************* terminals *******************
    public function TerminalTypeList(){
        $data=null;
        $client = new Client();
        $result = $client->post($this->url . 'TerminalTypeList' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response);
        return $response;
    }
    public function TerminalLocationList($location_id , $type=null)
    {
        $data = [
            "location_id" =>  $location_id
        ];
        $client = new Client();
        $result = $client->post($this->url . 'TerminalLocationList' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);
        $this->checkError($response , $type);
        return $response;
    }
    public function TerminalInfo($terminal_id, $terminal_number, $serial_number, $terminal_name, $terminal_address){
        $data = [
            "terminal_id" => $terminal_id,
            "terminal_number" => $terminal_number,
            "serial_number" => $serial_number,
            "terminal_name" =>  $terminal_name,
            "terminal_address" => $terminal_address,
        ];
        $client = new Client();
        $result = $client->post($this->url . 'AddClearingAccount' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response);
        return $response;
    }
    public function AssignTerminal($terminal_id, $imei, $domain, $serial_number, $type_id, $location_id, $project_name)
    {
        $terminal_serial_type = [
            "terminal_id" => $terminal_id,
            "imei" => $imei,
            "domain" => $domain,
            "serial_number" => $serial_number,
            "type_id" => $type_id
        ];
        $data = [
            "terminal_serial_type" => $terminal_serial_type,
            "project_name" => $project_name,
            "location_id" => $location_id
        ];
        $client = new Client();
        $result = $client->post($this->url . 'AssignTerminal', [
                'headers' => $this->getHeader(),
                'json' => $data
            ]
        );
        $response = json_decode($result->getBody(), true);

        $this->checkError($response);
        return $response;
    }
    public function EditAssignTerminal($location_terminal_id, $terminal_id, $serial_number, $type_id)
    {
        $data = [
            "location_terminal_id"=> $location_terminal_id,
            "terminal_id"=> $terminal_id,
            "type_id"=> $type_id,
            "serial_number"=> $serial_number
        ];
        $client = new Client();
        $result = $client->post($this->url . 'EditAssignTerminal', [
                'headers' => $this->getHeader(),
                'json' => $data
            ]
        );
        $response = json_decode($result->getBody(), true);

        $this->checkError($response);
        return $response;
    }

    // ******************* Sans *******************
    public function GetTimeGroup()
    {
        $data=null;
        $client = new Client();
        $result = $client->post($this->url . 'GetTimeGroup' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response);
        return $response;
    }

    /*public function EditServiceTime($data)
    {
        $client = new Client();
        $result = $client->post($this->url . 'UpsertDeleteTimeGroup' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response);
        return $response;
    }*/

    public function DeleteServiceTime($service_times_id , $ajax=null)
    {
        $data = [
           "service_time_id" => $service_times_id ,
        ];
        $client = new Client();
        $result = $client->post($this->url . 'DeleteServiceTime' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        Log::info("DeleteService : " , $data);
        $response = json_decode($result->getBody(),true);

        $this->checkError($response , $ajax);
        return $response;
    }

    public function EditServiceTime($service_times_id , $start , $end , $sex , $total_capacity , $voucher_infos, $ajax=null)
    {
            /*
            "total_capacity":100,
            "amount":23,
            "voucher_type_id":3,
            "max_discount_percentage":50
            */
        $data = [
            "service_time_id" => $service_times_id,
            "start" => $start,
            "end" => $end,
            "sex" => $sex,
            "total_capacity" => $total_capacity,
	        "voucher_infos" => $voucher_infos
        ];
        $client = new Client();
        $result = $client->post($this->url . 'EditServiceTime' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        Log::info("EditServiceTime : " , $data);
        $response = json_decode($result->getBody(),true);
        $this->checkError($response , $ajax);
        return $response;
    }

    public function GetServiceListFromServicetime($show_based_on_province=false , $ajax=null)
    {
        if(is_null($show_based_on_province))
            $show_based_on_province = false ;

        $data =[
            "show_based_on_province" => $show_based_on_province
        ];

        $client = new Client();
        $result = $client->post($this->url . 'GetServiceListFromServicetime' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);
        $this->checkError($response , $ajax);
        return $response;
    }

    public function ImportExportServiceTimes($import_to_service_id , $export_from_service_id ,$start_export , $end_export , $days_extend ,  $ajax=null)
    {
        $data = [
        "export_from_service_id" => $export_from_service_id,
        "start_export" => $start_export ,
        "end_export" => $end_export,
        "import_to_service_id" => $import_to_service_id,
        "days_extend" =>  $days_extend
        ];
        $client = new Client();
        $result = $client->post($this->url . 'ImportExportServiceTimes' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        Log::info("ImportExportServiceTimes => " , $data);
        $response = json_decode($result->getBody(),true);
        $this->checkError($response , $ajax);
        return $response;
    }

    public function AddTimeTemplate($times_template){
        $data = [
            'times_template' => $times_template
        ];
        $client = new Client();
        $result = $client->post($this->url . 'AddTimeTemplate' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response);
        return $response;
    }
    public function AddTimeGroup($name,$time_template_ids){
        $data = [
            'name' => $name,
            'time_template_ids' => $time_template_ids
        ];
        $client = new Client();
        $result = $client->post($this->url . 'AddTimeGroup' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response);
        return $response;
    }
    public function EditTimeGroup($time_group_id,$name,$time_template_ids){
        $data = [
            'time_group_id' => $time_group_id,
            'name' => $name,
            'time_template_ids' => $time_template_ids
        ];
        $client = new Client();
        $result = $client->post($this->url . 'EditTimeGroup' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response);
        return $response;
    }
    public function GetServiceTimeList($service_id , $ajax=null)
    {
        $data = [
            "service_id" => $service_id ,
        ];
        $client = new Client();
        $result = $client->post($this->url . 'GetServiceTimeList' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response , $ajax) ;
        return $response;
    }
    public function GetServiceTimes($service_time_ids , $ajax=null)
    {
        $data = [
            "service_time_ids" => $service_time_ids ,
        ];
        Log::info("GetServiceTimes => " , $data);
        $client = new Client();
        $result = $client->post($this->url . 'GetServiceTimes' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);
        $this->checkError($response , $ajax) ;
        return $response;
    }
    public function ServiceTimeActivation($service_time_id , $activation , $ajax=null)
    {
        $data = [
            "service_time_id" => (int)$service_time_id ,
            "activation" => $activation ,
        ];
        Log::info("ServiceTimeActivation => " , $data);
        $client = new Client();
        $result = $client->post($this->url . 'ServiceTimeActivation' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);
        $this->checkError($response , $ajax) ;
        return $response;
    }


    // ******************* Alerts *******************
    public function GetLocationAlerts($location_id)
    {
        $data = [
        "location_id" => $location_id
        ];
        $client = new Client();
        $result = $client->post($this->url . 'GetLocationAlerts' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response , "ajax");
        return $response;
    }
    public function AddAlert($location_id, $title, $start, $end, $description, $importance)
    {
        $data = [
            "location_id" => (int)$location_id,
            "title"=> $title,
            "start"=> $start,
            "end"=> $end,
            "description" => $description,
            "importance"=> $importance
        ];
        Log::info("Alert data => " , $data);
        $client = new Client();
        $result = $client->post($this->url . 'AddAlert' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response);
        return $response;
    }
    public function DeleteAlert($alert_id)
    {
        $data = [
            "alert_id" => $alert_id,
        ];
        $client = new Client();
        $result = $client->DELETE($this->url . 'AlertDetail' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response);
        return $response;
    }
    public function EditAlert($alert_id, $title, $start, $end, $description, $importance)
    {
        $data = [
            "alert_id" => $alert_id,
        ];
        $data = [
            "alert_id" => $alert_id,
            "title" => $title,
            "start" => $start,
            "end" => $end,
            "description" => $description,
            "importance" => $importance
        ] ;
        $client = new Client();
        $result = $client->put($this->url . 'EditAlert' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response);
        return $response;
    }
    // ******************** VerifyOtp ****************
    public function VerifyOtp($otp){
        $data = [
            'otp' => $otp,
        ];
        Log::info("otp =>" , $data);
        $client = new Client();
        $result = $client->post($this->url . 'VerifyOtp' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response);
        return $response;
    }
    public function GenerateOtp($user_id){
        $data = [
            "user_id" => $user_id
        ];
        Log::info("GenerateOtp =>" , $data);
        $client = new Client();
        $result = $client->post($this->url . 'GenerateOtp' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);
        $this->checkError($response);
        return $response;
    }

    // ******************** Project Manager ****************
    public function ProjectList($type=null)
    {
        $data = null ;
        $client = new Client();
        $result = $client->post($this->url . 'ProjectList' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response , $type);
        return $response;
    }
    public function AddProject($project_name ,$description ,  $type=null)
    {
        $data = [
            "project_name" => $project_name,
            "description" => $description
        ] ;
        $client = new Client();
        $result = $client->post($this->url . 'AddProject' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response , $type);
        return $response;
    }
    public function EditProject($project_id , $project_name ,$description ,  $type=null)
    {
        $data = [
            "project_id" => $project_id,
            "project_name" => $project_name,
            "description" => $description
        ] ;
        $client = new Client();
        $result = $client->post($this->url . 'EditProject' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response , $type);
        return $response;
    }
    public function GetProject($project_id , $type=null)
    {
        $data = [
            "project_id" => $project_id,
        ] ;
        $client = new Client();
        $result = $client->post($this->url . 'GetProject' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);
        $this->checkError($response , $type);
        return $response;
    }
    public function AddProjectSetting($project_id  , $type_of_service_sale , $type=null)
    {
        $data = [
            "project_id" => $project_id,
            "type_of_service_sale" => $type_of_service_sale
        ];
        $client = new Client();
        $result = $client->post($this->url . 'AddProjectSetting' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);
        $this->checkError($response , $type);
        return $response;
    }

    public function EditProjectSetting($project_id  , $type_of_service_sale , $type=null)
    {
        $data = [
            "project_id" => $project_id,
            "type_of_service_sale" => $type_of_service_sale
        ];
        $client = new Client();
        $result = $client->post($this->url . 'EditProjectSetting' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response , $type);
        return $response;
    }
    public function GetProjectSetting($project_id  , $type=null)
    {
        $data = [
            "project_id" => $project_id
        ];
        $client = new Client();
        $result = $client->post($this->url . 'GetProjectSetting' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response , $type);
        return $response;
    }

    // ******************** Discount Manager ****************
    public function AddDiscountPolicy($project_id ,$location_id ,$service_id , $voucher_info_id ,$sib_user_id ,$description ,$percentage ,$activation_date=null , $expiration_date=null ,$type=null)
    {
        $data = [
               "project_id" =>$project_id ,
                "location_id"=> $location_id ,
                "service_id"=>$service_id ,
                "voucher_info_id"=> $voucher_info_id ,
                "sib_user_id"=> $sib_user_id ,
                "description"=> $description ,
                "percentage"=> $percentage ,
                "activation_date"=> $activation_date ,
                "expiration_date"=> $expiration_date ,
        ];
        Log::info("AddDiscountPolicy => " , $data);
        $client = new Client();
        $result = $client->post($this->url . 'AddDiscountPolicy' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response , $type);
        return $response;
    }
    public function GetDiscountPolicyList($project_id ,$location_id ,$service_id , $voucher_info_id ,$sib_user_id , $type=null)
    {
        $data = [
               "project_id" =>$project_id,
                "location_id"=> $location_id,
                "service_id"=>$service_id,
                "voucher_info_id"=> $voucher_info_id,
                "sib_user_id"=> $sib_user_id,
        ];
//        Log::info("GetDiscountPolicyList => " , $data);
        $client = new Client();
        $result = $client->post($this->url . 'GetDiscountPolicyList' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response , $type);
        return $response;
    }
    public function EditDiscountPolicy($discount_policy_id ,$active ,$description ,$percentage ,$activation_date ,  $expiration_date, $type=null)
    {
        $data = [
            "discount_policy_id" => $discount_policy_id,
            "active" => $active,
            "description" => $description,
            "percentage" => $percentage ,
            "activation_date"=> $activation_date ,
            "expiration_date"=> $expiration_date ,
        ];
        Log::info("EditDiscountPolicy => " , $data);
        $client = new Client();
        $result = $client->post($this->url . 'EditDiscountPolicy' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response , $type);
        return $response;
    }
    public function GetDiscountPolicy($discount_policy_id , $type=null)
    {
        $data = [
            "discount_policy_id" =>$discount_policy_id,
        ];
        Log::info("GetDiscountPolicy => " , $data);
        $client = new Client();
        $result = $client->post($this->url . 'GetDiscountPolicy' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);
        $this->checkError($response , $type);
        return $response;
    }
    public function DiscountPolicyActivation($discount_policy_id , $activation ,  $type=null)
    {
        $data = [
            "discount_policy_id" =>$discount_policy_id,
            "activation" => $activation
        ];
        $client = new Client();
        $result = $client->post($this->url . 'DiscountPolicyActivation' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);
        $this->checkError($response , "ajax");
        return $response;
    }

    // ******************** Presell ****************
    public function GetAccountProvince($province_id , $type=null){
        $data = [
            'province_id' => $province_id,
        ];
        $client = new Client();
        $result = $client->post($this->url . 'GetAccountProvince' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response , "ajax");
        return $response;
    }
    public function LocationAccountActivation($locationaccount_id , $account_id  ,$activation){
        $data = [
            "location_id" => $locationaccount_id,
            "account_id" => $account_id,
            "activation" => $activation
        ];
        $client = new Client();
        Log::info("location account actiavion : " , $data);
        $result = $client->post($this->url . 'LocationAccountActivation' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response , "ajax");
        return $response;
    }
    public function AccountActivation($account_id  ,$activation){
        $data = [
            "account_id" => $account_id,
            "activation" => $activation
        ];
        Log::info("AccountActivation => "  , $data);
        $client = new Client();
        $result = $client->post($this->url . 'LocationAccountActivation' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response , "ajax");
        return $response;
    }
    public function SetAccountSetting($account_id ,$average_balance_use , $red_percentage ,$orange_percentage , $yellow_percentage , $green_percentage){
        $data = [
            "account_id" =>  $account_id,
            "average_balance_use" => $average_balance_use,
            "red_percentage" => $red_percentage,
            "orange_percentage" =>$orange_percentage,
            "yellow_percentage" => $yellow_percentage,
            "green_percentage" => $green_percentage
        ];
        $client = new Client();
        $result = $client->post($this->url . 'SetAccountSetting' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response);
        return $response;
    }
    public function AccountList($project_id, $account_ids){
        $data = [
            "project_id" => 1,
	        "account_ids" => [0]
        ];
        $client = new Client();
        $result = $client->post('swtest.atishahr.net:1663/AccountList2' ,[
                'headers'=>[
                    "Authorization" => "Basic YWRtaW46MjI4MjE4ZmFqYQ==" ,
                    "Content-Type" => "application/json"
                ],
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response);
        return $response;
    }
    public function GetChargeTransaction($page ,$account_id, $trace_number , $reference_number="" , $date="", $ajax=null , $factor=null){
        if($date == "" && is_null($factor))
        {

            $now = Carbon::now('Asia/Tehran')->format('Y/m/d') ;
            $date = [Carbon::parse($now." 00:00:00")->timestamp,Carbon::parse($now." 23:59:59")->timestamp] ;
        }

        $data = [
                "page" => $page,
                "conditions" =>
                    [
                        "account_id"  => [$account_id],
                        "trace_number"=> $trace_number,
//                        "date" => ["",""]
                        "reference_number" => $reference_number,
                        "date" => $date ,
                    ]
            ];
        Log::info("GetChargeTransaction Log : " , $data);
        $client = new Client();
        $result = $client->post($this->url . 'GetChargeTransaction' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response , $ajax);
        return $response;
    }
    public function GetDechargeTransaction($page ,$account_id, $trace_number, $reference_number="" , $date="", $ajax=null , $factor=null){
        if($date == "" && is_null($factor))
        {
            $now = Carbon::now()->format('Y-m-d') ;
            $date = [Carbon::parse($now." 00:00:00")->timestamp,Carbon::parse($now." 23:59:59")->timestamp] ;
        }

        $data = [
            "page" => $page,
            "conditions" =>
                [
                    "account_id"  => [$account_id],
                    "trace_number"=> $trace_number,
                    "reference_number" => $reference_number,
                    "date" => $date ,
                ]
        ];
        $client = new Client();
        Log::info("GetDechargeTransaction Log : " , $data);
        $result = $client->post($this->url . 'GetDechargeTransaction' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);
        $this->checkError($response  , $ajax);
        return $response;
    }
    public function ChargeAccount($charge_amount ,$account_id, $project_name , $reference_number , $source_bank , $payment_datetime , $pic_str , $description, $tag=""){
        $data = [
            "charge_amount" => $charge_amount,
            "account_id"=>$account_id,
            "project_name"=> $project_name , //"TourismSystem"
            "reference_number"=> $reference_number , //"18411525685",
            "source_bank"=>$source_bank , //"خیابان معالی آباد",
            "payment_datetime" =>$payment_datetime,
            "pic_str" => $pic_str,
            "description" => $description,
            "tag" => $tag
        ];
        Log::info( "Charge data : " ,  $data);
        $client = new Client();
        $result = $client->post($this->url . 'ChargeAccount' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response);
        return $response;
    }
    public function GetChargeDocument($picture_id){
        $data = [
            "picture_id" => $picture_id,
        ];
        $client = new Client();
        $result = $client->post($this->url . 'GetChargeDocument' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
//        $response = json_decode($result->getBody(),true);
//        $this->checkError($response);
        return $result = [
            'type' => $result->getHeader("Content-Type")[0] ,
            'content' => $result->getBody()->getContents() ,
        ];
//        return $response;
    }

    // ******************** Accounts ****************
    public function AddAccount($account_name ,$shaba ,$payment_id , $project_id , $account_id , $pan , $pin_block , $type=null){
        $data = [
            "account_name" => "esi_test",
            "shaba" => "123456789123456798",
            "payment_id" => "987654321987654321",
            "project_id" => 1,
            "account_id" => 0,
            "pan" => "",
            "pin_block" => ""
        ];
        $client = new Client();
        $result = $client->post($this->url . 'GetAccountProvince' ,[
                'headers'=>$this->getHeader(),
                'json'=>$data
            ]
        );
        $response = json_decode($result->getBody(),true);

        $this->checkError($response , "ajax");
        return $response;
    }
    // ******************* Charts *******************
    public function statsChart(){
        $client = new Client();
        $result = $client->get("http://185.129.169.64:5020/stats.json");
        $response = json_decode($result->getBody(),true);
//        $this->checkError($response);
        return $response;
    }

    // ******************* Methods *******************
    private function getHeader(){
        $this->session_id = (session()->has('SessionId')) ?  session('SessionId') : null ;
        if ($this->session_id == null)
            $this->session_id = $this->session_from_job;
        $header = [
            'Content-Type'=>$this->CONTENT_TYPE,
            'Authorization'=>$this->AUTHORIZATION,
            'Session-Id' => $this->session_id
        ];
        return $header;
    }
    public function checkError($response , $type=null)
    {

        if($this->from != 'job' && $type == "ajax"){
            if($response['Header']['MessageCode'] == 141){
                \App::abort(400);
            }
            Log::info("requset was ajax ");
        }


        if ($this->from != 'job' && $response['Header']['MessageCode'] == 141) {
            session()->forget('SessionId');
            session()->forget('UserInfo');
//            return Redirect::to('login')->with('message', 'your message');
            try {
                \App::abort(302, 'test', ['Location' => '/logout']);
            } catch (\Exception $exception) {
                $previousErrorHandler = set_exception_handler(function () {
                });
                restore_error_handler();
                call_user_func($previousErrorHandler, $exception);
                die;
            }
        }
    }
    function GetImageAddress($id)
    {
        $GetPicture = $this->GetPicture($id);
        $mime = $GetPicture['type'];
        $content = $GetPicture['content'];
        $base64   = base64_encode($content);
        return ('data:' . $mime . ';base64,' . $base64);
    }
    function GetDocumentAddress($id , $tag)
    {

        $GetPicture = $this->GetChargeDocument($id);
        Log::info("GetPicture : " ,$GetPicture );
        if($tag == "pdf"){
            $base64 =  base64_encode($GetPicture['content']);
            return ('data:application/pdf;base64,'. $base64);
        }

        Log::info("GetPicture : " ,$GetPicture );
        $mime = $GetPicture['type'];
        $content = $GetPicture['content'];
        $base64   = base64_encode($content);
        return ('data:' . $mime . ';base64,' . $base64);
    }
    public function fa2en($number){
        return strtr($number, array('۰'=>'0', '۱'=>'1', '۲'=>'2', '۳'=>'3', '۴'=>'4', '۵'=>'5', '۶'=>'6', '۷'=>'7', '۸'=>'8', '۹'=>'9', '٠'=>'0', '١'=>'1', '٢'=>'2', '٣'=>'3', '٤'=>'4', '٥'=>'5', '٦'=>'6', '٧'=>'7', '٨'=>'8', '٩'=>'9'));
    }
    function fa_number($number) {
        if(empty($number))
            return '۰';
        $en = array("0","1","2","3","4","5","6","7","8","9");
        $fa = array("۰","۱","۲","۳","۴","۵","۶","۷","۸","۹");
        return str_replace($en, $fa, $number);
    }

}
