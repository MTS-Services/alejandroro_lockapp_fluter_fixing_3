@extends('layouts.app')
@section('title','Dashboard')
@section('content')                           
<!--Page header-->
<div class="page-header d-xl-flex d-block">
    <div class="page-leftheader">
        <h4 class="page-title">Dashboard</h4>
    </div>
</div>
<!--End Page header-->

<!-- Row -->
<div class="row">
  <div class="col-xl-3 col-lg-6 col-md-12">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-7">
            <div class="mt-0 text-left">
              <span class="fs-16 font-weight-semibold">Users</span>
              <h3 class="mb-0 mt-1 text-primary fs-25">{{$total_user}}</h3>
            </div>
          </div>
          <div class="col-5">
            <div class="icon1 bg-primary my-auto float-right"> <i class="feather feather-users"></i> </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-6 col-md-12">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-7">
            <div class="mt-0 text-left">
              <span class="fs-16 font-weight-semibold">Active Users</span>
              <h3 class="mb-0 mt-1 text-success fs-25">{{$active_user}}</h3>
            </div>
          </div>
          <div class="col-5">
            <div class="icon1 bg-success my-auto float-right"> <i class="feather feather-users"></i> </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-6 col-md-12">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-7">
            <div class="mt-0 text-left">
              <span class="fs-16 font-weight-semibold">Deactive Users</span>
              <h3 class="mb-0 mt-1 text-danger fs-25">{{$deactive_user}}</h3>
            </div>
          </div>
          <div class="col-5">
            <div class="icon1 bg-danger my-auto float-right"> <i class="feather feather-users"></i> </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- <div class="col-xl-3 col-lg-6 col-md-12">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-7">
            <div class="mt-0 text-left">
              <span class="fs-16 font-weight-semibold">Pending Projects</span>
              <h3 class="mb-0 mt-1 text-danger fs-25">14</h3>
            </div>
          </div>
          <div class="col-5">
            <div class="icon1 bg-danger my-auto  float-right"> <i class="feather feather-briefcase"></i> </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-6 col-md-12">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-7">
            <div class="mt-0 text-left">
              <span class="fs-16 font-weight-semibold">Completed Projects</span>
              <h3 class="mb-0 mt-1 text-success fs-25">35</h3>
            </div>
          </div>
          <div class="col-5">
            <div class="icon1 bg-success my-auto  float-right"> <i class="feather feather-check"></i> </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-lg-6 col-md-12">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-7">
            <div class="mt-0 text-left">
              <span class="fs-16 font-weight-semibold">On going Projects</span>
              <h3 class="mb-0 mt-1 text-secondary fs-25">15</h3>
            </div>
          </div>
          <div class="col-5">
            <div class="icon1 bg-secondary my-auto  float-right"> <i class="feather feather-info"></i> </div>
          </div>
        </div>
      </div>
    </div>
  </div> -->
</div>
<!-- End Row -->

<!--Row-->
<div class="row">
  <div class="col-xl-12 col-md-12 col-lg-12">
    <div class="card">
      <div class="card-header border-0">
        <h4 class="card-title">Latest User Summary</h4>
      </div>
      <div class="card-body pt-3 p-0">
        <div class="table-responsive">
          <table class="table table-vcenter text-nowrap border-top  mb-0" id="projecttable">
            <thead>
              <tr>
                <th class="wd-10p border-bottom-0">Profile</th>
                <th class="wd-10p border-bottom-0">Name</th>
                <th class="wd-15p border-bottom-0">Email</th>
                <th class="wd-20p border-bottom-0">Gender</th>
                <th class="wd-5p border-bottom-0">DOB</th>
                <th class="wd-25p border-bottom-0">Action</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($latest_user as $key => $value)
                <tr>
                    <td>
                      <div class="avatar-list avatar-list-stacked">
                        <img class="avatar avatar-md brround" src="{{$value->profile}}" alt="img">
                      </div>
                    </td>
                    <td>{{$value->firstname}} {{$value->lastname}}</td>
                    <td>{{$value->email}}</td>
                    <td>{{$value->gender}}</td>
                    <td>{{$value->dob}}</td>
                    <td class="text-left d-flex">
                        <a href="{{URL::to('viewuser/'.$value->id)}}" class="action-btns1">
                            <i class="feather feather-eye  text-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="view"></i>
                        </a>
                      <!-- <a href="#" class="action-btns1" data-toggle="tooltip" data-placement="top" title="Mail"><i class="feather feather-mail  text-primary"></i></a>
                      <a href="#" class="action-btns1" data-toggle="tooltip" data-placement="top" title="Delete"><i class="feather feather-trash-2 text-danger"></i></a> -->
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
<!-- End Row-->
@endsection
@section('customjs')
@endsection