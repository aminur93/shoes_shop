<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Cart;
use App\Http\Controllers\Controller;
use App\Logo;
use App\ProductStock;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $logo = Logo::where('status','=',1)->latest()->first();

        $banner = Banner::where('status','=',1)->latest()->first();

        $user_id = Auth::guard('customer')->id();

        $carts = $cart = DB::table('carts')
            ->select(
                'carts.*',
                'products.image as image'
            )

            ->leftJoin('products','carts.product_id','=','products.id')
            ->where('carts.user_id',$user_id)
            ->get();

        $sub_total = 0;

        foreach ($carts as $c)
        {
            $total = $c->price * $c->product_quantity;

            $sub_total += $total;
        }

        return view('cart',compact('logo','banner','carts','sub_total'));
    }

    public function addToCart(Request $request)
    {
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                //add to cart

                $cart = new Cart();

                $cart->product_id = $request->product_id;

                $id = Auth::guard('customer')->user()->id;
                if (!empty($id)){
                    $cart->user_id = $id;
                }else{
                    $cart->user_id = null;
                }

                if (!empty($request->session_id))
                {
                    $cart->session_id = $request->session_id;
                }else{
                    $cart->session_id = null;
                }

                $cart->product_title = $request->product_title;
                $cart->price = $request->price;
                $cart->product_quantity = $request->product_quantity;
                $cart->product_size_id = $request->product_size;

                $cart->save();

                DB::commit();

                return \response()->json([
                    'flash_message_success' => $request->product_title.' added to cart successful',
                    'status_code' => 200
                ],Response::HTTP_OK);

            }catch (QueryException $e){
                DB::rollBack();

                $error = $e->getMessage();

                return response()->json([
                    'error' => $error,
                    'status_code' => 500
                ],Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function getCartData()
    {
        if (isset($_GET['session_id']))
        {
            $session_id = $_GET['session_id'];

            $cart = DB::table('carts')
                        ->select(
                            'carts.*',
                            'products.image as image'
                        )

                        ->leftJoin('products','carts.product_id','=','products.id')
                        ->where('carts.session_id',$session_id)
                        ->get();

            $cart_total = count($cart);

            $sub_total = 0;

            foreach ($cart as $c)
            {
                $total = $c->price * $c->product_quantity;

                $sub_total += $total;
            }

            return \response()->json([
                'cart' => $cart,
                'sub_total' => $sub_total,
                'cart_total' => $cart_total,
                'status_code' => 200
            ],Response::HTTP_OK);
        }
    }

    public function update(Request $request)
    {
        $carts_id = $request->carts_id;

        $product_size_id = $request->product_size_id;

        $product_quantity = $request->product_quantity;

        $product_stock = ProductStock::where('id', $product_size_id)->first();

        if ($product_stock->quantity < $product_quantity)
        {
            return \response()->json([
                'error' =>'Stock is out',
                'status_code' => 500
            ]);
        }else{

            Cart::where('id',$carts_id)->update(['product_quantity' => $product_quantity]);

            return \response()->json([
                'flash_message_success' =>'Cart updated successful',
                'status_code' => 200
            ]);

        }
    }

    public function remove(Request $request)
    {
        $cart = Cart::where('id',$request->cart_id)->first();

        $cart->delete();

        return \response()->json([
            'flash_message_success' =>' cart item remove successful',
            'status_code' => 200
        ]);
    }
}
