<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\DemoMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendemail()
    {
        $mailData=[
            'title'=>'mail from smd',
            'body'=>'smtp'
        ];
//        dd((new DemoMail(($mailData)))->mailData);
        Mail::to('smd.afrashteh1@gmail.com')->send(new DemoMail($mailData));
        return response()->json([
            'status'=> true,
            'message'=>'ایمیل با موفقیت ارسال شد'
        ]);
    }
}
