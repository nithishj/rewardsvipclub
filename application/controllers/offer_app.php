<?php defined('BASEPATH') OR exit('No direct script access allowed');


class offer_app extends CI_Controller
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
   
   function get_offers()
   {
   
      $start=!empty($_GET['start'])?$_GET['start']:0;
      $this->load->model('offer_app_model');
      $msg=$this->offer_app_model->get_offers($start);
	  echo json_encode($msg); 
   }
   
    function useoffer()
    {
	    $json = json_decode(trim(file_get_contents('php://input')),true);
			
		if(!empty($json['UserId']) && !empty($json['OfferCode']) )
		{
			$this->load->model('offer_app_model');
			$msg=$this->offer_app_model->useoffer($json['UserId'],$json['OfferCode']);
		}
		else
		$msg=array("Message"=>"Required Fields","code"=>400);
	    echo json_encode($msg);
		
	}
}