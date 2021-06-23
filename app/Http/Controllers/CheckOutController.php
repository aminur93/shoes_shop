<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Http\Controllers\Controller;
use App\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckOutController extends Controller
{
    public function checkOut()
    {
        $logo = Logo::where('status','=',1)->latest()->first();

        $banner = Banner::where('status','=',1)->latest()->first();

        $user_id = Auth::guard('customer')->user()->id;

        $order_place = DB::table('order_place')->where('order_place.user_id',$user_id)->first();

        $order_details = DB::table('order_details')->where('order_place_id',$order_place->id)->get();


        return view('checkout',compact('logo','banner','order_place','order_details'));
    }

    public function thank()
    {
        $logo = Logo::where('status','=',1)->latest()->first();

        $banner = Banner::where('status','=',1)->latest()->first();

        return view('thank', compact('logo','banner'));
    }
}
