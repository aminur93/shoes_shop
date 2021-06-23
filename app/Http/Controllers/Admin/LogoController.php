<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Logo;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Image;

class LogoController extends Controller
{
    public function index()
    {
        return view('admin.settings.logo.index');
    }

    public function getData()
    {
        $logo = Logo::latest()->get();

        return DataTables::of($logo)
            ->addIndexColumn()

            ->addColumn('image',function ($logo){
                if ($logo->logo_image)
                {
                    $url=asset("assets/admin/uploads/logo/small/$logo->logo_image");
                    return '<img src='.$url.' border="0" width="40" class="img-rounded" align="center" />';
                }

            })

            ->addColumn('status',function ($logo){
                if($logo->status == 0)
                {

                    return '<div>
                            <label class="switch patch">
                                <input type="checkbox" class="status_toggle" data-value="'.$logo->id.'" id="status_change" value="'.$logo->id.'">
                                <span class="slider"></span>
                            </label>
                          </div>';
                }else{
                    return '<div>
                        <label class="switch patch">
                            <input type="checkbox" id="status_change"  class="status_toggle" data-value="'.$logo->id.'"  value="'.$logo->id.'" checked>
                            <span class="slider"></span>
                        </label>
                      </div>';
                }

            })

            ->editColumn('action', function ($logo) {
                $return = "<div class=\"btn-group\">";
                if (!empty($logo->logo_image))
                {
                    $return .= "
                            <a href=\"/logo/edit/$logo->id\" style='margin-right: 5px' class=\"btn btn-sm btn-warning\"><i class='fa fa-edit'></i></a>
                            ||
                              <a rel=\"$logo->id\" rel1=\"logo/destroy\" href=\"javascript:\" style='margin-right: 5px' class=\"btn btn-sm btn-danger deleteRecord \"><i class='fa fa-trash'></i></a>
                                  ";
                }
                $return .= "</div>";
                return $return;
            })
            ->rawColumns([
                'action','image','status'
            ])
            ->make(true);
    }

    public function status_change($id)
    {
        $logo = Logo::findOrFail($id);

        if ($logo->status == 0)
        {
            $logo->update(['status' => 1]);

            return response()->json([
                'message' => 'Logo is active',
                'status_code' => 200
            ], 200);
        }else{
            $logo->update(['status' => 0]);

            return response()->json([
                'message' => 'Logo  active is Remove',
                'status_code' => 200
            ], 200);
        }
    }

    public function create()
    {
        return view('admin.settings.logo.create');
    }

    public function store(Request $request)
    {
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                //create category

                $logo = new Logo();

                $logo->logo_name = $request->logo_name;

                if($request->hasFile('logo_image')){

                    $image_tmp = $request->file('logo_image');
                    if($image_tmp->isValid()){
                        $extenson = $image_tmp->getClientOriginalExtension();
                        $filename = rand(111,99999).'.'.$extenson;

                        $original_image_path = public_path().'/assets/admin/uploads/logo/original/'.$filename;
                        $large_image_path = public_path().'/assets/admin/uploads/logo/large/'.$filename;
                        $medium_image_path = public_path().'/assets/admin/uploads/logo/medium/'.$filename;
                        $small_image_path = public_path().'/assets/admin/uploads/logo/small/'.$filename;

                        //Resize Image
                        Image::make($image_tmp)->save($original_image_path);
                        Image::make($image_tmp)->resize(1110,680)->save($large_image_path);
                        Image::make($image_tmp)->resize(520,329)->save($medium_image_path);
                        Image::make($image_tmp)->resize(100,75)->save($small_image_path);

                        $logo->logo_image = $filename;

                    }
                }

                if (!empty($request->status))
                {
                    $logo->status = 1;
                }else{
                    $logo->status = 0;
                }

                $logo->save();

                DB::commit();

                return \response()->json([
                    'flash_message_success' => 'Logo added successful',
                    'status_code' => 200
                ]);

            }catch (QueryException $e){
                DB::rollBack();

                $error = $e->getMessage();

                return response()->json([
                        'error' => $error,
                        'status_code' => 500
                    ].Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function edit($id)
    {
        $logo = Logo::findOrFail($id);

        return view('admin.settings.logo.edit', compact('logo'));
    }

    public function update(Request $request, $id)
    {
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                //create category

                $logo = Logo::findOrFail($id);

                $logo->logo_name = $request->logo_name;

                if($request->hasFile('logo_image')){

                    $image_tmp = $request->file('logo_image');
                    if($image_tmp->isValid()){
                        $extenson = $image_tmp->getClientOriginalExtension();
                        $filename = rand(111,99999).'.'.$extenson;

                        $original_image_path = public_path().'/assets/admin/uploads/logo/original/'.$filename;
                        $large_image_path = public_path().'/assets/admin/uploads/logo/large/'.$filename;
                        $medium_image_path = public_path().'/assets/admin/uploads/logo/medium/'.$filename;
                        $small_image_path = public_path().'/assets/admin/uploads/logo/small/'.$filename;

                        //Resize Image
                        Image::make($image_tmp)->save($original_image_path);
                        Image::make($image_tmp)->resize(1110,680)->save($large_image_path);
                        Image::make($image_tmp)->resize(520,329)->save($medium_image_path);
                        Image::make($image_tmp)->resize(100,75)->save($small_image_path);

                    }
                }else{
                    $filename = $request->current_image;
                }

                $logo->logo_image = $filename;

                if (!empty($request->status))
                {
                    $logo->status = 1;
                }else{
                    $logo->status = 0;
                }

                $logo->save();

                DB::commit();

                return \response()->json([
                    'flash_message_success' => 'Logo added successful',
                    'status_code' => 200
                ]);

            }catch (QueryException $e){
                DB::rollBack();

                $error = $e->getMessage();

                return response()->json([
                        'error' => $error,
                        'status_code' => 500
                    ].Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    public function destroy($id)
    {
        $logo = Logo::findOrFail($id);

        if ($logo->logo_image)
        {
            $original_image_path = public_path().'/assets/admin/uploads/logo/original/'.$logo->logo_image;
            $large_image_path = public_path().'/assets/admin/uploads/logo/large/'.$logo->logo_image;
            $medium_image_path = public_path().'/assets/admin/uploads/logo/medium/'.$logo->logo_image;
            $small_image_path = public_path().'/assets/admin/uploads/logo/small/'.$logo->logo_image;

            unlink($original_image_path);
            unlink($large_image_path);
            unlink($medium_image_path);
            unlink($small_image_path);
        }else{
            $logo->delete();
        }

        $logo->delete();

        return \response()->json([
            'flash_message_success' => 'Logo deleted successful',
            'status_code' => 200
        ],Response::HTTP_OK);
    }
}
