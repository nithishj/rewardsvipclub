<?php

Class admin_users_model extends CI_Model
{

function plususer($username,$to_email,$role,$gender)
{
 $q=$this->db->query("select user_id from users where email='$to_email' and Deleted=0");
 
 if($q->num_rows()==0)
 {
 
		$href = base_url()."mailer/page/".base64_encode($to_email);
		$link = '<a href="'.$href.'">Click Here</a>';
		$notes="<html><body>Hello!"."<br/><br/>"."We received a request to provide you with your VIP App Login Credentials, Please click on the link below to Set your Password."."<br/><br/>".
				"Username : ".$to_email."<br/> Link :".$link."<br/><br/>"."Thank you for using VIP!"."<br/><br/>".
				"VIP Team</body></html>";
 
  $config=array('protocol'=>'smtp','smtp_host'=>'dedrelay.secureserver.net','smtp_port'=>25,'smtp_user'=>'','smtp_pass'=>'');
                $this->load->library('email',$config);
                $this->email->set_newline("\r\n");
                $this->email->from('VIP@rewardsvipclub.com', 'VIP');
                $this->email->to($to_email);
                $this->email->subject("Set VIP Password");
                $this->email->message($notes);
				$this->email->set_mailtype("html");
	
    if ($this->email->send()){
    
				    $a=array("email"=>$to_email,"Status"=>3,"user_role"=>$role);
		            $this->db->insert('users',$a);
					$id=$this->db->insert_id();
					$b=array("user_id"=>$id,"user_name"=>$username,"gender"=>$gender);
					$this->db->insert('user_profile',$b);
					
				    return array("code"=>"200","User added successfully");
				}
				else
				{
					// failed message
					 return array("code"=>400,"message"=>"Mail delivery failed or Invalid Email.");
				}

 }
 else
 {
   return array("code"=>400,"message"=>"User with this Email already Exists");
 }

} 
 
function pushmessage($msg,$userid,$type,$color,$image,$audio,$video,$thumb)
{
 if(!empty($video) && empty($thumb))
 $thumb="includes/images/defaultthumb.png";
 
$a=array("Message"=>$msg,"Fr_UserId"=>$userid,"BroadcastType"=>$type,"Color"=>$color,"Image"=>$image,"Audio"=>$audio,"Video"=>$video,"VideoThumb"=>$thumb);
$this->db->insert('broadcast',$a);
$q=$this->db->query("select device_token from user_profile where device_token is not null and char_length(device_token)>0 group by device_token");

if($q->num_rows()>0)
{
$r=$q->result();
foreach($r as $v)
{
   $this->iosnotify($v->device_token,(strlen($msg) > 110) ? substr($msg,0,110).'... More' : $msg,$type);
}
}
return array("code"=>200);
}

function iosnotify($devicetoken,$message,$type)
{
$time = time();
$apnsHost = 'gateway.push.apple.com';
$apnsPort = 2195;
$apnsCert = 'vip.pem';
$streamContext = stream_context_create();
stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);
$apns = stream_socket_client('ssl://' . $apnsHost . ':' . $apnsPort, $error, $errorString, 2, STREAM_CLIENT_CONNECT,$streamContext);
if($apns)
{
$payload = array();
//$payload['aps'] = array('alert' => $message, 'badge' => 1, 'sound' => 'default','notifytype'=>$notifytype,'keyword'=>$keyword);strval($badge)
$payload['aps'] = array('alert' => $message,'sound' => 'default','badge'=>1,"broadcasttype"=>$type);
$payload = json_encode($payload);
$apnsMessage = chr(0) . chr(0) . chr(32) . pack('H*', str_replace(' ', '', $devicetoken)) . chr(0) . chr(strlen($payload)) . $payload;
fwrite($apns, $apnsMessage);
//echo 'Push Message Sent Successfully';
//echo $payload;
//print_r($payload);
//echo $notifytype.'/'.$deviceToken.'/'.$message.'/'.$keyword;
//echo $payload;
}
else
{
/*echo "Connection Failed - iPhone Push Notifications Server";
echo $errorString."<br />";
echo $error."<br />";*/
}
fclose($apns);

}
	
	
}