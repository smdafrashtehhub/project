<?php

namespace App\Jobs;

use App\Http\Controllers\Api\SmsController;
use App\Models\Product;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Melipayamak\MelipayamakApi;

class SendSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public Product $product;
    public  $admin;
    public function __construct(Product $product, $admin)
    {
        $this->product=$product;
        $this->admin=$admin;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

            $username = '09901950098';
            $password = 'QY5!H';
            $api = new MelipayamakApi($username, $password);
            $sms = $api->sms();
            $to = $this->admin->phone_number;
            $from = '50002710050098';
            $text = $this->admin->first_name." عزیز یک محصول توسط ".$this->product->user->first_name."ثبت شد!";
            $response = $sms->send($to, $from, $text);

//        $username = '09901950098';
//        $password = 'QY5!H';
//        $api = new MelipayamakApi($username, $password);
//        $sms = $api->sms();
//        $to = '1233';
//        $from = '50002710050098';
//        $text = "د!";
//        $response = $sms->send($to, $from, $text);

//        $smsproduct=new SmsController();
//        $smsproduct->sendSmsProduct($this->product);
    }
}
