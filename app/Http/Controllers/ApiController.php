<?php

namespace App\Http\Controllers;
use App\Classes\ApiManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use DB;
use Mail;
use Validator;
use Carbon\Carbon;
use App\Models\AppUsers;
use App\Models\UserGallery;
use App\Models\Favourite;
use App\Models\LikedUsers;
use App\Models\UserStory;
use App\Models\ViewStory;
use App\Models\Chats;
use App\Models\ChatConversion;
use App\Models\AbuseReport;
use App\Models\Packages;
use App\Models\Membership;
use App\Models\UserBlock;

// use Kreait\Laravel\Firebase\Facades\Firebase;
// use Kreait\Firebase\Messaging\CloudMessage;

class ApiController extends Controller
{
    public function __construct(ApiManager $apiManager){
        $this->apiManager = $apiManager;
    }
    public function signup(Request $request) {
        $email = $request->get('email');
        
        $mobi_check = AppUsers::where('email',$email)->first();
        if($mobi_check) {
            return response()->json(['status' => false, 'message' => 'Email already exists']);
        }
        $usertoken = $this->apiManager->getUserToken();
        $user = new AppUsers();
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        // $user->mobile = $request->mobile;
        $user->dob = $request->dob;
        $user->age = Carbon::parse($request->dob)->age;
        $user->gender = $request->gender;
        $user->interests = $request->interests;
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $destinationPath = public_path('/uploads/profile/');
            $profile = 'profile' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $profile);
            $user->profile = $profile;
        }else{
            $user->profile = '';
        }
        $user->password = Hash::make($request->password);
        $user->user_token = $usertoken;
        $user->device_token = $request->get('device_token');
        $user->latitude = $request->latitude;
        $user->longitude = $request->longitude;
        $user->about = $request->about;
        $user->save();

        //  if ($user && $user->device_token) {
        //     $notification = array('title' => "New user registered", 'body' => "New user registered", 'sound' => 'default', 'badge' => '1');
        //     $messaging = Firebase::messaging();
        //     $message = CloudMessage::withTarget('token', $user->device_token)
        //         ->withNotification($notification);
        //     $profile_detail = $this->apiManager->getUserProfile($user->id);
        //     $sendReport = $messaging->send($message);
        //     return response()->json(['status' => true, 'message' => 'Registration done successfully and notification sent', 'data' => $profile_detail]);
        // }

        if($user) {
            $user_id = $user->id;
            $profile_detail = $this->apiManager->getUserProfile($user_id);
            return response()->json(['status' => true, 'message' => 'Registration done successfully', 'data' => $profile_detail]);
        }
        else{
            return response()->json(['status' => false, 'message' => 'Something went wrong!']);
        }
    }
    public function verifyLogin(Request $request)
    {
        // $user = User::where('email', $request->get('mobile'))->where('otp',$request->get('otp'))->first();
        // if(Auth::attempt(['email' => $request->email, 'password' => $request->password,'status'=>1])) {
        if(Auth::guard('apiuser')->attempt(['email' => $request->email, 'password' => $request->password,'status'=>1])) {
            $user = AppUsers::where('email', $request->get('email'))->first();
            $usertoken = $this->apiManager->getUserToken();
            $user->user_token = $usertoken;
            $user->device_token = $request->get('device_token');
            $user->save();
            $user_id = $user->id;
            
            $profile_detail = $this->apiManager->getUserProfile($user_id);
            return response()->json(['status' => true, 'message' => 'Login successfully', 'data' => $profile_detail]);
        }
        else {
            return response()->json(['status' => false, 'message' => 'Invalid Email or Password!']);
        }
    }
    public function socialsignin(Request $request)
    {
        $social_name = $request->get('social_name');
        $social_id = $request->get('social_id');
        
        $check = AppUsers::where('social_name',$social_name)->where('social_id',$social_id)->first();
        if($check) {
            $usertoken = $this->apiManager->getUserToken();
            $check->user_token = $usertoken;
            $check->device_token = $request->get('device_token');
            $check->save();
            $user_id = $check->id;
            
            $profile_detail = $this->apiManager->getUserProfile($user_id);
            return response()->json(['status' => true, 'response' => 'login','message' => 'Login successfully', 'data' => $profile_detail]);   
        }else{
            $usertoken = $this->apiManager->getUserToken();
            $user = new AppUsers();
            $user->firstname = $request->firstname;
            $user->lastname = $request->lastname;
            $user->email = $request->email;
            $user->social_name = $social_name;
            $user->social_id = $social_id;
            $user->user_token = $usertoken;
            /*$user->mobile = $request->mobile;
            $user->dob = $request->dob;
            if ($request->hasFile('profile')) {
                $file = $request->file('profile');
                $destinationPath = public_path('/uploads/profile/');
                $profile = 'profile' . time() . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $profile);
                $user->profile = $profile;
            }else{
                $user->profile = '';
            }
            $user->gender = $request->gender;
            $user->interests = $request->interests;
            $user->password = '';
            $user->social_name = $social_name;
            $user->social_id = $social_id;
            $user->user_token = $usertoken;
            $user->device_token = $request->get('device_token');
            $user->latitude = $request->latitude;
            $user->longitude = $request->longitude;
            $user->about = $request->about;*/
            $user->save();
            if($user) {
                $user_id = $user->id;
                $profile_detail = $this->apiManager->getUserProfile($user_id);
                return response()->json(['status' => true, 'response' => 'register','message' => 'Registration done successfully', 'data' => $profile_detail]);
            }
            else{
                return response()->json(['status' => false, 'message' => 'Something went wrong!']);
            }
        }
    }
    public function profile_complete(Request $request)
    {
        $user_id = $request->get('user_id');
        $usertoken = $request->get('user_token');
        $response = $this->apiManager->verifyUserToken($user_id,$usertoken);
        if(!$response) {
            return response()->json(['status' => false, 'message' => 'Unauthorized access!']);
        }
        $user = AppUsers::find($user_id);
        // $user->mobile = $request->mobile;
        $user->dob = $request->dob;
        $user->age = Carbon::parse($request->dob)->age;
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $destinationPath = public_path('/uploads/profile/');
            $profile = 'profile' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $profile);
            $user->profile = $profile;
        }else{
            $user->profile = '';
        }
        $user->gender = $request->gender;
        $user->interests = $request->interests;
        $user->latitude = $request->latitude;
        $user->longitude = $request->longitude;
        $user->about = $request->about;
        $user->save();
        if($user) {
            $profile_detail = $this->apiManager->getUserProfile($user_id);
            return response()->json(['status' => true, 'message' => 'Profile Updated successfully', 'data' => $profile_detail]);
        }
        else{
            return response()->json(['status' => false, 'message' => 'Something went wrong!']);
        }
    }
    public function Forgot(Request $request)
    {
        $email = $request->get('email');
        
        $email_check = AppUsers::where('email',$email)->first();
        if($email_check) {
            /*$tokenParts = explode(".", $response);  
            $tokenHeader = base64_decode($tokenParts[0]);
            $tokenPayload = base64_decode($tokenParts[1]);
            $jwtHeader = json_decode($tokenHeader);
            $jwtPayload = json_decode($tokenPayload);*/
            $forgotid = rand(100000,999999);
            $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
            // Create token payload as a JSON string
            $payload = json_encode(['user_id' => $email_check->id,'timestamp' => time(),'forgotid' => $forgotid]);
            // Encode Header to Base64Url String
            $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
            // Encode Payload to Base64Url String
            $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
            // Create Signature Hash
            /*$signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, env('PAY_SPRINT_TOKEN'), true);
            // Encode Signature to Base64Url String
            $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));*/
            // Create JWT
            $jwt = $base64UrlHeader . "." . $base64UrlPayload;

            $email_check->forgotid = $forgotid;
            $email_check->save();
            /*$tokenParts = explode(".", $jwt);  
            $tokenHeader = base64_decode($tokenParts[0]);
            $tokenPayload = base64_decode($tokenParts[1]);
            $jwtHeader = json_decode($tokenHeader);
            $jwtPayload = json_decode($tokenPayload,true);*/
            // $data = json_decode($jwtPayload);
            /*echo $jwtPayload['user_id'];
            exit;*/
            /*echo $jwt;
            exit;*/
            $data = [
                'jwt' => $jwt
            ];
            Mail::send('forgetPassword', ['token'=>$jwt], function($message) use ($email) {
                $message->to($email, '')->subject('Forgot Password : Dating');
                $message->from('info@datingapp.unikappstech.in','Dating App');
            });

            return response()->json(['status' => true, 'message' => 'Password Reset link send in your mail','link'=>'http://localhost/dating_app/reset-password/'.$jwt]);
        }else{
            return response()->json(['status' => false, 'message' => 'Email is not exists']);
        }
    }
    public function UpdateProfile(Request $request)
    {
        $user_id = $request->get('user_id');
        $usertoken = $request->get('user_token');
        $response = $this->apiManager->verifyUserToken($user_id,$usertoken);
        if(!$response) {
            return response()->json(['status' => false, 'message' => 'Unauthorized access!']);
        }
        $user = AppUsers::find($user_id);
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        // $user->mobile = $request->mobile;
        $user->dob = $request->dob;
        $user->age = Carbon::parse($request->dob)->age;
        $user->gender = $request->gender;
        $user->interests = $request->interests;
        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $destinationPath = public_path('/uploads/profile/');
            $profile = 'profile' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $profile);
            $user->profile = $profile;
        }
        $user->latitude = $request->latitude;
        $user->longitude = $request->longitude;
        $user->about = $request->about;
        $user->save();
        if($user) {
            $profile_detail = $this->apiManager->getUserProfile($user_id);
            return response()->json(['status' => true, 'message' => 'Profile Updated successfully', 'data' => $profile_detail]);
        }
        else{
            return response()->json(['status' => false, 'message' => 'Something went wrong!']);
        }
    }
    public function UpdatePassword(Request $request)
    {
        $user_id = $request->get('user_id');
        $usertoken = $request->get('user_token');
        $response = $this->apiManager->verifyUserToken($user_id,$usertoken);
        if(!$response) {
            return response()->json(['status' => false, 'message' => 'Unauthorized access!']);
        }
        $user = AppUsers::find($user_id);
        /*if($request->newpass!=$request->confpass){
            return redirect()->back()->with('error','New & Confirm Password Not Match!');
        }*/
        if(Hash::check($request->oldpass, $user->getAuthPassword()))
        {
            $user->password = Hash::make($request->newpass);
            $user->save();
            return response()->json(['status' => true, 'message' => 'Password has been Updated Successfull.']);
        }
        else
        {
            return response()->json(['status' => false, 'message' => 'Old Password Not Match.']);
        }
    }
    public function AddMedia(Request $request)
    {
        $user_id = $request->get('user_id');
        $usertoken = $request->get('user_token');
        $response = $this->apiManager->verifyUserToken($user_id,$usertoken);
        if(!$response) {
            return response()->json(['status' => false, 'message' => 'Unauthorized access!']);
        }
        $UserGallery = new UserGallery();
        $UserGallery->user_id = $user_id;
        $UserGallery->type = $request->media_type;
        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $destinationPath = public_path('/uploads/gallery/');
            $media = 'media' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $media);
            $UserGallery->filename = $media;
        }
        $UserGallery->save();
        if($UserGallery){
            return response()->json(['status' => true, 'message' => 'Media Uploaded successfully']);
        }
        else{
            return response()->json(['status' => false, 'message' => 'Something went wrong!']);
        }
    }
    public function GetMedia(Request $request)
    {
        $user_id = $request->get('user_id');
        $usertoken = $request->get('user_token');
        $response = $this->apiManager->verifyUserToken($user_id,$usertoken);
        if(!$response) {
            return response()->json(['status' => false, 'message' => 'Unauthorized access!']);
        }
        $galleryurl = env('IMAGE_URL').'uploads/gallery/';
        $filename = DB::raw("CONCAT('$galleryurl',user_gallery.filename) AS filename");
        $UserGallery = UserGallery::select('*',$filename)->where('user_id',$user_id)->get();
        
        if($UserGallery){
            return response()->json(['status' => true, 'message' => 'User Gallery data', 'data' => $UserGallery]);
        }
        else{
            return response()->json(['status' => false, 'message' => 'Something went wrong!']);
        }
    }
    public function DeleteMedia(Request $request)
    {
        $user_id = $request->get('user_id');
        $usertoken = $request->get('user_token');
        $response = $this->apiManager->verifyUserToken($user_id,$usertoken);
        if(!$response) {
            return response()->json(['status' => false, 'message' => 'Unauthorized access!']);
        }
        $UserGallery = UserGallery::where('user_id',$user_id)->where('id',$request->media_id)->delete();
        
        if($UserGallery){
            return response()->json(['status' => true, 'message' => 'Media Deleted Successfull']);
        }
        else{
            return response()->json(['status' => false, 'message' => 'Something went wrong!']);
        }
    }
    public function DeleteAccount(Request $request)
    {
        $user_id = $request->get('user_id');
        $usertoken = $request->get('user_token');
        $response = $this->apiManager->verifyUserToken($user_id,$usertoken);
        if(!$response) {
            return response()->json(['status' => false, 'message' => 'Unauthorized access!']);
        }
        $AppUsers = AppUsers::find($user_id);
        $AppUsers->delete();
        Chats::where('sender_id',$user_id)->delete();
        Chats::where('receiver_id',$user_id)->delete();
        LikedUsers::where('user_id',$user_id)->delete();
        LikedUsers::where('like_user_id',$user_id)->delete();
        Favourite::where('user_id',$user_id)->delete();
        Favourite::where('favourite_user_id',$user_id)->delete();
        UserStory::where('user_id',$user_id)->delete();
        ViewStory::where('user_id',$user_id)->delete();
        Membership::where('user_id',$user_id)->delete();
        
        if($AppUsers){
            return response()->json(['status' => true, 'message' => 'Your Account Deleted Successfull.']);
        }
        else{
            return response()->json(['status' => false, 'message' => 'Something went wrong!']);
        }
    }
    public function DiscoverUsers(Request $request)
    {
        $user_id = $request->get('user_id');
        $usertoken = $request->get('user_token');
        $response = $this->apiManager->verifyUserToken($user_id,$usertoken);
        if(!$response) {
            return response()->json(['status' => false, 'message' => 'Unauthorized access!']);
        }
        $user = AppUsers::find($user_id);
        $lat = $user->latitude;
        $lon = $user->longitude;
        $radius = 1000;
        $profileurl = env('IMAGE_URL').'uploads/profile/';
        $profile_pic = DB::raw("CONCAT('$profileurl',app_users.profile) AS profile");
        $block_user = UserBlock::select('block_user_id')->where('user_id',$user_id)->get();
        $block_user_ids = $block_user->pluck('block_user_id')->toArray();
        $block_user_ids[] = $user_id;

        $LikedUsers = LikedUsers::select('like_user_id')->where('user_id',$user_id)->get();
        $LikedUsers_ids = $LikedUsers->pluck('like_user_id')->toArray();
        $ignore_ids = array_merge($block_user_ids,$LikedUsers_ids);

        $users = AppUsers::select("app_users.*",$profile_pic
                ,DB::raw("6371 * acos(cos(radians(" . $lat . ")) 
                * cos(radians(app_users.latitude)) 
                * cos(radians(app_users.longitude) - radians(" . $lon . ")) 
                + sin(radians(" .$lat. ")) 
                * sin(radians(app_users.latitude))) AS distance"))
                // ->where('app_users.id','!=',$user_id)
                ->whereNotIn('app_users.id',$ignore_ids)
                // ->groupBy("app_users.id")
                // ->having("distance", "<", $radius)
                ->orderBy("distance",'asc')
                ->get();
        if($users) {
            return response()->json(['status' => true, 'message' => 'Discover Data', 'data' => $users]);
        }
        else{
            return response()->json(['status' => false, 'message' => 'Something went wrong!']);
        }
    }
    public function DiscoverFilter(Request $request)
{
    $user_id = $request->get('user_id');
    $usertoken = $request->get('user_token');
    $response = $this->apiManager->verifyUserToken($user_id,$usertoken);
    if(!$response) {
        return response()->json(['status' => false, 'message' => 'Unauthorized access!']);
    }
    
    // Debug logging - add temporarily to see what's being received
    \Log::info('Filter Request Data:', [
        'distance' => $request->distance,
        'interested_in' => $request->interested_in,
        'min_age' => $request->min_age,
        'max_age' => $request->max_age,
        'interests' => $request->interests
    ]);
    
    $user = AppUsers::find($user_id);
    $lat = $user->latitude;
    $lon = $user->longitude;
    
    // Get filter parameters
    $radius = $request->distance;
    $interested_in = $request->interested_in;
    $min_age = (int)$request->min_age;
    $max_age = (int)$request->max_age;
    $interests = $request->interests;
    
    // Split interests string into array
    $interests_array = [];
    if($interests && trim($interests) !== '') {
        $interests_array = array_filter(array_map('trim', explode(',', $interests)));
    }
    
    $profileurl = env('IMAGE_URL').'uploads/profile/';
    $profile_pic = DB::raw("CONCAT('$profileurl',app_users.profile) AS profile");
    
    // Get blocked users
    $block_user = UserBlock::select('block_user_id')->where('user_id',$user_id)->get();
    $block_user_ids = $block_user->pluck('block_user_id')->toArray();
    $block_user_ids[] = $user_id;

    // Get already liked users
    $LikedUsers = LikedUsers::select('like_user_id')->where('user_id',$user_id)->get();
    $LikedUsers_ids = $LikedUsers->pluck('like_user_id')->toArray();
    $ignore_ids = array_merge($block_user_ids,$LikedUsers_ids);

    // Build the query
    $query = AppUsers::select("app_users.*",$profile_pic
            ,DB::raw("6371 * acos(cos(radians(" . $lat . ")) 
            * cos(radians(app_users.latitude)) 
            * cos(radians(app_users.longitude) - radians(" . $lon . ")) 
            + sin(radians(" .$lat. ")) 
            * sin(radians(app_users.latitude))) AS distance"));
    
    // Exclude blocked and liked users
    $query->whereNotIn('app_users.id',$ignore_ids);
    
    // Apply gender filter
    if($interested_in){
        $query->where('app_users.gender', $interested_in);
    }
    
    // Apply age filter - THIS IS THE KEY FIX
    if($min_age && $max_age){
        $query->where('app_users.age', '>=', $min_age);
        $query->where('app_users.age', '<=', $max_age);
    }
    
    // Apply interests filter
    if(!empty($interests_array)){
        $query->where(function($query1) use($interests_array) {
            foreach($interests_array as $interest) {
                $query1->orWhere('app_users.interests', 'like', "%$interest%");
            }
        });
    }
    
    // Apply distance filter
    if($radius){
        $query->having("distance", "<=", $radius);
    }

    $query->orderBy("distance",'asc');
    $users = $query->get();
    
    // Debug logging - add temporarily
    \Log::info('Filter Results Count:', ['count' => count($users)]);
    
    if($users) {
        return response()->json(['status' => true, 'message' => 'Filtered Users Data', 'data' => $users]);
    }
    else{
        return response()->json(['status' => false, 'message' => 'No users found matching your criteria']);
    }
}
    public function GetUserDetails(Request $request)
    {
        $user_id = $request->get('user_id');
        $usertoken = $request->get('user_token');
        $response = $this->apiManager->verifyUserToken($user_id,$usertoken);
        if(!$response) {
            return response()->json(['status' => false, 'message' => 'Unauthorized access!']);
        }
        $user = AppUsers::find($user_id);
        $lat = $user->latitude;
        $lon = $user->longitude;

        $detail_user_id = $request->detail_user_id;
        $profileurl = env('IMAGE_URL').'uploads/profile/';
        $profile_pic = DB::raw("CONCAT('$profileurl',app_users.profile) AS profile");
        $users = AppUsers::select("app_users.*",$profile_pic
                ,DB::raw("6371 * acos(cos(radians(" . $lat . ")) 
                * cos(radians(app_users.latitude)) 
                * cos(radians(app_users.longitude) - radians(" . $lon . ")) 
                + sin(radians(" .$lat. ")) 
                * sin(radians(app_users.latitude))) AS distance"))
                ->where('app_users.id',$detail_user_id)
                ->first();

        $galleryurl = env('IMAGE_URL').'uploads/gallery/';
        $filename = DB::raw("CONCAT('$galleryurl',user_gallery.filename) AS filename");
        $UserGallery = UserGallery::select('*',$filename)->where('user_id',$detail_user_id)->get();
        $users['gallery'] = $UserGallery;

        if($users) {
            return response()->json(['status' => true, 'message' => 'User details Data', 'data' => $users]);
        }
        else{
            return response()->json(['status' => false, 'message' => 'Something went wrong!']);
        }   
    }
    public function AddtoFavorite(Request $request)
    {
        $user_id = $request->get('user_id');
        $usertoken = $request->get('user_token');
        $response = $this->apiManager->verifyUserToken($user_id,$usertoken);
        if(!$response) {
            return response()->json(['status' => false, 'message' => 'Unauthorized access!']);
        }
        $to_user_id = $request->to_user_id;
        $check = Favourite::where('user_id',$user_id)->where('favourite_user_id',$to_user_id)->first();
        if($check){
            return response()->json(['status' => false, 'message' => 'User already in Favourite']);
        }
        $Favourite = new Favourite();
        $Favourite->user_id = $user_id;
        $Favourite->favourite_user_id = $to_user_id;
        $Favourite->save();
        if($Favourite){
            return response()->json(['status' => true, 'message' => 'User Added to Favourite successfully']);
        }
        else{
            return response()->json(['status' => false, 'message' => 'Something went wrong!']);
        }
    }
    public function GetUserFavorite(Request $request)
    {
        $user_id = $request->get('user_id');
        $usertoken = $request->get('user_token');
        $response = $this->apiManager->verifyUserToken($user_id,$usertoken);
        if(!$response) {
            return response()->json(['status' => false, 'message' => 'Unauthorized access!']);
        }
        $profileurl = env('IMAGE_URL').'uploads/profile/';
        $profile_pic = DB::raw("CONCAT('$profileurl',app_users.profile) AS profile");

        $FavouriteData = Favourite::join('app_users','app_users.id','favourite.favourite_user_id')->select('favourite.*','app_users.*',$profile_pic)->where('user_id',$user_id)->get();
        
        if($FavouriteData){
            return response()->json(['status' => true, 'message' => 'Favourite Data','data' => $FavouriteData]);
        }
        else{
            return response()->json(['status' => false, 'message' => 'Something went wrong!']);
        }   
    }
    public function RemovetoFavorite(Request $request)
    {
        $user_id = $request->get('user_id');
        $usertoken = $request->get('user_token');
        $response = $this->apiManager->verifyUserToken($user_id,$usertoken);
        if(!$response) {
            return response()->json(['status' => false, 'message' => 'Unauthorized access!']);
        }
        $to_user_id = $request->favourite_user_id;
        $delete = Favourite::where('user_id',$user_id)->where('favourite_user_id',$to_user_id)->delete();
        if($delete){
            return response()->json(['status' => true, 'message' => 'Remove User to Favourite successfully']);
        }
        else{
            return response()->json(['status' => false, 'message' => 'Something went wrong!']);
        }
    }
    public function CreateChat(Request $request)
{
    $user_id = $request->get('user_id');
    $usertoken = $request->get('user_token');
    $response = $this->apiManager->verifyUserToken($user_id,$usertoken);
    if(!$response) {
        return response()->json(['status' => false, 'message' => 'Unauthorized access!']);
    }
    
    $receiver_id = $request->get('receiver_id');
    
    // Check if chat already exists between these users
    $existingChat = Chats::where(function($query) use ($user_id, $receiver_id) {
        $query->where('sender_id', $user_id)
              ->where('receiver_id', $receiver_id);
    })->orWhere(function($query) use ($user_id, $receiver_id) {
        $query->where('sender_id', $receiver_id)
              ->where('receiver_id', $user_id);
    })->first();
    
    if($existingChat) {
        // Return existing chat
        return response()->json([
            'status' => true, 
            'message' => 'Chat already exists',
            'data' => ['id' => $existingChat->id]
        ]);
    }
    
    // Create new chat
    $chat = new Chats();
    $chat->sender_id = $user_id;
    $chat->receiver_id = $receiver_id;
    $chat->save();
    
    if($chat) {
        return response()->json([
            'status' => true, 
            'message' => 'Chat created successfully',
            'data' => ['id' => $chat->id]
        ]);
    } else {
        return response()->json(['status' => false, 'message' => 'Failed to create chat']);
    }
}

public function MarkTokenInvalid(Request $request)
{
    $user_id = $request->get('user_id');
    $usertoken = $request->get('user_token');
    $response = $this->apiManager->verifyUserToken($user_id,$usertoken);
    if(!$response) {
        return response()->json(['status' => false, 'message' => 'Unauthorized access!']);
    }
    
    $invalid_token = $request->get('device_token');
    $target_user_id = $request->get('target_user_id'); // User whose token is invalid
    
    if (empty($invalid_token) || empty($target_user_id)) {
        return response()->json(['status' => false, 'message' => 'Missing parameters']);
    }
    
    // Find user with this token and clear it
    $user = AppUsers::where('id', $target_user_id)
                    ->where('device_token', $invalid_token)
                    ->first();
    
    if ($user) {
        $user->device_token = null; // Clear invalid token
        $user->save();
        
        \Log::info("Cleared invalid device token for user: " . $target_user_id);
        
        return response()->json([
            'status' => true, 
            'message' => 'Invalid token cleared successfully'
        ]);
    }
    
    return response()->json([
        'status' => false, 
        'message' => 'User or token not found'
    ]);
}

public function UpdateDeviceToken(Request $request)
{
    $user_id = $request->get('user_id');
    $usertoken = $request->get('user_token');
    $response = $this->apiManager->verifyUserToken($user_id,$usertoken);
    if(!$response) {
        return response()->json(['status' => false, 'message' => 'Unauthorized access!']);
    }
    
    $device_token = $request->get('device_token');
    
    if (empty($device_token)) {
        return response()->json(['status' => false, 'message' => 'Device token is required']);
    }
    
    $user = AppUsers::find($user_id);
    if ($user) {
        // Only update if token has changed
        if ($user->device_token !== $device_token) {
            $user->device_token = $device_token;
            $user->save();
            
            \Log::info("Device token updated for user: " . $user_id);
        }
        
        return response()->json([
            'status' => true, 
            'message' => 'Device token updated successfully'
        ]);
    }
    
    return response()->json(['status' => false, 'message' => 'User not found']);
}
    public function UserLiked(Request $request)
    {
        $user_id = $request->get('user_id');
        $usertoken = $request->get('user_token');
        $response = $this->apiManager->verifyUserToken($user_id,$usertoken);
        if(!$response) {
            return response()->json(['status' => false, 'message' => 'Unauthorized access!']);
        }
        $to_user_id = $request->to_user_id;
        $check = LikedUsers::where('user_id',$user_id)->where('like_user_id',$to_user_id)->first();
        if($check){
            return response()->json(['status' => false, 'message' => 'Already Liked this Users']);
        }
        $LikedUsers = new LikedUsers();
        $LikedUsers->user_id = $user_id;
        $LikedUsers->like_user_id = $to_user_id;
        $LikedUsers->save();
        if($LikedUsers){
            return response()->json(['status' => true, 'message' => 'Liked Users successfully']);
        }
        else{
            return response()->json(['status' => false, 'message' => 'Something went wrong!']);
        }
    }
    public function GetUserLiked(Request $request)
    {
        $user_id = $request->get('user_id');
        $usertoken = $request->get('user_token');
        $response = $this->apiManager->verifyUserToken($user_id,$usertoken);
        if(!$response) {
            return response()->json(['status' => false, 'message' => 'Unauthorized access!']);
        }
        $profileurl = env('IMAGE_URL').'uploads/profile/';
        $profile_pic = DB::raw("CONCAT('$profileurl',app_users.profile) AS profile");

        $LikedUsersData = LikedUsers::join('app_users','app_users.id','liked_users.like_user_id')->select('liked_users.*','app_users.*',$profile_pic)->where('user_id',$user_id)->get();
        
        if($LikedUsersData){
            return response()->json(['status' => true, 'message' => 'Liked User Data','data' => $LikedUsersData]);
        }
        else{
            return response()->json(['status' => false, 'message' => 'Something went wrong!']);
        }
    }
    public function UserUnliked(Request $request)
    {
        $user_id = $request->get('user_id');
        $usertoken = $request->get('user_token');
        $response = $this->apiManager->verifyUserToken($user_id,$usertoken);
        if(!$response) {
            return response()->json(['status' => false, 'message' => 'Unauthorized access!']);
        }
        $to_user_id = $request->like_user_id;
        $delete = LikedUsers::where('user_id',$user_id)->where('like_user_id',$to_user_id)->delete();
        if($delete){
            return response()->json(['status' => true, 'message' => 'Unlike Users Successfully']);
        }
        else{
            return response()->json(['status' => false, 'message' => 'Something went wrong!']);
        }
    }
    public function CreateStory(Request $request)
    {
        $user_id = $request->get('user_id');
        $usertoken = $request->get('user_token');
        $response = $this->apiManager->verifyUserToken($user_id,$usertoken);
        if(!$response) {
            return response()->json(['status' => false, 'message' => 'Unauthorized access!']);
        }
        $UserStory = new UserStory();
        $UserStory->user_id = $user_id;
        if ($request->hasFile('storyfile')) {
            $file = $request->file('storyfile');
            $destinationPath = public_path('/uploads/story/');
            $storyfile = 'story' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $storyfile);
            $UserStory->storyfile = $storyfile;
        }
        $UserStory->expires_at = Carbon::now()->subDay(-1)->toDateTimeString();
        $UserStory->save();
        
        if($UserStory){
            return response()->json(['status' => true, 'message' => 'Your Story Has been Created.']);
        }
        else{
            return response()->json(['status' => false, 'message' => 'Something went wrong!']);
        }
    }
    public function DeleteStory(Request $request)
    {
        $user_id = $request->get('user_id');
        $usertoken = $request->get('user_token');
        $response = $this->apiManager->verifyUserToken($user_id,$usertoken);
        if(!$response) {
            return response()->json(['status' => false, 'message' => 'Unauthorized access!']);
        }
        $storyid = $request->storyid;

        $UserStory = UserStory::where('id',$storyid)->where('user_id',$user_id)->first();
        if($UserStory){
            $storyfile = 'public/uploads/story/'.$UserStory->storyfile;
            unlink($storyfile);
            $UserStory->delete();
            
            if($UserStory){
                return response()->json(['status' => true, 'message' => 'Your Story Has been Deleted.']);
            }
            else{
                return response()->json(['status' => false, 'message' => 'Something went wrong!']);
            }
        }else{
            return response()->json(['status' => false, 'message' => 'Something went wrong!']);
        }
    }
    public function GetYourStory(Request $request)
    {
        $user_id = $request->get('user_id');
        $usertoken = $request->get('user_token');
        $response = $this->apiManager->verifyUserToken($user_id,$usertoken);
        if(!$response) {
            return response()->json(['status' => false, 'message' => 'Unauthorized access!']);
        }
        $storyurl = env('IMAGE_URL').'uploads/story/';
        $storyfile   = DB::raw("CONCAT('$storyurl',user_story.storyfile) AS storyfile");
        $today = Carbon::now();
        $UserStory = UserStory::select('*',$storyfile)->where('user_id',$user_id)->where('expires_at','>=',$today)->orderBy('created_at','desc')->get();
        
        if($UserStory){
            return response()->json(['status' => true, 'message' => 'Story Data.','data' => $UserStory]);
        }
        else{
            return response()->json(['status' => false, 'message' => 'Something went wrong!']);
        }
    }
    public function GetFriendStory(Request $request)
    {
        $user_id = $request->get('user_id');
        $usertoken = $request->get('user_token');
        $response = $this->apiManager->verifyUserToken($user_id,$usertoken);
        if(!$response) {
            return response()->json(['status' => false, 'message' => 'Unauthorized access!']);
        }
        $storyurl = env('IMAGE_URL').'uploads/story/';
        $storyfile   = DB::raw("CONCAT('$storyurl',user_story.storyfile) AS storyfile");
        $profileurl = env('IMAGE_URL').'uploads/profile/';
        $profile_pic = DB::raw("CONCAT('$profileurl',app_users.profile) AS profile");

        $today = Carbon::now();
        // $UserStory = UserStory::select('*',$storyfile)->where('user_id',$user_id)->where('expires_at','>=',$today)->get();
        $FriendStory = LikedUsers::join('app_users','app_users.id','liked_users.like_user_id')
        ->join('user_story','user_story.user_id','liked_users.like_user_id')
        ->select('liked_users.*','user_story.user_id as suser_id','app_users.firstname','app_users.lastname',$profile_pic)
        ->where('liked_users.user_id',$user_id)
        ->orderBy('user_story.created_at','desc')
        // ->groupBy("user_story.user_id")
        ->get()
        ->unique('suser_id');

        // echo json_encode($FriendStory);
        // exit;

        // $FriendStory = LikedUsers::join('app_users','app_users.id','liked_users.like_user_id')->select('liked_users.*','app_users.firstname','app_users.lastname',$profile_pic)->where('liked_users.user_id',$user_id)->get();
        $data = [];
        foreach ($FriendStory as $key => $value) {
            $UserStory = UserStory::select('*',$storyfile,DB::raw("(SELECT count(view_story.id) FROM view_story WHERE view_story.story_id=user_story.id AND view_story.user_id=$user_id)  as is_view"))->where('user_id',$value->like_user_id)->where('expires_at','>=',$today)->orderBy('created_at','desc')->get();
            if(!collect($UserStory)->isEmpty()){
                $value['story'] = $UserStory;
                $data[] = $value;
            }
        }
        if($data){
            return response()->json(['status' => true, 'message' => 'Friend Story Data.','data' => $data]);
        }
        else{
            return response()->json(['status' => false, 'message' => 'Something went wrong!']);
        }
    }
    public function UserViewStory(Request $request)
    {
        $user_id = $request->get('user_id');
        $usertoken = $request->get('user_token');
        $response = $this->apiManager->verifyUserToken($user_id,$usertoken);
        if(!$response) {
            return response()->json(['status' => false, 'message' => 'Unauthorized access!']);
        }
        $story_id = $request->story_id;
        $check = ViewStory::where('story_id',$story_id)->where('user_id',$user_id)->first();
        if(!$check){
            $ViewStory = new ViewStory();
            $ViewStory->story_id = $story_id;
            $ViewStory->user_id = $user_id;
            $ViewStory->save();

            if($ViewStory){
                $updateview = UserStory::find($story_id);
                $updateview->views = $updateview->views + 1;
                $updateview->save();
                return response()->json(['status' => true, 'message' => 'Story Seen.']);
            }
            else{
                return response()->json(['status' => false, 'message' => 'Something went wrong!']);
            }
        }else{
            return response()->json(['status' => true, 'message' => 'Already Story Seen.']);
        }
    }
    public function GetStoryseenUserlist(Request $request)
    {
        $user_id = $request->get('user_id');
        $usertoken = $request->get('user_token');
        $response = $this->apiManager->verifyUserToken($user_id,$usertoken);
        if(!$response) {
            return response()->json(['status' => false, 'message' => 'Unauthorized access!']);
        }
        $story_id = $request->story_id;
        $profileurl = env('IMAGE_URL').'uploads/profile/';
        $profile_pic = DB::raw("CONCAT('$profileurl',app_users.profile) AS profile");

        $getstoryseenuser = ViewStory::join('app_users','app_users.id','view_story.user_id')
        ->select('app_users.id','app_users.firstname','app_users.lastname',$profile_pic)
        ->where('story_id',$story_id)->orderBy('view_story.id','desc')->get();

        if($getstoryseenuser){
            return response()->json(['status' => true, 'message' => 'Story Seen Userlist Data.', 'data' => $getstoryseenuser]);
        }else{
            return response()->json(['status' => false, 'message' => 'Something went wrong!']);
        }
    }
    public function GetChats(Request $request)
    {
        $user_id = $request->get('user_id');
        $usertoken = $request->get('user_token');
        $response = $this->apiManager->verifyUserToken($user_id,$usertoken);
        if(!$response) {
            return response()->json(['status' => false, 'message' => 'Unauthorized access!']);
        }
        $today = Carbon::now();
        $profileurl = env('IMAGE_URL').'uploads/profile/';
        $profile_pic = DB::raw("CONCAT('$profileurl',app_users.profile) AS profile");

        $storyurl = env('IMAGE_URL').'uploads/story/';
        $storyfile   = DB::raw("CONCAT('$storyurl',user_story.storyfile) AS storyfile");

        $chats = Chats::orwhere('sender_id',$user_id)->orwhere('receiver_id',$user_id)->get();
        foreach ($chats as $key => $value) {
            if($value->sender_id!=$user_id){
                $appuser_id = $value->sender_id;
            }else{
                $appuser_id = $value->receiver_id;
            }
            $getuserinfo = AppUsers::select('app_users.firstname','app_users.lastname','app_users.device_token',$profile_pic)->where('id',$appuser_id)->first();
            $value['user_id'] = $appuser_id;
            $value['firstname'] = $getuserinfo->firstname;
            $value['lastname'] = $getuserinfo->lastname;
            $value['profile'] = $getuserinfo->profile;
            $value['device_token'] = $getuserinfo->device_token;
            $checkblock = UserBlock::where('user_id',$user_id)->where('block_user_id',$appuser_id)->first();
            $checkblock1 = UserBlock::where('user_id',$appuser_id)->where('block_user_id',$user_id)->first();
            if($checkblock || $checkblock1){
                $value['blocked'] = true;
            }else{
                $value['blocked'] = false;
            }
            $UserStory = UserStory::select('*',$storyfile,DB::raw("(SELECT count(view_story.id) FROM view_story WHERE view_story.story_id=user_story.id AND view_story.user_id=$user_id)  as is_view"))->where('user_id',$appuser_id)->where('expires_at','>=',$today)->orderBy('created_at','desc')->get();            
            $value['story'] = $UserStory;
        }

        if($chats){
            return response()->json(['status' => true, 'message' => 'User Chat Data.', 'data' => $chats]);
        }else{
            return response()->json(['status' => false, 'message' => 'Something went wrong!']);
        }
    }
    public function GetChatConversion(Request $request)
    {
        $user_id = $request->get('user_id');
        $usertoken = $request->get('user_token');
        $response = $this->apiManager->verifyUserToken($user_id,$usertoken);
        if(!$response) {
            return response()->json(['status' => false, 'message' => 'Unauthorized access!']);
        }
        $today = Carbon::now();
        $chats_id = $request->chats_id;
        
        $fileurl = env('IMAGE_URL').'uploads/chatmedia/';
        // $fileurl = 'http://195.35.20.122/public/uploads/chatmedia/';
        $file = DB::raw("CONCAT('$fileurl',chat_conversion.file) AS file");

        $ChatConversion = ChatConversion::select('*',$file)->where('chats_id',$chats_id)->get();
        
        if($ChatConversion){
            return response()->json(['status' => true, 'message' => 'ChatConversion Data.', 'data' => $ChatConversion]);
        }else{
            return response()->json(['status' => false, 'message' => 'Something went wrong!']);
        }
    }
    public function AbuseReport(Request $request)
    {
        $user_id = $request->get('user_id');
        $usertoken = $request->get('user_token');
        $response = $this->apiManager->verifyUserToken($user_id,$usertoken);
        if(!$response) {
            return response()->json(['status' => false, 'message' => 'Unauthorized access!']);
        }
        $AbuseReport = new AbuseReport();
        $AbuseReport->user_id = $user_id;
        $AbuseReport->reported_userid = $request->reported_userid;
        $AbuseReport->reason = $request->reason;
        $AbuseReport->save();

        if($AbuseReport){
            return response()->json(['status' => true, 'message' => 'Abuse Report Send Successfully.']);
        }else{
            return response()->json(['status' => false, 'message' => 'Something went wrong!']);
        }
    }
    public function GetPackages(Request $request)
    {
        $user_id = $request->get('user_id');
        $usertoken = $request->get('user_token');
        $response = $this->apiManager->verifyUserToken($user_id,$usertoken);
        if(!$response) {
            return response()->json(['status' => false, 'message' => 'Unauthorized access!']);
        }
        $packages = Packages::where('status',1)->get();
        
        if($packages){
            return response()->json(['status' => true, 'message' => 'Packages Data', 'data' => $packages]);
        }else{
            return response()->json(['status' => false, 'message' => 'Something went wrong!']);
        }
    }
    public function BuyPackage(Request $request)
    {
        $user_id = $request->get('user_id');
        $usertoken = $request->get('user_token');
        $response = $this->apiManager->verifyUserToken($user_id,$usertoken);
        if(!$response) {
            return response()->json(['status' => false, 'message' => 'Unauthorized access!']);
        }

        $package_id = $request->package_id;
        $payment_id = $request->payment_id;
        $status = $request->status;
        if($payment_id && $status==1){
            $packages = Packages::find($package_id);
            $user = AppUsers::find($user_id);
            if($packages->credits=='unlimited'){
                $user->swipes_tokens = -1;
            }else{
                $user->swipes_tokens = $user->swipes_tokens + $packages->credits;    
            }
            $user->save();
        }

        $membership = new Membership();
        $membership->user_id = $user_id;
        $membership->package_id = $package_id;
        $membership->payment_id = $payment_id;
        $membership->status = $status;
        $membership->save();
        
        if($membership){
            return response()->json(['status' => true, 'message' => 'Membership Buy Successfully']);
        }else{
            return response()->json(['status' => false, 'message' => 'Something went wrong!']);
        }
    }
    public function GetTransaction(Request $request)
    {
        $user_id = $request->get('user_id');
        $usertoken = $request->get('user_token');
        $response = $this->apiManager->verifyUserToken($user_id,$usertoken);
        if(!$response) {
            return response()->json(['status' => false, 'message' => 'Unauthorized access!']);
        }

        $Membership = Membership::leftjoin('packages','packages.id','membership.package_id')
        ->select('membership.*','packages.package_name','packages.price','packages.credits')
        ->orderBy('id','desc')->get();

        if($Membership){
            return response()->json(['status' => true, 'message' => 'Transaction Data', 'data' => $Membership]);
        }else{
            return response()->json(['status' => false, 'message' => 'Something went wrong!']);
        }
    }
    public function GetUserBlock(Request $request)
    {
        $user_id = $request->get('user_id');
        $usertoken = $request->get('user_token');
        $response = $this->apiManager->verifyUserToken($user_id,$usertoken);
        if(!$response) {
            return response()->json(['status' => false, 'message' => 'Unauthorized access!']);
        }
        $profileurl = env('IMAGE_URL').'uploads/profile/';
        $profile_pic = DB::raw("CONCAT('$profileurl',app_users.profile) AS profile");

        $UserBlock = UserBlock::leftjoin('app_users','app_users.id','user_block.block_user_id')
        ->select('user_block.*','app_users.firstname','app_users.lastname',$profile_pic)
        ->where('user_block.user_id',$user_id)
        ->get();

        if($UserBlock){
            return response()->json(['status' => true, 'message' => 'User Blocked Data', 'data' => $UserBlock]);
        }else{
            return response()->json(['status' => false, 'message' => 'Something went wrong!']);
        }   
    }
    public function UserBlock(Request $request)
    {
        $user_id = $request->get('user_id');
        $usertoken = $request->get('user_token');
        $response = $this->apiManager->verifyUserToken($user_id,$usertoken);
        if(!$response) {
            return response()->json(['status' => false, 'message' => 'Unauthorized access!']);
        }
        $block_user_id = $request->block_user_id;
        $check = UserBlock::where('user_id',$user_id)->where('block_user_id',$block_user_id)->first();
        if($check){
            return response()->json(['status' => false, 'message' => 'User Already Blocked']);
        }
        $user = new UserBlock();
        $user->user_id = $user_id;
        $user->block_user_id = $block_user_id;
        $user->save();

        if($user){
            return response()->json(['status' => true, 'message' => 'User Blocked Successfully']);
        }else{
            return response()->json(['status' => false, 'message' => 'Something went wrong!']);
        }
    }
    public function UserUnBlock(Request $request)
    {
        $user_id = $request->get('user_id');
        $usertoken = $request->get('user_token');
        $response = $this->apiManager->verifyUserToken($user_id,$usertoken);
        if(!$response) {
            return response()->json(['status' => false, 'message' => 'Unauthorized access!']);
        }

        $user = UserBlock::where('block_user_id',$request->block_user_id)->delete();

        if($user){
            return response()->json(['status' => true, 'message' => 'User UnBlock Successfully']);
        }else{
            return response()->json(['status' => false, 'message' => 'Something went wrong!']);
        }
    }
    public function Swipes(Request $request)
    {
        $user_id = $request->get('user_id');
        $usertoken = $request->get('user_token');
        $response = $this->apiManager->verifyUserToken($user_id,$usertoken);
        if(!$response) {
            return response()->json(['status' => false, 'message' => 'Unauthorized access!']);
        }
        $user = AppUsers::find($user_id);
        if($user->swipes_tokens!=-1){
            if($user->swipes_tokens>0){
                $user->swipes_tokens -= 1;
                $user->save();
            }else{
                return response()->json(['status' => false, 'swipes_tokens' => $user->swipes_tokens,'message' => 'swipes tokens not available']);
            }
        }
        
        if($user){
            return response()->json(['status' => true, 'swipes_tokens' => $user->swipes_tokens]);
        }else{
            return response()->json(['status' => false, 'message' => 'Something went wrong!']);
        }
    }
}