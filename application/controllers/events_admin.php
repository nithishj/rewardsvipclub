<?php defined('BASEPATH') OR exit('No direct script access allowed');


class events_admin extends CI_Controller
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
		$this->load->model('events_admin_model');
		$res=$this->events_admin_model->addevent($json['UserId'],$json['EventName'],$json['EventDescription'],$json['IconId'],$json['EventDate']);
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
		$this->load->model('events_admin_model');
		$res=$this->events_admin_model->editevent($json['EventId'],$json['UserId'],$json['EventName'],$json['EventDescription'],$json['IconId'],$json['EventDate']);
		}
		else
		$res=array("Message"=>"Required Fields","code"=>400);
	    echo json_encode($res);
		
	}
	 function deleteevent()
    {
	    $json = json_decode(trim(file_get_contents('php://input')),true);
		if(!empty($json['EventId']))
		{
		$this->load->model('events_admin_model');
		$res=$this->events_admin_model->deleteevent($json['EventId']);
		}
		else
		$res=array("Message"=>"Required Fields","code"=>400);
	    echo json_encode($res);
		
	}
	
	 function getevents($id)
    {
	    $json = json_decode(trim(file_get_contents('php://input')),true);
		$this->load->model('events_admin_model');
		$res=$this->events_admin_model->getevents($id);
	    echo json_encode($res);
	}
	
	function geticons()
	{
		$this->load->model('events_admin_model');
		$res=$this->events_admin_model->geticons();
		echo json_encode($res);
	}
	
}