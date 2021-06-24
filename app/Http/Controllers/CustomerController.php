<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Cart;
use App\Customer;
use App\Logo;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {
        $logo = Logo::where('status','=',1)->latest()->first();

        $banner = Banner::where('status','=',1)->latest()->first();

        return view('customer_dashboard',compact('logo','banner'));
    }


    public function login()
    {
        $logo = Logo::where('status','=',1)->latest()->first();

        $banner = Banner::where('status','=',1)->latest()->first();

        return view('login', compact('logo','banner'));
    }

    public function loginStore(Request $request)
    {
        if ($request->isMethod('post'))
        {

            $credentials = [
                'email' => $request->email,
                'password' => $request->password
            ];

            if (Auth::guard('customer')->attempt($credentials)){


                $id = Auth::guard('customer')->id();

                $session_id = $request->session_id;

                if (!empty($session_id))
                {
                  Cart::where('session_id',$session_id)->update(['user_id' => $id]);
                }

                return \response()->json([
                    'flash_message_success' => 'Customer login successful',
                    'id' => $id,
                    'status_code' => 200
                ],Response::HTTP_OK);

            }

        }
    }

    public function customerLogout()
    {
        auth('customer')->logout();

        return redirect('/');
    }

    public function register()
    {
        $logo = Logo::where('status','=',1)->latest()->first();

        $banner = Banner::where('status','=',1)->latest()->first();

        return view('register', compact('logo','banner'));
    }

    public function registerStore(Request $request)
    {
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                //create customer

                $customer = new Customer();

                $customer->name = $request->name;
                $customer->email = $request->email;
                $customer->phone = $request->phone;
                $customer->password = bcrypt($request->password);

                $customer->save();

                DB::commit();

                return \response()->json([
                    'flash_message_success' => 'Customer register successful',
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
}
