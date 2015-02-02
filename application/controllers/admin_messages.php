<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class admin_messages extends CI_Controller
{

   function __construct()
	{
		parent::__construct();
		$this->load->helper('url'); 
		
	}
	
function getpushmessages()
	{
		$json = json_decode(trim(file_get_contents('php://input')),true);
		if(!empty($json['type']))
		{
	
	  $base=base_url();
	  $defaultimg=base_url('includes/images').'/a5.jpg';
	  $colorimg=base_url('color_images').'/';
      $q=$this->db->query("select bb.BroadcastId,bb.Message,bb.Fr_UserId,case when CHAR_LENGTH(bb.Image)>0 then concat('$base',bb.Image) else '' END as Image,
	  case when CHAR_LENGTH(bb.Audio)>0 then concat('$base',bb.Audio) ELSE '' END as Audio,case when CHAR_LENGTH(bb.Video)>0 then concat('$base',bb.Video) ELSE '' END as Video,
	  case when CHAR_LENGTH(bb.VideoThumb)>0 then concat('$base',bb.VideoThumb) ELSE '' END as VideoThumb,bb.CreatedDate,
	  case when up.profile_picture IS NULL or CHAR_LENGTH(up.profile_picture)=0 then '$defaultimg' ELSE up.profile_picture END as profile_picture,
	  case when char_length(cl.color_images)>0 then '' else concat('rgb(',cl.r_value,',',cl.g_value,',',cl.b_value,')') END  as rgb,
	  concat('rgb(',cl.r_fore_value,',',cl.g_fore_value,',',cl.b_fore_value,')') as rgb_fore,
	  case when CHAR_LENGTH(cl.color_images)>0 then concat('$colorimg',cl.color_images) ELSE '' END as colorsimage
	  from broadcast bb inner join user_profile up on bb.Fr_UserId=up.user_id left join color_lookup cl on bb.color=cl.color_lookup_id where bb.BroadcastType='$json[type]' order by bb.BroadcastId desc");
	   
	   }
	  echo json_encode($q->result());
	
	}
	
	function delbroadcast()
       {
	    $json = json_decode(trim(file_get_contents('php://input')),true);
		if(!empty($json['broadcastid']))
		{
         $q=$this->db->query("delete from broadcast where BroadcastId in($json[broadcastid])");
         if($q)
         $msg=array("message"=>"success","code"=>200);
         else
         $msg=array("message"=>"fail","code"=>400);
        }
	   echo json_encode($msg);
	   }
	   
    function clonebroadcast()
	{
	$json = json_decode(trim(file_get_contents('php://input')),true);
		if(!empty($json['broadcastid']) && !empty($json['userid']))
		{
			$q=$this->db->query("select * from broadcast where BroadcastId='$json[broadcastid]'");
			$r=$q->row();
			$a=array("BroadcastType"=>$r->BroadcastType,"Message"=>$r->Message,"Fr_UserId"=>$json[userid],"Image"=>$r->Image,"Color"=>$r->Color,"Audio"=>$r->Audio,"Video"=>$r->Video,"VideoThumb"=>$r->VideoThumb);
			$this->db->insert('broadcast',$a);
			$msg=array("message"=>"success");
	    }
	    echo json_encode($msg); 
	}
	
	
}