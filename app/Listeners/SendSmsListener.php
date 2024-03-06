<?php

namespace App\Listeners;

use App\Events\SendSmsEvent;
use App\Http\Controllers\Api\SmsController;
use App\Mail\OrderMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendSmsListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SendSmsEvent $event): void
    {
        $users=array_unique($event->order->products->pluck('user_id')->toArray());
        foreach (User::find($users) as $user)
        {

            if(auth('api')->user()->email != $user->email)
            {
                $sms=new SmsController($user);
                $sms->sendsms();
            }
        }
        $sms=new SmsController(auth('api')->user());
        $sms->sendsms();

    }
}
