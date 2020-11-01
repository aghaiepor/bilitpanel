<?php

namespace App\Jobs;

use App\Api\Api;
use App\Exports\UsersExport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class ExportToExel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $location_id;
    private $key;
    private $values;
    private $status_codeArray;
    private $service_id;
    private $operator_id;
    private $sale_type_id;
    private $sell_type_id;
    private $voucher_type_id;
    private $date;
    private $province_id;
    private $city_id;
    private $project_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($location_id, $key, $values, $status_codeArray, $service_id, $operator_id, $sale_type_id, $sell_type_id, $voucher_type_id, $date, $province_id, $city_id , $project_id)
    {
        //
        $this->location_id = $location_id;
        $this->key = $key;
        $this->values = $values;
        $this->status_codeArray = $status_codeArray;
        $this->service_id = $service_id;
        $this->operator_id = $operator_id;
        $this->sale_type_id = $sale_type_id;
        $this->sell_type_id = $sell_type_id;
        $this->voucher_type_id = $voucher_type_id;
        $this->date = $date;
        $this->province_id = $province_id;
        $this->city_id = $city_id;
        $this->project_id = $project_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $api = new Api();
        $test = [] ;
        $data = $api->GetTransaction(1,$this->location_id, $this->key, $this->values, $this->status_codeArray, $this->service_id, $this->operator_id, $this->sale_type_id, $this->sell_type_id, $this->voucher_type_id, $this->date, $this->province_id, $this->city_id , $this->project_id);
//        echo  "ok";
        $total_page = (int)$data['ContentData']["total_pages"] ;
//        echo $total_page;
//        $data = $data['ContentData']["log"] ;
//        return $data['ContentData']["log"] ;
        for ($i = 1 ; $i <= $total_page  ;$i++ )
        {
            $GetStat = $api->GetTransaction($i,$this->location_id, $this->key, $this->values, $this->status_codeArray, $this->service_id, $this->operator_id, $this->sale_type_id, $this->sell_type_id, $this->voucher_type_id, $this->date, $this->province_id, $this->city_id , $this->project_id);
            $test = array_merge($test,$GetStat['ContentData']["log"]);
        }
        return json_encode($test) ;
        return Excel::download(new UsersExport($test), 'tansacion.xlsx') ;;
//        return json_encode($test) ;
//        return "done";
//        return Excel::download(new UsersExport($test), 'tansacion.xlsx') ;
    }
}
