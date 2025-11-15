<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use DB;
use Validator;
use App\Models\User;
use App\Models\AppUsers;

class LoginController extends Controller
{
    public function Login(){
        if(Auth::user()){
            // return redirect()->intended('dashboard');
            if(Auth::user()->user_type=='admin'){
                return redirect()->intended('dashboard');    
            }else{
                return redirect()->intended('user/dashboard');    
            }
        }else{
            return view('admin.login');
        }
    }
    public function DoLogin(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->intended('dashboard');
        }
        else {
            // return redirect()->back()->withInput($request->only('email', 'remember'))->withErrors(['error' => 'Credentials dose not match our database.']);
            return redirect()->back()->with('error','Invalid Username or Password.');
        }
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/login');
    }
    public function ResetPassword($token)
    {
        return view('reset_password',compact('token'));
    }
    public function postResetPassword(Request $request)
    {
        $request->validate([
            'new_password' => 'required|string|min:6|same:confirm_password',
            'confirm_password' => 'required'
        ]);
        $tokenParts = explode(".", $request->token);
        // $tokenHeader = base64_decode($tokenParts[0]);
        $tokenPayload = base64_decode($tokenParts[1]);
        // $jwtHeader = json_decode($tokenHeader);
        $jwtPayload = json_decode($tokenPayload,true);

        $updatePassword = AppUsers::where([
            'id' => $jwtPayload['user_id'], 
            'forgotid' => $jwtPayload['forgotid']
        ])
        ->first();
  
        if(!$updatePassword){
            return back()->withInput()->with('error', 'your reset password link is expire please try again!');
        }
  
        $user = AppUsers::where('id', $jwtPayload['user_id'])->update(['password' => Hash::make($request->new_password),'forgotid'=>'']);
            
        // DB::table('password_resets')->where(['email'=> $request->email])->delete();
            
        // return redirect('success_message')->with('success','Reset Password successfull please try to login in App.');
        return redirect('success_message');
    }

}

