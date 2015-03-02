<?php defined('BASEPATH') OR exit('No direct script access allowed');

class schedulepush_admin extends CI_Controller
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
   
    function addpush()
	{
		$json = json_decode(trim(file_get_contents('php://input')),true);
		if(!empty($json['UserId']) && !empty($json['AlertMessage']) && !empty($json['AlertType']) && ((!empty($json['AlertDate']) && !empty($json['AlertTime'])) || (!empty($json['AlertDay']) && !empty($json['AlertTime'])) || (!empty($json['AlertTime']))))
		{
			if($json['AlertType']==1)
			{
				$json['AlertDay']="";
			}
			elseif ($json['AlertType']==2)
		    {
				$json['AlertDate']="";
			}
			elseif ($json['AlertType']==3)
		    {
				$json['AlertDate']="";
				$json['AlertDay']="";
			}	
		$this->load->model('schedulepush_admin_model');
		$res=$this->schedulepush_admin_model->addpush($json['UserId'],$json['AlertMessage'],$json['AlertType'],!empty($json['AlertDate'])?$json['AlertDate']:"",$json['AlertTime'],!empty($json['AlertDay'])?$json['AlertDay']:'');
		
		}
		else
		$res=array("Message"=>"Required Fields","code"=>400);
	    echo json_encode($res);
	
	
	}
	
	function editpush()
	{
		$json = json_decode(trim(file_get_contents('php://input')),true);
		if(!empty($json['SchedulePushId']) &&!empty($json['UserId']) && !empty($json['AlertMessage']) && !empty($json['AlertType']) && ((!empty($json['AlertDate']) && !empty($json['AlertTime'])) || (!empty($json['AlertDay']) && !empty($json['AlertTime'])) || (!empty($json['AlertTime']))))
		{
			if($json['AlertType']==1)
			{
				$json['AlertDay']="";
			}
			elseif ($json['AlertType']==2)
		    {
				$json['AlertDate']="";
			}
			elseif ($json['AlertType']==3)
		    {
				$json['AlertDate']="";
				$json['AlertDay']="";
			}	
		$this->load->model('schedulepush_admin_model');
		$res=$this->schedulepush_admin_model->editpush($json['SchedulePushId'],$json['UserId'],$json['AlertMessage'],$json['AlertType'],!empty($json['AlertDate'])?$json['AlertDate']:"",$json['AlertTime'],!empty($json['AlertDay'])?$json['AlertDay']:'');
		}
		else
		$res=array("Message"=>"Required Fields","code"=>400);
	    echo json_encode($res);
	
	}
	
	function deletepush()
	{
		$json = json_decode(trim(file_get_contents('php://input')),true);
		if(!empty($json['SchedulePushId']))
		{
		$this->load->model('schedulepush_admin_model');
		$res=$this->schedulepush_admin_model->deletepush($json['SchedulePushId']);
		
		}
		else
		$res=array("Message"=>"Required Fields","code"=>400);
	    echo json_encode($res);
	
	}
	
	function getpush($id)
	{
		$this->load->model('schedulepush_admin_model');
		$res=$this->schedulepush_admin_model->getpush($id);
		echo json_encode($res);
	}

	function scheduleCron()
	{
        $this->db->query("");

	}
}