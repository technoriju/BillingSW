@extends('layouts.common-template')
@push('title')
    <title>Suvecha - Category</title>
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
                                            <h5>Add Category</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="{{ $url }}" method="post" id="categoryform">
                                                @csrf
                                                @if((Request::segment(3) !== null) && Request::segment(3) == 'edit')
                                                    {{method_field('PUT')}}
                                                @endif
                                                <div class="row">
                                                    <div class="col-md-offset-3"></div>
                                                    <div class="col-md-6">

                                                        {{-- All Message --}}
                                                        @if(isset($errors) && count($errors)>0)
                                                          <div class="alert alert-danger" role="alert">{{$errors->first()}}</div>
                                                        @endif
                                                        @if(session('error')!== null)
                                                            <div class="alert alert-danger" role="alert">{{session('error')}}</div>
                                                        @endif
                                                        @if(session('success')!== null)
                                                            <div class="alert alert-success" role="alert">{{session('success')}}</div>
                                                        @endif
                                                        {{-- All Message end--}}

                                                        <div class="form-group">
                                                            @php $selected = ""; $disabled = ""; @endphp
                                                            @if(isset($data2))
                                                               @php $disabled = "disabled"; @endphp
                                                            @endif

                                                            @if((old('choose') !== null) && (old('choose') == 1))
                                                               @php $selected = "selected" @endphp
                                                            @elseif(isset($data2->parent_id) && ($data2->parent_id != 0))
                                                               @php $selected = "selected" @endphp
                                                            @endif

                                                            <label for="exampleInputEmail1">Choose Any Option</label>
                                                            <select name="choose" class="form-control" id="" placeholder="Name" value="" required onchange="Choose(this.value);" {{$disabled}}>
                                                                <option value="0">Category</option>
                                                                <option value="1" {{$selected}}>Sub-category</option>
                                                            </select>
                                                        </div>
                                                        @if((old('choose') !== null) && (old('choose') == 1))
                                                          @php $style = "" @endphp
                                                        @elseif(isset($data2->parent_id) && ($data2->parent_id != 0))
                                                          @php $style = "" @endphp
                                                        @elseif((isset($data2->parent_id) && ($data2->parent_id == 0)) || !isset($data2->parent_id))
                                                          @php $style = "display: none" @endphp
                                                        @endif

                                                        <div class="form-group" id="subcategory" style="{{$style}}">
                                                            <label for="exampleInputPassword1">Choose Category</label>
                                                            <select name="parent_id" class="form-control" id="parent_id" placeholder="Name" value="">
                                                                <option value="">Choose any Category</option>
                                                                @if(isset($data) && count($data)>0)
                                                                    @foreach ($data as $val)
                                                                    <option value="{{$val->category_id}}" {{((isset($data2) && $val->category_id == $data2->parent_id) ||($val->category_id == old('parent_id'))) ? 'selected' : ''}}>{{$val->category_name}}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputPassword1">Name <span id="show"></span></label>
                                                            <input name="category_name" type="text" class="form-control" id="" placeholder="Category Name" value="{{ old('category_name') ? old('category_name') : ( isset($data2->category_name) ? $data2->category_name :'') }}" onkeyup="MatchCategory(this.value);">
                                                        </div>
                                                        @isset($data2)
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1">Status</label>
                                                                <select name="status" class="form-control">
                                                                    <option value="1" {{($data2->status == 1) ? 'selected' : ''}}>Active</option>
                                                                    <option value="0" {{($data2->status == 0) ? 'selected' : ''}}>Inactive</option>
                                                                </select>
                                                            </div>
                                                        @endisset
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

    <script>
        function Choose(val)
        {
            if(val == 1) { $('#subcategory').show(); } else {  $('#subcategory').hide();  $('#parent_id').val(''); }
        }

        function MatchCategory(val)
        {
            var val = val.trim();
            $.ajax({
                type:"POST",
                url: "/category",
                data: {'_token':"{{csrf_token()}}",'category_name':val},
                dataType: "JSON",
                success: function(resp)
                {
                    $('#show').css('color','red').html(resp.msg);
                },
                error: function(resp){
                    console.log(resp);
                }
            })
        }
    </script>

@endpush
