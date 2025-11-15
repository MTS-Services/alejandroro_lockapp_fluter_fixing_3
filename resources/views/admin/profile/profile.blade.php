@extends('layouts.app')
@section('title','Editprofile')
@section('content')                           
<!--Page header-->
<div class="page-header d-lg-flex d-block">
    <div class="page-leftheader">
        <h4 class="page-title">Editprofile</h4>
    </div>
</div>
<!--End Page header-->

<!-- Row -->
<div class="row">
    <div class="col-xl-6 col-lg-7">
        <div class="card">
            <div class="card-body">
                <div class="card-title">Basic info:</div>
                <form method="POST" action="{{URL::to('updateprofile')}}">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{Auth::user()->name}}" placeholder="Enter Name" required>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="form-label">Email address</label>
                                <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{Auth::user()->email}}" placeholder="Email" required>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-lg btn-primary">Updated</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Row-->
@endsection
@section('customjs')
@endsection