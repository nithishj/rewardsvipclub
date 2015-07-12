<?php

Class discussion_app_model extends CI_Model
{
function addDiscussion($userid,$title,$description)
{
  $a=array("UserId"=>$userid,"Title"=>$title,"Description"=>$description);
  $this->db->insert('Discussion',$a);
  return array("code"=>200,"message"=>"success");
}

	function addComment($userid,$discussionid,$comment,$color,$audio,$image,$video,$videothumb,$latitude,$longitude,$address,$iconid)
	{
	   $this->iconhistory($iconid,$userid);
	   $a=array("DiscussionId"=>$discussionid,"Comment"=>$comment,"Fr_UserId"=>$userid,"IconId"=>$iconid,"Image"=>$image,"Color"=>$color,"Audio"=>$audio,"Video"=>$video,"Latitude"=>$latitude,"Longitude"=>$longitude,"Address"=>$address,"VideoThumb"=>$videothumb);
	   $this->db->insert('DiscussionCom',$a);

	   $q=$this->db->query("select Fr_UserId from DiscussionCom where DiscussionId='$discussionid' and Fr_UserId!='$userid'");
	   $r=$q->result();
	   foreach($r as $v)
	   {

		 $q1=$this->db->query("select device_token from user_profile where user_id='$v->Fr_UserId'");
		 if($q1->num_rows()>0)
		 {
			$r1=$q1->row();
			$this->iosnotify($r1->device_token,$comment,'comment');
		 }

	   }
	   return array("code"=>200,"message"=>"success");   
	}

	function editDiscussion($discussionid,$title,$description)
	{
	   $a=array("Title"=>$title,"Description"=>$description);
	   $this->db->where('DiscussionId',$discussionid);
	   $q=$this->db->update('Discussion',$a);
	   return array("code"=>200,"message"=>"successfully updated");   	
	}

	function deleteDiscussion($discussionid)
	{
		$this->db->where('DiscussionId', $discussionid);
		$this->db->delete('Discussion'); 
		return array("code"=>200,"message"=>"successfully deleted");  
	}

	function getDiscussions($start)
	{
	
	   $base=base_url();
	   $thumb=$base."resize.php?height=50&width=50&path=";
	   $q=$this->db->query("select d.DiscussionId,d.Title,d.Description,DATE_FORMAT(d.CreatedDate, '%Y-%m-%dT%T') as CreatedDate,up.user_name,(select count(dc.DiscussionComId) from  DiscussionCom dc where dc.DiscussionId=d.DiscussionId) as commentscount,case when up.profile_picture is null or char_length(up.profile_picture)=0 then '' else concat('$thumb',up.profile_picture) end as profile_picture from Discussion d inner join user_profile up on d.UserId=up.user_id order by DiscussionId desc limit $start,30");
	   if($q->num_rows()>0)
	   return $q->result();
	   else
	   return array();
	}

	function getComments($discussionid)
	{
		$base=base_url();
		$thumb=$base."resize.php?height=50&width=50&path=";
		$q=$this->db->query("select dc.DiscussionComId,dc.DiscussionId,up.user_name,case when up.profile_picture is null or char_length(up.profile_picture)=0 then '' else concat('$thumb',up.profile_picture) end as profile_picture,dc.Comment,dc.Fr_UserId,case when dc.IconId=0 then '' else  concat('$base','icons/',ic.IconName) end as Icon, case when char_length(dc.Image)>0 then concat('$base',dc.Image) else '' end as Image,dc.Color,case when char_length(dc.Audio)>0 then concat('$base',dc.Audio) else '' end  as Audio,
		case when char_length(dc.Video)>0 then concat('$base',dc.Video) else '' end  as Video,dc.Latitude,dc.Longitude,dc.Address,case when char_length(dc.VideoThumb)>0 then concat('$base',dc.VideoThumb) else '' end  as VideoThumb,DATE_FORMAT(dc.CreatedDate, '%Y-%m-%dT%T') as CreatedDate from Discussioncom dc left join icon ic on dc.IconId=ic.IconId inner join user_profile up on dc.Fr_UserId=up.user_id  where DiscussionId='$discussionid' order by dc.DiscussionComId desc");
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