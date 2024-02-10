<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;


class LocationController extends Controller
{
    //--------------------------------------------1way------------------------------------------

    public function location(Request $request, Order $order)
    {
        /**
         * Requires libcurl
         */
        $first = array(35.701139, 51.430584);
        $users = [];
        $x = [];
        $last = [];
        $sum = 0;
        $users = array_unique($order->products->pluck('user_id')->toArray());
        $users[] = $order->user_id;
        $query = array(
            "key" => "bc5a0dd0-bce4-4a9c-bb98-db951176146f"
        );
        foreach (User::find($users) as $user) {
            $last = array($user->lan, $user->long);

            $curl = curl_init();

            $payload = array(
                "points" => array(
                    $first, $last
                ),
                "point_hints" => array(
                    "Lindenschmitstraße",
                    "Thalkirchener Str."
                ),
                "snap_preventions" => array(
                    "motorway",
                    "ferry",
                    "tunnel"
                ),
                "details" => array(
                    "road_class",
                    "surface"
                ),
                "vehicle" => "bike",
                "locale" => "en",
                "instructions" => true,
                "calc_points" => true,
                "points_encoded" => false
            );

            curl_setopt_array($curl, [
                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json"
                ],
                CURLOPT_POSTFIELDS => json_encode($payload),
                CURLOPT_URL => "https://graphhopper.com/api/1/route?" . http_build_query($query),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => "POST",
            ]);

            $response = curl_exec($curl);

            $error = curl_error($curl);

            curl_close($curl);

            $sum += json_decode($response)->paths[0]->distance;

            $first = $last;

        }//------------------end of foreach--------------------

        $order->update([
            'price_km' => ($sum / 3280) * User::find(5)->price_per_km,
            'total_price' => $order->total_price + ($sum / 3280) * User::find(5)->price_per_km
        ]);
        if ($error) {
            echo "cURL Error #:" . $error;
        } else {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'قیمت سفارش به درستی محاسبه شد'
                ]
            );
        }
    }




    //-----------------------------------------matrix---------------------------------------------
//    public function location(Request $request,Order $order)
//    {
//        /**
//         * Requires libcurl
//         */
//
//        $query = array(
//            "key" => "bc5a0dd0-bce4-4a9c-bb98-db951176146f"
//        );
//        $curl = curl_init();
//        //-------------------------------------------
//        $to_points=[];
//        $to_point_hints=[];
//        foreach ($order->products as $product){
//            $to_points[]=array($product->user->lan,$product->user->long);
//        }
//        $to_points[]=array($order->user->lan,$order->user->long);
//
//        foreach ($order->products as $product) {
//            $to_point_hints[]='';
//        }
//        $to_point_hints[]='';
//        //-------------------------------------------
//        $payload = array(
//            "from_points" => array(
//                array(
//                    35.701139,
//                    51.430584
//                ),
//            ),
//            "to_points" =>$to_points,
//            "from_point_hints" => array(
//                "Copenhagen Street",
//            ),
//            "to_point_hints" => $to_point_hints,
//            "out_arrays" => array(
//                "weights",
//                "times",
//                "distances"
//            ),
//            "vehicle" => "car"
//        );
////        dd($payload['to_points']);
//        curl_setopt_array($curl, [
//            CURLOPT_HTTPHEADER => [
//                "Content-Type: application/json"
//            ],
//            CURLOPT_POSTFIELDS => json_encode($payload),
//            CURLOPT_URL => "https://graphhopper.com/api/1/matrix?" . http_build_query($query),
//            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_CUSTOMREQUEST => "POST",
//        ]);
//
//        $response = curl_exec($curl);
//        $error = curl_error($curl);
//
//        curl_close($curl);
//
//        dd(json_decode($response)->distances[0][1]);
//
//        if ($error) {
//            echo "cURL Error #:" . $error;
//        } else {
//            echo $response;
//        }    }
}
