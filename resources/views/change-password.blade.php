@extends('layouts.common-template')
@push('title')
    <title>Shuvecha - Change Password</title>
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
                                            <h5>Password Change Section</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="{{ $url }}" method="post">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        @if (isset($errors) && count($errors) > 0)
                                                            <div class="alert alert-danger" role="alert">
                                                                {{ $errors->first() }}</div>
                                                        @endif
                                                        @if (session('error') !== null)
                                                            <div class="alert alert-danger" role="alert">
                                                                {{ session('error') }}</div>
                                                        @endif
                                                        @if (session('success') !== null)
                                                            <div class="alert alert-success" role="alert">
                                                                {{ session('success') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Current Password</label>
                                                            <input name="current_password" type="text" class="form-control"
                                                                id="" placeholder="Current Password"
                                                                value="{{old('current_password')}}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputPassword1">New Password</label>
                                                            <input name="new_password" type="text" class="form-control"
                                                                id="" placeholder="New Password"
                                                                value="{{ old('new_password') }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputPassword1">Re-enter New Password</label>
                                                            <input name="confirm_password" type="text" class="form-control"
                                                                id="" placeholder="Confirm Password"
                                                                value="{{ old('confirm_password') }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                           <button type="submit" name="sub" value="submit" class="btn btn-primary">Submit</button>
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
