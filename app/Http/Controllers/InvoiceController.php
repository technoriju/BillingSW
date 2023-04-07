<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminated\Support\Facades\Session;
use App\Models\{Product,Category,Seller,SaleReport,SaleProduct,Customer};
use Carbon\Carbon;
use DB;
class InvoiceController extends MyController
{

    public function index()
    {
       $invoice_no = SaleReport::max('invoice_no');
       $data = parent::Product();
       $customer = parent::Customer();
       if($data != true) $data = [];
       $url = url('/sales/invoice');
       return view('sales_invoice',compact('data','url','invoice_no','customer'));
    }


    public function fetchpriceqty(Request $request)
    {
        $data = Product::select('qty','sell_price','purchase_price','mrp_price')->where('product_id',$request->product_id)->first();
        $data2['qty'] = $data->qty;
        $data2['mrp_price'] = $data->mrp_price;
        $data2['sell_price'] = $data->sell_price;
        $data2['purchase_price'] = $data->purchase_price;
        echo json_encode($data2);
    }

    public function invoice(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
           'customer_name' => 'required',
           'customer_phone' => 'nullable|regex:/[6-9]{1}[0-9]{9}/',
           'invoice_no' => 'required|unique:sale_reports,invoice_no',
           'product_id' => 'required'
        ]);

        if($validator->fails()):
            return redirect()->back()->withErrors($validator)->withInput();
        endif;

        $customer_id = Customer::insertGetId(['name'=>$request->customer_name,'phone'=>$request->customer_phone]);

        $sales_report = new SaleReport;
        $sales_report->invoice_no = $request->invoice_no;
        $sales_report->date = $request->invoice_date;
        $sales_report->total = $request->totalamt;
        $sales_report->discount = $request->discount;
        $sales_report->customer_id = $customer_id;
        $sales_report->created_at = curDate();
        $sales_report->updated_at = curDate();
        $sales_report->save();
        $sales_report_id = $sales_report->sales_report_id;

        $total_purchase = $total_purchase2 = 0;

        for($i = 0; $i< count($request->product_id); $i++):
            if($request->product_id[$i] != ''):
                $total_purchase += $request->qnt[$i] * $request->purchase_price[$i];
                $total_purchase2 = $request->qnt[$i] * $request->purchase_price[$i];
                $profit = $request->tprice[$i] - $total_purchase2;
                $sale_product = [
                        'product_id' => $request->product_id[$i],
                        'qty' => $request->qnt[$i],
                        'mrp_price' => $request->mrp_price[$i],
                        'sales_price' => $request->price[$i],
                        'total_price' => $request->tprice[$i],
                        'sales_report_id' => $sales_report_id,
                        'profit' => $profit,
                        'created_at' => curDate(),
                        'updated_at' => curDate()
                    ];
                $rsp = SaleProduct::insert($sale_product);
                if($rsp==1):
                Product::where('product_id',$request->product_id[$i])->decrement('qty', $request->qnt[$i]);
                else:
                    $request->session()->flash('error', 'Database error! Try again');
                    return redirect('sales/invoice');
                endif;
            endif;
        endfor;
        parent::StockRecord2( $request, 3 );

        SaleReport::where('sales_report_id',$sales_report_id)->update(['profit'=>$request->totalamt-$total_purchase]);

        return redirect('sales/print/'.$sales_report_id);
    }

    public function print($id)
    {
        $data = SaleReport::with(['customer','sale_products'])->where('sales_report_id',$id)->get();
        return view('print',compact('data'));
    }

    public function transaction()
    {
        $data = SaleReport::with(['customer'])->orderBy('sales_report_id','DESC')->get();
        return view('transaction',compact('data'));
    }

    public function edit($id)
    {
       $inv = SaleReport::with(['customer','sale_products'])->where('sales_report_id',$id)->get();
       $data = parent::Product();
       $customer = parent::Customer();
       if($data != true) $data = [];
       $url = url('/sales/invoice/'.$id);
       return view('sales_invoice',compact('data','url','inv','customer'));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        // die;
        $validator = Validator::make($request->all(),
        [
           'customer_id' => 'required',
            // 'customer_phone' => 'required_with:customer_name|regex:/[6-9]{1}[0-9]{9}/',
           'product_id' => 'required'
        ]);

        if($validator->fails()):
            return redirect()->back()->withErrors($validator)->withInput();
        endif;

        $sales_report = SaleReport::find($id);
        $sales_report->customer_id = $request->customer_id;
        $sales_report->date = $request->invoice_date;
        $sales_report->total = $request->totalamt;
        $sales_report->discount = $request->discount;
        $sales_report->updated_at = curDate();
        $sales_report->save();

        for($i = 0; $i< count($request->product_id); $i++):
            if($request->product_id[$i] != ''):
                $sale_product = [
                        'product_id' => $request->product_id[$i],
                        'qty' => $request->qnt[$i],
                        'mrp_price' => $request->mrp_price[$i],
                        'sales_price' => $request->price[$i],
                        'total_price' => $request->tprice[$i],
                        'sales_report_id' => $id,
                        'updated_at' => curDate()
                    ];
                if(isset($request->sales_product_id[$i]))
                    $rsp = SaleProduct::where('sales_product_id',$request->sales_product_id[$i])->update($sale_product);
                elseif($request->product_id[$i] != '')
                    $rsp =SaleProduct::insert($sale_product);

                if($rsp==1):
                    Product::where('product_id',$request->product_id[$i])->decrement('qty', $request->qnt[$i]);
                else:
                    $request->session()->flash('error', 'Database error! Try again');
                    return redirect('sales/invoice/'.$id);
                endif;
            endif;
        endfor;

        return redirect('sales/print/'.$id);
    }

    public function destroy($id)
    {

        $fromSubYear = Carbon::now()->subMonths(1);
        //DB::enableQueryLog();
        $data = SaleReport::select('sales_report_id')->where('sales_report_id',$id)->whereBetween('date', [$fromSubYear, Carbon::now()])->first();
        //dd(DB::getQueryLog());

        if(isset($data->sales_report_id) && $data->sales_report_id >= 1):

            $sales_product_id = SaleProduct::select('sales_product_id','product_id','qty','mrp_price','sales_price')->where('sales_report_id',$id)->get();

            if(isset($sales_product_id)):
                foreach($sales_product_id as $val):

                    $request=[
                        'product_id' => $val->product_id,
                        'qty' => $val->qty,
                        'mrp_price' => $val->mrp_price,
                        'sell_price' => $val->sales_price,
                    ];
                    parent::StockRecord3( $request, 4 );

                    $product = SaleProduct::find($val->sales_product_id);
                    $data = $product->delete();

                    if($data == 1)
                        Product::where('product_id',$val->product_id)->increment('qty', $val->qty);

                endforeach;
            endif;

            if($data==1):
                $sales = SaleReport::find($id);
                $data = $sales->delete();
            endif;

        endif;

        if($data == true) { echo "success"; } else { echo "failed"; }
    }
}
