<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Slider;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Image;

class ProductSliderController extends Controller
{
    public function index()
    {
        return view('admin.slider.index');
    }

    public function getData()
    {
        $slider = Slider::latest()->get();

        return DataTables::of($slider)
            ->addIndexColumn()

            ->addColumn('image',function ($slider){
                if ($slider->slider_image)
                {
                    $url=asset("assets/admin/uploads/slider/small/$slider->slider_image");
                    return '<img src='.$url.' border="0" width="40" class="img-rounded" align="center" />';
                }

            })

            ->editColumn('action', function ($slider) {
                $return = "<div class=\"btn-group\">";
                if (!empty($slider->id))
                {
                    $return .= "
                            <a href=\"/slider/edit/$slider->id\" style='margin-right: 5px' class=\"btn btn-sm btn-warning\"><i class='fa fa-edit'></i></a>
                            ||
                              <a rel=\"$slider->id\" rel1=\"slider/destroy\" href=\"javascript:\" style='margin-right: 5px' class=\"btn btn-sm btn-danger deleteRecord \"><i class='fa fa-trash'></i></a>
                                  ";
                }
                $return .= "</div>";
                return $return;
            })
            ->rawColumns([
                'action','image'
            ])
            ->make(true);
    }

    public function create()
    {
        return view('admin.slider.create');
    }

    public function store(Request $request)
    {
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                //create slider

                $slider = new Slider();

                $slider->slider_name = $request->slider_name;

                if($request->hasFile('slider_image')){

                    $image_tmp = $request->file('slider_image');
                    if($image_tmp->isValid()){
                        $extenson = $image_tmp->getClientOriginalExtension();
                        $filename = rand(111,99999).'.'.$extenson;

                        $original_image_path = public_path().'/assets/admin/uploads/slider/original/'.$filename;
                        $large_image_path = public_path().'/assets/admin/uploads/slider/large/'.$filename;
                        $medium_image_path = public_path().'/assets/admin/uploads/slider/medium/'.$filename;
                        $small_image_path = public_path().'/assets/admin/uploads/slider/small/'.$filename;

                        //Resize Image
                        Image::make($image_tmp)->save($original_image_path);
                        Image::make($image_tmp)->resize(1026,580)->save($large_image_path);
                        Image::make($image_tmp)->resize(520,329)->save($medium_image_path);
                        Image::make($image_tmp)->resize(100,75)->save($small_image_path);

                        $slider->slider_image = $filename;

                    }
                }

                $slider->save();

                DB::commit();

                return \response()->json([
                    'flash_message_success' => 'Slider added successful',
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
        $slider = Slider::findOrFail($id);

        return view('admin.slider.edit', compact('slider'));
    }

    public function update(Request $request, $id)
    {
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                //create slider

                $slider = Slider::findOrFail($id);

                $slider->slider_name = $request->slider_name;

                if($request->hasFile('slider_image')){

                    $image_tmp = $request->file('slider_image');
                    if($image_tmp->isValid()){
                        $extenson = $image_tmp->getClientOriginalExtension();
                        $filename = rand(111,99999).'.'.$extenson;

                        $original_image_path = public_path().'/assets/admin/uploads/slider/original/'.$filename;
                        $large_image_path = public_path().'/assets/admin/uploads/slider/large/'.$filename;
                        $medium_image_path = public_path().'/assets/admin/uploads/slider/medium/'.$filename;
                        $small_image_path = public_path().'/assets/admin/uploads/slider/small/'.$filename;

                        //Resize Image
                        Image::make($image_tmp)->save($original_image_path);
                        Image::make($image_tmp)->resize(1026,580)->save($large_image_path);
                        Image::make($image_tmp)->resize(520,329)->save($medium_image_path);
                        Image::make($image_tmp)->resize(100,75)->save($small_image_path);



                    }
                }else{
                    $filename = $request->current_image;
                }

                $slider->slider_image = $filename;

                $slider->save();

                DB::commit();

                return \response()->json([
                    'flash_message_success' => 'Slider updated successful',
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

    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);

        if ($slider->slider_image)
        {
            $original_image_path = public_path().'/assets/admin/uploads/slider/original/'.$slider->slider_image;
            $large_image_path = public_path().'/assets/admin/uploads/slider/large/'.$slider->slider_image;
            $medium_image_path = public_path().'/assets/admin/uploads/slider/medium/'.$slider->slider_image;
            $small_image_path = public_path().'/assets/admin/uploads/slider/small/'.$slider->slider_image;

            unlink($original_image_path);
            unlink($large_image_path);
            unlink($medium_image_path);
            unlink($small_image_path);
        }else{
            $slider->delete();
        }

        $slider->delete();

        return \response()->json([
            'flash_message_success' => 'Slider updated successful',
            'status_code' => 200
        ],Response::HTTP_OK);
    }
}
