<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class admin extends CI_Controller
{

   function __construct()
	{
		parent::__construct();
		$this->load->helper('url'); 
		$this->load->library('session');		 
		error_reporting(E_ALL); ini_set('display_errors', '1');
		error_reporting(E_ERROR | E_PARSE);
	}
	
function validate()
{
$v=$this->session->all_userdata();
if(isset($v['user_id']) && isset($v['email']))
{
return true;
}
else
{
return false;
}

}

function login()
{
$v=$this->session->all_userdata();
if($this->validate())
{
//for admin login
 $this->load->view('admin/index.html');
}
else
{
$this->load->view('login');
}
}

function listusers()
{
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('content-type: application/json;charset=utf-8');

$start=!empty($_REQUEST['start'])?$_REQUEST['start']:0;
$this->load->model('admin_model');
$msg=$this->admin_model->listusers($start);
echo json_encode($msg);

}
function portal_signin()
{
	$email=$_REQUEST['email'];
	$password=$_REQUEST['password'];
    if(!empty($email) && !empty($password))
	{
     $this->load->model('admin_model');
	 $data=$this->admin_model->portal_signin($email,$password);
	 if($data['msg']=='success')
	 {
	  echo json_encode($data);
	 }
	 else
	 {
	echo json_encode($data);
	 }
	}
	else
	{
	 $data['msg']="Required Fields";
	 echo json_encode($data);
	}
}

function logout()
{
$this->session->sess_destroy();
$this->login();
}


function sessionvalues()
	{		
		echo json_encode(array("base_url"=>base_url(),"ssdata"=>$this->session->all_userdata()));
	} 
	


}