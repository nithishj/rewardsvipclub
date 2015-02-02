<?php
class Users_Db extends CI_Model
{
	private $message = null;
	private $data = null;
	private $code = null;
	public function __construct()
	{
		$this->load->database();
		
	}
	/* 200 OK
	 * 204 No Content
	 * 400 Bad Request
	 * 401 Unauthorized
	 * 408 Request Timeout
	 * 440 Login Timeout (Microsoft)
	 */ 
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	public function insert_user($data) {
		
		if ($this->db->insert('users',$data))
			return array('data'=>$this->db->insert_id(),'message'=>$this->db->_error_message());
		return array('data'=>false,'message'=>$this->db->_error_message());
	}
	
	public function insert_social_login($data) {
		
		if ($this->db->insert('social_login',$data))
			return array('data'=>$this->db->insert_id(),'message'=>$this->db->_error_message());
		return array('data'=>false,'message'=>$this->db->_error_message());
	}
	
	public function insert_user_profile($data) {
		
		if ($this->db->insert('user_profile',$data))
			return array('data'=>$this->db->insert_id(),'message'=>$this->db->_error_message());
		return array('data'=>false,'message'=>$this->db->_error_message());
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function user($input = null)	{
		
	}
	
	public function user_by_id($id) {
		if (empty($id))
			return false;
		$this->db->select('*');
		$result = $this->db->get_where('users', array('user_id'=>$id));
		if ($result->num_rows()>0){
			$result = $result->result_array(); 
			$result = $result[0];
			return $result;
		}
		return false;
	}
	//('user_id', 'user_name', 'user_type', 'email', 'password', 'device_token', 'gender', 'image')
	public function user_by_emal($email) {
		if (empty($email))
			return false;
		$this->db->select('*');
		$result = $this->db->get_where('users', array('email'=>$email));
		if ($result->num_rows()>0){
			$result = $result->result_array(); 
			$result = $result[0];
			return $result;
		}
		return false;
	}
	
	public function user_by_emal_password($email,$password) {
		if (empty($email))
			return false;
		if (empty($password))
			return false;
		$this->db->select('*');
		$result = $this->db->get_where('users', array('email'=>$email, 'password'=>$password, 'Deleted'=>0));
		if ($result->num_rows()>0){
			$result = $result->result_array();
			$result = $result[0];
			return $result;
		}
		return false;
	}
	
	public function userprofile_by_user_id($id) {
		if (empty($id))
			return false;
		$this->db->select('*');
		$result = $this->db->get_where('user_profile', array('user_id'=>$id));
		if ($result->num_rows()>0){
			$result = $result->result_array();
			$result = $result[0];
			return $result;
		}
		return false;
	}
	
	public function general_user_by_id($id,$devicetoken) {
		if (empty($id))
			return false;
                if(!empty($devicetoken))
                {
                   $this->db->where('user_id',$id);
                   $d=array("device_token"=>$devicetoken);
                   $this->db->update('user_profile',$d);
                }
		$this->db->select('u.user_id AS id, u.user_role AS userrole, u.email, up.gender, up.profile_picture AS image, up.mobile AS phone, up.user_name AS username, up.device_token AS devicetoken');
		$this->db->from('users u');
		$this->db->join('user_profile up', 'up.user_id = u.user_id');
		$this->db->where('u.user_id = '.$id);
		$result = $this->db->get();
		if ($result->num_rows()>0){
			$result = $result->result_array();
			$result = $result[0];
			return $result;
		}
		return false;
	}
	
	public function is_not_blocked($id)
	{
	  if(empty($id))
	  return false;
	  $q=$this->db->query("select Status from users where user_id='$id' and Status='2'");
	  if($q->num_rows()>0)  //is blocked
	  return false;
	  else
	  return true;
	}
	

	//('user_id', 'user_name', 'user_type', 'email', 'password', 'device_token', 'gender', 'image')
	public function userprofile_by_profile_id($profile_id) {
		if (empty($profile_id))
			return false;
		$this->db->select('*');
		$result = $this->db->get_where('user_profile', array('user_profile_id'=>$profile_id));
		if ($result->num_rows()>0){
			$result = $result->result_array();
			$result = $result[0];
			return $result;
		}
		return false;
	}
	
	public function sociallogin_by_user_id_and_socialtype($id, $social_type) {
		if (empty($id))
			return false;
		if (empty($social_type))
			return false;
		$this->db->select('*');
		$result = $this->db->get_where('social_login', array('user_id'=>$id, 'social_type'=>$social_type));
		if ($result->num_rows()>0){
			$result = $result->result_array();
			$result = $result[0];
			return $result;
		}
		return false;
	}
	
	public function sociallogin_by_social_id($social_id) {
		if (empty($social_id))
			return false;
		$this->db->select('*');
		$result = $this->db->get_where('social_login', array('social_login_id'=>$social_id));
		if ($result->num_rows()>0){
			$result = $result->result_array();
			$result = $result[0];
			return $result;
		}
		return false;
	}
	
	public function sociallogin_by_social_id_and_socialtype($social_id, $social_type) {
		if (empty($social_id))
			return false;
		if (empty($social_type))
			return false;
		$this->db->select('*');
		$result = $this->db->get_where('social_login', array('social_id'=>$social_id, 'social_type'=>$social_type));
		if ($result->num_rows()>0){
			$result = $result->result_array();
			$result = $result[0];
			return $result;
		}
		return false;
	}
	
	//('user_id', 'user_name', 'user_type', 'email', 'password', 'device_token', 'gender', 'image')
	public function social_user_exists_by_socialid($social_id) {
		if (empty($social_id))
			return false;
		$this->db->select('*');
		$result = $this->db->get_where('social_login', array('social_id'=>$social_id));
		if ($result->num_rows()>0){
			$result = $result->result_array();
			$result = $result[0];
			return $result;
		}
		return false;
	}
	
	public function userdetails_by_user_id($id, $social_type) {
		if (empty($id))
			return false;
		$this->db->select('u.user_id AS id, u.user_role AS userrole, u.email, sn.social_id AS psw, sn.social_type AS socialtype,
				 up.gender, up.profile_picture AS image, up.mobile AS phone, up.user_name AS username, up.device_token AS devicetoken');
		$this->db->from('users u');
		$this->db->join('social_login sn', 'sn.user_id = u.user_id');
		$this->db->join('user_profile up', 'up.user_id = u.user_id');
		$this->db->where('u.user_id = '.$id.' AND sn.social_type = "'.$social_type.'"');
		$result = $this->db->get();
		if ($result->num_rows()>0){
			$result = $result->result_array();
			$result = $result[0];
			return $result;
		}
		return false;
	}
	
	public function general_user_exists_by_email($email) {
		if (empty($email))
			return false;
		$this->db->select('u.user_id',false);
		$this->db->from('users u');
		$this->db->join('social_login sn', 'sn.user_id = u.user_id','left');
		$this->db->where('u.email LIKE "'.$email.'" AND sn.user_id is null');
		$result = $this->db->get();
		if ($result->num_rows()>0){
			$result = $result->result_array();
			$result = $result[0];
			return $result;
		}
		return false;
	}
	
	public function update_user_by_social_id($social_id, $social_type, $data) {
		if (empty($social_id) OR empty($social_type) OR empty($data))
			return false;
		$user = array('user_role' => $data['user_role']);
		if ($social_type == 'General') {
			$user_id = $social_id;
		} else {
			$user['email'] = $data['email'];
			$social_user = $this->sociallogin_by_social_id_and_socialtype($social_id, $social_type);
			$user_id = $social_user['user_id'];
		}
		$this->db->where('user_id', $user_id);
		
		$user_profile = array(
				'user_name'	=> $data['user_name'],
				'device_token'=>$data['device_token'],
				'profile_picture'=>$data['profile_picture'],
				'gender'=>$data['gender']
		);
		if ($social_type != 'General')
			$this->db->update('users', $user);

                 $this->db->where('user_id', $user_id);
		$this->db->update('user_profile', $user_profile);
		return false;
	}
	
	public function remove_user($id){
		if (empty($id))
			return false;
		$tables = array('social_login', 'user_profile', 'users');
		$this->db->where('user_id', $id);
		$this->db->delete($tables);
		$result = $this->db->affected_rows();
		if ($result > 0){
			return array('data' => true, 'message' => $this->db->affected_rows());
		}
		return array('data' => false, 'message' => $this->db->_error_message());
	}
}