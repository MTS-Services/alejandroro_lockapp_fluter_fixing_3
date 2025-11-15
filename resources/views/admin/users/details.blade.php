@extends('layouts.app')
@section('title','Users Details')
@section('content')                           
<!--Page header-->
<div class="page-header d-lg-flex d-block">
    <div class="page-leftheader">
        <h4 class="page-title">Users Details</h4>
    </div>
    <div class="page-rightheader ml-md-auto">
        <div class=" btn-list">
            @if($user_details->status==0)
                <a href="{{URL::to('userstatus/'.$user_details->id.'/1')}}"><button class="btn btn-success" data-placement="top" data-toggle="tooltip" title="" data-original-title="Active Now"> Active Now</button></a>
            @else
                <a href="{{URL::to('userstatus/'.$user_details->id.'/0')}}"><button class="btn btn-danger" data-placement="top" data-toggle="tooltip" title="" data-original-title="Deactive Now"> Deactive Now </button></a>
            @endif
        </div>
    </div>
</div>
<!--End Page header-->

<div class="row">
    <div class="col-xl-3 col-lg-4 col-md-12">
        <div class="card user-pro-list overflow-hidden">
            <div class="card-body">
                <div class="user-pic text-center">
                    <span class="avatar avatar-xxl brround" style="background-image: url('{{$user_details->profile}}')">
                        <span class="avatar-status bg-green"></span>
                    </span>
                    <div class="pro-user mt-3">
                        <h5 class="pro-user-username text-dark mb-1 fs-16">{{$user_details->firstname}} {{$user_details->lastname}}</h5>
                        <h6 class="pro-user-desc text-muted fs-12">{{$user_details->email}}</h6>
                        <!-- <div class="mb-3 clearfix">
                            <span class="fa fa-star text-warning"></span>
                            <span class="fa fa-star text-warning"></span>
                            <span class="fa fa-star text-warning"></span>
                            <span class="fa fa-star-half-o text-warning"></span>
                            <span class="fa fa-star-o text-warning"></span>
                        </div> -->
                        <!-- <div class="btn-list">
                            <a href="editprofile.html" class="btn btn-primary mt-3">Edit Profile</a>
                            <a href="#" class="btn btn-success mt-3">Follow</a>
                        </div> -->
                    </div>
                </div>
            </div>
            <div class="card-footer p-0">
                <div class="row">
                    <div class="col-6 text-center py-5 border-right">
                        <h5 class="mb-2">
                            <span class="fs-18 text-success">{{$Followers}}</span>
                        </h5>
                        <h5 class="fs-12 mb-0">Followers</h5>
                    </div>
                    <div class="col-6  py-5 text-center border-right">
                        <h5 class="mb-2">
                            <span class="fs-18 text-orange">{{$Following}}</span>
                        </h5>
                        <h5 class="fs-12 mb-0">Following</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Personal Details</h4>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <tbody>
                            <tr>
                                <td class="py-2 px-0">
                                    <span class="font-weight-semibold w-50">Name </span>
                                </td>
                                <td class="py-2 px-0">{{$user_details->firstname}} {{$user_details->lastname}}</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-0">
                                    <span class="font-weight-semibold w-50">Email </span>
                                </td>
                                <td class="py-2 px-0">{{$user_details->email}}</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-0">
                                    <span class="font-weight-semibold w-50">DOB </span>
                                </td>
                                <td class="py-2 px-0">{{$user_details->dob}}</td>
                            </tr>
                            <tr>
                                <td class="py-2 px-0">
                                    <span class="font-weight-semibold w-50">Gender </span>
                                </td>
                                <td class="py-2 px-0">{{$user_details->gender}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-9 col-md-12 col-lg-12">
        <div class="tab-menu-heading hremp-tabs p-0 ">
            <div class="tabs-menu1">
                <!-- Tabs -->
                <ul class="nav panel-tabs">
                    <li class="ml-4"><a href="#tab1" class="active"  data-toggle="tab">Personal Details</a></li>
                    <li><a href="#tab2"  data-toggle="tab">Images</a></li>
                    <li><a href="#tab3" data-toggle="tab">Videos</a></li>
                </ul>
            </div>
        </div>
        <div class="panel-body tabs-menu-body hremp-tabs1 p-0">
            <div class="tab-content">
                <div class="tab-pane active" id="tab1">
                    <div class="card-body">
                        <h5 class="font-weight-semibold">About me</h5>
                        <div class="main-profile-bio mb-0">
                            <p>{{$user_details->about}}</p>
                        </div>
                    </div>
                    <div class="card-body border-top">
                        <h5 class="font-weight-semibold">Interests</h5>
                        <?php $interests = explode(',', $user_details->interests); ?>
                        @foreach ($interests as $key => $value)
                            <a class="btn btn-sm btn-white mt-1" href="#">{{ucfirst($value)}}</a>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane" id="tab2">
                    <div class="card-body">
                        <ul id="lightgallery" class="list-unstyled row">
                            @foreach ($galleryimage as $key => $value)
                                <li class="col-xs-6 col-sm-4 col-md-3" data-responsive="{{$value->filename}}" data-src="{{$value->filename}}" data-sub-html="">
                                    <a href="#">
                                        <img class="img-responsive" src="{{$value->filename}}" alt="Thumb-1">
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="tab-pane" id="tab3">
                    <div class="card-body">
                        <ul id="lightgallery" class="list-unstyled row">
                            @foreach ($galleryvideo as $key => $value)
                                <li class="col-xs-6 col-sm-4 col-md-3" data-responsive="{{$value->filename}}" data-src="{{$value->filename}}" data-sub-html="">
                                    <a href="#">
                                        <video class="img-responsive" src="{{$value->filename}}" alt="Thumb-1">
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('customjs')
@endsection