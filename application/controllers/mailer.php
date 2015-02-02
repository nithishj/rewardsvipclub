<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class mailer extends CI_Controller
{

   function __construct()
	{
		parent::__construct();
		$this->load->helper('url'); 
		$this->load->library('session');			
		error_reporting(E_ALL); ini_set('display_errors', '1');
		error_reporting(E_ERROR | E_PARSE);
	}
	
	function page($dat)
	{
	$email=base64_decode($dat);
	$q=$this->db->query("select email from users where email='$email'");
	if($q->num_rows()>0)
	{
	$data['email']=$email;
	$this->load->view('password',$data);
	
	}
	
	}
	
	
	function reset_password()
	{
	
	
	$email=$_POST['email'];
	$password=$_POST['password'];
	
     $q=$this->db->query("update users set password='$password',Status=1 where email='$email'");
	 
	if($q)
	{
	  echo json_encode(array("code"=>200));
	}
	
	}
	
	}