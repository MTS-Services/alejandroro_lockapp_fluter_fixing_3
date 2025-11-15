@extends('layouts.app')
@section('title','Update Password')
@section('content')                           
<!--Page header-->
<div class="page-header d-lg-flex d-block">
    <div class="page-leftheader">
        <h4 class="page-title">Update Password</h4>
    </div>
</div>
<!--End Page header-->

<!-- Row -->
<div class="row">
    <div class="col-xl-4 col-lg-5">
        <div class="card">
            <div class="card-header border-bottom-0">
                <div class="card-title">Update Password</div>
            </div>
            <form method="POST" action="{{URL::to('updatepassword')}}">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">Current Password</label>
                        <input type="password" class="form-control{{ $errors->has('current_password') ? ' is-invalid' : '' }}" name="current_password" placeholder="Current Password" required>
                        @if ($errors->has('current_password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('current_password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="form-label">New Password</label>
                        <input type="password" class="form-control{{ $errors->has('new_password') ? ' is-invalid' : '' }}" name="new_password" placeholder="New Password" required>
                        @if ($errors->has('new_password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('new_password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" class="form-control{{ $errors->has('confirm_password') ? ' is-invalid' : '' }}" name="confirm_password" placeholder="Confirm Password" required>
                        @if ($errors->has('confirm_password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('confirm_password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">Updated</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Row-->
@endsection
@section('customjs')
@endsection