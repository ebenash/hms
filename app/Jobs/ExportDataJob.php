<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Madnest\Madzipper\Madzipper;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\Notification;
use App\Notifications\BulkExportNotification;
use App\Notifications\BulkExportFailedNotification;

class ExportDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $customname;
    protected $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data,$customname,$user)
    {
        //
        $this->data = (is_array($data) ? $data : $data->get()->toArray());
        $this->customname = $customname;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $zipper = new Madzipper;
        $filename = $this->customname ? $this->customname.'_'.time() : 'frog-data-export_'.time();
        $zipper->make(storage_path('app/public/exports/'.$filename.'.zip'))->folder($this->customname ? $this->customname : 'frog-data-export');
        $i = 1;
        $deletables = array();
        if(count($this->data) > 0){
            foreach(array_chunk($this->data,50000) as $chunk) {
                $file = (new FastExcel($chunk))->export(storage_path('app/public/exports/'.$filename.'_'.$i.'.xlsx'));
                $zipper->add($file);
                array_push($deletables,$filename.'_'.$i.'.xlsx');
                $i++;
            }

            $zipper->close();

            foreach ($deletables as $file) {
                unlink(storage_path('app/public/exports/'.$file));
            }

            $data = base64_encode(file_get_contents(storage_path('app/public/exports/'.$filename.'.zip')));

            $postdata = array('exportdata'=>$data,'fileextension'=>'zip','ismsid'=>$filename,'username'=>'frogexport');

            unlink(storage_path('app/public/exports/'.$filename.'.zip'));

            $url = null;

            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => "http://45.79.28.35:2381/export",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($postdata),
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
            ),
            ));
            //dd($curl);
            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            $response = json_decode($response, true);
            // dump($response);
            if(!$err){
                if($response['status'] == 200){
                    $url = $response['downloadlink'];
                }
            }
            if($url){
                Notification::send($this->user, new BulkExportNotification($this->user,$url));
            }else{
                Notification::send($this->user, new BulkExportFailedNotification($this->user));
            }
        }
    }
}
