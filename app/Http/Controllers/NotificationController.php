<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Auth;
use DB;
use App\Models\AppUsers;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Kreait\Firebase\Messaging\CloudMessage;
class NotificationController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    public function Index() {
        return view('admin.notification.index');
    }
    public function SendNotification(Request $request)
    {
        $imageUrl = '';
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $destinationPath = public_path('/uploads/notification/');
            $image = 'noti'. time() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $image);
            // $Notification->image = $image;
            $imageUrl = env('IMAGE_URL').'uploads/notification/'.$image;
        }
        $users = AppUsers::select('device_token')->where('device_token','!=','')->get();
        $deviceTokens = [];
        foreach($users as $user){
            $deviceTokens[] = $user->device_token;
        }
        $title = $request->title;
        $body = $request->description;

        $messaging = app('firebase.messaging');
        
        if($request->scheduledTime){
            $notification = array('title' =>$title , 'body' => $body,'image'=> $imageUrl, 'sound' => 'default', 'badge' => '1','isScheduled'=>'true','scheduledTime'=>$request->scheduledTime);
        }else{
            $notification = array('title' =>$title , 'body' => $body,'image'=> $imageUrl, 'sound' => 'default', 'badge' => '1');
        }
        $message = CloudMessage::fromArray([
            'notification' => $notification
        ]);
        $sendReport = $messaging->sendMulticast($message, $deviceTokens);

        return redirect()->back()->with('success','Notification has been Send Successfull.');

        /*foreach($users as $user){
            
            $url = "https://fcm.googleapis.com/fcm/send";
            $token = $user->device_token;
            $serverKey = env('NOTIFICATION_KEY');
            $title = $request->title;
            $body = $request->description;
            
            // $notification = array('title' =>$request->title , 'body' => $request->description,'image'=> $imageUrl, 'sound' => 'default', 'badge' => '1');
            if($request->scheduledTime){
                $notification = array('title' =>$title , 'body' => $body,'image'=> $imageUrl, 'sound' => 'default', 'badge' => '1','isScheduled'=>'true','scheduledTime'=>$request->scheduledTime);
            }else{
                $notification = array('title' =>$title , 'body' => $body,'image'=> $imageUrl, 'sound' => 'default', 'badge' => '1');
            }
            $arrayToSend = array('to' => $token, 'notification' => $notification,'priority'=>'high');
            $json = json_encode($arrayToSend);
            $headers = array();
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Authorization: key='. $serverKey;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
            //Send the request
            $response = curl_exec($ch);
            curl_close($ch);

        }
        return redirect()->back()->with('success','Notification has been Send Successfull.');*/
    }
}