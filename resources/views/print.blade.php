@extends('layouts.common-template')
@push('title')
    <title>Shuvecha - Sales Invoice Print</title>
@endpush
@push('style')
    <style>
        #panel {
            padding: 10px;
            display: none;
        }
    </style>
@endpush

@section('body')

    <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <h5>Print Bill</h5>
                                                </div>
                                            </div>
                                        </div>
                                        @foreach ($data as $sale)

                                        <div class="card-body">
                                            <div id="printableArea">
                                                <div class="print-main-div">
                                                    <h5 class="text-center">TAX INVOICE</h5>
                                                    <h4 class="text-center">Shuvecha Retail Stores</h4>
                                                    <hr>
                                                    <!--<h6 class="text-center">Authorised Distributor of: Bengal Bevarages Pvt.-->
                                                    <!--    Ltd.</h6>-->
                                                    <table class="bil-table">
                                                        <tbody>
                                                            <tr>
                                                                <td rowspan="4">
                                                                    <p>Seller :</p>
                                                                    <strong>Shuvecha Retail Stores</strong>
                                                                    <p>Propiter: Soma Bhandary</p>
                                                                    <p>Saharaberia,Joypur,HOWRAH -711401</p>
                                                                    <p>PH: 9732570661</p>
                                                                    <p>E-mail: avijit.bhandary@gmail.com</p>
                                                                </td>
                                                                <td>
                                                                    Invoice No :
                                                                    <strong>SUV - {{$sale->invoice_no}}</strong>
                                                                </td>
                                                                <td>
                                                                    Date :
                                                                    <strong>{{ date('d-m-Y',strtotime($sale->date)) }}</strong>
                                                                </td>

                                                                <tr>
                                                                    <td>
                                                                        Customer Name <p></p>
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <p>{{uppercase($sale->customer['name']) ?? 'Buyer'}}</p>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        Customer Phone <p></p>
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <p>{{$sale->customer['phone'] ?? ''}}</p>
                                                                    </td>
                                                                </tr>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                    <table class="bil-table addcss">
                                                        <thead>
                                                            <tr>
                                                                <th width="5%">#</th>
                                                                <th>Products</th>
                                                                <th>Quantity</th>
                                                                <th>MRP. Price</th>
                                                                <th>Sale. Price</th>
                                                                <th>Sub total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php $count = 0 @endphp
                                                           @foreach($sale->sale_products as $product)
                                                            @php
                                                               $count++;
                                                               $qp = productNQP($product->product_id)
                                                            @endphp
                                                            <tr>
                                                                <td>{{$count}}</td>
                                                                <td>{{ $qp->product_name }}</td>
                                                                <td>{{$product->qty}}</td>
                                                                <td>{{$product->mrp_price}} /-</td>
                                                                <td>{{$product->sales_price}} /-</td>
                                                                <td>{{$product->total_price}} /-</td>
                                                            </tr>
                                                           @endforeach
                                                           @if($sale->discount>0)
                                                           <tr>
                                                            <th colspan="5">Discount</th>
                                                            <th style="font-size: 20px; font-weight: 20px;"> -{{$sale->discount}} /-</th>
                                                           </tr>
                                                           @endif
                                                           <tr>
                                                            <th colspan="5">Total Amount</th>
                                                            <th style="font-size: 20px; font-weight: 20px;">{{$sale->total}} /-</th>
                                                           </tr>
                                                        </tbody>
                                                        <tbody>

                                                        </tbody>
                                                    </table><br>
                                                    @php
                                                    $number = $sale->total;
                                                    $no = floor($number);
                                                    $point = round($number - $no, 2) * 100;
                                                    $hundred = null;
                                                    $digits_1 = strlen($no);
                                                    $i = 0;
                                                    $str = [];
                                                    $words = ['0' => '', '1' => 'One', '2' => 'Two', '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six', '7' => 'Seven', '8' => 'Eight', '9' => 'Nine', '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve', '13' => 'Thirteen', '14' => 'Fourteen', '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen', '18' => 'Eighteen', '19' => 'Nineteen', '20' => 'Twenty', '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty', '60' => 'Sixty', '70' => 'Seventy', '80' => 'Eighty', '90' => 'Ninety'];
                                                    $digits = ['', 'Hundred', 'Thousand', 'Lakh', 'Crore'];
                                                    while ($i < $digits_1) {
                                                        $divider = $i == 2 ? 10 : 100;
                                                        $number = floor($no % $divider);
                                                        $no = floor($no / $divider);
                                                        $i += $divider == 10 ? 1 : 2;
                                                        if ($number) {
                                                            $plural = ($counter = count($str)) && $number > 9 ? 's' : null;
                                                            $hundred = $counter == 1 && $str[0] ? ' and ' : null;
                                                            $str[] = $number < 21 ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
                                                        } else {
                                                            $str[] = null;
                                                        }
                                                    }
                                                    $str = array_reverse($str);
                                                    $result = implode('', $str);
                                                    $points = $point ? '.' . $words[$point / 10] . ' ' . $words[($point = $point % 10)] : '';
                                                    $pointt = $points ? $points . ' Paise' : null;
                                                    @endphp
                                                    <h6> Amount (in words): * <?php echo $result . 'Rupees  ' . $pointt; ?></h6>


                                                    <div class="signa">
                                                        <p><strong><b>Declaration</b></strong><br>
                                                            <i>বিকৃত মাল এক সপ্তাহের মধ্যে ফেরত দিতে হবে না হলে ফেরত নেয়া হবে না,</i> <br>
                                                            এবং স্টিকার এবং প্যাকেট ঠিকঠাক করে আনতে হবে।<br> Price of the
                                                            goods described and that all particulars are true and correct.
                                                        </p>
                                                        <h4><span>Shuvecha Retail Stores</span>Signature</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach

                                    </div>


                                    <div class="print-div">
                                        <input type="button" class="btn btn-md btn-success"
                                            onclick="printDiv('printableArea')" value="Print" />
                                        <input type="button" class="btn btn-md btn-success"
                                            onclick="document.location='report.php?page=1'" value="Back" />
                                    </div>
                                    <script>
                                        function printDiv(divName) {
                                            var printContents = document.getElementById(divName).innerHTML;
                                            var originalContents = document.body.innerHTML;

                                            document.body.innerHTML = printContents;

                                            window.print();

                                            document.body.innerHTML = originalContents;
                                        }
                                    </script>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- [ Main Content ] end -->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ url('assets/js/script.js') }}"></script>
@endpush
