<?php

namespace App\Jobs;

use App\Api\Api;
use App\UserJob;
use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Excel;

class ReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user_name;
    protected $session_id;
    protected $search_headers;

    protected $location_id;
    protected $key;
    protected $values;
    protected $status_codeArray;
    protected $service_id;
    protected $operator_id;
    protected $sale_type_id;
    protected $sell_type_id;
    protected $voucher_type_id;
    protected $date;
    protected $province_id;
    protected $city_id;
    protected $project_id;

    protected $job_date;
    /**
     * Create a new job instance.
     * @param $user
     * @return void
     */
    public function __construct($user_name,$session_id,$search_headers,$location_id, $key, $values, $status_codeArray, $service_id, $operator_id, $sale_type_id, $sell_type_id, $voucher_type_id, $date, $province_id, $city_id , $project_id)
    {
        $this->session_id=$session_id;
        $this->user_name=$user_name;
        $this->search_headers=$search_headers;
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

        $verta = new Verta(Carbon::now('Asia/Tehran')->timestamp);
        $this->job_date = $verta->format('Y/n/j H:i');

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $job_id = $this->job->getJobId();
        $user_job = UserJob::create([
            'job_id' => $job_id,
            'user_name' => $this->user_name,
            'date' => $this->job_date,
            'search_headers' => json_encode($this->search_headers),
            'session_id' => $this->session_id,
            'current_page' => -1,
            'total_pages' => -1,
            'finished' => false,
        ]);

        $user_job->save();

        $api = new Api('job');
        $api->set_session_id($this->session_id);
        $data = $api->GetTransaction(1,$this->location_id, $this->key, $this->values, $this->status_codeArray,
            $this->service_id, $this->operator_id, $this->sell_type_id, $this->sale_type_id, $this->voucher_type_id,
            $this->date, $this->province_id, $this->city_id , $this->project_id,'','');

        $total_page = (int)$data['ContentData']["total_pages"] ;
        UserJob::where('job_id',$job_id)->update(['total_pages'=>$total_page]);

        $row = 'نام مکان'
            .','.'نام جاذبه	'
            .','.'شماره بلیت'
            .','.'RRN'
            .','.'نوع بلیت'
            .','.'نوع پرداخت'
            .','.'وضعیت پرداخت'
            .','.'تعداد'
            .','.'زمان تراکنش'
            .','.'جمع کل (ریال)';
        Storage::append("{$this->user_name}_{$job_id}.csv",$row);


        for ($i = 1 ; $i <= $total_page  ;$i++ )
        {
            $this->session_id = UserJob::where('job_id',$job_id)->first()->session_id;
            $api->set_session_id($this->session_id);

            $this->session_id = UserJob::where('job_id',$job_id)->first()->session_id;
            $api->set_session_id($this->session_id);

            $res = $api->GetTransaction($i,$this->location_id, $this->key, $this->values,
                $this->status_codeArray, $this->service_id, $this->operator_id, $this->sale_type_id,
                $this->sell_type_id, $this->voucher_type_id, $this->date, $this->province_id, $this->city_id ,
                $this->project_id,'','');
            if ($res['Header']['MessageCode']==141){

                // user logged in again wait for new session to store in db
                sleep(60);

                $this->session_id = UserJob::where('job_id',$job_id)->first()->session_id;
                $api->set_session_id($this->session_id);
                $res = $api->GetTransaction($i,$this->location_id, $this->key, $this->values,
                    $this->status_codeArray, $this->service_id, $this->operator_id, $this->sale_type_id,
                    $this->sell_type_id, $this->voucher_type_id, $this->date, $this->province_id, $this->city_id ,
                    $this->project_id,'','');

            }

            foreach ($res['ContentData']['log'] as $log){
                $row = $log['location_name']
                    .','.$log['service_name']
                    .','.$log['voucher_number']
                    .','.$log['RRN']
                    .','.$log['voucher_type_name']
                    .','.$log['sale_type_name']
                    .','.$this->procedure_name($log['procedure_status'])
                    .','.$log['ticket_number']
                    .','.$log['get_voucher_date_jalali']
                    .','.$log['amount'];

                Storage::append("{$this->user_name}_{$job_id}.csv",$row);
            }

//            Storage::put("{$this->user_name}_{$job_id}_{$i}.txt",json_encode($res));


            UserJob::where('job_id',$job_id)->update(['current_page'=>$i]);
        }

        UserJob::where('job_id',$job_id)->update(['finished'=>true]);




    }

    private function procedure_name($status){
        switch ($status){
            case 10:
            case 1:
                return 'استفاده نشده';

            case 11:
            case 5:
                return 'استفاده شده';

            case 3:
                return 'حذف شده';

            default:
                return '';
        }
    }
}
