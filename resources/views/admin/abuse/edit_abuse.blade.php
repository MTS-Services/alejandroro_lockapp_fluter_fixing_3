<div class="table-responsive">
    <table class="table mb-0">
        <tbody>
            <tr>
                <td class="font-weight-semibold">Reported By </td>
                <td>:</td>
                <td>{{$abuse_data->firstname}} {{$abuse_data->lastname}}</td>
            </tr>
            <tr>
                <td class="font-weight-semibold">Reported To User</td>
                <td>:</td>
                <td>{{$abuse_data->re_firstname}} {{$abuse_data->re_lastname}}</td>
            </tr>
            <tr>
                <td class="font-weight-semibold">Reason</td>
                <td>:</td>
                <td>{{$abuse_data->reason}}</td>
            </tr>
            <tr>
                <td class="font-weight-semibold">Reported Date/Time</td>
                <td>:</td>
                <td>{{$abuse_data->created_at}}</td>
            </tr>
        </tbody>
    </table>
    <form action="{{URL::to('update_abuse')}}" method="post">
        @csrf
        <input type="hidden" name="id" value="{{$abuse_data->id}}">
        <div class="form-group">
            <label class="form-label">Remarks</label>
            <textarea class="form-control" name="remarks" rows="3" placeholder="Enter Remarks"></textarea>
        </div>
        <div class="form-group ">
            <div class="custom-controls-stacked">
                <label class="custom-control custom-radio">
                    <input type="radio" class="custom-control-input" name="status" value="1" checked>
                    <span class="custom-control-label">Accept</span>
                </label>
                <label class="custom-control custom-radio">
                    <input type="radio" class="custom-control-input" name="status" value="2">
                    <span class="custom-control-label">Reject</span>
                </label>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>

