<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Image;

class ProductImageGalleryController extends Controller
{
    public function index($id)
    {
        $product = Product::findOrFail($id);

        return view('admin.product_image_gallery.index', compact('product'));
    }

    public function gallery_image()
    {
        $product_id = $_GET['id'];

        $product_images = DB::table('product_image_galleries')
            ->select(
                'product_image_galleries.*',
                'products.name as name'
            )
            ->leftJoin('products','product_image_galleries.product_id','=','products.id')
            ->where('product_image_galleries.product_id', $product_id)
            ->orderBy('product_image_galleries.id','desc')
            ->get();



        //dd($product);

        return DataTables::of($product_images)
            ->addIndexColumn()
            ->addColumn('image',function ($product_images){
                if ($product_images->gallery_image)
                {
                    $url=asset("assets/admin/uploads/product_gallery/small/$product_images->gallery_image");
                    return '<img src='.$url.' border="0" width="40" class="img-rounded" align="center" />';
                }

            })
            ->editColumn('action', function ($product_images) {
                $return = "<div class=\"btn-group\">";
                if (!empty($product_images->id))
                {
                    $return .= "
                                  <a href=\"/product_gallery/edit/$product_images->id\" class=\"btn btn-sm btn-clean btn-icon btn-icon-md\" title=\"View\">
                                      <i class=\"fa fa-edit\"></i>
                                    </a>
                                    
                                    <a rel=\"$product_images->id\" rel1=\"gallery_image_destroy\" href=\"javascript:\" style='margin-right: 5px' class=\"btn btn-sm btn-clean btn-icon btn-icon-md deleteRecord \"><i class='fa fa-trash'></i></a>
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

    public function galleryImageCreate($id)
    {
        $product = Product::findOrFail($id);

        return view('admin.product_image_gallery.create', compact('product'));
    }

    public function galleryImageStore(Request $request, $id)
    {
        if ($request->isMethod('post')) {

            //create product Image

            if ($request->file('file')) {

                $product = Product::findOrFail($id);

                foreach ($request->file('file') as $value) {
                    //dd($value);
                    $image_tmp = $value;
                    $name = $value->getClientOriginalName();
                    $filename = $name;

                    $original_image_path = public_path() . '/assets/admin/uploads/product_gallery/original/' . $filename;
                    $large_path = public_path() . '/assets/admin/uploads/product_gallery/large/' . $filename;
                    $medium_image_path = public_path() . '/assets/admin/uploads/product_gallery/medium/' . $filename;
                    $small_image_path = public_path() . '/assets/admin/uploads/product_gallery/small/' . $filename;

                    //Resize Image
                    Image::make($image_tmp)->save($original_image_path);
                    Image::make($image_tmp)->resize(1120, 520)->save($large_path);
                    Image::make($image_tmp)->resize(520, 370)->save($medium_image_path);
                    Image::make($image_tmp)->resize(100, 75)->save($small_image_path);

                    //$value->move(public_path().'/assets/admin/uploads/product_images/original/'.$name);

                    DB::table('product_image_galleries')->insert([
                        'product_id' => $product->id,
                        'gallery_image' => $filename,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                }
            }

            return \response()->json([
                'flash_message_success' => 'Product Image Added Successful',
                'status_code' => 200
            ], Response::HTTP_OK);
        }
    }

    public function image_delete(Request $request)
    {
        $filename =  $request->get('filename');

        $product_images = DB::table('product_image_galleries')->where('gallery_image',$filename)->first();

        if ($product_images->gallery_image != null)
        {
            $original = public_path().'/assets/admin/uploads/product_gallery/original/'.$product_images->gallery_image;
            $large = public_path().'/assets/admin/uploads/product_gallery/large/'.$product_images->gallery_image;
            $medium = public_path().'/assets/admin/uploads/product_gallery/medium/'.$product_images->gallery_image;
            $small = public_path().'/assets/admin/uploads/product_gallery/small/'.$product_images->gallery_image;

            unlink($original);
            unlink($large);
            unlink($medium);
            unlink($small);

        }

        DB::table('product_image_galleries')->where('product_image_galleries.id', $product_images->id)->delete();

        return response()->json([
            'flash_message_success' => 'Product Image Remove',
            'status_code' => 200
        ], 200);
    }

    public function edit($id)
    {
        $product_image = DB::table('product_image_galleries')->where('product_image_galleries.id', $id)->first();

        return view('admin.product_image_gallery.edit',compact('product_image'));
    }

    public function galleryImageUpdate(Request $request, $id)
    {
        if ($request->isMethod('post')) {

            //create product Image

            if ($request->file('gallery_image'))
            {
                $product =   DB::table('product_image_galleries')->where('product_image_galleries.id', $id)->first();

                //dd($value);
                $image_tmp = $request->file('gallery_image');
                $name=$image_tmp->getClientOriginalName();
                $filename = $name;

                $original_image_path = public_path() . '/assets/admin/uploads/product_gallery/original/' . $filename;
                $large_path = public_path() . '/assets/admin/uploads/product_gallery/large/' . $filename;
                $medium_image_path = public_path() . '/assets/admin/uploads/product_gallery/medium/' . $filename;
                $small_image_path = public_path() . '/assets/admin/uploads/product_gallery/small/' . $filename;

                //Resize Image
                Image::make($image_tmp)->save($original_image_path);
                Image::make($image_tmp)->resize(1120, 520)->save($large_path);
                Image::make($image_tmp)->resize(520, 370)->save($medium_image_path);
                Image::make($image_tmp)->resize(100, 75)->save($small_image_path);

                DB::table('product_image_galleries')->where('product_image_galleries.id', $id)->update([
                    'product_id' => $product->product_id,
                    'gallery_image' => $filename,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

            }

            return \response()->json([
                'flash_message_success' => 'Product Image Updated Successful',
                'status_code' => 200
            ], Response::HTTP_OK);

        }
    }

    public function galleryImageDestroy($id)
    {
        $product_images = DB::table('product_image_galleries')->where('product_image_galleries.id', $id)->first();

        if ($product_images->gallery_image != null)
        {
            $original_image_path = public_path() . '/assets/admin/uploads/product_gallery/original/' . $product_images->gallery_image;
            $large_path = public_path() . '/assets/admin/uploads/product_gallery/large/' . $product_images->gallery_image;
            $medium_image_path = public_path() . '/assets/admin/uploads/product_gallery/medium/' . $product_images->gallery_image;
            $small_image_path = public_path() . '/assets/admin/uploads/product_gallery/small/' . $product_images->gallery_image;

            unlink($original_image_path);
            unlink($large_path);
            unlink($medium_image_path);
            unlink($small_image_path);

        }

        DB::table('product_image_galleries')->where('product_image_galleries.id', $id)->delete();

        return response()->json([
            'flash_message_success' => 'Product Image Destroy Successful',
            'status_code' => 200
        ], 200);
    }
}
