<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminated\Support\Facades\Session;
use App\Models\Admin;
class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $data = Admin::where('type','<>',1)->get();
       if($data == false): $data = []; endif;
       return view('employee_list',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $url = url('/employee');
        return view('employee_add',compact('url'));
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
                'name' => 'required',
                'phone' => 'required|regex:/[6-9]{1}[0-9]{9}/|unique:admins,user_name',
            ]);

        if($validator->fails()):
            return redirect()->back()->withErrors($validator)->withInput();
        endif;

        $seller = new Admin;
        $seller->name = $request->name;
        $seller->user_name = $request->phone;
        $seller->password = md5($request->password);
        $seller->type = 2;
        $data = $seller->save();

        if($data):
            $request->session()->flash('success', 'Employee data Uploaded');
            return redirect('employee/create');
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
        $data = Admin::find($id);
        $url = url('/employee')."/".$id;
        if($data == false) { $data = []; }
        return view('employee_add',compact('data','url'));
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
        $seller = Admin::find($id);
        $seller->name = $request->name;
        $data = $seller->save();
        if($data):
            $request->session()->flash('success', 'Employee data Updated');
            return redirect('/employee');
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
        $seller = Admin::find($id);
        $data = $seller->delete();
        if($data == true) { echo "success"; } else { echo "failed"; }
    }
}
