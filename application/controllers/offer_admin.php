<?php defined('BASEPATH') OR exit('No direct script access allowed');


class offer_admin extends CI_Controller
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
   
    function addoffer()
    {
		$json = json_decode(trim(file_get_contents('php://input')),true);
		if(!empty($json['OfferName']) && !empty($json['Points']) && !empty($json['userid']) && !empty($json['image']))
		{
		$this->load->model('offer_admin_model');
		$res=$this->offer_admin_model->addoffer($json['OfferName'],!empty($json['Description'])?$json['Description']:"",$json['Points'],$json['userid'],$json['image']);
		
		}
	     else
		 $res=array("code"=>400,"message"=>"Required Fields");
		 
		 echo json_encode($res);
	}
	
	   function editoffer()
    {
		$json = json_decode(trim(file_get_contents('php://input')),true);
		if(!empty($json['OfferId']) && !empty($json['OfferName']) && !empty($json['Points']) && !empty($json['userid']) && !empty($json['image']))
		{
		$this->load->model('offer_admin_model');
		$res=$this->offer_admin_model->editoffer($json['OfferId'],$json['OfferName'],!empty($json['Description'])?$json['Description']:"",$json['Points'],$json['userid'],$json['image']);
		
		}
	     else
		 $res=array("code"=>400,"message"=>"Required Fields");
		 
		 echo json_encode($res);
	}

	function deleteoffer()
	{
	   $json = json_decode(trim(file_get_contents('php://input')),true);
	      if(!empty($json['offerid']))
	      {
	      $this->load->model('offer_admin_model');
          $res=$this->offer_admin_model->deleteoffer($json['offerid']);
	      }
	      else
	     $res=array("code"=>400,"message"=>"Required Fields");

	     echo json_encode($res);

	}
	
	function listoffers($id)
	{

	 $this->load->model('offer_admin_model');
	 $res=$this->offer_admin_model->listoffers($id);
	 echo json_encode($res);
	}
}