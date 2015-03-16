<?php 

class taskrunner extends CI_Controller
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
		$this->schedulepushtask();
	}
	
	
	 function schedulepushtask()
    {
	   $q=$this->db->query("insert into temp values ('hello hello')");

	}

}