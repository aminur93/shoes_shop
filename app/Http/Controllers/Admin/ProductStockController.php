<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Product;
use App\ProductStock;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ProductStockController extends Controller
{
    public function index()
    {
        $product = Product::latest()->get();
        return view('admin.product_stock.index',compact('product'));
    }

    public function getData()
    {
        $product_stock = DB::table('product_stocks')
                            ->select(
                                'product_stocks.*',
                                'products.name as name'
                            )
                            ->leftJoin('products','product_stocks.product_id','=','products.id')
                            ->orderBy('product_stocks.id','desc')
                            ->get();

        return DataTables::of($product_stock)
            ->addIndexColumn()

            ->editColumn('action', function ($product_stock) {
                $return = "<div class=\"btn-group\">";
                if (!empty($product_stock->id))
                {
                    $return .= "
                            <a href=\"/product_stock/edit/$product_stock->id\" style='margin-right: 5px' class=\"btn btn-sm btn-warning\"><i class='fa fa-edit'></i></a>
                            ||
                              <a rel=\"$product_stock->id\" rel1=\"product_stock/destroy\" href=\"javascript:\" style='margin-right: 5px' class=\"btn btn-sm btn-danger deleteRecord \"><i class='fa fa-trash'></i></a>
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
        return view('admin.product_stock.create');
    }

    public function store(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $product_id = count($request->product_id);

            for ($i=0; $i<$product_id; $i++){
                DB::table('product_stocks')->insert([
                    'product_id' => $request->product_id[$i],
                    'size' => $request->size[$i],
                    'quantity' => $request->quantity[$i],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }

            return response()->json([
                'flash_message_success' => 'Product stock added successful',
                'status_code' => 200
            ],Response::HTTP_OK);
        }
    }

    public function edit($id)
    {
        $product = Product::latest()->get();
        $product_stock = ProductStock::findOrFail($id);
        return view('admin.product_stock.edit', compact('product','product_stock'));
    }

    public function update(Request $request, $id)
    {
        if ($request->isMethod('post'))
        {
            DB::beginTransaction();

            try{

                //update product Stock

                $product_stock = ProductStock::findOrFail($id);

                $product_stock->product_id = $request->product_id;
                $product_stock->size = $request->size;
                $product_stock->quantity = $request->quantity;

                $product_stock->save();

                DB::commit();

                return \response()->json([
                    'flash_message_success' => 'Product Stock updated successful',
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
        $product_stock = ProductStock::findOrFail($id);

        $product_stock->delete();

        return \response()->json([
            'flash_message_success' => 'Product Stock delete successful',
            'status_code' => 200
        ],Response::HTTP_OK);
    }
}
