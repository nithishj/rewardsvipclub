<?php

Class starrewards_admin_model extends CI_Model
{

function getusers($search,$users)
{
   $baseurl=base_url();
   $defaultpic=$baseurl.'includes/images/a5.jpg';
   if(empty($search) && empty($users))
   $q=$this->db->query("select uu.user_id as id,up.user_name as name,case when up.profile_picture is null or char_length(up.profile_picture)=0 then '$defaultpic' else concat('$baseurl',up.profile_picture) end as profile_image from users uu inner join user_profile up on uu.user_id=up.user_id where uu.Status=1 and uu.Deleted=0 order by up.user_name limit 0,30");
   else if(!empty($search) && empty($users))
   $q=$this->db->query("select uu.user_id as id,up.user_name as name,case when up.profile_picture is null or char_length(up.profile_picture)=0 then '$defaultpic' else concat('$baseurl',up.profile_picture) end as profile_image from users uu inner join user_profile up on uu.user_id=up.user_id where uu.Status=1 and uu.Deleted=0 and up.user_name like '%$search%' order by up.user_name limit 0,30");
   else if(!empty($search) && !empty($users))
   $q=$this->db->query("select uu.user_id as id,up.user_name as name,case when up.profile_picture is null or char_length(up.profile_picture)=0 then '$defaultpic' else concat('$baseurl',up.profile_picture) end as profile_image from users uu inner join user_profile up on uu.user_id=up.user_id where uu.Status=1 and uu.Deleted=0 and up.user_name like '%$search%' and uu.user_id not in ($users) order by up.user_name limit 0,30");
   
   if($q->num_rows()>0)
   return $q->result();
   else
   return array();
}

function addstarreward($message,$points,$userids)
{
  $q=$this->db->query("insert into starrewards (Message,Points,Code)  values ('$message','$points',left(UUID(), 5))");
  $id=$this->db->insert_id();
  $userids=explode(',',$userids);
  for($i=0;$i<count($userids);$i++)
  {
    $q1=$this->db->query("insert into rewardusers (StarRewardsId, UserId)  values ('$id','$userids[$i]')");
  }
  return array("message"=>"success","code"=>200);
  
}

function getschedulehistory()
{
  $defaultpic='includes/images/a5.jpg';
  $q=$this->db->query("select StarRewardsId,Message,Points,Code from starrewards order by StarRewardsId desc");
  if($q->num_rows()>0)
  {
   $r=$q->result();
   foreach($r as $v)
   {
   
   $q2=$this->db->query("select case when (profile_picture is null or char_length(profile_picture)=0) then '$defaultpic' else profile_picture end as profile_picture,user_name from user_profile where user_id IN (select UserId from rewardusers where StarRewardsId='$v->StarRewardsId')");
   
   $msg[]=array("Message"=>$v->Message,"Points"=>$v->Points,"Code"=>$v->Code,"users"=>$q2->result());
   }
   return $msg;
  }
  else
  return array();
}

}