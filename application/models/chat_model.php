<?php

Class chat_model extends CI_Model
{

	function listusers($id,$start)
	{
	  $q=$this->db->query("select uu.user_id,up.user_name,case when (up.profile_picture is null) then '' else up.profile_picture END as profile_picture,uu.OnStatus from users uu inner join user_profile up on uu.user_id=up.user_id where uu.Deleted=0 and uu.Status=1 and uu.user_id!='$id' order by uu.user_id=1 desc,uu.OnStatus limit $start,20");
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
	
	function chatMessage($userid,$friendid,$message,$myimage,$myvideo,$myvideothumb)
	{

		$data=array("Message"=>$message,"UserId"=>$userid,"FriendId"=>$friendid,"Image"=>!empty($myimage)?$myimage:"","Video"=>!empty($myvideo)?$myvideo:"","VideoThumb"=>!empty($myvideothumb)?$myvideothumb:"");
		$this->db->insert('chat',$data);
		

		return array("message"=>"success","code"=>200);
	}
	
	
	function getChatHistory($myid,$fid,$start)
	{
	 $base=base_url();
	    $q=$this->db->query("SELECT  cc.ChatId,cc.UserId,cc.FriendId,cc.Message,case when CHAR_length(cc.Image>0) then concat('$base',cc.Image) END as Image,case when CHAR_length(cc.Video>0) then concat('$base',cc.Video) END as Video,case when CHAR_length(cc.VideoThumb>0) then concat('$base',cc.VideoThumb) END as VideoThumb,(select uu.user_name from user_profile uu where uu.user_id=cc.UserId) as myname,(select uu.user_name from user_profile uu where uu.user_id=cc.FriendId) as friendname FROM chat cc where (cc.UserId='$myid' and cc.FriendId='$fid') or (cc.UserId='$fid' and cc.FriendId='$myid') order by cc.ChatId desc limit $start,20");
	    return $q->result();
	}
} 