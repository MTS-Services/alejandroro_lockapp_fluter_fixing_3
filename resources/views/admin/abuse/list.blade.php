@extends('layouts.app')
@section('title','Abuse Report')
@section('content')                           
<!--Page header-->
<div class="page-header d-lg-flex d-block">
    <div class="page-leftheader">
        <h4 class="page-title">Abuse Report</h4>
    </div>
</div>
<!--End Page header-->

<div class="row">
    <div class="col-xl-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="card-header  border-0">
                <h4 class="card-title">Abuse Report</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap border-bottom" id="basic-datatable">
                        <thead>
                            <tr>
                                <th class="border-bottom-0 w-5">No</th>
                                <th class="border-bottom-0">Reported By User</th>
                                <th class="border-bottom-0">Reported to User</th>
                                <th class="border-bottom-0">Reason</th>
                                <th class="border-bottom-0">Remarks</th>
                                <th class="border-bottom-0">Date/Time</th>
                                <th class="border-bottom-0">Status</th>
                                <th class="border-bottom-0">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($AbuseReport as $key => $value)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>
                                        <div class="d-flex">
                                            <span class="avatar avatar-md brround mr-3" style="background-image: url('{{$value->profile}}')"></span>
                                            <div class="mr-3 mt-0 mt-sm-1 d-block">
                                                <h6 class="mb-1 fs-14">{{$value->firstname}} {{$value->lastname}}</h6>
                                                <div class="d-flex">
                                                    <a href="{{URL::to('viewuser/'.$value->user_id)}}" class="action-btns1" data-toggle="tooltip" data-placement="top" title="" data-original-title="View User Details"><i class="feather feather-send text-info"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <span class="avatar avatar-md brround mr-3" style="background-image: url('{{$value->re_profile}}')"></span>
                                            <div class="mr-3 mt-0 mt-sm-1 d-block">
                                                <h6 class="mb-1 fs-14">{{$value->re_firstname}} {{$value->re_lastname}}</h6>
                                                <div class="d-flex">
                                                    <a href="{{URL::to('viewuser/'.$value->reported_userid)}}" class="action-btns1" data-toggle="tooltip" data-placement="top" title="" data-original-title="View User Details"><i class="feather feather-send text-info"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{$value->reason}}</td>
                                    <td>{{$value->remarks}}</td>
                                    <td>{{$value->created_at}}</td>
                                    <td>
                                        @if($value->status==1)
                                            <span class="badge badge-success">Accepted</span>
                                        @elseif($value->status==0)
                                            <span class="badge badge-warning">Awaiting</span>
                                        @elseif($value->status==2)
                                            <span class="badge badge-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td class="text-left d-flex">
                                        <a class="action-btns1" onclick="editabuse_report('{{$value->id}}')">
                                            <i class="feather feather-edit text-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="view"></i>
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
<div class="modal fade"  id="abuse_report_modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">My Leave Application</h5>
                <button  class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="abuse_report_body">
            </div>
        </div>
    </div>
</div>
@endsection
@section('customjs')
<script type="text/javascript">
    function editabuse_report(id) {
        $.ajax({
            type: 'get',
            dataType:'html',
            url: "{{ URL::to('editabuse_report') }}/"+id,
            success: function (result) {
                $('#abuse_report_modal').modal('show');
                $('#abuse_report_modal .modal-title').html('Report Moderation');
                $('#abuse_report_body').html(result);
            }
        });
    }
</script>
@endsection