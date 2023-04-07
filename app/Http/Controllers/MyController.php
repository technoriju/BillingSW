<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StockRecord;
use App\Models\Category;
use App\Models\Seller;
use App\Models\Customer;
class MyController extends Controller
{
    public function Category()
    {
      return $data = Category::select('category_id','category_name')->where(['status'=>1,'parent_id'=>0])->get();
    }
    public function subCate($id)
    {
      return $data = Category::select('category_id','category_name')->where(['category_id'=>$id])->first();
    }
    public function Subcategory($category_id)
    {
        $data = Category::select('category_id','category_name')
                 ->where(['parent_id'=>$category_id,'status'=>1])
                 ->get();
        if(isset($data) && count($data)>0)
        {
            $subcat ="<option value='0'> Choose any one </option>";
            foreach($data as $val):
                $subcat.= "<option value='$val->category_id'>$val->category_name</option>";
            endforeach;

        } else {
            $subcat ="<option value='0'> No Sub Category was found. </option>";
        }
        return $subcat;
    }

    public function Seller()
    {
      return $data = Seller::select('seller_id','seller_name')->get();
    }

    public function Customer()
    {
      return $customer = Customer::select('customer_id','name')->get();
    }

    public function Product()
    {
      return $data = Product::select('product_id','product_name')->get();
    }

    public function StockRecord(Request $request, $action, $product_id = 0, $qty = NULL)
    {
        $qty = ($qty == NULL) ? $request->qty : $qty;
        if($action == 0)
           $remark = "Record inserted";
        elseif($action == 1)
           $remark = "Record Updated";
        elseif($action == 2)
           $remark = "Record Deleted";
        elseif($action == 4)
           $remark = "Delete Invoice Product";

        $stockr = new StockRecord;
        $stockr->category_id = $request->category_id ?? 0;
        $stockr->subcategory_id = $request->subcategory_id ?? 0;
        $stockr->sku_code = $request->sku_code ?? 0;
        $stockr->seller_id = $request->seller_id ?? 0;
        $stockr->product_name = $request->product_name ?? '';
        $stockr->qty = $qty ?? 0;
        $stockr->purchase_price = $request->purchase_price ?? 0;
        $stockr->mrp_price = $request->mrp_price ?? 0;
        $stockr->sell_price = $request->sell_price ?? 0;
        $stockr->product_id = $product_id ?? 0;
        $stockr->action = $action;
        $stockr->remark = $remark;
        $stockr->created_at = curDate();
        $stockr->updated_at = curDate();
        $stockr->save();
    }

    public function StockRecord2(Request $request, $action)
    {
        if($action == 3)
           $remark = "Sales Invoice Product";
        elseif($action == 4)
           $remark = "Delete Invoice Product";

            for($i = 0; $i< count($request->product_id); $i++):
                $sale_product = [
                       'category_id' => 0,
                       'subcategory_id' => 0,
                       'sku_code' => '',
                       'seller_id' => 0,
                       'product_name' => '',
                        'product_id' => $request->product_id[$i],
                        'qty' => $request->qnt[$i],
                        'purchase_price' => $request->purchase_price[$i],
                        'mrp_price' => $request->mrp_price[$i],
                        'sell_price' => $request->price[$i],
                        'action' => $action,
                        'remark' => $remark,
                        'created_at' => curDate(),
                        'updated_at' => curDate()
                    ];
                $rsp = StockRecord::insert($sale_product);
            endfor;
    }

    public function StockRecord3($request, $action)
    {
        if($action == 4)
           $remark = "Delete Invoice Product";

                $sale_product = [
                       'category_id' => 0,
                       'subcategory_id' => 0,
                       'sku_code' => '',
                       'seller_id' => 0,
                       'product_name' => '',
                        'product_id' => $request['product_id'] ?? 0,
                        'qty' => $request['qty'],
                        'purchase_price' => 0,
                        'mrp_price' => $request['mrp_price'] ?? 0,
                        'sell_price' => $request['sell_price'] ?? 0,
                        'action' => $action,
                        'remark' => $remark,
                        'created_at' => curDate(),
                        'updated_at' => curDate()
                    ];
                $rsp = StockRecord::insert($sale_product);

    }
    
    public function StockRecord4($request, $action)
    {
        if($action == 2)
           $remark = "Record Deleted";

                $sale_product = [
                       'category_id' => 0,
                       'subcategory_id' => 0,
                       'sku_code' => '',
                       'seller_id' => 0,
                       'product_name' => $request['product_name'] ?? '',
                        'product_id' => $request['product_id'] ?? 0,
                        'qty' => $request['qty'],
                        'purchase_price' => 0,
                        'mrp_price' => $request['mrp_price'] ?? 0,
                        'sell_price' => $request['sell_price'] ?? 0,
                        'action' => $action,
                        'remark' => $remark,
                        'created_at' => curDate(),
                        'updated_at' => curDate()
                    ];
                $rsp = StockRecord::insert($sale_product);

    }
}
