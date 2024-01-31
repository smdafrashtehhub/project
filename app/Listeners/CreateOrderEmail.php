<?php

namespace App\Listeners;

use App\Events\CreateOrder;
use App\Mail\OrderMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class CreateOrderEmail
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
    public function handle(CreateOrder $event): void
    {
        $users=array_unique($event->order->products->pluck('user_id')->toArray());
        foreach (User::find($users) as $user)
        {
            $MailData=[
                'title'=>$user->first_name,
                'body'=>'email seller event'
            ];
            if(auth('api')->user()->email != $user->email)
                Mail::to($user->email)->send(new OrderMail($MailData));
        }
        $MailData=[
            'title'=>auth('api')->user()->first_name,
            'body'=>'email customer event'
        ];
        Mail::to(auth('api')->user()->email)->send(new OrderMail($MailData));

    }
}
