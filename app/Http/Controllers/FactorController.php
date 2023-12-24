<?php

namespace App\Http\Controllers;

use App\Http\Requests\FactorRequest;
use App\Models\Factor;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FactorController extends Controller
{
    public function create()
    {
        $orders=Order::where('status','enable')->get();
        return view('factors.addFactor',['orders'=>$orders]);
    }

    public function store(FactorRequest $request)
    {
        $order=Order::find($request->order_id);
        $order->update([
            'status'=>'disable'
        ]);
        Factor::create([
            'title'=>$request->title,
            'type'=>$request->type,
            'description'=>$request->description,
            'order_id'=>$request->order_id,
            'total_pay'=>($request->type == 'رسمی') ? ( 1.09 * $order->total_price) : ($order->total_price),
//            'created_at'=>Carbon::now(),
        ]);
        return redirect()->route('factors.index');
    }

    public function index()
    {
        $factors=Factor::all();
        return view('factors.factorsData',['factors'=>$factors]);
    }

    public function destroy(Factor $factor)
    {
        $factor->delete();
        return back();
    }

    public function edit(Factor $factor)
    {
        return view('factors.editFactorMenue',['factor'=>$factor]);
    }

    public function update(FactorRequest $request,Factor $factor)
    {
//        if ($request->old('type') != $request->type)
//        {
//            if($request->type == 'رسمی')
//            {dd('gggg');
//                $total_pay=1.09 * $factor->total_pay;}
//            else
//                $total_pay=$factor->order->total_price;
//        }
//        else
//        {
//            $total_pay=$factor->total_pay;
//        }
        $factor->update([
            'title'=>$request->title,
            'type'=>$request->type,
            'total_pay'=>($request->type == 'رسمی') ?(1.09 * $factor->order->total_price) : ($factor->order->total_price),
            'description'=>$request->description,
        ]);

        return redirect()->route('factors.index');
    }

    public function trashed()
    {
        $trash_factors=Factor::onlyTrashed()->get();
        return view('factors.trashedFactor',compact('trash_factors'));
    }

    public function recovery(Factor $factor)
    {
        dd('hh');
        $factor->update([
           'deleted_at'=>NULL
        ]);
        return back();
    }
}
