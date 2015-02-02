<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class admin_users extends CI_Controller
{

   function __construct()
	{
		parent::__construct();
		$this->load->helper('url'); 
	   
	
	}
	
function plususer()
	{
	
	header("Access-Control-Allow-Origin: *");
	header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
	header('content-type: application/json;charset=utf-8');
	$json = json_decode(trim(file_get_contents('php://input')),true);

    $username=$json['username'];
    $email=$json['email'];
    $role=$json['role'];
    $gender=$json['gender'];

	if(!empty($username) && !empty($email) && !empty($role) && !empty($gender))
	{
	$this->load->model('admin_users_model');
	$msg=$this->admin_users_model->plususer(urldecode($username),urldecode($email),urldecode($role),urldecode($gender));
	}
	else
	{
	$msg=array("code"=>400,"message"=>"Required Fields");
	}
	echo json_encode($msg);

	}
	
	function samplemail()
	{
	    $config=array('protocol'=>'smtp','smtp_host'=>'dedrelay.secureserver.net','smtp_port'=>25,'smtp_user'=>'','smtp_pass'=>'');
                $this->load->library('email',$config);
                $this->email->set_newline("\r\n");
                $this->email->from('info@vip.com','nithish');
                $this->email->to('nithish.reddy.jnh@gmail.com');
                $this->email->subject("Friend Request from $name");
                $this->email->message('Hi,I would like to add you as my friend on Mailapp');
                $this->email->send();
                echo $this->email->print_debugger();
	
	}
	
	function sendmail()
	{
	     	$json = json_decode(trim(file_get_contents('php://input')),true);			
			if(!empty($json['to_id']) && !empty($json['message']))
			{
			  $q=$this->db->query("select email from users where user_id='$json[to_id]'");
			  $r=$q->row();
			  $config=array('protocol'=>'smtp','smtp_host'=>'dedrelay.secureserver.net','smtp_port'=>25,'smtp_user'=>'','smtp_pass'=>'');
			  $this->load->library('email',$config);
			  $this->email->set_newline("\r\n");
			  $this->email->from('vip@rewardsvipclub.com','VIP');
			  $this->email->to($r->email);
			  $this->email->subject("Mail from VIP Admin");
			  $this->email->message($json['message']);
			  $this->email->set_mailtype("html");
              if($this->email->send())
			  {
			  echo json_encode(array("code"=>200,"message"=>"Email sent successfully"));
			  }
			  else
			  echo json_encode(array("code"=>400,"message"=>"Delivery Failed/Invalid Email"));
			  
			}
	}
	
	function pushmessage()
	{
	  $json = json_decode(trim(file_get_contents('php://input')),true);
	  if(!empty($json['msg']))
	  {
		$this->load->model('admin_users_model');
		$msg=$this->admin_users_model->pushmessage($json['msg']);
	  } 
	  else
	  {
	    array("code"=>400,"message"=>"Required message");
	  }
	  echo json_encode($msg);
	  
	}
	
	function getmyfile()
		{
		
		$json = json_decode(trim(file_get_contents('php://input')),true);
		if($json['type']=='image')
		$filedest="user_images/";
		else if($json['type']=='audio')
		$filedest="user_audio/"; 
		else if($json['type']=='video' || $json['type']=='videothumb')
		$filedest="user_video/"; 
		//echo $json['value'];
		$name=str_replace(' ','',$json['name1']);
		$val=explode(",", $json['value']);
		$d=base64_decode($val[1]);
		//echo $d;
		$myfile = $filedest.uniqid() .$name;
		//$myfile = $filedest. uniqid().'.'.$json['ext'];
		$success = file_put_contents($myfile,$d);
		if($success==true)
		{
		$filepath = base_url().$myfile;
		echo json_encode(array("filepath"=>$filepath,"type"=>$json['type']));
		}  
		}
	
	function getemail($userid)
	{
      if(!empty($userid))
	  {
	    $q=$this->db->query("select uu.email,up.user_name,uu.user_id from users uu inner join user_profile up on uu.user_id=up.user_id where uu.user_id='$userid'");
	    echo json_encode($q->row_array());
	 }
	 
	}
	
	 function deleteuser($userid)
	 {
	   if(!empty($userid))
	   {
	   $q=$this->db->query("update users set Deleted=1 where user_id='$userid'");
	    
	   }
	 
	 }
	 
	 function setStatus($userid,$status)
	 {
	 $stat=($status=='Active')?2:1;
     if(!empty($userid) && !empty($stat))
	 {
	  $q=$this->db->query("update users set Status='$stat' where user_id='$userid'"); 
	 }
	 
	 }
	
	}