@extends('layouts.common-template')
    @push('title')
        <title>Shuvecha - Sales Invoice</title>
    @endpush
    @push('style')
        <style>
            #panel { padding: 10px; display: none; }
        </style>
    @endpush

@section('body')

   @isset($inv)
       @foreach ($inv as $val)
       @endforeach
   @endisset

    <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- [ Main Content ] start -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <form id="idForm" action="{{$url}}" method="post">
                                            @csrf
                                            @if((Request::segment(3) !== null) && Request::segment(4) == 'edit')
                                               {{method_field('PUT')}}
                                            @endif
                                            <div class="card-header">
                                                <div class="row">
                                                    <div class="col-sm-2">
                                                        <h5>Add Bill</h5>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <div class="input-group">
                                                            <input type="text" id="invoice_no" name="invoice_no" value="{{ isset($val->invoice_no)? $val->invoice_no : (isset($invoice_no) ? $invoice_no + 1 : 1) }}" class="form-control" placeholder="Invoice No" aria-label="Invoice No" aria-describedby="basic-addon2" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="input-group">
                                                            <input type="text" id="customer_name" name="customer_name" class="form-control" aria-describedby="basic-addon2" placeholder="Customer Name" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="input-group">
                                                            <input type="text" id="customer_phone" name="customer_phone" class="form-control" aria-describedby="basic-addon2" placeholder="Customer Phone">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="input-group">
                                                            <input type="date" id="invoice_date" required name="invoice_date" value="{{ $val->date ?? date('Y-m-d')}}" class="form-control" aria-describedby="basic-addon2">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if(isset($errors) && count($errors)>0)
                                            <div class="alert alert-danger" role="alert">{{$errors->first()}}</div>
                                            @endif
                                            @if(session('error')!== null)
                                            <div class="alert alert-danger" role="alert">{{session('error')}}</div>
                                            @endif
                                            <div class="card-body">
                                                {{-- <div class="text-center mb-3">
                                                    <button class="btn btn-md btn-info" id="bu1">Free Product</button>

                                                    <button class="btn btn-md btn-danger" id="bu2">Discount</button>
                                                </div> --}}
                                                <table id="myTable" class="bill-table table order-list table-responsive">
                                                    <thead>
                                                        <tr>
                                                            <td>Product Name</td>
                                                            <td>Quantity</td>
                                                            <td>MRP Rate</td>
                                                            <td>Rate</td>
                                                            <td>Total Amount</td>
                                                            <td></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="countrow">
                                                        @if(isset($val->sale_products) && count($val->sale_products)>0)
                                                          @php $count = 100 @endphp
                                                        @foreach($val->sale_products as $p)
                                                          @php
                                                           $count++;
                                                           $qp = productNQP($p->product_id);
                                                          @endphp
                                                        <tr>
                                                            <td><select class="form-control" name="product_id[]" id="name{{$count}}" required onchange="Total(this.value,getAttribute('id'));">
                                                                    <option value="">Select any Product</option>
                                                                    @if(isset($data) && count($data)>0)
                                                                    @foreach ($data as $pro)
                                                                      <option value="{{ $pro->product_id }}" {{($pro->product_id == $p->product_id)? 'selected' : ''}}>{{$pro->product_name}}</option>
                                                                    @endforeach
                                                                @endif
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" name="qnt[]" id="qnt{{$count}}" placeholder="Quantity" value="{{$p->qty}}" class="form-control" onkeyup="Calcu(this.id);" required />
                                                                <input type="hidden" id="hid_qnt{{$count}}" value="{{$qp->qty}}">
                                                                <input type="hidden" name="sales_product_id[]" value="{{$p->sales_product_id}}">
                                                            </td>
                                                            <td>
                                                                <input type="text" name="mrp_price[]" id="mrp{{$count}}" value="{{$p->mrp_price}}" placeholder="MRP Price" class="form-control"/>
                                                            </td>
                                                            <td>
                                                                <input type="text" name="price[]" id="price{{$count}}" value="{{$p->sales_price}}" placeholder="Price" class="form-control" onkeyup="Calcu(this.id);"/>
                                                                <input type="hidden" name="purchase_price[]" id="hid_price{{$count}}" value="{{$qp->purchase_price}}">
                                                            </td>
                                                            <td><input type="text" name="tprice[]" id="tprice{{$count}}" value="{{$p->total_price}}" placeholder="Total Amount" class="form-control Amount"/></td>
                                                        </tr>
                                                        @endforeach
                                                        @endif
                                                        <tr>
                                                            <td><select class="form-control" name="product_id[]" id="name0" {{ (Request::segment(4) == null) ? 'required': ''}} onchange="Total(this.value,getAttribute('id'));">
                                                                    <option value="">Select any Product</option>
                                                                    @if(isset($data) && count($data)>0)
                                                                    @foreach ($data as $pro)
                                                                      <option value="{{$pro->product_id}}">{{$pro->product_name}}</option>
                                                                    @endforeach
                                                                @endif
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" name="qnt[]" id="qnt0" placeholder="Quantity" class="form-control" onkeyup="Calcu(this.id);" {{ (Request::segment(4) == null) ? 'required': ''}} />
                                                                <input type="hidden" id="hid_qnt0">
                                                            </td>
                                                            <td>
                                                                <input type="text" name="mrp_price[]" id="mrp0" placeholder="MRP Price" class="form-control"/>
                                                            </td>
                                                            <td>
                                                                <input type="text" name="price[]" id="price0" placeholder="Price" class="form-control" onkeyup="Calcu(this.id);"/>
                                                                <input type="hidden" id="hid_price0" name="purchase_price[]">
                                                            </td>
                                                            <td><input type="text" name="tprice[]" id="tprice0" value="0" placeholder="Total Amount" class="form-control Amount"/></td>
                                                            <td><a class="deleteRow"></a>
                                                                <input type="button" class="btn btn-md btn-success" id="addrow" value="Add Row" />
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                                <table class="table discount-table table-responsive">
                                                    <tbody>
                                                        {{-- <tr id="sh11">
                                                            <td><select name="free_name" placeholder="Product Name" class="form-control">
                                                                    <option value="">Choose Free Product</option>
                                                                </select>
                                                            </td>
                                                            <td><input type="text" name="free_qnt" placeholder="Quantity" class="form-control" /></td>
                                                            <td><input type="text" name="" placeholder="00" class="form-control" value="00" /></td>
                                                        </tr> --}}
                                                        <tr id="sh12">
                                                            <td></td>
                                                            <td>Discount</td>
                                                            <td><input type="text" name="discount" id="discounts" placeholder="Amount" class="form-control" value="{{ $val->discount ?? 0 }}" onkeyup="everyTotal();"/></td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td>Total Amount</td>
                                                            <td><input type="text" name="totalamt" id="totalamt" placeholder="Total Amount"  class="form-control" value="{{ $val->total ?? 0 }}"/></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>


                                            <div class="text-center mb-5">
                                                <button class="btn btn-md btn-success" name="" id="printid" type="submit" onclick="return Fullpayment();">Print</button>
                                            </div>
                                            {{-- <div class="text-center mb-5">
                                               <button class="btn btn-md btn-info" name="payment_status[]" value="f" id="button1" onclick="return Fullpayment();">Full Payment</button>

                                                <button class="btn btn-md btn-warning" id="button2">Step Payment</button>

                                                <button class="btn btn-md btn-danger" name="payment_status[]" value="d" id="button3" type="submit" onclick="return Fullpayment();">Due</button>
                                                <button class="btn btn-md btn-success" name="payment_status[]" value="p" id="button3" type="submit" onclick="return Fullpayment();">Print</button>
                                                <div id="panel" class="w-100">

                                                    <div class="pice-form">
                                                        <input type="text" name="due_payment" class="form-control w-25" placeholder="Price" value="0">
                                                        <button name="payment_status[]" value="s" class="btn btn-md btn-success" onclick="return Fullpayment();">Submit</button>
                                                   </div>
                                                </div>
                                            </div> --}}
                                        </form>

                                    </div>



                                </div>
                            </div>
                            <!-- [ Main Content ] end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ url('assets/js/select-search.js') }}"></script>
    <script>
        $('#sh11').hide();
       // $('#sh12').hide();
        $("#bu1").click(function(e) {
            e.preventDefault();
            $('#sh11').slideToggle("slow");
        });
        $("#bu2").click(function(e) {
            e.preventDefault();
            $('#sh12').slideToggle("slow");
        });

        $(document).ready(function() {
            var counter = 1;

            $("#addrow").on("click", function() {
                var newRow = $("<tr>");
                var cols = "";

                //$("#qnt0").clone().appendTo("#qnt"+counter);
                cols += '<td><select class="form-control" name="product_id[]" id="name' + counter + '" onchange="Total(this.value,this.id);"></select></td>';
                cols += '<td><input type="text" class="form-control" placeholder="Quantity" id="qnt' + counter + '" name="qnt[]" onkeyup="Calcu(this.id);" required/><input type="hidden" id="hid_qnt' + counter + '"></td>';
                cols += '<td><input type="text" name="mrp_price[]" id="mrp' +counter+ '" placeholder="MRP Price" class="form-control"/></td>';
                cols += '<td><input type="text" class="form-control" placeholder="Price" id="price' + counter + '" name="price[]" onkeyup="Calcu(this.id);"/><input type="hidden" id="hid_price' + counter + '" name="purchase_price[]"></td>';
                cols += '<td><input type="text" class="form-control Amount" placeholder="Total price" id="tprice' + counter + '" name="tprice[]"/></td>';
                cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>';
                newRow.append(cols);
                $("table.order-list").append(newRow);

                var $options = $("#name0 > option").clone();
                $('#name'+counter).append($options);

                counter++;
            });

            $("table.order-list").on("click", ".ibtnDel", function(event) {
                $(this).closest("tr").remove();
                counter -= 1
                everyTotal();
            });
        });

        // function calculateRow(row) {
        //     var price = +row.find('input[name^="price"]').val();
        // }

        // function calculateGrandTotal() {
        //     var grandTotal = 0;
        //     $("table.order-list").find('input[name^="tprice"]').each(function() {
        //         grandTotal += +$(this).val();
        //     });
        //     $("#totalamt").text(grandTotal.toFixed(2));
        // }


        function everyTotal()
        {
            $("#totalamt").val(0);
                $(".Amount").each(function () {
                    if (this.value != "")
                    var tot = parseFloat($("#totalamt").val()) + parseFloat($(this).val());
                    $("#totalamt").val(tot);
                });
            Discount();
        }

        function Discount()
        {
            if($("#discounts").val() != '')
            {
                $("#totalamt").val(parseFloat($("#totalamt").val()) - parseFloat($("#discounts").val()));
            }
        }

        function Total(val, val2) {
            var suffix = val2.match(/\d+/);
            $.ajax({
                type: "POST",
                url: "/sales/fetchpriceqty",
                data: { 'product_id': val,'_token':"{{ csrf_token() }}" },
                dataType: "JSON",
                success: function(data) {
                    $("#price" + suffix).val(data.sell_price);
                    $("#mrp" + suffix).val(data.mrp_price);
                    $("#hid_price" + suffix).val(data.purchase_price);
                    $("#hid_qnt" + suffix).val(data.qty);
                    $("#qnt" + suffix).attr('placeholder',"Available Qty : "+data.qty);
                }
            })
        }

        function Calcu(val2)
        {
            var suffix = val2.match(/\d+/);

            var total_qty = parseInt($("#hid_qnt" + suffix).val());
            var qty = parseInt($('#qnt' + suffix).val());
           // alert(total_qty);
            var purchase_price = parseFloat($('#hid_price' + suffix).val());
            var price = parseFloat($('#price' + suffix).val());

            if(total_qty < qty)
            {
                $('#qnt' + suffix).attr('style','border:4px solid red');
                $("#printid").prop('disabled', true);
            }
            else if(purchase_price > price)
            {
                $('#price' + suffix).attr('style','border:4px solid red');
                $("#printid").prop('disabled', true);
            }
            else
            {
                $('#qnt' + suffix).attr('style','');
                $('#price' + suffix).attr('style','');
                $("#printid").prop('disabled', false);
            }

            var total = qty * price;
            var total2 = total.toFixed(2);
            $('#tprice' + suffix).val(total2);
            everyTotal();
        }


        // $("#button2").on('click', function(e) {
        //     e.preventDefault();
        //     $("#panel").slideToggle("slow");
        // });

        function Fullpayment() {
            var x = confirm("Are you sure want to Submit?");
            if (x) {
                return true;
            } else {
                return false;
            }
        }

    </script>
@endpush

