<?php defined('BASEPATH') OR exit('No direct script access allowed');


class chat extends CI_Controller
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
   
    function listusers()
    {
		$json = json_decode(trim(file_get_contents('php://input')),true);
		if(!empty($json['userid']))
		{  
		 $this->load->model('chat_model');
		 $msg=$this->chat_model->listusers($json['userid'],!empty($json['start'])?$json['start']:0);
		}
		else
		{
		  $msg=array("code"=>400,"Message"=>"Required UserId");
		}
		echo json_encode($msg);
	}
	
	function setChatStatus()
	{
	  $json = json_decode(trim(file_get_contents('php://input')),true);
		if(!empty($json['userid']) && !empty($json['status']))
		{  
			$this->load->model('chat_model');
			$msg=$this->chat_model->setChatStatus($json['userid'],$json['status']);
	    } 
		else
		{
		    $msg=array("code"=>400,"Message"=>"Required UserId");
		}
		echo json_encode($msg);
	}
	
	
function chatMessage()
{			 
$data = json_decode(trim(file_get_contents('php://input')),true);
foreach ($data['data'] as $v)
{
$userid=$v['userid'];
$friendid=$v['friendid'];
$image=$v['image'];
$image_ext=$v['image_ext'];
$message=$v['message'];
$video=$v['video'];
$video_ext=$v['video_ext'];
$video_thumb=$v['video_thumb'];

if(!empty($userid) &&  !empty($friendid) &&!empty($message))
{
if(!empty($image) && !empty($image_ext))
$myimage=$this->getmyfile($image,$image_ext,"./user_images/");
if(!empty($video) && !empty($video_ext))
$myvideo=$this->getmyfile($video,$video_ext,"./user_video/");
if(!empty($video_thumb))
$myvideothumb=$this->getmyfile($video_thumb,".jpeg","./user_video/");
$this->load->model('chat_model');
$msg=$this->chat_model->chatMessage($userid,$friendid,$message,$myimage,$myvideo,$myvideothumb);
echo json_encode($msg);
}
else
{ 
echo json_encode(array("code"=>400,"message"=>"required fields"));
}
}
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

function getChatHistory()
{
	$json = json_decode(trim(file_get_contents('php://input')),true);
	if(!empty($json['userid']) && !empty($json['friendid']))
	{
	    $start=!empty($json['start'])?$json['start']:0;
		$this->load->model('chat_model');
		$msg=$this->chat_model->getChatHistory($json['userid'],$json['friendid'],$start);
	}
	else
	{
		$msg=array("code"=>400,"message"=>"Required Fields");
	}
	echo json_encode($msg);
}
	
	
}