<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
//use Mail;
use App\mail\DemoMail;
class MailController extends Controller
{
    public function index()
    {
        $mailData=[
            'title'=>'mail from smd',
            'body'=>'smtp'
        ];
        Mail::to('smd.afrashteh1@gmail.com')->send(new DemoMail($mailData));
    }
}
