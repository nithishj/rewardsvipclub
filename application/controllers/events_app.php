<?php defined('BASEPATH') OR exit('No direct script access allowed');


class events_app extends CI_Controller
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
	
	
	 function addevent()
    {
	    $json = json_decode(trim(file_get_contents('php://input')),true);
			
		if(!empty($json['UserId']) && !empty($json['EventName']) && !empty($json['EventDate']))
		{
		  
			if(!empty($json['image']) && !empty($json['image_ext']))
			$myimage=$this->getmyfile($json['image'],$json['image_ext'],"user_images/");
			if(!empty($json['video']) && !empty($json['video_ext']))
			$myvideo=$this->getmyfile($json['video'],$json['video_ext'],"user_video/");
			if(!empty($json['video_thumb']))
			$myvideothumb=$this->getmyfile($json['video_thumb'],".jpeg","user_video/");
			if(!empty($json['audio']) && !empty($json['audio_ext']))
			$myaudio=$this->getmyfile($json['audio'],$json['audio_ext'],"user_audio/");
		
		$this->load->model('events_app_model');
		$res=$this->events_app_model->addevent($json['UserId'],$json['EventName'],!empty($json['EventDescription'])?$json['EventDescription']:"",!empty($json['IconId'])?$json['IconId']:0,$json['EventDate'],!empty($myimage)?$myimage:'',!empty($myvideo)?$myvideo:'',!empty($myvideothumb)?$myvideothumb:'',!empty($myaudio)?$myaudio:'',!empty($json['latitude'])?$json['latitude']:'',!empty($json['longitude'])?$json['longitude']:'',!empty($json['address'])?$json['address']:'');
		}
		else
		$res=array("Message"=>"Required Fields","code"=>400);
	    echo json_encode($res);
		
	}
	
	 function editevent()
    {
	    $json = json_decode(trim(file_get_contents('php://input')),true);
		if(!empty($json['EventId']) && !empty($json['UserId']) && !empty($json['EventName']) && !empty($json['EventDate']))
		{
			if(!empty($json['image']) && !empty($json['image_ext']))
			$myimage=$this->getmyfile($json['image'],$json['image_ext'],"user_images/");
			if(!empty($json['video']) && !empty($json['video_ext']))
			$myvideo=$this->getmyfile($json['video'],$json['video_ext'],"user_video/");
			if(!empty($json['video_thumb']))
			$myvideothumb=$this->getmyfile($json['video_thumb'],".jpeg","user_video/");
			if(!empty($json['audio']) && !empty($json['audio_ext']))
				$myaudio=$this->getmyfile($json['audio'],$json['audio_ext'],"user_audio/");
				$this->load->model('events_app_model');
				$res=$this->events_app_model->editevent($json['EventId'],$json['UserId'],$json['EventName'],!empty($json['EventDescription'])?$json['EventDescription']:"",!empty($json['IconId'])?$json['IconId']:0,$json['EventDate'],!empty($myimage)?$myimage:'',!empty($myvideo)?$myvideo:'',!empty($myvideothumb)?$myvideothumb:'',!empty($myaudio)?$myaudio:'',!empty($json['latitude'])?$json['latitude']:'',!empty($json['longitude'])?$json['longitude']:'',!empty($json['address'])?$json['address']:'');
		}
		else
		$res=array("Message"=>"Required Fields","code"=>400);
	    echo json_encode($res);
		
	}
	
	function getevents($id)
    {
		$this->load->model('events_app_model');
		$res=$this->events_app_model->getevents($id);
	    echo json_encode($res);
	}
	
	function deleteevent()
	{
	    $json = json_decode(trim(file_get_contents('php://input')),true);
		if(!empty($json['EventId']))
		{
		$this->load->model('events_app_model');
		$res=$this->events_app_model->deleteevent($json['EventId']);
		}
		else
		$res=array("message"=>"Required Fieds","code"=>"200");
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