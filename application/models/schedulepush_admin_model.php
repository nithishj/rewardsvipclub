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
    $q=$this->db->query("delete from pushschedule where PushScheduleId IN ($schedulepushid)");
	if($q)
    return array("Message"=>"success","code"=>200);
}

function getpush($id)
{
	$base=base_url();
	if(empty($id))
	$q=$this->db->query("select up.user_name,ps.PushScheduleId,ps.UserId,ps.AlertMessage,ps.AlertType,case when ps.AlertType=1 then 'Once' when ps.AlertType=2 then 'Every Week' else 'Every Day' END as Alerttypemsg,case when char_length(ps.AlertDate)>0 then ps.AlertDate else '' end as AlertDate,ps.AlertDay,ps.AlertTime,case when ps.AlertDay=1 then 'Monday' when ps.AlertDay=2 then 'Tuesday' when ps.AlertDay=3 then 'Wednesday' when ps.AlertDay=4 then 'Thursday' when ps.AlertDay=5 then 'Friday' when ps.AlertDay=6 then 'Saturday' when ps.AlertDay=7 then 'Sunday' else '' END as AlertDayMsg from pushschedule ps inner join user_profile up on ps.UserId=up.user_id order by ps.PushScheduleId desc");
	else
	$q=$this->db->query("select up.user_name,ps.PushScheduleId,ps.UserId,ps.AlertMessage,ps.AlertType,case when ps.AlertType=1 then 'Once' when ps.AlertType=2 then 'Every Week' else 'Every Day' END as Alerttypemsg,case when char_length(ps.AlertDate)>0 then ps.AlertDate else '' end as AlertDate,ps.AlertDay,ps.AlertTime,case when ps.AlertDay=1 then 'Monday' when ps.AlertDay=2 then 'Tuesday' when ps.AlertDay=3 then 'Wednesday' when ps.AlertDay=4 then 'Thursday' when ps.AlertDay=5 then 'Friday' when ps.AlertDay=6 then 'Saturday' when ps.AlertDay=7 then 'Sunday' else '' END as AlertDayMsg from pushschedule ps inner join user_profile up on ps.UserId=up.user_id where ps.PushScheduleId='$id'");
	if($q->num_rows()>0)
	return $q->result();
	else
	return array();
	
}

}