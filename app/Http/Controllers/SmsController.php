<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Melipayamak\MelipayamakApi;
class SmsController extends Controller
{
    public function sendsms()
    {

        $username = '09901950098';
        $password = 'QY5!H';
        $api = new MelipayamakApi($username,$password);
        $sms = $api->sms();
        $to = '09901950098';
        $from = '50002710050098';
        $text = ' تست وب سرویس ملی پیامک لغو 11';
        $response = $sms->send($to,$from,$text);
        dd($response);
    }
}
