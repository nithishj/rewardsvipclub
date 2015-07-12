<?php

Class events_admin_model extends CI_Model
{

function addevent($userid,$eventname,$eventdescription,$iconid,$eventdate)
{

  $a=array("UserId"=>$userid,"EventName"=>$eventname,"EventDescription"=>$eventdescription,"IconId"=>$iconid,"EventDate"=>$eventdate);
  $q=$this->db->insert('event',$a);
  if($q)
  return array("Message"=>"success","code"=>200);
  
}

function editevent($eventid,$userid,$eventname,$eventdescription,$iconid,$eventdate)
{

  $a=array("UserId"=>$userid,"EventName"=>$eventname,"EventDescription"=>$eventdescription,"IconId"=>$iconid,"EventDate"=>$eventdate);
  $this->db->where("EventId",$eventid);
  $q=$this->db->update('event',$a);
  if($q)
  return array("Message"=>"success","code"=>200);

}

function deleteevent($eventid)
{
	$this->db->where('EventId', $eventid);
	$q=$this->db->delete('event'); 
	if($q)
    return array("Message"=>"success","code"=>200);
}

function getevents($id)
{
   $base=base_url('icons').'/';
	if(empty($id))
	$q=$this->db->query("select up.user_name,ev.EventId,ev.UserId,ev.EventName,ev.EventDescription,Ic.IconId,case when (ev.IconId!=0) then concat('$base',Ic.IconName) else '' END as Icon,ev.EventDate  from event ev inner join user_profile up on ev.UserId=up.user_id left join icon Ic on ev.IconId=Ic.IconId order by ev.EventId desc");
	else
	$q=$this->db->query("select up.user_name,ev.EventId,ev.UserId,ev.EventName,ev.EventDescription,Ic.IconId,case when (ev.IconId!=0) then concat('$base',Ic.IconName) else '' END as Icon,ev.EventDate  from event ev inner join user_profile up on ev.UserId=up.user_id left join icon Ic on ev.IconId=Ic.IconId where ev.EventId='$id'");
	if($q->num_rows()>0)
	return $q->result();
	else
	return array();
	
}

function geticons($userid,$type)
{

$base=base_url('icons').'/';
if(empty($userid) && empty($type))
{
$q=$this->db->query("select IconId,concat('$base',IconName) as Icon from icon");
if($q->num_rows()>0)
return $q->result_array();
else
return array();
}
else
{
  $tmp=array();
  if($type=="general")
  {     
		$q=$this->db->query("select IconId,concat('$base',IconName) as Icon from icon order by IconType desc");
  }
  else if($type=="emoji")
  {
		$q=$this->db->query("select IconId,concat('$base',IconName) as Icon from icon order by IconType");
  }
  
       $a=$q->result();
        $ids_q=$this->db->query("select IconId from IconHistory where UserId='$userid' order by IconHistoryId desc");		
		if($ids_q->num_rows()>0)
		{  
		  $ids_r=$ids_q->result();
		   foreach($ids_r as $val)
		   {
		       foreach($a as $key => $org)
			   {
			      if($val->IconId==$org->IconId)
				  {
					$parray=array("IconId"=>$org->IconId,"Icon"=>$org->Icon);
					array_push($tmp,$parray);
					unset($a[$key]);
				  }
			   
			   }
		   
		   }
		 foreach($a as $org)
		   {
				$parray=array("IconId"=>$org->IconId,"Icon"=>$org->Icon);
				array_push($tmp,$parray);
		   }
		   return $tmp;
		}
		else
		return $a;
}

}


}