@extends('layouts.app')
@section('title','Notification')
@section('content')                           
<!--Page header-->
<div class="page-header d-lg-flex d-block">
    <div class="page-leftheader">
        <h4 class="page-title">Notification</h4>
    </div>
</div>
<!--End Page header-->

<div class="row">
    <div class="col-sm-12 col-xl-6 col-md-12 col-lg-6">
        <div class="card">
            <div class="card-header  border-0">
                <h4 class="card-title">Notification</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{URL::to('sendnotification')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <label class="col-form-label" for="title">Title<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" required>
                            <div class="invalid-feedback">
                                Please enter a Title.
                            </div>
                        </div>
                        
                        <div class="col-lg-12">
                            <label class="col-form-label" for="description">Description<span class="text-danger">*</span></label>
                            <textarea type="text" class="form-control" id="description" name="description" placeholder="Enter Description" required></textarea>
                            <div class="invalid-feedback">
                                Please enter a Description.
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <label class="col-form-label" for="scheduledTime">Scheduled Time</label>
                            <!-- <input type="date" class="form-control" id="scheduledTime" name="scheduledTime" > -->
                            <input type="datetime-local" name="scheduledTime" class="form-control">
                        </div>

                        <div class="col-lg-12">
                            <label class="col-form-label" for="image">Upload Image file</label>
                            <!-- <input type="file" class="form-control" id="image" name="image"> -->
                            <input type="file" class="dropify" name="image" data-height="180" />
                            <div class="invalid-feedback">
                                Please Select Image.
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 mt-4">
                            <div class="form-group">
                                <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('customjs')
@endsection