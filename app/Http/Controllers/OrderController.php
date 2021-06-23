<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Http\Controllers\Controller;
use App\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function orderPlace(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $id = Auth::guard('customer')->user()->id;

            DB::table('order_place')->insert([
                'user_id' => $id,
                'total' => $request->sub_total,
                'grand_total' => $request->sub_total,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            $order_place_id = DB::getPdo()->lastInsertId();

            $product_id = $request->product_id;

            $carts = Cart::where('product_id',$product_id)->get();

            foreach ($carts as $c)
            {
                $total = $c->price * $c->product_quantity;

                DB::table('order_details')->insert([
                    'product_id' => $c->product_id,
                    'order_place_id' => $order_place_id,
                    'product_title' => $c->product_title,
                    'product_price' => $c->price,
                    'product_quantity' => $c->product_quantity,
                    'product_total' => $total,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
            }

            return response()->json([
                'flash_message_success' =>'Cart updated successful',
                'status_code' => 200
            ]);
        }
    }

    public function order(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $id = Auth::guard('customer')->user()->id;

            $order = new Order();

            $order->order_place_id = $request->order_place_id;
            $order->user_id = $id;
            $order->total = $request->sub_total;
            $order->grand_total = $request->grand_total;

            $order->save();

            $order_id = DB::getPdo()->lastInsertId();

            DB::table('shipping_address')->insert([
                'order_id' => $order_id,
                'user_id' => $id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'country' => $request->country,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'postal' => $request->postal,
            ]);

            Cart::where('user_id',$id)->delete();

            return response()->json([
                'flash_message_success' =>'Order is  Confirm',
                'status_code' => 200
            ]);
        }
    }
}
