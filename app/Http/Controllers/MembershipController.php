<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Auth;
use DB;
use App\Models\Membership;
class MembershipController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    public function Index() {
    	$profileurl = env('IMAGE_URL').'uploads/profile/';
        $profile_pic = DB::raw("CONCAT('$profileurl',app_users.profile) AS profile");
        $Membership = Membership::leftjoin('app_users','app_users.id','membership.user_id')
        ->leftjoin('packages','packages.id','membership.package_id')
        ->select('membership.*','app_users.firstname','app_users.lastname',$profile_pic,'packages.package_name','packages.price','packages.credits')
        ->orderBy('id','desc')->get();
        return view('admin.membership.list',compact('Membership'));
    }
}