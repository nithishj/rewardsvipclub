<?php defined('BASEPATH') OR exit('No direct script access allowed');
class survey extends CI_Controller
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
		if(!empty($json['Title']) && !empty($json['Description']) && !empty($json['UserId']))
	     {
			$this->load->model('survey_model');
			$msg=$this->survey_model->addsurvey($json['Title'],$json['Description'],$json['UserId']);
	     }
	   else
	    {
			$msg=array("code"=>400,"message"=>"Required Fields");
	    }
	 echo json_encode($msg);
	  
	}
	
	function addquestion()
	{
	  $json = json_decode(trim(file_get_contents('php://input')),true);
		if(!empty($json['SurveyId']) && !empty($json['Question']) && !empty($json['UserId']) && !empty($json['Choice']))
	     {
			$myimage=(!empty($json['Image']) && !empty($json['Image_Ext']))?($this->getmyfile($json['Image'],$json['Image_Ext'],"user_images/")):"";
			$myaudio=(!empty($json['Audio']) && !empty($json['Audio_Ext']))?($this->getmyfile($json['Audio'],$json['Audio_Ext'],"user_audio/")):"";
			$myvideo=(!empty($json['Video']) && !empty($json['Video_Ext']))?($this->getmyfile($json['Video'],$json['Video_Ext'],"user_video/")):"";
			$myvideothumb=(!empty($json['Video_Thumb']) && !empty($json['Video_Thumb_Ext']))?($this->getmyfile($json['Video_Thumb'],$json['Video_Thumb_Ext'],"user_video/")):"";
			
			$this->load->model('survey_model');
			$msg=$this->survey_model->addquestion($json['SurveyId'],$json['Question'],$json['QuestionId'],$json['UserId'],$myimage,$myaudio,$myvideo,$myvideothumb,$json['ColorId'],$json['IconId'],$json['Choice']);
	     }
	   else
	    {
			$msg=array("code"=>400,"message"=>"Required Fields");
	    }
	 echo json_encode($msg);
	  
	}
	
	function answersurvey()
	{
	$json = json_decode(trim(file_get_contents('php://input')),true);
	if(!empty($json))
	{
	      $this->load->model('survey_model');
		  $msg=$this->survey_model->answersurvey($json);
	}
	else
	     $msg=array("code"=>400,"message"=>"Required Fields");
		 
		 echo json_encode($msg);
	
	
	
	}
	
	function  getsurvey()
	{
	    $start=!empty($_GET['start'])?$_GET['start']:0;
		$this->load->model('survey_model');
		$msg=$this->survey_model->getsurvey($start);
		echo json_encode($msg);
	}
	
	
	 function getsurveyquestions()
	 {
	    $userid=$_GET['UserId'];
		$surveyid=$_GET['SurveyId'];
		$this->load->model('survey_model');
		$msg=$this->survey_model->getsurveyquestions($userid,$surveyid);
		echo json_encode($msg);
	 }
	 
	 function getsurveystatistics()
	 {
		$surveyid=$_GET['SurveyId'];
		$this->load->model('survey_model');
		$msg=$this->survey_model->getsurveystatistics($surveyid);
		echo json_encode($msg);
	 }
	 
	 function getparticipants()
	 {
		$surveyid=$_GET['SurveyId'];
		$this->load->model('survey_model');
		$msg=$this->survey_model->getparticipants($surveyid);
		echo json_encode($msg);
	 }
	 
	 

	
	function  deletequestion()
	{
	  $json = json_decode(trim(file_get_contents('php://input')),true);
	   if(!empty($json['QuestionId']) && !empty($json['UserId']))
	   {
	        $this->load->model('survey_model');
			$msg=$this->survey_model->deletequestion($json['QuestionId'],$json['UserId']);
	   }
	   else
	     $msg=array("code"=>400,"message"=>"Required Fields");
		 
		 echo json_encode($msg);
	}
	
	function  deletesurvey()
	{
	  $json = json_decode(trim(file_get_contents('php://input')),true);
	   if(!empty($json['SurveyId']) && !empty($json['UserId']))
	   {
	       $this->load->model('survey_model');
			$msg=$this->survey_model->deletesurvey($json['SurveyId'],$json['UserId']);
	   }
	   else
	     $msg=array("code"=>400,"message"=>"Required Fields");
		 
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