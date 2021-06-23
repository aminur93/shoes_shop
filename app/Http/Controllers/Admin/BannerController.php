<?php

namespace App\Http\Controllers\Admin;

use App\Banner;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Image;

class BannerController extends Controller
{
    public function index()
    {
        return view('admin.settings.banner.index');
    }

    public function getData()
    {
        $banner = Banner::latest()->get();

        return DataTables::of($banner)
            ->addIndexColumn()

            ->addColumn('image',function ($banner){
                if ($banner->banner_image)
                {
                    $url=asset("assets/admin/uploads/banner/small/$banner->banner_image");
                    return '<img src='.$url.' border="0" width="40" class="img-rounded" align="center" />';
                }

            })

            ->addColumn('status',function ($banner){
                if($banner->status == 0)
                {

                    return '<div>
                            <label class="switch patch">
                                <input type="checkbox" class="status_toggle" data-value="'.$banner->id.'" id="status_change" value="'.$banner->id.'">
                                <span class="slider"></span>
                            </label>
                          </div>';
                }else{
                    return '<div>
                        <label class="switch patch">
                            <input type="checkbox" id="status_change"  class="status_toggle" data-value="'.$banner->id.'"  value="'.$banner->id.'" checked>
                            <span class="slider"></span>
                        </label>
                      </div>';
                }

            })

            ->editColumn('action', function ($banner) {
                $return = "<div class=\"btn-group\">";
                if (!empty($banner->banner_image))
                {
                    $return .= "
                            <a href=\"/banner/edit/$banner->id\" style='margin-right: 5px' class=\"btn btn-sm btn-warning\"><i class='fa fa-edit'></i></a>
                            ||
                              <a rel=\"$banner->id\" rel1=\"banner/destroy\" href=\"javascript:\" style='margin-right: 5px' class=\"btn btn-sm btn-danger deleteRecord \"><i class='fa fa-trash'></i></a>
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
        $banner = Banner::findOrFail($id);

        if ($banner->status == 0)
        {
            $banner->update(['status' => 1]);

            return response()->json([
                'message' => 'Banner is active',
                'status_code' => 200
            ], 200);
        }else{
            $banner->update(['status' => 0]);

            return response()->json([
                'message' => 'News  active is Remove',
                'status_code' => 200
            ], 200);
        }
    }

    public function create()
    {
        return view('admin.settings.banner.create');
    }

    public function store(Request $request)
    {
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                //create category

                $banner = new Banner();

                $banner->banner_name = $request->banner_name;

                if($request->hasFile('banner_image')){

                    $image_tmp = $request->file('banner_image');
                    if($image_tmp->isValid()){
                        $extenson = $image_tmp->getClientOriginalExtension();
                        $filename = rand(111,99999).'.'.$extenson;

                        $original_image_path = public_path().'/assets/admin/uploads/banner/original/'.$filename;
                        $large_image_path = public_path().'/assets/admin/uploads/banner/large/'.$filename;
                        $medium_image_path = public_path().'/assets/admin/uploads/banner/medium/'.$filename;
                        $small_image_path = public_path().'/assets/admin/uploads/banner/small/'.$filename;

                        //Resize Image
                        Image::make($image_tmp)->save($original_image_path);
                        Image::make($image_tmp)->resize(1110,680)->save($large_image_path);
                        Image::make($image_tmp)->resize(520,329)->save($medium_image_path);
                        Image::make($image_tmp)->resize(100,75)->save($small_image_path);

                        $banner->banner_image = $filename;

                    }
                }

                if (!empty($request->status))
                {
                    $banner->status = 1;
                }else{
                    $banner->status = 0;
                }

                $banner->save();

                DB::commit();

                return \response()->json([
                    'flash_message_success' => 'Banner added successful',
                    'status_code' => 200
                ],Response::HTTP_OK);

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
        $banner = Banner::findOrFail($id);

        return view('admin.settings.banner.edit', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                //create category

                $banner = Banner::findOrFail($id);

                $banner->banner_name = $request->banner_name;

                if($request->hasFile('banner_image')){

                    $image_tmp = $request->file('banner_image');
                    if($image_tmp->isValid()){
                        $extenson = $image_tmp->getClientOriginalExtension();
                        $filename = rand(111,99999).'.'.$extenson;

                        $original_image_path = public_path().'/assets/admin/uploads/banner/original/'.$filename;
                        $large_image_path = public_path().'/assets/admin/uploads/banner/large/'.$filename;
                        $medium_image_path = public_path().'/assets/admin/uploads/banner/medium/'.$filename;
                        $small_image_path = public_path().'/assets/admin/uploads/banner/small/'.$filename;

                        //Resize Image
                        Image::make($image_tmp)->save($original_image_path);
                        Image::make($image_tmp)->resize(1110,680)->save($large_image_path);
                        Image::make($image_tmp)->resize(520,329)->save($medium_image_path);
                        Image::make($image_tmp)->resize(100,75)->save($small_image_path);

                    }
                }else{
                    $filename = $request->current_image;
                }

                $banner->banner_image = $filename;

                if (!empty($request->status))
                {
                    $banner->status = 1;
                }else{
                    $banner->status = 0;
                }

                $banner->save();

                DB::commit();

                return \response()->json([
                    'flash_message_success' => 'Banner updated successful',
                    'status_code' => 200
                ],Response::HTTP_OK);

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
        $banner = Banner::findOrFail($id);

        if ($banner->banner_image)
        {
            $original_image_path = public_path().'/assets/admin/uploads/banner/original/'.$banner->banner_image;
            $large_image_path = public_path().'/assets/admin/uploads/banner/large/'.$banner->banner_image;
            $medium_image_path = public_path().'/assets/admin/uploads/banner/medium/'.$banner->banner_image;
            $small_image_path = public_path().'/assets/admin/uploads/banner/small/'.$banner->banner_image;

            unlink($original_image_path);
            unlink($large_image_path);
            unlink($medium_image_path);
            unlink($small_image_path);
        }else{
            $banner->delete();
        }

        $banner->delete();

        return \response()->json([
            'flash_message_success' => 'Banner destroy successful',
            'status_code' => 200
        ],Response::HTTP_OK);
    }
}
