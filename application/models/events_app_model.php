<?php

Class events_app_model extends CI_Model
{

	function addevent($userid,$eventname,$eventdesc,$iconid,$eventdate,$myimage,$myvideo,$myvideothumb,$myaudio,$latitude,$longitude,$address)
	{
       $a=array("UserId"=>$userid,"EventName"=>$eventname,"EventDescription"=>$eventdesc,"IconId"=>$iconid,"EventDate"=>$eventdate,"Image"=>$myimage,"Video"=>$myvideo,"VideoThumb"=>$myvideothumb,"Audio"=>$myaudio,"Latitude"=>$latitude,"Longitude"=>$longitude,"Address"=>$address);
       $this->db->insert('event',$a);
       return array("message"=>"success","code"=>200);
	}		

	function editevent($eventid,$userid,$eventname,$eventdesc,$iconid,$eventdate,$myimage,$myvideo,$myvideothumb,$myaudio,$latitude,$longitude,$address)
	{
		$a=array("UserId"=>$userid,"EventName"=>$eventname,"EventDescription"=>$eventdesc,"IconId"=>$iconid,"EventDate"=>$eventdate,"Image"=>$myimage,"Video"=>$myvideo,"VideoThumb"=>$myvideothumb,"Audio"=>$myaudio,"Latitude"=>$latitude,"Longitude"=>$longitude,"Address"=>$address);
		$this->db->where("EventId",$eventid);
		$this->db->update('event',$a);
		return array("message"=>"success","code"=>200);

	}
	
	function deleteevent($id)
	{
	    $q=$this->db->query("Delete from event where EventId='$id'");
		return array("code"=>200,"message"=>"Successfully deleted");
	}

	function getevents($id)
    {
	    $base=base_url();
		$thumb=$base."resize.php?height=100&width=100&path=";
		if(!empty($id))
		$q=$this->db->query("select e.EventId,e.UserId,e.EventName,e.EventDescription,case when (i.IconId>=1) then concat('$base','icons/',i.IconName) else '' end as IconName,i.IconId,e.EventDate,case when char_length(e.Image)>0 then concat('$base',e.Image) else '' END as Image,case when char_length(e.Image)>0 then concat('$thumb',e.Image) else '' END as ImageThumb ,case when char_length(e.Audio)>0 then concat('$base',e.Audio) else '' END as Audio ,case when char_length(e.Video)>0 then concat('$base',e.Video) else '' END as Video, case when char_length(e.VideoThumb)>0 then concat('$base',e.VideoThumb) else '' END as VideoThumb,case when char_length(e.VideoThumb)>0 then concat('$thumb',e.VideoThumb) else '' END as resizedvthumb,e.Latitude,e.Longitude,e.Address from event e left join icon i on e.IconId=i.IconId where e.UserId='$id' order by EventId desc");
		else
		$q=$this->db->query("select e.EventId,e.UserId,e.EventName,e.EventDescription,case when (i.IconId>=1) then concat('$base','icons/',i.IconName) else '' end as IconName,i.IconId,e.EventDate,case when char_length(e.Image)>0 then concat('$base',e.Image) else '' END as Image,case when char_length(e.Image)>0 then concat('$thumb',e.Image) else '' END as ImageThumb,case when char_length(e.Audio)>0 then concat('$base',e.Audio) else '' END as Audio ,case when char_length(e.Video)>0 then concat('$base',e.Video) else '' END as Video, case when char_length(e.VideoThumb)>0 then concat('$base',e.VideoThumb) else '' END as VideoThumb,case when char_length(e.VideoThumb)>0 then concat('$thumb',e.VideoThumb) else '' END as resizedvthumb,e.Latitude,e.Longitude,e.Address from event e left join icon i on e.IconId=i.IconId order by EventId desc");
		
		
		if($q->num_rows()>0)
		return $q->result();
		else
		return array();
	}

}