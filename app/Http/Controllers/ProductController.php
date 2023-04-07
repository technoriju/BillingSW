<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminated\Support\Facades\Session;
//use Illuminated\Support\Facades\DB;
use App\Models\Product;
use App\Models\StockRecord;
use App\Models\Category;
use App\Models\Seller;
use DB;
class ProductController extends MyController
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $data = Product::join('categories','categories.category_id','=','products.category_id')
                ->select('products.*', 'categories.category_name')
                ->orderBy('product_id','DESC')
                ->get();
    //    r($data);
    //    die;
       if($data == false): $data = []; endif;
       return view('product_stock',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data2 = parent::Category();
        $seller = parent::Seller();
        $url = url('/product');
        return view('product_add',compact('data2','seller','url'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'category_id' => 'required',
                'sku_code' => 'nullable|unique:products,sku_code',
                'product_name' => 'required',
                'purchase_price' => 'required|numeric',
                'mrp_price' => 'numeric',
                'sell_price' => 'numeric',
                'qty' => 'integer'
            ]);

        if($validator->fails()):
            return redirect()->back()->withErrors($validator)->withInput();
        endif;

        $product = new Product;
        $product->category_id = $request->category_id;
        $product->subcategory_id = $request->subcategory_id ?? 0;
        $product->sku_code = $request->sku_code ?? '';
        $product->seller_id = $request->seller_id ?? 0;
        $product->product_name = $request->product_name;
        $product->qty = $request->qty ?? 0;
        $product->purchase_price = $request->purchase_price ?? 0;
        $product->mrp_price = $request->mrp_price ?? 0;
        $product->sell_price = $request->sell_price ?? 0;
        $product->created_at = curDate();
        $product->updated_at = curDate();
        $data = $product->save();
        $product_id = $product->product_id;

        if($product_id>0):
            parent::StockRecord( $request, 0, $product_id);
        endif;

        if($data):
            $request->session()->flash('success', 'Product data Uploaded');
            return redirect('product/create');
        else:
            $request->session()->flash('error', 'Please try again');
            return redirect()->back();
        endif;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data2 = parent::Category();
        $seller = parent::Seller();
        $data = Product::find($id);
        $data3 = '';
        if($data->subcategory_id != 0)
          $data3 = parent::subCate($data->subcategory_id);

        $url = url('/product')."/".$id;
        if($data == false) { $data = []; }
        return view('product_add',compact('data','url','data2','data3','seller'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),
            [
                'category_id' => 'required',
                'sku_code' => 'required|unique:products,sku_code,'.$id.',product_id',
                'product_name' => 'required',
                'purchase_price' => 'required|numeric',
                'sell_price' => 'numeric',
                'qty' => 'integer'
            ]);

        if($validator->fails()):
            return redirect()->back()->withErrors($validator)->withInput();
        endif;

        $product = Product::find($id);
        $product->category_id = $request->category_id;
        $product->subcategory_id = $request->subcategory_id ?? 0;
        $product->sku_code = $request->sku_code;
        $product->seller_id = $request->seller_id ?? 0;
        $product->product_name = $request->product_name;
        $product->qty += $request->qty;
        $product->purchase_price = $request->purchase_price ?? 0;
        $product->sell_price = $request->sell_price ?? 0;
        $product->mrp_price = $request->mrp_price ?? 0;
        $product->updated_at = curDate();
        $data = $product->save();

        if($data):
            parent::StockRecord( $request, 1, $id );

            $request->session()->flash('success', 'Product data Updated');
            return redirect('/product');
        else:
            $request->session()->flash('error', 'Please try again');
            return redirect()->back();
        endif;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $data = $product->delete();
        if($data == true)
        {
            parent::StockRecord4( $product, 2 );
            echo "success";
        }
        else
        {
             echo "failed";
        }
    }

    public function subcat(Request $request)
    {
        $data = parent::Subcategory($request->id);
        echo $data;
    }
}
