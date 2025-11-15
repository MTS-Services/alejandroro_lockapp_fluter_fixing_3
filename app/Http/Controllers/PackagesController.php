<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Auth;
use DB;
use App\Models\Packages;
class PackagesController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    public function Index() {
        $packages = Packages::orderBy('id','desc')->get();
        return view('admin.packages.list',compact('packages'));
    }
    public function AddPackages()
    {
        return view('admin.packages.add');
    }
    public function PostAddPackages(Request $request)
    {
        $add = new Packages();
        $add->package_name = $request->package_name;
        $add->price = $request->price;
        $add->credits = $request->credits;
        $add->save();
        if($add){
            return redirect()->back()->with('success','Packages Added Successfull.');
        }else{
            return redirect()->back()->with('error','Packages not Added.');
        }
    }
    public function EditPackages($id)
    {
        $package_data = Packages::find($id);
        return view('admin.packages.add',compact('package_data'));
    }
    public function UpdatePackages(Request $request)
    {
        $update = Packages::find($request->id);
        $update->package_name = $request->package_name;
        $update->price = $request->price;
        $update->credits = $request->credits;
        $update->status = $request->status;
        $update->save();
        if($update){
            return redirect()->back()->with('success','Packages Updated Successfull.');
        }else{
            return redirect()->back()->with('error','Packages not Updated.');
        }   
    }
    public function DeletePackages($id)
    {
        $delete = Packages::find($id);
        $delete->delete();
        if($delete){
            return redirect()->back()->with('success','Packages Deleted Successfull.');
        }else{
            return redirect()->back()->with('error','Packages not Deleted.');
        }      
    }
}