<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Factor;
use App\Models\Order;
use Illuminate\Http\Request;

class FactorController extends Controller
{
    //---------------------------------------- index -----------------------------------------
    public function index()
    {
        return response()->json([
            'status' => true,
            'message' => Factor::all(),
        ]);
    }

    //---------------------------------------- create -----------------------------------------
    public function create(Request $request)
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
        ]);
        return response()->json([
            'status' => true,
            'message' => 'فاکتور با موفقیت ساخته شد',
        ]);
    }

    //---------------------------------------- destroy -----------------------------------------
    public function destroy(Factor $factor)
    {
        $factor->delete();
        return response()->json([
            'status' => true,
            'message' => 'فاکتور با موفقیت حذف شد',
        ]);
    }

    //---------------------------------------- update -----------------------------------------
    public function update(Request $request, Factor $factor)
    {
        $factor->update([
            'title' => $request->title,
            'type' => $request->type,
            'total_pay' => ($request->type == 'رسمی') ? (1.09 * $factor->order->total_price) : ($factor->order->total_price),
            'description' => $request->description,
        ]);
        return response()->json([
            'status' => true,
            'message' => 'فاکتور با موفقیت آبدیت شد',
        ]);
    }

    //---------------------------------------- filter -----------------------------------------
    public function filter(Request $request)
    {
        if (auth('api')->user()->role == 'admin') {
            $factors = Factor::with('order')->get();
        } else {
            $factors = auth('api')->user()->orders;
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
        return response()->json([
            'status' => true,
            'message' => $factors,
        ]);
    }

}
