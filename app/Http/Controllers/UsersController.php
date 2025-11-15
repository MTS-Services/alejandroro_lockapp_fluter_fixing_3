<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Auth;
use DB;
use App\Models\AppUsers;
use App\Models\LikedUsers;
use App\Models\UserGallery;
class UsersController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    public function Users() {
        $profileurl = env('IMAGE_URL').'uploads/profile/';
        $profile_pic = DB::raw("CONCAT('$profileurl',app_users.profile) AS profile");
        $user_list = AppUsers::select('app_users.*',$profile_pic)->get();
        return view('admin.users.list',compact('user_list'));
    }
    public function ViewUser($id)
    {
        $profileurl = env('IMAGE_URL').'uploads/profile/';
        $profile_pic = DB::raw("CONCAT('$profileurl',app_users.profile) AS profile");
        $user_details = AppUsers::select('app_users.*',$profile_pic)->where('id',$id)->first();
        $Followers = LikedUsers::where('like_user_id',$id)->count();
        $Following = LikedUsers::where('user_id',$id)->count();
        $galleryurl = env('IMAGE_URL').'uploads/gallery/';
        $filename = DB::raw("CONCAT('$galleryurl',user_gallery.filename) AS filename");

        $galleryimage = UserGallery::select('*',$filename)->where('user_id',$id)->where('type','image')->get();
        $galleryvideo = UserGallery::select('*',$filename)->where('user_id',$id)->where('type','video')->get();
        return view('admin.users.details',compact('user_details','Followers','Following','galleryimage','galleryvideo'));
    }
    public function UserStatus($id,$status)
    {
        $user = AppUsers::find($id);
        $user->status = $status;
        $user->save();
        if($user){
            if($status==1){
                $message = 'User Activated Successfull.';
            }else{
                $message = 'User Deactivated Successfull.';
            }
            return redirect()->back()->with('success',$message);
        }else{
            return redirect()->back()->with('error','Something went wrong.');
        }
    }
    public function UserDelete($id)
    {
        $delete = AppUsers::find($id);
        $delete->delete();
        if($delete){
            return redirect()->back()->with('success','User has been Deleted Successfull.');
        }else{
            return redirect()->back()->with('error','User not Deleted.');
        }
    }
}