<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Image;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.user.index');
    }

    public function getData()
    {
        $user_id = auth()->user()->id;

        $user = User::where('id','!=', $user_id)->latest()->get();

        return DataTables::of($user)
            ->addIndexColumn()

            ->editColumn('action', function ($user) {
                $return = "<div class=\"btn-group\">";
                if (!empty($user->id))
                {
                    $return .= "
                            <a href=\"/user/edit/$user->id\" style='margin-right: 5px' class=\"btn btn-sm btn-warning\"><i class='fa fa-edit'></i></a>
                            ||
                              <a rel=\"$user->id\" rel1=\"user/destroy\" href=\"javascript:\" style='margin-right: 5px' class=\"btn btn-sm btn-danger deleteRecord \"><i class='fa fa-trash'></i></a>
                                  ";
                }
                $return .= "</div>";
                return $return;
            })
            ->rawColumns([
                'action'
            ])
            ->make(true);
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed'
        ]);

        if ($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                //create user

                $user = new User();

                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = bcrypt($request->password);

                $user->save();

                DB::commit();

                return \response()->json([
                    'flash_message_success' => 'User added successful',
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

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                //update user

                $user = User::findOrFail($id);

                $user->name = $request->name;
                $user->email = $request->email;

                if ($request->get('password') == '') {
                    $user->update($request->except('password'));
                }else{
                    $user->password = bcrypt($request->password);
                }

                $user->save();

                DB::commit();

                return \response()->json([
                    'flash_message_success' => 'User updated successful',
                    'status_code' => 200
                ],Response::HTTP_OK);

            }catch (QueryException $e){
                DB::rollBack();

                $error = $e->getMessage();

                return \response()->json([
                    'error' => $error,
                    'status_code' => 500
                ],Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return \response()->json([
            'flash_message_success' => 'User destroy successful',
            'status_code' => 200
        ],Response::HTTP_OK);
    }

    public function profile()
    {

        return view('admin.user.profile');
    }

    public function profileUpdate(Request $request)
    {
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                //update profile

                $user_id = auth()->user()->id;

                $user = User::findOrFail($user_id);

                $user->name = $request->name;
                $user->email = $request->email;

                if($request->hasFile('profile_image')){

                    $image_tmp = $request->file('profile_image');

                    if($image_tmp->isValid()){
                        $extenson = $image_tmp->getClientOriginalExtension();
                        $filename = rand(111,99999).'.'.$extenson;

                        $original_image_path = public_path().'/assets/admin/uploads/user_image/original/'.$filename;
                        $large_image_path = public_path().'/assets/admin/uploads/user_image/large/'.$filename;
                        $medium_image_path = public_path().'/assets/admin/uploads/user_image/medium/'.$filename;
                        $small_image_path = public_path().'/assets/admin/uploads/user_image/small/'.$filename;

                        //Resize Image
                        Image::make($image_tmp)->save($original_image_path);
                        Image::make($image_tmp)->resize(1110,680)->save($large_image_path);
                        Image::make($image_tmp)->resize(520,329)->save($medium_image_path);
                        Image::make($image_tmp)->resize(100,75)->save($small_image_path);
                    }
                }else{
                    $filename = $request->current_image;
                }

                $user->profile_image = $filename;

                $user->save();

                DB::commit();

                return \response()->json([
                    'flash_message_success' => 'User profile updated successful',
                    'status_code' => 200
                ],Response::HTTP_OK);

            }catch (QueryException $e){
                DB::rollBack();

                $error = $e->getMessage();

                return \response()->json([
                    'error' => $error,
                    'status_code' => 500
                ],Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function ChangePassword()
    {
        return view('admin.user.change_password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed'
        ]);

        if ($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                //update password

                $user_id = auth()->user()->id;

                $user = User::findOrFail($user_id);

                $user->password = bcrypt($request->password);

                $user->save();

                DB::commit();

                return \response()->json([
                    'flash_message_success' => 'User profile updated successful',
                    'status_code' => 200
                ],Response::HTTP_OK);

            }catch (QueryException $e){
                DB::rollBack();

                $error = $e->getMessage();

                return \response()->json([
                    'error' => $error,
                    'status_code' => 500
                ],Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }
}
