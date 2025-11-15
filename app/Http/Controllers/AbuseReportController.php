<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Auth;
use DB;
use App\Models\AppUsers;
use App\Models\AbuseReport;
class AbuseReportController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    public function Index() {
        $profileurl = env('IMAGE_URL').'uploads/profile/';
        $profile_pic1 = DB::raw("CONCAT('$profileurl',app_users.profile) AS profile");
        $profile_pic2 = DB::raw("CONCAT('$profileurl',app_users1.profile) AS re_profile");
        $AbuseReport = AbuseReport::leftjoin('app_users','app_users.id','abuse_report.user_id')
        ->leftjoin('app_users as app_users1','app_users1.id','abuse_report.reported_userid')
        ->select('abuse_report.*','app_users.firstname','app_users.lastname',$profile_pic1,'app_users1.firstname as re_firstname','app_users1.firstname as re_lastname',$profile_pic2)
        ->orderBy('id','desc')
        ->get();
        return view('admin.abuse.list',compact('AbuseReport'));
    }
    public function EditAbuseReport($id)
    {
        $abuse_data = AbuseReport::leftjoin('app_users','app_users.id','abuse_report.user_id')
        ->leftjoin('app_users as app_users1','app_users1.id','abuse_report.reported_userid')
        ->select('abuse_report.*','app_users.firstname','app_users.lastname','app_users1.firstname as re_firstname','app_users1.firstname as re_lastname')
        ->where('abuse_report.id',$id)
        ->first();
        return view('admin.abuse.edit_abuse',compact('abuse_data'));
    }
    public function UpdateAbuse(Request $request)
    {
        $AbuseReport = AbuseReport::find($request->id);
        $AbuseReport->remarks = $request->remarks;
        $AbuseReport->status = $request->status;
        $AbuseReport->save();
        if($AbuseReport){
            return redirect('abuse_report')->with('success','Abuse Updated Successfully');
        }else{
            return redirect('abuse_report')->with('error','somthing want wrong');
        }
    }
}