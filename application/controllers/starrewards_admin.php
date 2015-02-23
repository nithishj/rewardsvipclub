<?php defined('BASEPATH') OR exit('No direct script access allowed');


class starrewards_admin extends CI_Controller
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

    function addstarreward()
    {
		$json = json_decode(trim(file_get_contents('php://input')),true);
		if(!empty($json['Message']) && !empty($json['Points']) && !empty($json['UserIds']))
		$this->load->model('starrewards_admin_model');
		$msg=$this->starrewards_admin_model->addstarreward($json['Message'],$json['Points'],$json['UserIds']);
	    echo json_encode($msg);
	}
	
	function getusers()
	{
		$json = json_decode(trim(file_get_contents('php://input')),true);
		$this->load->model('starrewards_admin_model');
		//echo json_encode($json);
		$msg=$this->starrewards_admin_model->getusers($json['query'],$json['users']);
		echo json_encode($msg);
	}
}