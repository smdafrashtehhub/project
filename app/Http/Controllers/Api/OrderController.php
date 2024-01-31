<?php

namespace App\Http\Controllers\Api;

use App\Events\CreateOrder;
use App\Http\Controllers\Controller;
use App\Mail\OrderMail;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use mysql_xdevapi\Collection;
use App\Http\Controllers\Api\SendEmail;

class OrderController extends Controller
{
    //------------------------------------------------- filter --------------------------------------------
    public function filter(Request $request)
    {
        if (auth('api')->user()->hasRole('admin'))
            $orders_filter = Order::with('user')->get();
        else
            $orders_filter = auth('api')->user()->orders;
//        dd($request->filterOrderName);
        if ($request->filterOrderName)
            $orders_filter = $orders_filter->where('title', $request->filterOrderName);
        if ($request->filterOrderCustomer)
            $orders_filter = $orders_filter->where('user.first_name', $request->filterOrderCustomer);
        if ($request->filterOrderPriceMin && $request->filterOrderPriceMax)
            $orders_filter = $orders_filter->whereBetween('total_price', [$request->filterOrderPriceMin, $request->filterOrderPriceMax]);
        return response()->json([
            'status' => true,
            'message' => $orders_filter,
        ]);
    }
    //------------------------------------------------- index --------------------------------------------
    public function index()
    {
        if (auth('api')->user()->hasRole('admin'))
            return response()->json([
                'status' => true,
                'message' => Order::all(),
            ]);
        else
            return response()->json([
                'status' => true,
                'message' => auth('api')->user()->orders,
            ]);
    }

    //------------------------------------------------- create --------------------------------------------

    public function create(Request $request)
    {

        if ($request->user_id == auth('api')->user()->id) {
            $total_price = 0;
            foreach ($request->products as $product) {
                $total_price += ($product['price']) * ($product['count']);
            }
            $order = Order::create([
                'user_id' => $request->user_id,
                'title' => $request->order_title,
                'total_price' => $total_price,
                'explanations' => $request->explanations,
            ]);
            foreach ($request->products as $product) {
                Product::find($product['id'])->orders()->attach($order, [
                    'count' => $product['count'],
                ]);
                Product::where('id', $product['id'])->update([
                    'inventory' => (Product::find($product['id'])->inventory) - ($product['count']),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }

//            $mail=new SendEmail($order);
//            $mail->sendemail();

//            event(new CreateOrder($order));
            CreateOrder::dispatch($order);
            return response()->json([
                'status' => true,
                'message' => 'سفارش با موفقیت ثبت شد'
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'شما نمیتوانید  برای این کاربر سفارش ایجاد کنید'
        ]);
    }

    //------------------------------------------------- destroy --------------------------------------------
    public function destroy(Order $order)
    {
        if (auth('api')->user()->hasRole('admin') || $order->user->id == auth('api')->user()->id) {
            $order->products()->detach();
            $order->factor()->delete();
            $order->update([
                'status' => 'disable'
            ]);
            $order->delete();
            return response()->json([
                'status' => true,
                'message' => 'سفارش با موفقیت حذف شد'
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'شما قادر به حذف این سفارش نیستید'
        ]);
    }

    //------------------------------------------------- update --------------------------------------------
    public function update(Request $request, Order $order)
    {
        if ($order->user->id == auth('api')->user()->id) {
            $total_price = 0;
            $order_products = DB::table('orders')
                ->join('order_product', 'order_product.order_id', '=', 'orders.id')
                ->where('orders.id', $order->id)
                ->get();
            foreach (Product::all() as $product) {
                if (in_array($product->id, collect($request->products)->pluck('id')->toArray())) {
                    $api_count = collect($request->products)->where('id', $product->id)->first()['count'];
                    $api_price = Product::find($product->id)->price;
                    $total_price += $api_count * $api_price;
                    if ($order_products->where('product_id', $product->id)->count())
                        $database_count = $order_products->where('product_id', $product->id)->first()->count;
                    else
                        $database_count = 0;
                } elseif ($order_products->where('product_id', $product->id)->count()) {
                    $api_count = 0;
                    $database_count = $order_products->where('product_id', $product->id)->first()->count;
                    $database_price = Product::find($product->id)->price;
                    $total_price += $database_count * $database_price;

                } else {
                    $database_count = $api_count = 0;
                }
                $newinventory = Product::find($product->id)->inventory + $database_count - $api_count;
                Product::find($product->id)->update([
                    'inventory' => $newinventory,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
            $order->update([
                'title' => $request->order_title,
                'user_id' => auth('api')->user()->id,
                'total_price' => $total_price,
                'explanations' => $request->explanations,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);


            $order->products()->detach();

            foreach (Product::all() as $product) {
                if (in_array($product->id, collect($request->products)->pluck('id')->toArray())) {
                    if (collect($request->products)->where('id', $product->id)->first()['count']) {
                        $product->orders()->save($order, [
                            'count' => collect($request->products)->where('id', $product->id)->first()['count'],
                            'updated_at' => date('Y-m-d H:i:s'),
                        ]);
                    }
                } elseif ($order_products->where('product_id', $product->id)->count()) {
                    $product->orders()->save($order, [
                        'count' => $order_products->where('product_id', $product->id)->first()->count,
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                }

            }
            return response()->json([
                'status' => true,
                'message' => 'سفارش با موفقیت آبدیت شد'
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'شما دسترسی به این سفارش ندارید'
        ]);
    }
}
