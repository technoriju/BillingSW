@extends('layouts.common-template')
    @push('title')
        <title>Suvecha - Seller List</title>
    @endpush
    @push('style')
        <style>
            #panel { padding: 10px; display: none; }
        </style>
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
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <h5>All Seller List</h5>
                                                </div>
                                            </div>
                                        </div>
                                         @if(session('success')!== null)
                                           <div class="alert alert-success" role="alert">{{session('success')}}</div>
                                         @endif
                                        <div class="card-body data-tablee table-responsive">
                                            <table class="table table-hover tablemanager">
                                                <thead>
                                                    <tr>
                                                        <th class="disableSort">#</th>
                                                        <th>Seller Name</th>
                                                        <th>Phone</th>
                                                        <th>Email</th>
                                                        <th>D.O.B</th>
                                                        <th>Address</th>
                                                        <th>Gst No</th>
                                                        <th class="disableFilterBy">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(isset($data) && count($data)>0)  @php $count=0 @endphp
                                                        @foreach ($data as $val)  @php $count++ @endphp
                                                            <tr>
                                                                <td>{{$count}}</td>
                                                                <td>{{$val->seller_name}}</td>
                                                                <td>{{$val->phone}}</td>
                                                                <td>{{$val->email}}</td>
                                                                <td>{{$val->dob}}</td>
                                                                <td>{{$val->address}}</td>
                                                                <td>{{$val->gstno}}</td>
                                                                <td>
                                                                    <a href="{{url('/seller'.'/'.$val->seller_id.'/edit')}}">Edit</a> |
                                                                    <a href="javascript:void(0);" id="{{$val->seller_id}}" onclick="return Delete(this.id);">Delete</a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                      <tr><td>No data found</td></tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
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
        <script src="{{ url('assets/js/tableManager.js') }}"></script>
        <script type="text/javascript">

            $('.tablemanager').tablemanager({
                
                disable: ["last"],
                appendFilterby: true,
                dateFormat: [
                    [4, "mm-dd-yyyy"]
                ],
                debug: true,
                vocabulary: {
                    voc_filter_by: 'Filter By',
                    voc_type_here_filter: 'Filter...',
                    voc_show_rows: 'Rows Per Page'
                },
                pagination: true,
                showrows: [5, 10, 20, 50, 100],
                disableFilterBy: [1]
            });
            // $('.tablemanager').tablemanager();

            function Delete(id)
            {
                var x=confirm("Are you sure want to Delete?");
                if(x) { DeleteRecord(id); } else { return false; }
            }

           function DeleteRecord(id)
           {
              $.ajax(
                {
                    url: "seller/"+id,
                    type: 'DELETE',
                    data: {
                        "id": id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function (data){

                        swal({
                            title: "Great job!",
                            text: "Seller Data Deleted",
                            type: "success"
                        }).then(function() {
                            window.location = "/seller";
                        });
                    }
                });
           }

        </script>
@endpush
