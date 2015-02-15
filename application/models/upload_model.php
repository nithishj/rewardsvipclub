<?php

Class upload_model extends CI_Model
{

	function upload($userid,$message,$color,$myimage,$myaudio,$myvideo,$myvideothumb,$broadcast_type,$latitude,$longitude,$address)
	{

		$data=array("Message"=>$message,"Fr_UserId"=>$userid,"Image"=>!empty($myimage)?$myimage:"","Color"=>!empty($color)?$color:"","Audio"=>!empty($myaudio)?$myaudio:"","Video"=>!empty($myvideo)?$myvideo:"","Latitude"=>$latitude,"Longitude"=>$longitude,"Address"=>$address,"VideoThumb"=>!empty($myvideothumb)?$myvideothumb:"","BroadcastType"=>$broadcast_type);
		$this->db->insert('broadcast',$data);
		
		$this->db->select('device_token');
		$q=$this->db->get('user_profile');
		$r=$q->result();
		foreach($r as $v)
		{       
		 $this->iosnotify($v->device_token,(strlen($message) > 110) ? substr($message,0,110).'... More' : $message,$broadcast_type);
		}

		return array("message"=>"success","code"=>200);
	}
	

       function delbroadcast($broadcastid)
       {
         $q=$this->db->query("delete from broadcast where BroadcastId in($broadcastid)");
         if($q)
         return array("message"=>"success","code"=>200);
         else
         return array("message"=>"fail","code"=>400);
       }
	
	function getupload($broadcast_type)
	{
                $msg=array();
		$q=$this->db->query("select b.*,c.r_value,c.g_value,c.b_value,c.r_fore_value,c.g_fore_value,c.b_fore_value, c.color_images,b.Latitude,b.Longitude,b.Address  from broadcast b left join color_lookup c on b.Color=c.color_lookup_id where b.BroadcastType='$broadcast_type' order by b.BroadcastId desc limit 0,20");
		$v=$q->result();
		foreach($v as $val)
		{
			$msg[]=array("BroadcastId"=>$val->BroadcastId,"Message"=>$val->Message,"Fr_UserId"=>$val->Fr_UserId,"Image"=>!empty($val->Image)?base_url().$val->Image:"","Color"=>$val->Color,"Rvalue"=>!empty($val->r_value)?$val->r_value:"0","Gvalue"=>!empty($val->g_value)?$val->g_value:"0","Bvalue"=>!empty($val->b_value)?$val->b_value:"0","R_fore_value"=>!empty($val->r_fore_value)?$val->r_fore_value:"0","G_fore_value"=>!empty($val->g_fore_value)?$val->g_fore_value:"0","B_fore_value"=>!empty($val->b_fore_value)?$val->b_fore_value:"0","Audio"=>!empty($val->Audio)?base_url().$val->Audio:"","Video"=>!empty($val->Video)?base_url().$val->Video:"","VideoThumb"=>!empty($val->VideoThumb)?base_url().$val->VideoThumb:"","color_images"=>!empty($val->color_images)?base_url()."color_images/".$val->color_images:"","Latitude"=>!empty($val->Latitude)?$val->Latitude:"","Longitude"=>!empty($val->Longitude)?$val->Longitude:"","Address"=>!empty($val->Address)?$val->Address:"");
	    }
			return $msg;
	}

function clonebroadcast($broadcastid,$userid)
{
$q=$this->db->query("select * from broadcast where BroadcastId='$broadcastid'");
$r=$q->row();
$a=array("BroadcastType"=>$r->BroadcastType,"Message"=>$r->Message,"Fr_UserId"=>$userid,"Image"=>$r->Image,"Color"=>$r->Color,"Audio"=>$r->Audio,"Video"=>$r->Video,"VideoThumb"=>$r->VideoThumb,"Latitude"=>$r->Latitude,"Longitude"=>$r->Longitude,"Address"=>$r->Address);
$this->db->insert('broadcast',$a);
return array("message"=>"success");
}
	
	function iosnotify($devicetoken,$message,$broadcast_type)
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
            $payload['aps'] = array('alert' => $message,'sound' => 'default','badge'=>1,"broadcasttype"=>$broadcast_type);
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