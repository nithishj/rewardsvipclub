<?php defined('BASEPATH') OR exit('No direct script access allowed');
class admin_survey extends CI_Controller
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
	
	function addsurvey()
	{
		$json = json_decode(trim(file_get_contents('php://input')),true);
		$this->load->model('admin_survey_model');
		$msg=$this->admin_survey_model->addsurvey($json);
		echo json_encode($msg);
	}
	
	function submitsurvey()
	{
	$json = json_decode(trim(file_get_contents('php://input')),true);
	if(!empty($json))
	{
	      $this->load->model('admin_survey_model');
		  $msg=$this->admin_survey_model->submitsurvey($json);
	}
	else
	     $msg=array("code"=>400,"message"=>"Required Fields");
		 echo json_encode($msg);
	
	}
	
	function  getsurvey()
	{
	    $userid=$_GET['userid'];
	    $start=!empty($_GET['start'])?$_GET['start']:0;
		$this->load->model('admin_survey_model');
		$msg=$this->admin_survey_model->getsurvey($userid,$start);
		echo json_encode($msg);
	}
	
	
	 function getsurveyquestions()
	 {
	    $userid=$_GET['UserId'];
		$surveyid=$_GET['SurveyId'];
		$this->load->model('admin_survey_model');
		$msg=$this->admin_survey_model->getsurveyquestions($userid,$surveyid);
		echo json_encode($msg);
	 }
	 
	 function getsurveystatistics()
	 {
		$surveyid=$_GET['surveyid'];
		$this->load->model('admin_survey_model');
		$msg=$this->admin_survey_model->getsurveystatistics($surveyid);
		echo json_encode($msg);
	 }
	 
	 function getmyanswers()
	 {
	    $surveyid=$_GET['surveyid'];
		$userid=$_GET['userid'];
		$this->load->model('admin_survey_model');
		$msg=$this->admin_survey_model->getmyanswers($surveyid,$userid);
		echo json_encode($msg);
	 
	 }
	 
	 function getparticipants()
	 {
		$surveyid=$_GET['SurveyId'];
		$this->load->model('admin_survey_model');
		$msg=$this->admin_survey_model->getparticipants($surveyid);
		echo json_encode($msg);
	 }
	
	
	function  deletesurvey()
	{
	  $json = json_decode(trim(file_get_contents('php://input')),true);
	   if(!empty($json['SurveyId']))
	   {
	       $this->load->model('admin_survey_model');
			$msg=$this->admin_survey_model->deletesurvey($json['SurveyId'],$json['UserId']);
	   }
	   else
	     $msg=array("code"=>400,"message"=>"Required Fields");
		 
		 echo json_encode($msg);
	}

	
}