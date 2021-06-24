<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Customer;
use App\Http\Controllers\Controller;
use App\Order;
use App\ProductStock;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    public function index()
    {
        return view('admin.order.index');
    }

    public function getData()
    {
        $orders = DB::table('orders')
                    ->select(
                        'orders.*',
                        'customers.name as name',
                        'customers.phone as phone',
                        'order_payment.payment_type as payment_type'
                    )
                    ->leftJoin('customers','orders.user_id','=','customers.id')
                    ->leftJoin('order_payment','orders.id','=','order_payment.order_id')
                    ->orderBy('orders.id','desc')
                    ->get();

        return DataTables::of($orders)
            ->addIndexColumn()

            ->addColumn('confirm',function ($orders){
                if($orders->confirm == 0)
                {

                    return '<div>
                            <label class="switch patch">
                                <input type="checkbox" class="confirm_toggle" data-value="'.$orders->id.'" id="confirm_change" value="'.$orders->id.'">
                                <span class="slider"></span>
                            </label>
                          </div>';
                }else{
                    return '<div>
                        <label class="switch patch">
                            <input type="checkbox" id="confirm_change"  class="confirm_toggle" data-value="'.$orders->id.'"  value="'.$orders->id.'" checked>
                            <span class="slider"></span>
                        </label>
                      </div>';
                }

            })

            ->editColumn('action', function ($orders) {
                $return = "<div class=\"btn-group\">";
                if (!empty($orders->id))
                {
                    $return .= "
                            <a href=\"/order/details/$orders->id\" style='margin-right: 5px' class=\"btn btn-sm btn-warning\"><i class='fa fa-eye'></i></a>
                            ||
                            
                            <a href=\"/order/invoice/$orders->id\" style='margin-right: 5px' class=\"btn btn-sm btn-default\"><i class='fa fa-file-invoice'></i></a>
                            ||
                              <a rel=\"$orders->id\" rel1=\"category/destroy\" href=\"javascript:\" style='margin-right: 5px' class=\"btn btn-sm btn-danger deleteRecord \"><i class='fa fa-trash'></i></a>
                                  ";
                }
                $return .= "</div>";
                return $return;
            })
            ->rawColumns([
                'action','confirm'
            ])
            ->make(true);
    }

    public function confirm_status($id)
    {
        $order = Order::where('id',$id)->first();

        $order_details = DB::table('order_details')->where('order_place_id',$order->order_place_id)->get();

        if ($order->confirm == 0)
        {
            $order->update(['confirm' => 1]);

            foreach ($order_details as $od)
            {
                $customer_quantity = $od->product_quantity;

                $product_stock = ProductStock::where('id',$od->product_size_id)->get();

                if ($product_stock != null)
                {
                    foreach ($product_stock as $ps)
                    {
                        $base_quantity = $ps->quantity;

                        $leave_quantity = $base_quantity - $customer_quantity;

                        $ps->update(['quantity' => $leave_quantity]);
                    }
                }

            }

            return response()->json([
                'message' => 'Order is confirm',
                'status_code' => 200
            ], 200);
        }else{
            $order->update(['confirm' => 0]);

            foreach ($order_details as $od)
            {
                $customer_quantity = $od->product_quantity;

                $product_stock = ProductStock::where('id',$od->product_size_id)->get();

                if ($product_stock != null){

                    foreach ($product_stock as $ps)
                    {
                        $base_quantity = $ps->quantity;

                        $leave_quantity = $base_quantity + $customer_quantity;

                        $ps->update(['quantity' => $leave_quantity]);
                    }
                }
            }

            return response()->json([
                'message' => 'Order  Confirm is Remove',
                'status_code' => 200
            ], 200);
        }
    }

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
                    'product_size_id' => $c->product_size_id,
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

            $customer = Customer::where('id',$id)->first();

            $order = new Order();

            $order->order_place_id = $request->order_place_id;
            $order->user_id = $id;
            $order->total = $request->sub_total;
            $order->grand_total = $request->grand_total;

            $order->save();

            $order_id = DB::getPdo()->lastInsertId();

            $paymentType = '';

            $paymentName = '';

            if ($request->card != null)
            {
                $paymentType = $request->card;

                $paymentName = "Online Banking";
            }

            if ($request->cod != null)
            {
                $paymentType = $request->cod;

                $paymentName = "cash on delivery";
            }

            DB::table('order_payment')->insert([
                'order_id' => $order_id,
                'payment_type' => $paymentType,
                'payment_name' => $paymentName,
                'customer_number' => $customer->phone,
                'payable_amount' => $request->grand_total,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

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
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            Cart::where('user_id',$id)->delete();

            return response()->json([
                'flash_message_success' =>'Order is  Confirm',
                'status_code' => 200
            ]);
        }
    }

    public function details($id)
    {
        $order = Order::where('id',$id)->first();

        $shipping = DB::table('shipping_address')->where('order_id',$id)->first();

        $order_payment = DB::table('order_payment')->where('order_id',$id)->first();

        $order_details = DB::table('order_details')->where('order_place_id', $order->order_place_id)->get();

        $product_size = [];

        foreach ($order_details as $od){
            $product_size[] = ProductStock::where('id',$od->product_size_id)->get();
        }

        //dd($product_size);

        return view('admin.order.details',compact('shipping','order','order_payment','order_details','product_size'));
    }

    public function invoice($id)
    {
        $order = Order::where('id',$id)->first();

        $shipping = DB::table('shipping_address')->where('order_id',$id)->first();

        $order_payment = DB::table('order_payment')->where('order_id',$id)->first();

        $order_details = DB::table('order_details')->where('order_place_id', $order->order_place_id)->get();

        $product_size = [];

        foreach ($order_details as $od){
            $product_size[] = ProductStock::where('id',$od->product_size_id)->get();
        }

        return view('admin.order.invoice',compact('shipping','order','order_payment','order_details','product_size'));
    }
}
