@extends('layouts.common-template')
@push('title')
    <title>Shuvecha - Seller Data</title>
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
                                            <h5>Add Seller</h5>
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
                                                            <label for="exampleInputEmail1">Name</label>
                                                            <input name="seller_name" type="text" class="form-control" id="" placeholder="Name" value="{{ $data->seller_name ?? old('seller_name')}}" required>
                                                        </div>
                                                         <div class="form-group">
                                                            <label for="exampleInputPassword1">Phone</label>
                                                            <input name="phone" type="text" pattern="[6-9]{1}[0-9]{9}" title="Enter valid No" class="form-control" id="" placeholder="Phone" value="{{$data->phone ?? old('phone')}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputPassword1">Email</label>
                                                            <input name="email" type="text" class="form-control" id="" placeholder="Email" value="{{ $data->email ?? old('email')}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                      <div class="form-group">
                                                            <label for="exampleInputPassword1">Address</label>
                                                            <input name="address" type="text" class="form-control" id="" placeholder="Address" value="{{ $data->address ?? old('address')}}">
                                                      </div>
                                                      <div class="form-group">
                                                        <label for="exampleInputPassword1">GST NO</label>
                                                        <input name="gstno" type="text" class="form-control" id="" placeholder="GST NO" value="{{ $data->gstno ?? old('gstno')}}">
                                                      </div>
                                                      <div class="form-group">
                                                        <label for="exampleInputPassword1">Date of Birth</label>
                                                        <input name="dob" type="date" class="form-control" id="" placeholder="Date" value="{{ $data->dob ?? old('dob')}}">
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

    {{-- <script>
        swal({
            title: "Great job!",
            text: "Seller Data ",
            type: "success"
        }).then(function() {
            window.location = "";
        });
    </script> --}}

@endpush
