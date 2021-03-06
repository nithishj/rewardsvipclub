<?php defined('BASEPATH') OR exit('No direct script access allowed');


class banner_admin extends CI_Controller
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

    function addbanner()
    {
		$json = json_decode(trim(file_get_contents('php://input')),true);
		if(!empty($json['BannerName']) && !empty($json['BannerImage']) && !empty($json['UserId']) &&  !empty($json['Timer']))
		{
		$this->load->model('banner_admin_model');
		$res=$this->banner_admin_model->addbanner($json['BannerName'],$json['BannerImage'],!empty($json['BannerUrl'])?$json['BannerUrl']:"",$json['UserId'], $json['Timer']);

		}
	     else
		 $res=array("code"=>400,"message"=>"Required Fields");

		 echo json_encode($res);
	}

	   function editbanner()
    {
		$json = json_decode(trim(file_get_contents('php://input')),true);
		if(!empty($json['BannerId']) && !empty($json['BannerName']) && !empty($json['BannerImage']) && !empty($json['UserId']) &&  !empty($json['Timer']))
		{
		$this->load->model('banner_admin_model');
		$res=$this->banner_admin_model->editbanner($json['BannerId'],$json['BannerName'],$json['BannerImage'],!empty($json['BannerUrl'])?$json['BannerUrl']:"",$json['UserId'], $json['Timer']);

		}
	     else
		 $res=array("code"=>400,"message"=>"Required Fields");

		 echo json_encode($res);
	}

	function deletebanner()
	{
	   $json = json_decode(trim(file_get_contents('php://input')),true);
	      if(!empty($json['Bannerid']))
	      {
	      $this->load->model('banner_admin_model');
          $res=$this->banner_admin_model->deletebanner($json['Bannerid']);
	      }
	      else
	     $res=array("code"=>400,"message"=>"Required Fields");

	     echo json_encode($res);

	}

	function listbanners($id)
	{

	 $this->load->model('banner_admin_model');
	 $res=$this->banner_admin_model->listbanners($id);
	 echo json_encode($res);
	}

	function setstatus()
	{
      $json = json_decode(trim(file_get_contents('php://input')),true);
      if(!empty($json['BannerId']))
	      {
             $q=$this->db->query("select Status from banner where BannerId='$json[BannerId]'");
             $r=$q->row();
             if($r->Status==0)
             $stat=1;
             else
             $stat=0;
             
             $q1=$this->db->query("update banner set Status='$stat' where BannerId='$json[BannerId]'");
             $msg=array("message"=>"success");
          }
          else
          {
          	$msg=array("message"=>"Required Fields");
          }

        echo json_encode($msg);
	}
}