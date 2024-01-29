<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\OrderMail;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendEmail extends Controller
{
    public Order $order;
     function __construct(Order $order)
     {
         $this->order=clone $order;
     }

    public function sendemail()
    {
        $users=array_unique($this->order->products->pluck('user_id')->toArray());
        foreach (User::find($users) as $user)
        {
            $MailData=[
                'title'=>$user->first_name,
                'body'=>'email seller'
            ];
            if(auth('api')->user()->email != $user->email)
                Mail::to($user->email)->send(new OrderMail($MailData));
        }
        $MailData=[
            'title'=>auth('api')->user()->first_name,
            'body'=>'email customer'
        ];
        Mail::to(auth('api')->user()->email)->send(new OrderMail($MailData));

    }
}
