<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Auth;
use DB;
use App\Models\User;
use App\Models\AppUsers;
class DashboardController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    public function Dashboard() {
        $profileurl = env('IMAGE_URL').'uploads/profile/';
        $profile_pic = DB::raw("CONCAT('$profileurl',app_users.profile) AS profile");
        $latest_user = AppUsers::select('app_users.*',$profile_pic)->limit(10)->get();
        $total_user = AppUsers::count();
        $active_user = AppUsers::where('status',1)->count();
        $deactive_user = AppUsers::where('status',0)->count();
        return view('admin.dashboard',compact('total_user','latest_user','active_user','deactive_user'));
    }
}