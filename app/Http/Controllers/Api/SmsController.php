<?php

namespace App\Http\Controllers\Api;

use App\Events\SendSmsRegisterEvent;
use App\Http\Controllers\Controller;
use App\Jobs\SendCodConfirmationJob;
use App\Jobs\SendSms;
use App\Models\Code;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Melipayamak\MelipayamakApi;

class SmsController extends Controller
{
    public User $user;

    public function __construct(User $user=NULL)
    {
        $this->user = clone $user;
    }

    //---------------------------------------> sendsms order <--------------------------------------
    public function sendsms()
    {
        if($this->user->role !='customer')
            $text = " شخصی از محصولات شما خرید کرد 'لغو=11'";
        else
            $text = " سفارش شما ثبت شد 'لغو=11'";

        $username = '09901950098';
        $password = 'QY5!H';
        $api = new MelipayamakApi($username, $password);
        $sms = $api->sms();
        $to = $this->user->phone_number;
        $from = '50002710050098';
//        $text = " تست وب سرویس ملی پیامک 'لغو=11'";
        $response = $sms->send($to, $from, $text);
    }

    //----------------------------------> sendCodeConfirmation <---------------------------------------
    public function
    sendCodeConfirmation()
    {
        $name=$this->user->first_name;
        $code=random_int(10000,99999);
        config(['globals.flag'=>$code]);
        Code::create([
            'code'=>$code,
            'user_id'=>$this->user->id,
        ]);
//        cookie('code',$code);
//        session()->put('code',$code);
//        $this->random_code=session()->get('code',$code);

//        dd($this->random_code);
//        Session::put('code',$code);
//        dd(cookie('code',$code));
//        Session::save();
        $username = '09901950098';
        $password = 'QY5!H';
        $api = new MelipayamakApi($username, $password);
        $sms = $api->sms();
        $to = $this->user->phone_number;
        $from = '50002710050098';
        $text = "$name عزیز کد تایید شما $code  میباشید.
         لغو11";
        $response = $sms->send($to, $from, $text);
//        SendCodConfirmationJob::dispatch()->onQueue('smsconfirmation')->delay(now()->addSeconds(10));

    }


    //----------------------------------> codeConfirmation <---------------------------------------
    public function codeConfirmation(Request $request,User $user)
    {
//        dd($request->cookie('code'));
//        dd($this->random_code);

        if($request->code == $user->code->code)
        {
            $user->update([
               'code_confirmation'=> 'confirmation'
            ]);
            Code::where('code',$request->code)->delete();
            return response()->json([
               'status'=>true,
               'message'=>".$user->first_name عزیز ثبت نام شما تکمیل شد"
            ]);
        }
        return response()->json([
            'status'=>false,
            'message'=>"$user->first_nameعزیز کد وارد شده اشتباه میباشد "
        ]);
    }

    //-----------------------------------------> sendCode <------------------------------------------------
    public function sendCode(User $user)
    {
        $user->code->delete();
        SendSmsRegisterEvent::dispatch($user);
        return response()->json([
           'status'=>true,
           'message'=>"$user->first_name عزیز کد تاییدیه شما ".config('globals.flag')." میباشد"
        ]);
    }


}
