<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Sms;
use App\Archive;
use App\Cadry;

class myCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'myCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $token = Sms::find(1)->token;
        $cadry = Cadry::all();

        foreach($cadry as $item)
        {
            if($item->date_vacation->diffInDays() + 1 == 12 || $item->date_vacation->diffInDays() + 1 == 3) 
            { 
                $char = ['(', ')', ' ','-','+'];
                $replace = ['', '', '','',''];
                $x = "";
        
                $phone = str_replace($char, $replace, $item->phone);
                $text = "Xurmatli ".$item->fullname.". Siz ".date('d-m-Y', strtotime($item->date_vacation))." sanasigacha mexnat muxofazasi va texnika xavfsizligi bo'yicha bilim sinovida o'tishingiz zarur. Aks holda qonun talablari asosida ishdan chetlashtirilasiz. Shch-7 mexnat muxofazasi bo'limi!";
                $id = $item->id;
                
                $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://notify.eskiz.uz/api/message/sms/send-batch',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>"{ \"messages\":[ {\"user_sms_id\":\"$id\",\"to\": \"$phone\",\"text\": \"$text\"} ],\"from\":\"4546\",\"dispatch_id\":\"123\"}",
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer '.$token,
                    'Content-Type: application/json'
                ),
                ));
        
                $response = curl_exec($curl);
        
                $err = curl_error($curl);
                curl_close($curl);
        
                $json = json_decode($response, true);
        
                if($json['status'] == "success")
                {
                    $archive = new Archive();
                    $archive->user_id = $id;
                    $archive->text_message = $text;
                    $archive->status = 0;
                    $archive->save();
                }
                else
                {
                    
                    return redirect()->route('smstoken');
                }
            }
        }

        return 0;
    }
}
