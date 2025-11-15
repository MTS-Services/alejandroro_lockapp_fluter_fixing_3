<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use DB;
use PDF;
use Hash;
use App\Models\User;
class AdminController extends Controller
{
	public function __construct() {
        $this->middleware('auth');
    }
    public function Profile()
    {
        return view('admin.profile.profile');
    }
    public function UpdateProfile(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);
        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        if($user){
            return redirect()->back()->with('success','Profile has been Updated Successfull.');
        }else{
            return redirect()->back()->with('error','Profile not Updated.');
        }
    }
    public function Password()
    {
        return view('admin.profile.password');
    }
    public function UpdatePassword(Request $request)
    {
        request()->validate([
            'current_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required'
        ]);
        $user_id = Auth::User()->id;
        $user = User::find($user_id);

        if($request->new_password!=$request->confirm_password){
            return redirect()->back()->with('error','New & Confirm Password Not Match.');
        }
        if(Hash::check($request->current_password, $user->getAuthPassword()))
        {
            $user->password = bcrypt($request->new_password);
            $user->save();
            return redirect()->back()->with('success','Password has been Updated Successfull.');
        }
        else
        {
            return redirect()->back()->with('error','Current Password Not Match.');
        }
    }
}