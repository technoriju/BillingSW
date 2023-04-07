@extends('layouts.common-template')
@push('title')
    <title>Suvecha - Product Data</title>
@endpush
@section('body')
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
                                        <div class="card-header">
                                            <h5>Add Product</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="{{$url}}" method="post">
                                                @csrf
                                                @if((Request::segment(3) !== null) && Request::segment(3) == 'edit')
                                                  {{method_field('PUT')}}
                                                @endif
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        @if(isset($errors) && count($errors)>0)
                                                           <div class="alert alert-danger" role="alert">{{$errors->first()}}</div>
                                                        @endif
                                                        @if(session('error')!== null)
                                                            <div class="alert alert-danger" role="alert">{{session('error')}}</div>
                                                        @endif
                                                        @if(session('success')!== null)
                                                            <div class="alert alert-success" role="alert">{{session('success')}}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Category (*)</label>
                                                            <select name="category_id" class="form-control" required onchange="Subcat(this.value);">
                                                                <option value="">Choose any Category</option>
                                                                @if(isset($data2) && count($data2)>0)
                                                                    @foreach ($data2 as $val)
                                                                      <option value="{{$val->category_id}}" {{ (old('category_id') == $val->category_id)? 'selected' : ((isset($data) && ($data->category_id == $val->category_id)) ? 'selected' : '')}}>{{$val->category_name}}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                         <div class="form-group">
                                                            <label for="exampleInputPassword1">SKU Code (*)</label>
                                                            <input name="sku_code" type="text" title="Enter valid No" class="form-control" id="" placeholder="SKU Code" value="{{$data->sku_code ?? old('sku_code') }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputPassword1">Purchase Price (*)</label>
                                                            <input name="purchase_price" type="text" class="form-control" id="" placeholder="Purchase Price" value="{{ $data->purchase_price ?? old('purchase_price') }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputPassword1">MRP Price (*)</label>
                                                            <input name="mrp_price" type="text" class="form-control" id="" placeholder="MRP Price" value="{{ $data->mrp_price ?? old('mrp_price')}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputPassword1">Quantity</label>
                                                            <input name="show_qty" type="text" class="form-control" id="" placeholder="Qty" value="{{ $data->qty ?? old('qty')}}" onkeyup="Qtychange(this.value);">
                                                            <input name="qty" type="hidden" id="qty" value="0">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                      <div class="form-group">
                                                            <label for="exampleInputPassword1">Sub Category</label>
                                                            <select name="subcategory_id" class="form-control" id="subcat" placeholder="Name" value="">
                                                                <option value="0">Select Category First</option>
                                                                @if(isset($data3->category_id))
                                                                  <option value="{{$data3->category_id}}" {{ (old('subcategory_id') == $data3->category_id)? 'selected' : ((isset($data) && ($data->subcategory_id == $data3->category_id)) ? 'selected' : '')}}>{{$data3->category_name}}</option>
                                                                @endif
                                                            </select>
                                                      </div>
                                                      <div class="form-group">
                                                        <label for="exampleInputPassword1">Seller Name</label>
                                                        <select name="seller_id" class="form-control">
                                                            <option value="">Choose any Seller</option>
                                                            @if(isset($seller) && count($seller)>0)
                                                                @foreach ($seller as $val)
                                                                  <option value="{{$val->seller_id}}" {{ (old('seller_id') == $val->seller_id)? 'selected' : ((isset($data) && ($data->seller_id == $val->seller_id)) ? 'selected' : '')}}>{{$val->seller_name}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                      </div>
                                                      <div class="form-group">
                                                        <label for="exampleInputPassword1">Product Name (*)</label>
                                                        <input name="product_name" type="text" class="form-control" id="" placeholder="Product Name" value="{{ $data->product_name ?? old('product_name')}}">
                                                      </div>
                                                      <div class="form-group">
                                                        <label for="exampleInputPassword1">Sell Price</label>
                                                        <input name="sell_price" type="text" class="form-control" id="" placeholder="Sell Price" value="{{ $data->sell_price ?? old('sell_price')}}">
                                                      </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                     <div class="form-group">
                                                      <button type="submit" name="sub" value="submit" class="btn btn-primary">@if(isset($data)) Update @else Submit @endif</button>
                                                     </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Input group -->

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

   <script>

     function Subcat(id)
           {
              $.ajax(
                {
                    url: "/product/subcat",
                    type: 'POST',
                    data: { "id": id, "_token": "{{ csrf_token() }}" },
                    success: function (data)
                    {
                        console.log(data);
                        $("#subcat").html(data);
                    }
                });
           }

     function Qtychange(val)
        {
            $("#qty").val(val);
        }

   </script>

@endpush
