<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Image;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.product.index');
    }

    public function getData()
    {
        $products = DB::table('products')
                        ->select(
                            'products.*',
                            'categories.category_name as category_name'
                        )

                        ->leftJoin('categories','products.category_id','=','categories.id')
                        ->orderBy('products.id','desc')
                        ->get();

        return DataTables::of($products)
            ->addIndexColumn()

            ->addColumn('image',function ($products){
                if ($products->image)
                {
                    $url=asset("assets/admin/uploads/product/small/$products->image");
                    return '<img src='.$url.' border="0" width="40" class="img-rounded" align="center" />';
                }

            })

            ->addColumn('publish',function ($products){
                if($products->publish == 0)
                {

                    return '<div>
                            <label class="switch patch">
                                <input type="checkbox" class="publish_toggle" data-value="'.$products->id.'" id="publish_change" value="'.$products->id.'">
                                <span class="slider"></span>
                            </label>
                          </div>';
                }else{
                    return '<div>
                        <label class="switch patch">
                            <input type="checkbox" id="publish_change"  class="publish_toggle" data-value="'.$products->id.'"  value="'.$products->id.'" checked>
                            <span class="slider"></span>
                        </label>
                      </div>';
                }

            })
            ->addColumn('feature',function ($products){

                if ($products->feature == 0)
                {
                    return '<div>
                        <label class="switch patch">
                            <input type="checkbox" id="feature_change" class="feature_toggle" data-value="'.$products->id.'" value="'.$products->id.'">
                            <span class="slider"></span>
                        </label>
                      </div>';
                }else{
                    return '<div>
                        <label class="switch patch">
                            <input type="checkbox" id="feature_change" class="feature_toggle" data-value="'.$products->id.'" value="'.$products->id.'" checked>
                            <span class="slider"></span>
                        </label>
                      </div>';
                }

            })

            ->addColumn('new_arrival',function ($products){

                if ($products->new_arrival == 0)
                {
                    return '<div>
                        <label class="switch patch">
                            <input type="checkbox" id="new_arrival_change" class="new_arrival_toggle" data-value="'.$products->id.'" value="'.$products->id.'">
                            <span class="slider"></span>
                        </label>
                      </div>';
                }else{
                    return '<div>
                        <label class="switch patch">
                            <input type="checkbox" id="new_arrival_change" class="new_arrival_toggle" data-value="'.$products->id.'" value="'.$products->id.'" checked>
                            <span class="slider"></span>
                        </label>
                      </div>';
                }

            })

            ->editColumn('action', function ($products) {
                $return = "<div class=\"btn-group\">";
                if (!empty($products->name))
                {
                    $return .= "
                            <a href=\"/products/edit/$products->id\" style='margin-right: 5px' class=\"btn btn-sm btn-warning\"><i class='fa fa-edit'></i></a>
                            ||
                              <a rel=\"$products->id\" rel1=\"products/destroy\" href=\"javascript:\" style='margin-right: 5px' class=\"btn btn-sm btn-danger deleteRecord \"><i class='fa fa-trash'></i></a>
                              ||
                              <a href=\"/product_gallery/$products->id\" style='margin-right: 5px' class=\"btn btn-sm btn-primary\"><i class='fa fa-file-image'></i></a>
                                  ";
                }
                $return .= "</div>";
                return $return;
            })
            ->rawColumns([
                'action','image','publish','feature','new_arrival'
            ])
            ->make(true);
    }


    public function publish_change($id)
    {
        $product = Product::findOrFail($id);

        if ($product->publish == 0)
        {
            $product->update(['publish' => 1]);

            return response()->json([
                'message' => 'Product is publish',
                'status_code' => 200
            ], 200);
        }else{
            $product->update(['publish' => 0]);

            return response()->json([
                'message' => 'Product  publish is Remove',
                'status_code' => 200
            ], 200);
        }
    }

    public function feature_change($id)
    {
        $product = Product::findOrFail($id);

        if ($product->feature == 0)
        {
            $product->update(['feature' => 1]);

            return response()->json([
                'message' => 'Product is feature',
                'status_code' => 200
            ], 200);
        }else{
            $product->update(['feature' => 0]);

            return response()->json([
                'message' => 'Product  feature is remove',
                'status_code' => 200
            ], 200);
        }
    }

    public function new_arrival_change($id)
    {
        $product = Product::findOrFail($id);

        if ($product->new_arrival == 0)
        {
            $product->update(['new_arrival' => 1]);

            return response()->json([
                'message' => 'Product is New Arrival',
                'status_code' => 200
            ], 200);
        }else{
            $product->update(['new_arrival' => 0]);

            return response()->json([
                'message' => 'Product  New Arrival is remove',
                'status_code' => 200
            ], 200);
        }
    }

    public function create()
    {
        $category = Category::latest()->get();

        return view('admin.product.create',compact('category'));
    }

    public function store(Request $request)
    {
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                //create products

                $proudcts = new Product();

                $proudcts->category_id = $request->category_id;
                $proudcts->name = $request->name;
                $proudcts->description = $request->description;

                if($request->hasFile('image')){

                    $image_tmp = $request->file('image');
                    if($image_tmp->isValid()){
                        $extenson = $image_tmp->getClientOriginalExtension();
                        $filename = rand(111,99999).'.'.$extenson;

                        $original_image_path = public_path().'/assets/admin/uploads/product/original/'.$filename;
                        $large_image_path = public_path().'/assets/admin/uploads/product/large/'.$filename;
                        $medium_image_path = public_path().'/assets/admin/uploads/product/medium/'.$filename;
                        $small_image_path = public_path().'/assets/admin/uploads/product/small/'.$filename;

                        //Resize Image
                        Image::make($image_tmp)->save($original_image_path);
                        Image::make($image_tmp)->resize(1110,680)->save($large_image_path);
                        Image::make($image_tmp)->resize(5200,329)->save($medium_image_path);
                        Image::make($image_tmp)->resize(100,75)->save($small_image_path);

                        $proudcts->image = $filename;

                    }
                }

                $proudcts->price = $request->price;
                $proudcts->quantity = $request->quantity;


                if (!empty($request->publish))
                {
                    $proudcts->publish = 1;
                }else{
                    $proudcts->publish = 0;
                }

                if (!empty($request->feature))
                {
                    $proudcts->feature = 1;
                }else{
                    $proudcts->feature = 0;
                }

                if (!empty($request->new_arrival))
                {
                    $proudcts->new_arrival = 1;
                }else{
                    $proudcts->new_arrival = 0;
                }


                $proudcts->save();

                DB::commit();

                return \response()->json([
                    'flash_message_success' => 'Product added successful',
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
        $category = Category::latest()->get();

        $product = Product::findOrFail($id);

        return view('admin.product.edit', compact('category','product'));
    }

    public function update(Request $request, $id)
    {
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                //create products

                $proudcts = Product::findOrFail($id);

                $proudcts->category_id = $request->category_id;
                $proudcts->name = $request->name;
                $proudcts->description = $request->description;

                if($request->hasFile('image')){

                    $image_tmp = $request->file('image');
                    if($image_tmp->isValid()){
                        $extenson = $image_tmp->getClientOriginalExtension();
                        $filename = rand(111,99999).'.'.$extenson;

                        $original_image_path = public_path().'/assets/admin/uploads/product/original/'.$filename;
                        $large_image_path = public_path().'/assets/admin/uploads/product/large/'.$filename;
                        $medium_image_path = public_path().'/assets/admin/uploads/product/medium/'.$filename;
                        $small_image_path = public_path().'/assets/admin/uploads/product/small/'.$filename;

                        //Resize Image
                        Image::make($image_tmp)->save($original_image_path);
                        Image::make($image_tmp)->resize(1110,680)->save($large_image_path);
                        Image::make($image_tmp)->resize(5200,329)->save($medium_image_path);
                        Image::make($image_tmp)->resize(100,75)->save($small_image_path);

                    }
                }else{
                    $filename = $request->current_image;
                }

                $proudcts->image = $filename;

                $proudcts->price = $request->price;
                $proudcts->quantity = $request->quantity;


                if (!empty($request->publish))
                {
                    $proudcts->publish = 1;
                }else{
                    $proudcts->publish = 0;
                }

                if (!empty($request->feature))
                {
                    $proudcts->feature = 1;
                }else{
                    $proudcts->feature = 0;
                }

                if (!empty($request->new_arrival))
                {
                    $proudcts->new_arrival = 1;
                }else{
                    $proudcts->new_arrival = 0;
                }


                $proudcts->save();

                DB::commit();

                return \response()->json([
                    'flash_message_success' => 'Product updated successful',
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
        $product = Product::findOrFail($id);

        if ($product->image)
        {
            $original_path = public_path().'/assets/admin/uploads/product/original/'.$product->image;
            $large_path = public_path().'/assets/admin/uploads/product/large/'.$product->image;
            $medium_path = public_path().'/assets/admin/uploads/product/medium/'.$product->image;
            $small_path = public_path().'/assets/admin/uploads/product/small/'.$product->image;

            unlink($original_path);
            unlink($large_path);
            unlink($medium_path);
            unlink($small_path);
        }else{
            $product->delete();
        }

        $product->delete();

        return \response()->json([
            'flash_message_success' => 'Product destroy successful',
            'status_code' => 200
        ],Response::HTTP_OK);
    }
}
