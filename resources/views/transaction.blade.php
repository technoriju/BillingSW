@extends('layouts.common-template')
    @push('title')
        <title>Shuvecha - Transaction </title>
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
                                                    <h5>All Product List</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body data-tablee table-responsive">
                                            <table class="table table-hover tablemanager">
                                                <thead>
                                                    <tr>
                                                        <th class="disableSort">#</th>
                                                        <th>Invoice No</th>
                                                        <th>Customer Name</th>
                                                        <th>Total</th>
                                                        <th>Discount</th>
                                                        <th>Date</th>
                                                        <th class="disableFilterBy">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(isset($data) && count($data)>0)  @php $count=0 @endphp
                                                        @foreach ($data as $val)  @php $count++ @endphp
                                                            <tr>
                                                                <td>{{$count}}</td>
                                                                <td>SUV - {{$val->invoice_no}}</td>

                                                                <td>{{$val->customer['name']}}</td>
                                                                <td>{{$val->total}}</td>
                                                                <td>{{$val->discount}}</td>
                                                                <td>{{dateFormat($val->date)}}</td>
                                                                <td>
                                                                    {{-- <a href="{{url('/sales/invoice/'.$val->sales_report_id.'/edit')}}">Edit Invoice</a> | --}}
                                                                    <a href="{{url('/sales/print/'.$val->sales_report_id)}}">Print Copy</a>
                                                                    @if(strtotime(next30Date($val->date)) >= time())
                                                                    |<a href="javascript:void(0);" id="{{$val->sales_report_id}}" onclick="return Delete(this.id);">Delete Invoice</a>
                                                                    @endif
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
                    url: "/sales/"+id,
                    type: 'DELETE',
                    data: {
                        "id": id,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function (data){
                      if(data == 'success')
                      {
                        swal({
                            title: "Great job!",
                            text: "Invoice Data Deleted",
                            type: "success"
                        }).then(function() {
                            window.location = "/sales/transaction";
                        });
                      }
                      else
                      {
                        swal({
                            title: "Error!",
                            text: "Something went wrong",
                            type: "error"
                        }).then(function() {
                            window.location = "/sales/transaction";
                        });
                      }

                    }
                });
           }

        </script>
@endpush
