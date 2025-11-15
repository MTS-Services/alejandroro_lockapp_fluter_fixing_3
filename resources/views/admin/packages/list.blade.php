@extends('layouts.app')
@section('title','Credit Packages')
@section('content')                           
<!--Page header-->
<div class="page-header d-lg-flex d-block">
    <div class="page-leftheader">
        <h4 class="page-title">Credit Packages</h4>
    </div>
    <div class="page-rightheader ml-md-auto">
        <div class="btn-list">
            <button class="btn btn-success" onclick="addpackages()" data-placement="top" data-toggle="tooltip" title="" data-original-title="Add Package"> Add Package</button>
        </div>
    </div>
</div>
<!--End Page header-->

<div class="row">
    <div class="col-xl-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header  border-0">
                <h4 class="card-title">Credit Packages</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap border-bottom" id="basic-datatable">
                        <thead>
                            <tr>
                                <th class="border-bottom-0 w-5">No</th>
                                <th class="border-bottom-0">Packages Name</th>
                                <th class="border-bottom-0">Packages Price</th>
                                <th class="border-bottom-0">Credits</th>
                                <th class="border-bottom-0">Status</th>
                                <th class="border-bottom-0">Date/Time</th>
                                <th class="border-bottom-0">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($packages as $key => $value)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$value->package_name}}</td>
                                    <td>{{$value->price}}</td>
                                    <td>{{$value->credits}}</td>
                                    <td>
                                        @if($value->status==1)
                                            <span class="badge badge-success">Enable</span>
                                        @elseif($value->status==0)
                                            <span class="badge badge-danger">Disable</span>
                                        @endif
                                    </td>
                                    <td>{{$value->created_at}}</td>
                                    <td class="text-left d-flex">
                                        <a class="action-btns1" onclick="editpackages('{{$value->id}}')">
                                            <i class="feather feather-edit text-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="view"></i>
                                        </a>
                                        <a href="{{URL::to('deletepackages/'.$value->id)}}" class="action-btns1" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
                                            <i class="feather feather-trash-2 text-danger"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade"  id="packages_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button  class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="packages_body">
            </div>
        </div>
    </div>
</div>
@endsection
@section('customjs')
<script type="text/javascript">
    function addpackages() {
        $.ajax({
            type: 'get',
            dataType:'html',
            url: "{{ URL::to('addpackages') }}",
            success: function (result) {
                $('#packages_modal').modal('show');
                $('#packages_modal .modal-title').html('Add Package');
                $('#packages_body').html(result);
            }
        });
    }
    function editpackages(id) {
        $.ajax({
            type: 'get',
            dataType:'html',
            url: "{{ URL::to('editpackages') }}/"+id,
            success: function (result) {
                $('#packages_modal').modal('show');
                $('#packages_modal .modal-title').html('Edit Package');
                $('#packages_body').html(result);
            }
        });   
    }
</script>
@endsection