<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\Admin;
class LoginController extends Controller
{
    public function login(Request $request)
    {
        //url()->previous();
        $this->checkUrl();

        if($request->session()->has('shuvecha'))
            return redirect(url()->previous());
        else
            return view('login');
    }
    public function loginValidate(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'username'=>'required',
            'password'=>'required'
        ]);

        if($validator->fails()):
            return redirect()->back()->withErrors($validator)->withInput();
        endif;

        $data = Admin::select('user_name','name','id','type')
                ->where(['user_name'=>$request->username,'password'=>md5($request->password)])
                ->first();
        if($data == true)
        {
            Session::put('shuvecha',$data);
            if($request->session()->has('back_url')):
                $url = session('back_url');
                Session::pull('back_url');
                return redirect($url);
            endif;

            return redirect('/dashboard');
        }
        else
        {
            $data['error'] = "Username or Password wrong";
            $request->session()->flash('error', $data['error']);
            return redirect()->back();
        }

    }

    public function changePassword(Request $request)
    {
            if($request->all()):
                $count = Admin::where(['id'=>session('shuvecha')->id,'password'=>md5($request->current_password)])->count();

                $validator = Validator::make($request->all(),
                [
                    'current_password'=>'required',
                    'new_password'=>'required|min:6',
                    'confirm_password'=>'same:new_password'
                ]);

                if($validator->fails()):
                    return redirect()->back()->withErrors($validator)->withInput();
                elseif($count==0):
                    $request->session()->flash('error', 'The current password is not correct');
                    return redirect()->back()->withInput();
                else:
                    $data = Admin::where(['id'=>session('shuvecha')->id])->update(['password'=>md5($request->new_password)]);
                    if($data == true):
                        $request->session()->flash('success', 'The password was changed successfully. now log in to access your account.');
                        return redirect('logout');
                    else:
                            $request->session()->flash('error', 'Please try again');
                            return redirect()->back();
                    endif;
                endif;
            else:
                $url = url('/change-password');
                return view('change-password',compact('url'));
            endif;
    }

    public function checkUrl()
    {
       $url = url()->previous();
        $exp = explode('/',$url);
        if(($exp[2] == 'shuvecha.nationalent.co.in') && ($url == url('/register') || $url == url('/lostpassword') || $url == url('/logout') || $url == url('/'))):
            Session::forget('back_url');
        elseif($exp[2] == 'shuvecha.nationalent.co.in'):
            Session::put('back_url', $url);
        else:
            Session::forget('back_url');
        endif;
    }

    public function logout(Request $req)
    {
        $req->session()->flush();
        $req->session()->flash('error', "You are successfully Logout");
        return redirect('/');
    }
}
