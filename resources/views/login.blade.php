
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content=""/>

    @include('layouts.header')
</head>

<body>
    <div class="auth-wrapper">
        <div class="auth-content">
            <div class="auth-bg">

                <span class="r"></span>
                <span class="r s"></span>
                <span class="r s"></span>
                <span class="r"></span>
            </div>
            <div class="card">
                <div class="card-body text-center">
                   <form action="{{url('/')}}" method="POST">
                     @csrf
                    <div class="mb-4">
                        <i class="feather icon-unlock auth-icon"></i>
                    </div>
                    <h3 class="mb-4">Login</h3>

                   @if(isset($errors) && count($errors)>0)
                      <div class="alert alert-danger" role="alert">{{$errors->first()}}</div>
                   @endif
                   @if(session('error')!==null)
                      <div class="alert alert-danger" role="alert">{{session('error')}}</div>
                   @endif
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Username" name="username" value="{{old('username')}}">
                    </div>
                    <div class="input-group mb-4">
                        <input type="password" class="form-control" placeholder="password" name="password" value="{{old('password')}}">
                    </div>
                    <!-- <div class="form-group text-left">
                        <div class="checkbox checkbox-fill d-inline">
                            <input type="checkbox" name="checkbox-fill-1" id="checkbox-fill-a1" checked="">
                            <label for="checkbox-fill-a1" class="cr"> Save Details</label>
                        </div>
                    </div> -->
                    <input class="btn btn-primary shadow-2 mb-4" type="submit" name="sub" value="Login">
                    <!-- <p class="mb-2 text-muted">Forgot password? <a href="#">Reset</a></p>
                    <p class="mb-0 text-muted">Don’t have an account? <a href="register.php">Signup</a></p> -->
                </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Required Js -->
    <script src="{{ url('assets/js/vendor-all.min.js') }}"></script>
	<script src="{{ url('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

</body>
</html>
