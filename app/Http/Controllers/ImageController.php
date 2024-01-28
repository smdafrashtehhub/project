<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function create(Request $request)
    {
        $image=Image::create([
            'name'=>$request->name->getClientOriginalName(),
        ]);
        $image->addMediaFromRequest('name')->toMediaCollection();
        return response()->json([
           'status'=>true,
           'message'=>'عکس باموفقیت ذخیره شد'
        ]);
    }
}
