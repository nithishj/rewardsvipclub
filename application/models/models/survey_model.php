<?php

Class survey_model extends CI_Model
{
 
     function addsurvey($title,$description,$userid)
	 {
	    $data=array("Title"=>$title,"Description"=>$description,"UserId"=>$userid);
		$this->db->insert('survey',$data);
		return array("message"=>"success","code"=>200,"SurveyId"=>$this->db->insert_id());
	 }
	 
	 function addquestion($surveyid,$question,$questionid,$userid,$myimage,$myaudio,$myvideo,$myvideothumb,$colorid,$iconid,$choice)
	 {
	   $data=array("SurveyId"=>$surveyid,"Question"=>$question,"Image"=>$myimage,"Audio"=>$myaudio,"Video"=>$myvideo,"VideoThumb"=>$myvideothumb,"ColorId"=>$colorid,"IconId"=>$iconid,"UserId"=>$userid);
	    if(!empty($questionid))
	    {
			$this->db->where("QuestionId",$questionid);
			$this->db->update("surveyquestion",$data);
			$this->addchoice($questionid,$choice);
		}
		else
		{
		   $this->db->insert("surveyquestion",$data);
		   $this->addchoice($this->db->insert_id(),$choice);
		}
	       return array("message"=>"success","code"=>200);
	 }
	 
	 function getsurvey($start)
	 {
	    $thumb=base_url()."resize.php?height=50&width=50&path=";
	    $q= $this->db->query("select s.*,up.user_name,case when up.profile_picture is null or char_length(up.profile_picture)=0 then '' else concat('$thumb',up.profile_picture) end as profile_picture from survey s inner join user_profile up on s.UserId=up.user_id order by s.SurveyId desc limit $start,20");
	    return $q->result();
	 }
	 
	 function getsurveyquestions($userid,$surveyid)
	 {
	    $msg=array();
	    $base=base_url();
	    $q= $this->db->query("SELECT ss.QuestionId,ss.Question,case when char_length(ss.Image)>0 then concat('$base',ss.Image) else '' end as Image,case when char_length(ss.Audio)>0 then concat('$base',ss.Audio) else '' end as Audio,case when char_length(ss.Video)>0 then concat('$base',ss.Video) else '' end as Video,case when char_length(ss.VideoThumb)>0 then concat('$base',ss.VideoThumb) else '' end as VideoThumb,case when ss.IconId=0 then '' else concat('$base','icons/',ic.IconName) END as Icon,ss.ColorId,c.r_value,c.g_value,c.b_value,c.r_fore_value,c.g_fore_value,c.b_fore_value, c.color_images FROM  surveyquestion ss left join Icon ic on ss.IconId=ic.IconId left join color_lookup c on ss.ColorId=c.color_lookup_id   where ss.SurveyId= '$surveyid'");
		$r=$q->result();
		foreach($r as $v)
		{
		   $q1=$this->db->query("select sc.ChoiceId,sc.Choice,sc.QuestionId,case when sa.choiceId is not null and sa.UserId='$userid' then 'true' else 'false' end as Status from surveychoice sc left join surveyanswer sa on sc.ChoiceId=sa.ChoiceId where sc.QuestionId='$v->QuestionId'");
		 //$q2=$this->db->query("select sc.ChoiceId,sc.Choice from surveyanswer sa inner join surveychoice sc on sa.ChoiceId = sc.ChoiceId where sa.QuestionId='$v->QuestionId' and sa.UserId='$userid'");
		   
		   $msg[]=array("QuestionId"=>$v->QuestionId,"Question"=>$v->Question,"Image"=>$v->Image,"Audio"=>$v->Audio,"Video"=>$v->Video,"VideoThumb"=>$v->VideoThumb,"Icon"=>$v->Icon,"ColorId"=>$v->ColorId,"Rvalue"=>!empty($v->r_value)?$v->r_value:"0","Gvalue"=>!empty($v->g_value)?$v->g_value:"0","Bvalue"=>!empty($v->b_value)?$v->b_value:"0","R_fore_value"=>!empty($v->r_fore_value)?$v->r_fore_value:"0","G_fore_value"=>!empty($v->g_fore_value)?$v->g_fore_value:"0","B_fore_value"=>!empty($v->b_fore_value)?$v->b_fore_value:"0","color_images"=>!empty($v->color_images)?base_url()."color_images/".$v->color_images:"","AllChoice"=>$q1->result());
		}
		return $msg;
	 }
	 
	 function getparticipants($surveyid)
	 {
	    $thumb=base_url()."resize.php?height=50&width=50&path=";
		$q=$this->db->query("select sa.UserId,up.user_name,case when up.profile_picture is null or char_length(up.profile_picture)=0 then '' else concat('$thumb',up.profile_picture) end as profile_picture from surveyanswer sa inner join user_profile up on sa.UserId=up.user_id where sa.SurveyId='$surveyid'");
	    return $q->result();
	 }
	 
	 function deletequestion($questionid,$userid)
	 {
	    $this->db->query("delete from surveyquestion where UserId='$userid' and QuestionId='$questionid'");
	    return array("message"=>"success","code"=>200);
	 }
	 
	  function deletesurvey($surveyid,$userid)
	 {
	    $this->db->query("delete from survey where UserId='$userid' and SurveyId='$surveyid'");
	    return array("message"=>"success","code"=>200);
	 }
	 
	 function answersurvey($json)
	 {
	   foreach($json as $val)
	   {
	    $array=array("SurveyId"=>$val['SurveyId'],"QuestionId"=>$val['QuestionId'],"UserId"=>$val['UserId'],"ChoiceId"=>$val['ChoiceId']);
		$this->db->insert('surveyanswer',$array);
	   }
	   
	  return array("message"=>"success","code"=>200);
	 
	 }
	 
	 function addchoice($questionid,$choice)
	 {
		$this->db->where("QuestionId",$questionid);
		$this->db->delete("surveychoice");
		foreach($choice as $v)
		{
		   if(!empty($v["ChoiceId"]))
		     $data=array("ChoiceId"=>$v["ChoiceId"],"QuestionId"=>$questionid,"Choice"=>$v["ChoiceText"]);
		   else
			$data=array("QuestionId"=>$questionid,"Choice"=>$v["ChoiceText"]);
			
			$this->db->insert("surveychoice", $data);
		}
	 }

}