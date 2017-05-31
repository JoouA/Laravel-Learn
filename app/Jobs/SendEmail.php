<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($eamil)
    {
        $this->$eamil = $eamil;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       /* Mail::send('测试邮件啦',function($message){
            $message->to($this->eamil);
        });*/
        echo "666666";
        Log::info('已发送邮件-'.$this->email);
    }
}
