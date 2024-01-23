<?php

namespace App\Http\Controllers;

use App\Http\Requests\FactorRequest;
use App\Models\Factor;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FactorController extends Controller
{
    public function filter(Request $request)
    {
        $products = Product::all();
        if (auth()->user()->role == 'admin') {
            $factors = Factor::with('order')->get();
        } else {
            $factors = auth()->user()->orders;
        }
        if ($request->filterOrderId)
            $factors = $factors->where('order.id', $request->filterOrderId);
        if ($request->filterOrderTotalPriceMin && $request->filterOrderTotalPriceMax)
            $factors = $factors->whereBetween('total_pay', [$request->filterOrderTotalPriceMin, $request->filterOrderTotalPriceMax]);
        $arr = [];
        if ($request->filterUserName) {
            foreach ($factors as $factor) {
                if ($factor->order->user->user_name == $request->filterUserName)
                    $arr[] = $factor->id;
            }
            $factors = Factor::find($arr);
        }
        return view('factors.factorsData', ['products' => $products, 'factors' => $factors]);
    }

    public function ordercreate(Order $order)
    {
        return view('factors.createFactor', ['order' => $order]);
    }

    public function create()
    {
        $orders = Order::where('status', 'enable')->get();
        return view('factors.addFactor', ['orders' => $orders]);
    }

    public function store(FactorRequest $request)
    {

        $order = Order::find($request->order_id);
        $order->update([
            'status' => 'disable'
        ]);
        Factor::create([
            'title' => $request->title,
            'type' => $request->type,
            'description' => $request->description,
            'order_id' => $request->order_id,
            'total_pay' => ($request->type == 'رسمی') ? (1.09 * $order->total_price) : ($order->total_price),
//            'created_at'=>Carbon::now(),
        ]);
        if (auth()->user()->role == 'admin')
            return redirect()->route('factors.index');
        if(auth()->user()->role == 'seller' || auth()->user()->role == 'customer')
            return redirect()->route('orders.index');
    }

    public function index()
    {
        $factors = Factor::all();
//        dd($factors);
        $products = Product::all();
        return view('factors.factorsData', ['factors' => $factors, 'products' => $products]);
    }

    public function destroy(Factor $factor)
    {
        $factor->delete();
        return back();
    }

    public function edit(Factor $factor)
    {
        return view('factors.editFactorMenue', ['factor' => $factor]);
    }

    public function update(FactorRequest $request, Factor $factor)
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
            'title' => $request->title,
            'type' => $request->type,
            'total_pay' => ($request->type == 'رسمی') ? (1.09 * $factor->order->total_price) : ($factor->order->total_price),
            'description' => $request->description,
        ]);

        return redirect()->route('factors.index');
    }

    public function trashed()
    {
        $trash_factors = Factor::onlyTrashed()->get();
        return view('factors.trashedFactor', compact('trash_factors'));
    }

    public function recovery($id)
    {
        Factor::onlyTrashed()->find($id)->restore();
        return back();
    }


}
