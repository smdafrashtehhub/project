<?php

namespace App\Listeners;

use App\Events\SendSmsRegisterEvent;
use App\Http\Controllers\Api\SmsController;
use App\Jobs\SendCodConfirmationJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendSmsRegisterListener
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
    public function handle(SendSmsRegisterEvent $event): void
    {
        $sms=new SmsController($event->user);
        $sms->sendCodeConfirmation();
    }
}
