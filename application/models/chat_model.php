<?php

Class chat_model extends CI_Model
{

	function listusers($id,$start)
	{
	  $baseurl=base_url();
	  $thumb=$baseurl."resize.php?height=50&width=50&path=";
	  $q=$this->db->query("select uu.user_id,up.user_name,case when up.profile_picture is null or char_length(up.profile_picture)=0 then '' else concat('$thumb',up.profile_picture) end as profile_picture, uu.OnStatus from users uu inner join user_profile up on uu.user_id=up.user_id where uu.Deleted=0 and uu.Status=1 and uu.user_id!='$id' order by uu.user_id=1 desc,uu.OnStatus limit $start,20");
	if($q->num_rows()>0)
		return $q->result();
	else
		return array("code"=>400,"message"=>"No Users To display");
	
	}
	
	function setChatStatus($id,$status)
    {
	$q=$this->db->query("select Status from users where user_id='$id'");
	$r=$q->row();
	if($r->Status==2)
	{
	return array("code"=>400,"message"=>"Your Account has been blocked by Admin");
	}
	else
	{
	$a=array("OnStatus"=>$status);
	$this->db->where("user_id",$id);
	$this->db->update("users",$a);
	return array("code"=>200);
	}
	}
	
	function chatMessage($userid,$friendid,$message,$myimage,$myvideo,$myvideothumb,$myaudio,$latitude,$longitude,$address,$iconid)
	{
        $this->iconhistory($iconid,$userid);
		$data=array("Message"=>$message,"UserId"=>$userid,"FriendId"=>$friendid,"Image"=>!empty($myimage)?$myimage:"","Audio"=>!empty($myaudio)?$myaudio:"","Video"=>!empty($myvideo)?$myvideo:"","VideoThumb"=>!empty($myvideothumb)?$myvideothumb:"","Latitude"=>$latitude,"Longitude"=>$longitude,"Address"=>$address,"IconId"=>$iconid);
		$this->db->insert('chat',$data);
		
		$q=$this->db->query("select device_token from user_profile where device_token is not null and char_length(device_token)>0 and user_id='$friendid' group by device_token");
		if($q->num_rows()>0)
		{
		
		$r=$q->row();
		foreach($r as $v)
		{
		$this->iosnotify($v->device_token,(strlen($message) > 110) ? substr($message,0,110).'... More' : $message);
		}
		
		}
		
		return array("message"=>"success","code"=>200);
	}
	
	function groupMessage($userid,$message,$myimage,$myvideo,$myvideothumb,$myaudio,$latitude,$longitude,$address,$iconid,$eventid)
	{
        $this->iconhistory($iconid,$userid);
		$data=array("Message"=>$message,"UserId"=>$userid,"Image"=>!empty($myimage)?$myimage:"","Audio"=>!empty($myaudio)?$myaudio:"","Video"=>!empty($myvideo)?$myvideo:"","VideoThumb"=>!empty($myvideothumb)?$myvideothumb:"","Latitude"=>$latitude,"Longitude"=>$longitude,"Address"=>$address,"IconId"=>$iconid,"EventId"=>$eventid);
		$this->db->insert('groupchat',$data);
		
		if($eventid==0)
		$q=$this->db->query("select device_token from user_profile where device_token is not null and char_length(device_token)>0  and user_id!='$userid'  group by device_token");
		else
		$q=$this->db->query("select up.device_token from user_profile up inner join actionusers au on au.UserId=up.user_id where up.device_token is not null and char_length(up.device_token)>0  and up.user_id!='$userid' and au.EventId='$eventid'  group by device_token");
		
		if($q->num_rows()>0)
		{
		
		$r=$q->row();
		foreach($r as $v)
		{
		$this->iosnotify($v->device_token,(strlen($message) > 110) ? substr($message,0,110).'... More' : $message);
		}
		
		}
		
		return array("message"=>"success","code"=>200);
	}
	
	
	function getChatHistory($myid,$fid,$start)
	{
		$base=base_url();
		$thumb=$base."resize.php?height=50&width=50&path=";
		$q=$this->db->query("SELECT  cc.ChatId,cc.UserId,cc.FriendId,cc.Message,case when CHAR_LENGTH(cc.Image)>0 then concat('$base',cc.Image) ELSE ''  END as Image,case when CHAR_LENGTH(cc.Audio)>0 then concat('$base',cc.Audio) ELSE ''  END as Audio,case when CHAR_LENGTH(cc.Video)>0 then concat('$base',cc.Video)  ELSE '' END as Video,case when CHAR_LENGTH(cc.VideoThumb)>0 then concat('$base',cc.VideoThumb)  ELSE '' END as VideoThumb,(select uu.user_name from user_profile uu where uu.user_id=cc.UserId) as myname,(select uu.user_name from user_profile uu where uu.user_id=cc.FriendId) as friendname,(select case when uu.profile_picture is null or char_length(uu.profile_picture)=0 then '' else concat('$thumb',uu.profile_picture) end from user_profile uu where uu.user_id=cc.UserId) as mypic,case when cc.IconId=0 then '' else concat('$base','icons/',ic.IconName) END as Icon,(select case when uu.profile_picture is null or char_length(uu.profile_picture)=0 then '' else concat('$thumb',uu.profile_picture) end  from user_profile uu where uu.user_id=cc.FriendId) as friendpic,cc.Latitude,cc.Longitude,cc.Address FROM chat cc left join Icon ic on cc.IconId=ic.IconId where (cc.UserId='$myid' and cc.FriendId='$fid') or (cc.UserId='$fid' and cc.FriendId='$myid') order by cc.ChatId desc limit $start,20");
		return $q->result();
	}
	
	function getGroupHistory($start,$eventid)
	{
		$base=base_url();
		$thumb=$base."resize.php?height=50&width=50&path=";
		if(empty($eventid))
		$q=$this->db->query("SELECT  cc.GroupChatId,cc.UserId,cc.UserId as FriendId,cc.Message,case when CHAR_LENGTH(cc.Image)>0 then concat('$base',cc.Image) ELSE ''  END as Image,case when CHAR_LENGTH(cc.Audio)>0 then concat('$base',cc.Audio) ELSE ''  END as Audio,case when CHAR_LENGTH(cc.Video)>0 then concat('$base',cc.Video)  ELSE '' END as Video,case when CHAR_LENGTH(cc.VideoThumb)>0 then concat('$base',cc.VideoThumb)  ELSE '' END as VideoThumb,(select uu.user_name from user_profile uu where uu.user_id=cc.UserId) as myname,(select uu.user_name from user_profile uu where uu.user_id=cc.UserId) as friendname,(select case when uu.profile_picture is null or char_length(uu.profile_picture)=0 then '' else concat('$thumb',uu.profile_picture) end from user_profile uu where uu.user_id=cc.UserId) as mypic,case when cc.IconId=0 then '' else concat('$base','icons/',ic.IconName) END as Icon,(select case when uu.profile_picture is null or char_length(uu.profile_picture)=0 then '' else concat('$thumb',uu.profile_picture) end  from user_profile uu where uu.user_id=cc.UserId) as friendpic,cc.Latitude,cc.Longitude,cc.Address FROM groupchat cc left join Icon ic on cc.IconId=ic.IconId where cc.EventId='0' order by cc.GroupChatId desc limit $start,20");
		else
		$q=$this->db->query("SELECT  cc.GroupChatId,cc.UserId,cc.UserId as FriendId,cc.Message,case when CHAR_LENGTH(cc.Image)>0 then concat('$base',cc.Image) ELSE ''  END as Image,case when CHAR_LENGTH(cc.Audio)>0 then concat('$base',cc.Audio) ELSE ''  END as Audio,case when CHAR_LENGTH(cc.Video)>0 then concat('$base',cc.Video)  ELSE '' END as Video,case when CHAR_LENGTH(cc.VideoThumb)>0 then concat('$base',cc.VideoThumb)  ELSE '' END as VideoThumb,(select uu.user_name from user_profile uu where uu.user_id=cc.UserId) as myname,(select uu.user_name from user_profile uu where uu.user_id=cc.UserId) as friendname,(select case when uu.profile_picture is null or char_length(uu.profile_picture)=0 then '' else concat('$thumb',uu.profile_picture) end from user_profile uu where uu.user_id=cc.UserId) as mypic,case when cc.IconId=0 then '' else concat('$base','icons/',ic.IconName) END as Icon,(select case when uu.profile_picture is null or char_length(uu.profile_picture)=0 then '' else concat('$thumb',uu.profile_picture) end  from user_profile uu where uu.user_id=cc.UserId) as friendpic,cc.Latitude,cc.Longitude,cc.Address FROM groupchat cc left join Icon ic on cc.IconId=ic.IconId where cc.EventId='$eventid' order by cc.GroupChatId desc limit $start,20");
		
		return $q->result();
	}
	
		function iconhistory($iconid,$userid)
		{
			$q=$this->db->query("select IconHistoryId,IconId from iconhistory where UserId='$userid' order by IconHistoryId desc limit 0,1");
			if($q->num_rows()>0)
			{
				 $r=$q->row();
				 $icon=$r->IconId;
				 if($icon!=$iconid)
				 {
					 $a1=array("UserId"=>$userid,"IconId"=>$iconid);
					 $this->db->insert('iconhistory',$a1);
				 }
			}
			else
			{
				 $a1=array("UserId"=>$userid,"IconId"=>$iconid);
				 $this->db->insert('iconhistory',$a1);
			}
		}
	
	
		function iosnotify($devicetoken,$message)
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
			$payload['aps'] = array('alert' => $message,'sound' => 'default','badge'=>1,"type"=>"chat");
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