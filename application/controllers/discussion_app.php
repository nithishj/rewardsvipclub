<?php defined('BASEPATH') OR exit('No direct script access allowed');

class discussion_app extends CI_Controller
{  

	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');  
		header("Access-Control-Allow-Origin: *");
		header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
		header('content-type: application/json;charset=utf-8');
		error_reporting(E_ALL); ini_set('display_errors', '1');
		error_reporting(E_ERROR | E_PARSE);
	}
	
	
    function addDiscussion()
    {
	    $json = json_decode(trim(file_get_contents('php://input')),true);
	    if(!empty($json['UserId']) && !empty($json['Title']))
	    	{

	    		$this->load->model('discussion_app_model');
	    		$res= $this->discussion_app_model->addDiscussion($json['UserId'],$json['Title'],!empty($json['Description'])?$json['Description']:'');
	    	}
			else
			{
				$res=array("code"=>400,"message"=>"Required Fields");
			}
        echo json_encode($res);
	}
	
	function editDiscussion()
	{
        $json= json_decode(trim(file_get_contents('php://input')),true);
		if(!empty($json['DiscussionId']) && !empty($json['Title']))
		{
			$this->load->model('discussion_app_model');
			$res= $this->discussion_app_model->editDiscussion($json['DiscussionId'],$json['Title'],!empty($json['Description'])?$json['Description']:'');
		}
	    else
		{
		    $res=array("code"=>400,"message"=>"Required Fields");
		}
		
	     echo json_encode($res);
    }
	
	function deleteDiscussion()
	{
        $json= json_decode(trim(file_get_contents('php://input')),true);
		if(!empty($json['DiscussionId']))
		{
			$this->load->model('discussion_app_model');
			$res= $this->discussion_app_model->deleteDiscussion($json['DiscussionId']);
		}
	    else
		{
		    $res=array("code"=>400,"message"=>"Required Fields");
		}
		
	     echo json_encode($res);
    }
	
	function addComment()
	{
         $json = json_decode(trim(file_get_contents('php://input')),true);
		
		if(!empty($json['image']) && !empty($json['image_ext']))
		$image=$this->getmyfile($json['image'],$json['image_ext'],"user_images/");
		if(!empty($json['video']) && !empty($json['video_ext']))
		$video=$this->getmyfile($json['video'],$json['video_ext'],"user_video/");
		if(!empty($json['video_thumb']))
		$videothumb=$this->getmyfile($json['video_thumb'],".jpeg","user_video/");
		if(!empty($json['audio']) && !empty($json['audio_ext']))
		$audio=$this->getmyfile($json['audio'],$json['audio_ext'],"user_audio/");

		$latitude=!empty($json['latitude'])?$json['latitude']:'';
		$longitude=!empty($json['longitude'])?$json['longitude']:'';
		$address=!empty($json['address'])?$json['address']:'';
		$iconid=!empty($json['iconid'])?$json['iconid']:0;
	    
	   if(!empty($json['userid']) && !empty($json['discussionid']) && (!empty($json['comment']) || !empty($json['color']) || !empty($audio) || !empty($image) || !empty($video) || !empty($iconid) || (!empty($latitude) && !empty($longitude))))
	    	{
	    		//echo $image;
	    		 $this->load->model('discussion_app_model');
	    		 $res= $this->discussion_app_model->addComment($json['userid'],$json['discussionid'],!empty($json['comment'])?$json['comment']:'',!empty($json['color'])?$json['color']:'',!empty($audio)?$audio:'',!empty($image)?$image:'',!empty($video)?$video:'',!empty($videothumb)?$videothumb:'',$latitude,$longitude,$address,$iconid);
	    	}
			else
			{
				$res=array("code"=>400,"message"=>"Required Fields");
			}
        echo json_encode($res);
	}
	
	function getDiscussions()
	{
	    $start=!empty($_GET['start'])?$_GET['start']:0;
	    $this->load->model('discussion_app_model');
	    $res= $this->discussion_app_model->getDiscussions($start);
		
		echo json_encode($res);
	
	}
	
	function getComments()
	{
	    $discussionid= $_GET['discussionid'];
		if(!empty($discussionid))
		{
	    $this->load->model('discussion_app_model');
	    $res= $this->discussion_app_model->getComments($discussionid);
		}
		else
		$res=array("code"=>400,"message"=>"Required Fields");
		
		echo json_encode($res);
	}
	

		function getmyfile($file,$file_ext,$filedest)
		{
			 $d = base64_decode($file);
			 $myfile = $filedest. uniqid() .$file_ext;
			 $success = file_put_contents($myfile, $d);
		  if($success==true)
		  {
			$filepath = $myfile;
			return $filepath;
		  }  
		}


}