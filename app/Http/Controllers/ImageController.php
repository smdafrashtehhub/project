<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ImageController extends Controller
{
    public function create(Request $request)
    {
//        dd($request->File('name'));
//        dd('/app/public/'.Media::all()->count().'/'.Media::latest()->first()->file_name);
        foreach ($request->name as $name)
        {
            $image=Image::create([
                'name'=>$name->getClientOriginalName(),
            ]);
//                    $image->addMediaFromRequest('name')->toMediaCollection();

        }
        $fileAdders = $image->addMultipleMediaFromRequest(['name'])
            ->each(function ($fileAdder) {
                $fileAdder->toMediaCollection('name');
            });
//        $image->addMediaFromRequest('name')->toMediaCollection();
        return response()->json([
           'status'=>true,
           'message'=>'عکس باموفقیت ذخیره شد'
        ]);
    }
}
