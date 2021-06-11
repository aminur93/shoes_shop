<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Image;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.category.index');
    }

    public function getData()
    {
        $category = Category::latest()->get();

        return DataTables::of($category)
            ->addIndexColumn()

            ->addColumn('image',function ($category){
                if ($category->category_image)
                {
                    $url=asset("assets/admin/uploads/category/small/$category->category_image");
                    return '<img src='.$url.' border="0" width="40" class="img-rounded" align="center" />';
                }

            })

            ->editColumn('action', function ($category) {
                $return = "<div class=\"btn-group\">";
                if (!empty($category->category_name))
                {
                    $return .= "
                            <a href=\"/category/edit/$category->id\" style='margin-right: 5px' class=\"btn btn-sm btn-warning\"><i class='fa fa-edit'></i></a>
                            ||
                              <a rel=\"$category->id\" rel1=\"category/destroy\" href=\"javascript:\" style='margin-right: 5px' class=\"btn btn-sm btn-danger deleteRecord \"><i class='fa fa-trash'></i></a>
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
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                //create category

                $category = new Category();

                $category->category_name = $request->category_name;
                $category->category_slug = Str::slug($request->category_name);

                if($request->hasFile('category_image')){

                    $image_tmp = $request->file('category_image');
                    if($image_tmp->isValid()){
                        $extenson = $image_tmp->getClientOriginalExtension();
                        $filename = rand(111,99999).'.'.$extenson;

                        $original_image_path = public_path().'/assets/admin/uploads/category/original/'.$filename;
                        $large_image_path = public_path().'/assets/admin/uploads/category/large/'.$filename;
                        $medium_image_path = public_path().'/assets/admin/uploads/category/medium/'.$filename;
                        $small_image_path = public_path().'/assets/admin/uploads/category/small/'.$filename;

                        //Resize Image
                        Image::make($image_tmp)->save($original_image_path);
                        Image::make($image_tmp)->resize(1110,680)->save($large_image_path);
                        Image::make($image_tmp)->resize(5200,329)->save($medium_image_path);
                        Image::make($image_tmp)->resize(100,75)->save($small_image_path);

                        $category->category_image = $filename;

                    }
                }

                $category->save();

                DB::commit();

                return \response()->json([
                    'flash_message_success' => 'Category added successful',
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
        $category = Category::findOrFail($id);

        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                //update category

                $category = Category::findOrFail($id);

                $category->category_name = $request->category_name;
                $category->category_slug = Str::slug($request->category_name);

                if($request->hasFile('category_image')){

                    $image_tmp = $request->file('category_image');
                    if($image_tmp->isValid()){
                        $extenson = $image_tmp->getClientOriginalExtension();
                        $filename = rand(111,99999).'.'.$extenson;

                        $original_image_path = public_path().'/assets/admin/uploads/category/original/'.$filename;
                        $large_image_path = public_path().'/assets/admin/uploads/category/large/'.$filename;
                        $medium_image_path = public_path().'/assets/admin/uploads/category/medium/'.$filename;
                        $small_image_path = public_path().'/assets/admin/uploads/category/small/'.$filename;

                        //Resize Image
                        Image::make($image_tmp)->save($original_image_path);
                        Image::make($image_tmp)->resize(1110,680)->save($large_image_path);
                        Image::make($image_tmp)->resize(5200,329)->save($medium_image_path);
                        Image::make($image_tmp)->resize(100,75)->save($small_image_path);



                    }
                }else{
                    $filename = $request->current_image;
                }

                $category->category_image = $filename;

                $category->save();

                DB::commit();

                return \response()->json([
                    'flash_message_success' => 'Category updated successful',
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
        $category = Category::findOrFail($id);

        if ($category->category_image != null)
        {
            $original_image_path = public_path().'/assets/admin/uploads/category/original/'.$category->category_image;
            $large_image_path = public_path().'/assets/admin/uploads/category/large/'.$category->category_image;
            $medium_image_path = public_path().'/assets/admin/uploads/category/medium/'.$category->category_image;
            $small_image_path = public_path().'/assets/admin/uploads/category/small/'.$category->category_image;

            unlink($original_image_path);
            unlink($large_image_path);
            unlink($medium_image_path);
            unlink($small_image_path);
        }else{
            $category->delete();
        }

        $category->delete();

        return \response()->json([
            'flash_message_success' => 'Category destroy successful',
            'status_code' => 200
        ],Response::HTTP_OK);
    }
}
