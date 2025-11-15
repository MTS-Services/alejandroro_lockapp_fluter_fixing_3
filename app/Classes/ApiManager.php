<?php
namespace App\Classes;
use Config;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon;
use Auth;
use DB;
use Mail;
use App\Models\AppUsers;

class ApiManager
{
    public function getUserToken() {

        // Produces something like "2019-03-11 12:25:00"

        $current_date_time = Carbon::now()->toDateTimeString(); 

        return bcrypt($current_date_time);

    }
    public function getUniqueCode($length_of_string) { 

    	$str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; 

    	// $str_result = '0123456789'; 

    	return substr(str_shuffle($str_result),0, $length_of_string); 
    } 
    public function getOTP() {
        return rand(100000, 999999);
    }
    public function verifyUserToken($user_id,$usertoken) {

        $check = AppUsers::where('id',$user_id)->where('user_token',$usertoken)->where('status',1)->first();
        
        if($check)
            return true;
        else
            return false;
    }
    public function getUserProfile($user_id) {

        $profileurl = env('IMAGE_URL').'uploads/profile/';
        $profile_pic = DB::raw("CONCAT('$profileurl',app_users.profile) AS profile");

        $data = AppUsers::select('app_users.*',$profile_pic)
        ->where('app_users.id',$user_id)
        ->first();
        
        return $data;

    }
    public function sendfcmNotification($user_id, $title, $message) {

        $user = AppUsers::select('device_token')->where('id',$user_id)->whereNotNull('device_token')->first();
        if($user) 
        {
            $app_key = env('NOTIFICATION_KEY');
            $token = $user->device_token;
            $registrationIds = array($token);
            $msg = array (
                'title' => $title,
                'message' => $message,
            );
            $fields = array('registration_ids' => $registrationIds, 'data' => $msg);
            $headers = array('Authorization: key='.$app_key, 'Content-Type: application/json');
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

            $result = curl_exec($ch);

            curl_close($ch);

            $res = json_decode($result);

            if ($res->success == 1) {

                $create_notify = new Notifications();

                $create_notify->user_id = $user_id;

                $create_notify->title = $title;

                $create_notify->message = $message;

                $create_notify->save();

            } 
            return true;
        }
    }
    public function sendSMS($user_id,$message) {
        $user = User::find($user_id);

        if($user) {
            $sms = $message;

            $mobile = $user->mobile;

            $msg  = urlencode($message);
            
            $smsapi_data = SmsApi::where('status',1)->first();
            if($smsapi_data){
                $url = $smsapi_data->sms_url;
                if($mobile){
                    $url = str_replace("mobileno", $mobile, $url);
                }
                if($msg){
                    $url = str_replace("msg", $msg, $url);
                }
                // $url = __($smsapi_data->sms_url, ['mobile'=>$mobile,'message' => $msg]);
                // $url = "https://www.bulksmsplans.com/api/send_sms?api_id=API0LiBCuRW18899&api_password=Yqv4W9cf&sms_type=Transactional&sms_encoding=text&sender=MOBWDD&number=".$mobile."&message=".$msg;
                //$url = "https://mobilesmsapi.com/api/send_sms?api_token=c0a09f35-2371-43c5-94c0-7859650807d3&mobile=".$mobile."&message=".$msg;
                
                $ch = curl_init($url);

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $response = curl_exec($ch);

                curl_close($ch);
                
                

                $reponse_data = new ResponseTable();

                $reponse_data->response = $response;

                $reponse_data->api_name = 'SMS';

                $reponse_data->request = $sms;

                $reponse_data->save();
            }
        }

        return true;

    }
    public function sendDynamicSMS($user_id,$temp_id,$smsdata) {
    
        $user = User::find($user_id);

        if($user) {

            $mobile = $user->mobile;
            
            $smsapi_data = SmsApi::where('isDefault',1)->where('status',1)->first();
            if($smsapi_data){
                $url = $smsapi_data->sms_url;
                
                $get_templateformat = TemplateFormat::where('template_id',$temp_id)->where('isEnableSMS',1)->first();
                if($get_templateformat){
                    $msg = __($get_templateformat->smsTemplate, $smsdata);
                    $template_id = $get_templateformat->templateID;
                    $url = __($smsapi_data->sms_url, ['mobile'=>$mobile,'message' => $msg,'template_id'=>$template_id]);
                    
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    curl_close($ch);
                    
                    $reponse_data = new ResponseTable();
                    $reponse_data->response = $response;
                    $reponse_data->api_name = 'SMS';
                    $reponse_data->request = $msg;
                    $reponse_data->save();
                }
            }

            $whatsapp_api_data = SmsApi::where('isWhatsApp',1)->where('status',1)->first();
            if($whatsapp_api_data){
                $whatsurl = $whatsapp_api_data->sms_url;
                
                $get_whatsappformat = TemplateFormat::where('template_id',$temp_id)->where('isEnableWhatsApp',1)->first();
                if($get_whatsappformat){
                    $whatsmsg = __($get_whatsappformat->smsTemplate, $smsdata);

                    $whatsurl = __($whatsapp_api_data->sms_url, ['mobile'=>"91".$mobile,'message' => urlencode($whatsmsg)]);
                
                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                      CURLOPT_URL => $whatsurl,
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_ENCODING => "",
                      CURLOPT_MAXREDIRS => 10,
                      CURLOPT_TIMEOUT => 30,
                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                      CURLOPT_CUSTOMREQUEST => "GET",
                      CURLOPT_HTTPHEADER => array(
                        "cache-control: no-cache",
                        "postman-token: e0431515-d743-4d44-91aa-685bba9b342d"
                      ),
                    ));

                    $response = curl_exec($curl);
                    
                    $reponse_data = new ResponseTable();
                    $reponse_data->response = $response;
                    $reponse_data->api_name = 'WhatsApp';
                    $reponse_data->request = $whatsmsg;
                    $reponse_data->save();
                }
            }
        }
        //$this->sendEmail($user_id,$temp_id,$smsdata);
        return true;
    }
    public function sendEmail($user_id,$temp_id,$emaildata) {
        $user = User::find($user_id);
        $emailapi = EmailSetting::where('status',1)->first();
        if($emailapi){

            $config = array(
                'driver'     =>     'smtp',
                'host'       =>     $emailapi->host_name,
                'port'       =>     $emailapi->port,
                'username'   =>     $emailapi->email,
                'password'   =>     $emailapi->password,
                'encryption' =>     'ssl'
            );
            Config::set('mail', $config);

            $get_templateformat = TemplateFormat::where('template_id',$temp_id)->where('isEnableEmail',1)->first();
            
            if($get_templateformat){
                $msg = __($get_templateformat->emailTemplate, $emaildata);
                $data = [
                    'textmsg' => $msg
                ];
                Mail::send(['html' => 'mail'], $data, function($message) use ($get_templateformat,$user,$emailapi) {
                    $message->to($user->email, '')->subject($get_templateformat->subject);
                    $message->from($emailapi->email,env('APP_NAME'));
                });
            }
        }

        /*Mail::send(['text' => 'mail'], $data, function ($message)
        {
            $message->to('abc@gmail.com', 'Lorem Ipsum')
                ->subject('Laravel Basic Testing Mail');
            $message->from('xyz@gmail.com', $data['name']);
        });*/
        /*$user = User::find($user_id);

        if($user) {

            $mobile = $user->mobile;
            
            $smsapi_data = SmsApi::where('status',1)->first();
            if($smsapi_data){
                $url = $smsapi_data->sms_url;
                
                $get_templateformat = TemplateFormat::where('template_id',$temp_id)->where('isEnableSMS',1)->first();
                if($get_templateformat){
                    $msg = __($get_templateformat->smsTemplate, $smsdata);

                    $url = __($smsapi_data->sms_url, ['mobile'=>$mobile,'message' => $msg]);

                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    curl_close($ch);
                    
                    $reponse_data = new ResponseTable();
                    $reponse_data->response = $response;
                    $reponse_data->api_name = 'SMS';
                    $reponse_data->request = $msg;
                    $reponse_data->save();
                }
            }
        }*/
        return true;
    }
}