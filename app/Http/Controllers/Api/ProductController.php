<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\SendSms;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //------------------------------------------------- index --------------------------------------------

    public function index()
    {
        try {
            if (auth('api')->user()->hasRole('admin')) {
                return response()->json([
                    'status' => true,
                    'message' => Product::all(),
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => auth('api')->user()->products,
                ]);
            }
        } catch (\Throwable $th) {
            response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    //------------------------------------------------- create --------------------------------------------
    public function create(Request $request)
    {

        $product=Product::create([
            'title' => $request->product_name,
            'price' => $request->price,
            'inventory' => $request->amount_available,
            'description' => $request->explanation,
            'user_id' => auth('api')->user()->id,
        ]);
        $admins=User::where('role','admin')->get();
        foreach ($admins as $admin) {
            SendSms::dispatch($product,$admin);
        }
        return response()->json([
            'status' => true,
            'message' => 'محصول با موفقیت ساخته شد'
        ]);
    }

    //------------------------------------------------- update --------------------------------------------
    public function update(Request $request, Product $product)
    {
        if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('seller') && $product->user->id == auth('api')->user()->id) {
            $product->update([
                'title' => $request->product_name,
                'price' => $request->price,
                'inventory' => $request->amount_available,
                'description' => $request->explanation,
            ]);
            return response()->json([
                'status' => true,
                'message' => 'محصول با موفقیت ویرایش شد',
            ], 500);
        }

        return response()->json([
            'status' => false,
            'message' => 'شما نمیتوانید این محصول را ویرایش کنید',
        ], 500);
    }

    //------------------------------------------------- destroy --------------------------------------------
    public function destroy(Product $product)
    {
        if (auth('api')->user()->hasRole('admin') || $product->user->id == auth('api')->user()->id) {
            $product->delete();
            return response()->json([
                'status' => true,
                'message' => 'محصول با موفقیت حذف شد',
            ], 500);
        }
        return response()->json([
            'status' => false,
            'message' => 'شما نمیتوانید این محصول را حذف کنید',
        ], 500);
    }

    //------------------------------------------------- filter --------------------------------------------

    public function filter(Request $request)
    {
        if (auth('api')->user()->role == 'admin')
        $products = Product::with('user')->get();
        if (auth('api')->user()->role == 'seller')
        $products = auth('api')->user()->products;
        if ($request->filterProductName)
            $products = $products->where('title', $request->filterProductName);
        if ($request->filterDescription)
            $products = $products->where('description', $request->filterDescription);
        if ($request->filterPriceMin && $request->filterPriceMax)
            $products = $products->whereBetween('price', [$request->filterPriceMin, $request->filterPriceMax]);
        if ($request->filterInventoryMin && $request->filterInventoryMax)
            $products = $products->whereBetween('inventory', [$request->filterInventoryMin, $request->filterInventoryMax]);
        return response()->json([
           'status'=>true,
           'message'=>$products
        ]);
    }
}
