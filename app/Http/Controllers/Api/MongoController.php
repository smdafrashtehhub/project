<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mongo;
use Illuminate\Http\Request;

class MongoController extends Controller
{
    //--------------------------------- index ------------------------------------
    public function index()
    {
        return response([
           'status'=>true,
           'message'=>Mongo::all(),
        ]);
    }

    //--------------------------------- create ------------------------------------
    public function create(Request $request)
    {

        Mongo::create([
           'name'=>$request->name,
           'family'=>$request->family,
           'age'=>$request->age,
        ]);
        return response([
           'status'=>true,
           'message'=>'کاربر با موفقیت ساخته شد'
        ]);
    }
    //--------------------------------- show ------------------------------------
    public function show(Mongo $mongo)
    {
        try{
            return response([
               'status'=>true,
               'message'=>$mongo
            ]);
        }catch (\Throwable $th)
        {
            return response([
                'status'=>false,
                'message'=>$th
            ]);
        }
    }

    //--------------------------------- update ------------------------------------
    public function update(Request $request,Mongo $mongo)
    {
        $mongo->update([
           'name'=>$request->name,
           'family'=>$request->family,
           'age'=>$request->age,
        ]);
        return response([
            'status'=>true,
            'message'=>'کاربر با موفقیت آبدیت شد'
        ]);
    }

    //--------------------------------- delete ------------------------------------
    public function delete(Mongo $mongo)
    {

        $mongo->delete();
        return response([
           'status'=>true,
           'message'=>'کاربر با موفقیت ساخته شد'
        ]);
    }
}
