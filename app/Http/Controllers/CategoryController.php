<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Category::select('category_id','category_name','status','created_at')->where(['parent_id'=>0])->orderBy('category_id','DESC')->get();
        if($data == false) { $data = []; }
        return view('category_list',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Category::select('category_id','category_name')->where(['status'=>1,'parent_id'=>0])->get();

        if($data == false) { $data = []; }
        $url = url('/category');
        return view('category_add',compact('data','url'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->ajax()):
            $data = Category::where(['category_name' => $request->category_name])->count();
            $res['msg'] = ($data > 0) ? "This Category Already Exists in the Database. Be Careful!" : "";
            return response()->json($res);
        endif;
        
        $validator = Validator::make($request->all(),
        [
             'category_name' => 'required',
             'parent_id' => 'required_if:choose,1'
        ],
        [
            'parent_id.required_if' => 'The Category select is required when create Sub-category.'
        ]);

        if($validator->fails()):
            return redirect()->back()->withErrors($validator)->withInput();
        endif;

        $category = new Category;
        $category->parent_id = ($request->choose  == 0) ? 0 : $request->parent_id;
        $category->category_name = $request->category_name;
        $data = $category->save();
        if($data):
            $request->session()->flash('success', 'Category data Uploaded');
            return redirect('category/create');
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
        $category_name = Category::select('category_name')->where('category_id',$id)->value('category_name');
        $data = Category::select('category_id','category_name','status','created_at')->where(['parent_id'=>$id])->get();
        if($data == false) { $data = []; }
        return view('category_list_sub',compact('data','category_name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data2 = Category::find($id);
        $data = Category::select('category_id','category_name')->where(['status'=>1,'parent_id'=>0])->get();
        $url = url('/category')."/".$id;
        if($data == false) { $data = []; }
        return view('category_add',compact('data','data2','url'));
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

        $category = Category::find($id);
        //$category->parent_id = ($request->choose  == 0) ? 0 : $request->parent_id;
        $category->category_name = $request->category_name;
        $category->status = $request->status;
        $data = $category->save();
        if($data):
            $request->session()->flash('success', 'Category data Updated');
            return redirect('/category');
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
        //
    }
}
