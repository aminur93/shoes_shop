<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Cart;
use App\Category;
use App\Logo;
use App\Product;
use App\ProductImageGallery;
use App\ProductStock;
use App\Slider;
use Illuminate\Http\Request;

class KitesController extends Controller
{
    public function index()
    {
        $category = Category::latest()->get();

        $slider = Slider::latest()->get();

        $latest_category = Category::latest()->take(2)->get();

        $sell_category = Category::take(3)->get();

        $product = Product::where('publish','=',1)->latest()->take(10)->get();

        $feature_product = Product::where('feature','=',1)->latest()->take(10)->get();

        $new_arrival = Product::where('new_arrival','=',1)->latest()->take(10)->get();

        $logo = Logo::where('status','=',1)->latest()->first();

        $banner = Banner::where('status','=',1)->latest()->first();

        return view('welcome', compact('category','logo','banner','slider', 'latest_category','sell_category','product','feature_product','new_arrival'));
    }

    public function details($id)
    {
        $product = Product::findOrFail($id);

        $product_gallery = ProductImageGallery::where('product_id','=',$product->id)->latest()->get();

        $product_stock = ProductStock::where('product_id','=',$product->id)->latest()->get();

        //dd($product_gallery);

        $related_product = Product::where('category_id','=',$product->category_id)->where('id','!=',$product->id)->latest()->take(6)->get();

        $logo = Logo::where('status','=',1)->latest()->first();

        $banner = Banner::where('status','=',1)->latest()->first();

        return view('details', compact('product','logo','banner','related_product','product_gallery','product_stock'));
    }

    public function getQuantity(Request $request)
    {
        if (isset($_POST['product_id']) && isset($_POST['product_size_id']))
        {
            $product_id = $_POST['product_id'];

            $product_size_id = $_POST['product_size_id'];

            $option = '';

            $query = ProductStock::where('id','=',$product_size_id)->where('product_id','=',$product_id)->first();

            $option .= "<option value=''>Select Quantity</option>";

            for ($i=1; $i<=$query->quantity; $i++){
                $option .= "<option value=" . $i . ">" . $i . "</option>";
            }

            echo $option;
        }
    }
}
