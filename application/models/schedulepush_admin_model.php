<?php

Class schedulepush_admin_model extends CI_Model
{

function addpush($userid,$alertmessage,$alerttype,$alertdate,$alerttime,$alertday)
{

  $a=array("UserId"=>$userid,"AlertMessage"=>$alertmessage,"AlertType"=>$alerttype,"AlertDate"=>$alertdate,"AlertTime"=>$alerttime,"AlertDay"=>$alertday);
  $q=$this->db->insert('pushschedule',$a);
  if($q)
  return array("Message"=>"success","code"=>200);
  
}

function editpush($schedulepushid,$userid,$alertmessage,$alerttype,$alertdate,$alerttime,$alertday)
{

   $a=array("UserId"=>$userid,"AlertMessage"=>$alertmessage,"AlertType"=>$alerttype,"AlertDate"=>$alertdate,"AlertTime"=>$alerttime,"AlertDay"=>$alertday);
  $this->db->where("PushScheduleId",$schedulepushid);
  $q=$this->db->update('pushschedule',$a);
  if($q)
  return array("Message"=>"success","code"=>200);

}

function deletepush($schedulepushid)
{
	$this->db->where('PushScheduleId', $schedulepushid);
	$q=$this->db->delete('pushschedule'); 
	if($q)
    return array("Message"=>"success","code"=>200);
}

function getpush($id)
{
	$base=base_url();
	if(empty($id))
	$q=$this->db->query("select up.user_name,ps.*  from pushschedule ps inner join user_profile up on ps.UserId=up.user_id order by ps.PushScheduleId desc");
	else
	$q=$this->db->query("select up.user_name,ps.*   from pushschedule ps inner join user_profile up on ps.UserId=up.user_id where ps.PushScheduleId='$id'");
	if($q->num_rows()>0)
	return $q->result();
	else
	return array();
	
}

}