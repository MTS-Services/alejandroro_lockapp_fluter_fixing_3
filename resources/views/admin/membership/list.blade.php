@extends('layouts.app')
@section('title','Membership')
@section('content')                           
<!--Page header-->
<div class="page-header d-lg-flex d-block">
    <div class="page-leftheader">
        <h4 class="page-title">Membership</h4>
    </div>
</div>
<!--End Page header-->

<div class="row">
    <div class="col-xl-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header  border-0">
                <h4 class="card-title">Membership</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap border-bottom" id="basic-datatable">
                        <thead>
                            <tr>
                                <th class="border-bottom-0 w-5">No</th>
                                <th class="border-bottom-0">User</th>
                                <th class="border-bottom-0">Packages Name</th>
                                <th class="border-bottom-0">Packages Price</th>
                                <th class="border-bottom-0">Payment ID</th>
                                <th class="border-bottom-0">Status</th>
                                <th class="border-bottom-0">Date/Time</th>
                                <!-- <th class="border-bottom-0">Actions</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Membership as $key => $value)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>
                                        <div class="d-flex">
                                            <span class="avatar avatar-md brround mr-3" style="background-image: url('{{$value->profile}}')"></span>
                                            <div class="mr-3 mt-0 mt-sm-1 d-block">
                                                <h6 class="mb-1 fs-14">{{$value->firstname}} {{$value->lastname}}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{$value->package_name}}</td>
                                    <td>{{$value->price}}</td>
                                    <td>{{$value->payment_id}}</td>
                                    <td>
                                        @if($value->status==1)
                                            <span class="badge badge-success">Success</span>
                                        @elseif($value->status==0)
                                            <span class="badge badge-warning">Awaiting</span>
                                        @elseif($value->status==2)
                                            <span class="badge badge-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td>{{$value->created_at}}</td>
                                    <!-- <td class="text-left d-flex">
                                        <a class="action-btns1" onclick="editabuse_report('{{$value->id}}')">
                                            <i class="feather feather-edit text-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="view"></i>
                                        </a>
                                    </td> -->
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('customjs')
@endsection