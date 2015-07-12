<?php

Class events_app_model extends CI_Model
{
    function addactions($actioncenter,$eventid,$userlist)
	{
	    foreach($actioncenter as $val)
		{
		  $a=array("Name"=>$val[name],"Type"=>$val[type],"UserId"=>!empty($val[userid])?$val[userid]:0,"EventId"=>$eventid,"ColorId"=>!empty($val[colorid])?$val[colorid]:0,"IconId"=>!empty($val[iconid])?$val[iconid]:0);
		  $this->db->insert('actioncenter',$a);
		}
		foreach($userlist as $user)
		{
		   $b=array("EventId"=>$eventid,"UserId"=>$user[userid]);
		   $this->db->insert('actionusers',$b);
		}
	}
	
	function addevent($userid,$eventname,$eventdesc,$iconid,$eventdate,$enddate,$myimage,$myvideo,$myvideothumb,$myaudio,$latitude,$longitude,$address,$actioncenter,$userlist)
	{
	   if(!empty($iconid))
	   $this->iconhistory($iconid,$userid);
	  
       $a=array("UserId"=>$userid,"EventName"=>$eventname,"EventDescription"=>$eventdesc,"IconId"=>$iconid,"EventDate"=>$eventdate,"EndDate"=>$enddate,"Image"=>$myimage,"Video"=>$myvideo,"VideoThumb"=>$myvideothumb,"Audio"=>$myaudio,"Latitude"=>$latitude,"Longitude"=>$longitude,"Address"=>$address);
       $this->db->insert('event',$a);
	   
	   if(!empty($actioncenter))
	   $this->addactions($actioncenter,$this->db->insert_id(),$userlist);
       return array("message"=>"success","code"=>200);
	}		

	function editevent($eventid,$userid,$actionuserid,$eventname,$eventdesc,$iconid,$eventdate,$enddate,$myimage,$myvideo,$myvideothumb,$myaudio,$latitude,$longitude,$address,$actioncenter,$userlist)
	{
	   if(!empty($iconid))
	   $this->iconhistory($iconid,$userid);
		
		$a=array("UserId"=>$userid,"EventName"=>$eventname,"EventDescription"=>$eventdesc,"IconId"=>$iconid,"EventDate"=>$eventdate,"EndDate"=>$enddate,"Image"=>$myimage,"Video"=>$myvideo,"VideoThumb"=>$myvideothumb,"Audio"=>$myaudio,"Latitude"=>$latitude,"Longitude"=>$longitude,"Address"=>$address);
		$this->db->where("EventId",$eventid);
		$this->db->update('event',$a);
        
		$str="";
		$dlq=$this->db->query("select ActionCenterId from actioncenter where EventId='$eventid' and Type='privatenotes' and UserId!='$actionuserid'");
		$dlr=$dlq->result();
		foreach($dlr as $var)
		$str=$str.",".$var->ActionCenterId;
		$str=trim(trim($str),",");
		if(!empty($str))
		$q1=$this->db->query("delete from actioncenter where EventId='$eventid' and ActionCenterId NOT IN($str)");
		else
		$q1=$this->db->query("delete from actioncenter where EventId='$eventid'");
		//echo $this->db->last_query();
		$q2=$this->db->query("delete from actionusers where EventId='$eventid'");
		
		if(!empty($actioncenter))
		$this->addactions($actioncenter,$eventid,$userlist);
		
		return array("message"=>"success","code"=>200);

	}
	
	function deleteevent($id)
	{
	    $q=$this->db->query("Delete from event where EventId='$id'");
		return array("code"=>200,"message"=>"Successfully deleted");
	}
	
	function getcolordetails($colorid,$base)
	{
	   $q=$this->db->query("select color_lookup_id,r_value,g_value,b_value,r_fore_value,g_fore_value,b_fore_value,case when char_length(color_images)>0 then concat('$base','color_images/',color_images) else '' end as color_images from color_lookup where color_lookup_id='$colorid'");
	   return $q->row_array();
	}
	
	function geticondetails($iconid,$base)
	{
	   $q=$this->db->query("select IconId,concat('$base','icons/',IconName) as IconPath from icon where IconId='$iconid'");
	   return $q->row_array();
	}

	function getevents($id)
    {
	    $base=base_url();
		$thumb=$base."resize.php?height=100&width=100&path=";
		if(!empty($id))
		$q=$this->db->query("select e.EventId,e.UserId,up.user_name,case when up.profile_picture is null or char_length(up.profile_picture)=0 then '' else concat('$thumb',up.profile_picture) end as profilethumb,e.EventName,e.EventDescription,case when (i.IconId>=1) then concat('$base','icons/',i.IconName) else '' end as IconName,i.IconId,e.EventDate,e.EndDate,case when char_length(e.Image)>0 then concat('$base',e.Image) else '' END as Image,case when char_length(e.Image)>0 then concat('$thumb',e.Image) else '' END as ImageThumb ,case when char_length(e.Audio)>0 then concat('$base',e.Audio) else '' END as Audio ,case when char_length(e.Video)>0 then concat('$base',e.Video) else '' END as Video, case when char_length(e.VideoThumb)>0 then concat('$base',e.VideoThumb) else '' END as VideoThumb,case when char_length(e.VideoThumb)>0 then concat('$thumb',e.VideoThumb) else '' END as resizedvthumb,e.Latitude,e.Longitude,e.Address from event e left join icon i on e.IconId=i.IconId inner join user_profile up on e.UserId=up.user_id where e.UserId='$id' or e.EventId IN(select EventId from actionusers where UserId='$id') order by EventId desc");
		else
		$q=$this->db->query("select e.EventId,e.UserId,up.user_name,case when up.profile_picture is null or char_length(up.profile_picture)=0 then '' else concat('$thumb',up.profile_picture) end as profilethumb,e.EventName,e.EventDescription,case when (i.IconId>=1) then concat('$base','icons/',i.IconName) else '' end as IconName,i.IconId,e.EventDate,e.EndDate,case when char_length(e.Image)>0 then concat('$base',e.Image) else '' END as Image,case when char_length(e.Image)>0 then concat('$thumb',e.Image) else '' END as ImageThumb,case when char_length(e.Audio)>0 then concat('$base',e.Audio) else '' END as Audio ,case when char_length(e.Video)>0 then concat('$base',e.Video) else '' END as Video, case when char_length(e.VideoThumb)>0 then concat('$base',e.VideoThumb) else '' END as VideoThumb,case when char_length(e.VideoThumb)>0 then concat('$thumb',e.VideoThumb) else '' END as resizedvthumb,e.Latitude,e.Longitude,e.Address from event e left join icon i on e.IconId=i.IconId inner join user_profile up on e.UserId=up.user_id order by EventId desc");
		
		
		if($q->num_rows()>0)
		{
		//return $q->result();
		$r=$q->result_array();
		foreach($r as $v)
		{
		 $q1=$this->db->query("select * from actioncenter where EventId='$v[EventId]' and ActionCenterId Not IN (select ActionCenterId from actioncenter where EventId='$v[EventId]'  and UserId!=$id and Type='privatenotes')");
		 $res1=array();
		 if($q1->num_rows()>0)
		 {
		     
		     $r1=$q1->result_array();
		     foreach($r1 as $v1)
			 {
				$v1[color]=$this->getcolordetails($v1[ColorId],$base);
				$v1[icon]=$this->geticondetails($v1[IconId],$base);
				$res1[]=$v1;
			 }
		 
		 }
		 
		$v['actioncenter']=$res1;
		 
		 $q2=$this->db->query("select UserId from actionusers where EventId='$v[EventId]'");
		 $v['userslist']=$q2->result();
		 $result[]=$v;
		}
		return $result;
		}
		else
		return array();
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

}