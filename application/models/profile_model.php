<?php
Class profile_model extends CI_Model
{

function changepassword($userid,$oldpassword,$newpassword)
{
	$q=$this->db->query("select user_id from users where user_id='$userid' and password='$oldpassword'");
	if($q->num_rows()>0)
	{
		$this->db->query("update users set password='$newpassword' where user_id='$userid'");
	     return array("message"=>"Password Changed Successfully","code"=>200);
	}
	else
	{
		return array("message"=>"Wrong Password","code"=>400);
	}

}

function getmysettings($userid)
{
     $baseurl=base_url();
	
    $q=$this->db->query("SELECT uu.user_id,uu.password,uu.user_role,uu.email,uu.Status,uu.OnStatus,case when sl.social_type is not null then sl.social_type else 'General' End as socialtype,case when up.gender is not null then up.gender else '' END as gender,case when (up.profile_picture is  null or char_length(up.profile_picture)=0) then '' else concat('$baseurl',up.profile_picture) END as profie_picture,case when up.mobile is not null then up.mobile else '' END as mobile,up.user_name   FROM user_profile up inner join users uu on uu.user_id=up.user_id left join social_login sl on uu.user_id=sl.user_id where uu.user_id=$userid");
    if($q->num_rows()>0)
	return $q->row();
	else
	return array();
}


function updateprofile($userid,$usertype,$username,$profilepic)
{

$a=array("user_role"=>$usertype);
$this->db->where("user_id",$userid);
$this->db->update("users",$a);

if(empty($profilepic))
$b=array("user_name"=>$username);

else
$b=array("user_name"=>$username,"profile_picture"=>$profilepic);

$this->db->where("user_id",$userid);
$this->db->update("user_profile",$b);

return array("message"=>"Profile Updated Successfully","code"=>200);
}

function terminate($userid,$password)
{
$a=$this->db->query("select social_type from social_login where user_id='$userid'");
if($a->num_rows()>0)
{
$q=$this->db->query("update users set Deleted=1 where user_id=$userid");
return array("message"=>"User Deleted Successfully","code"=>200);
}
else
{

if(empty($password))
return array("message"=>"Required Fields","code"=>400);

$q=$this->db->query("select user_id from users where user_id=$userid and password='$password'");
if($q->num_rows()>0)
{
$q=$this->db->query("update users set Deleted=1 where user_id=$userid");
return array("message"=>"User Deleted Successfully","code"=>200);
}
else
{
return array("message"=>"Wrong Password","code"=>400);
}
}

}
}