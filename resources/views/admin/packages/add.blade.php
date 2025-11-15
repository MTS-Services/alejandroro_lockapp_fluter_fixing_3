@if(isset($package_data))
    <form method="POST" action="{{URL::to('editpackages')}}">
        <input type="hidden" name="id" value="{{$package_data->id}}">
@else
    <form method="POST" action="{{URL::to('addpackages')}}">
@endif
    @csrf
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label class="form-label">Package Name</label>
                <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="package_name" value="@if(isset($package_data)){{$package_data->package_name}}@endif" placeholder="Package Name" required>
                @if ($errors->has('name'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label class="form-label">Package Price</label>
                <input type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="price" value="@if(isset($package_data)){{$package_data->price}}@endif" placeholder="Package Price" required>
                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label class="form-label">Credits</label>
                <input type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="credits" value="@if(isset($package_data)){{$package_data->credits}}@endif" placeholder="Package Credits" required>
                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        @if(isset($package_data))
            <div class="col-sm-12 col-md-12">
                <div class="custom-controls-stacked d-md-flex">
                    <label class="form-label mt-1 mr-5">Status :</label>
                    <label class="custom-control custom-radio success mr-4">
                        <input type="radio" class="custom-control-input" name="status" value="1" @if($package_data->status==1) checked="" @endif>
                        <span class="custom-control-label">Enable</span>
                    </label>
                    <label class="custom-control custom-radio success mr-4">
                        <input type="radio" class="custom-control-input" name="status" value="0" @if($package_data->status==0) checked="" @endif>
                        <span class="custom-control-label">Disable</span>
                    </label>
                </div>
            </div>
        @endif
        <div class="col-sm-12 col-md-12 mt-4">
            <div class="form-group">
                <button type="submit" class="btn btn-lg btn-primary">Submit</button>
            </div>
        </div>
    </div>
</form>