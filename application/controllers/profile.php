<?php defined('BASEPATH') OR exit('No direct script access allowed');


class profile extends CI_Controller
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

	
	function changepassword()
	{

      $data = json_decode(trim(file_get_contents('php://input')),true);	
	  
		if(!empty($data['UserId']) && !empty($data['OldPassword']) && !empty($data['NewPassword']))
		{
				$this->load->model('profile_model');
		   $msg=$this->profile_model->changepassword($data['UserId'],$data['OldPassword'],$data['NewPassword']);
		}
		else
		{
		$msg=array("message"=>"Required Fields","code"=>400);
		}
		echo json_encode($msg);
	
	}
	
	function getmysettings()
	{
	  if(!empty($_GET['userid']))
	  {
	       $this->load->model('profile_model');
		   $msg=$this->profile_model->getmysettings($_GET['userid']);
	  
	  }
	  else
	  {
			$msg=array("message"=>"Required Fields","code"=>400);
	  }
	 echo json_encode($msg);
	}
	
	
	function updateprofile()
	{
	  $data = json_decode(trim(file_get_contents('php://input')),true);
	  if(!empty($data['Image']) && !empty($data['ImageExt']))
	  $myimage=$this->getmyfile($data['Image'],$data['ImageExt'],"user_images/");
	  else
	  $myimage="";
	  
      if(!empty($data['UserId']) && !empty($data['UserType']) && !empty($data['UserName']))	
	  {
			$this->load->model('profile_model');
			$msg=$this->profile_model->updateprofile($data['UserId'],$data['UserType'],$data['UserName'],$myimage);

	  }
	  else
	  {
			$msg=array("message"=>"Required Fields","code"=>400);
	  }
	  echo json_encode($msg);
	
	}
	
	function get_user_themes()
	{
	  $baseurl=base_url();	
	  $thumb=$baseurl."resize.php?height=100&width=100&path=";
	  $q=$this->db->query("select theme_lookup_id,concat('$baseurl',Image) as theme,concat('$thumb',Image) as thumb  from theme_lookup");
	  echo json_encode($q->result());
	}
	
	
	function terminate()
	{
	$data = json_decode(trim(file_get_contents('php://input')),true);
	 if(!empty($data['UserId']))
	 {
			$this->load->model('profile_model');
			$msg=$this->profile_model->terminate($data['UserId'],$data['Password']);
	 }
	 else
	 {
	       $msg=array("message"=>"Required Fields","code"=>400);
	 }
	   echo json_encode($msg);
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