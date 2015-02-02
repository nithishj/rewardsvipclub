<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Example
 *
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array.
 *
 * @package		CodeIgniter
 * @subpackage	Rest Server
 * @category	Controller
 * @author		Phil Sturgeon
 * @link		http://philsturgeon.co.uk/code/
*/

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';

class users extends REST_Controller
{
	private $cols = array(
			'user_id'=> 'id',
			'user_name' => 'username',
			'user_role' => 'userrole',
			'email' => 'email',
			'password' => 'password',
			'login_type' => 'logintype',
			'device_token' => 'devicetoken',
			'login_type' => 'logintype',
			'gender' => 'gender',
			'profile_picture' => 'image',
			'mobile' => 'mobile',
			'social_id' => 'psw'
	);
	public function __construct()
	{
		parent::__construct();
		$this->load->model('users_db');
		$this->load->library('vip');
		$this->load->library('myinput');
	}
	
    public function user_post()
    {
    	$input = $this->post();
    	$input = $this->security->xss_clean($input);
    	$data = $this->users_db->userdetails_by_user_id($input['id'], $input['socialtype']);
    	$this->response($data, 200);
    }
    
    public function login_post()
    {
    	$data = array();
    	$response = array(
    			'message'=>'',
    			'data'	=> '',
    			'code'	=> ''
    			);
    	/*
    	 * Input validations
    	 */
    	$input = $this->myinput;
    	$this->load->library('form_validation');
    	$input->setInput($this->post());
    	if (($data['email'] = $input->get('email','required')) === false) {
    		$response['message'] = 'Email is required';
    		$response['code'] = 400;
    		$this->response($response,200);
    	}
    	if (($data['password'] = $input->get('psw','required')) === false) {
    		$response['message'] = 'Password is required';
    		$response['code'] = 400;
    		$this->response($response,200);
    	}
        $data['device_token'] = $input->get('devicetoken');
    	$user = $this->users_db->user_by_emal_password($data['email'], $data['password']);
    	if ($user) {
	       $is_not_blocked=$this->users_db->is_not_blocked($user['user_id']);
		   if($is_not_blocked)
		    {
			
    		$user_data = $this->users_db->general_user_by_id($user['user_id'],$data['device_token']);
    		if ($user_data) {
    			$response['message'] = 'Login success';
    			$response['data'] = $user_data;
    			$response['code'] = 200;
    		} else{
	    		$response['message'] = 'Failed to retreive the user data';
	    		$response['code'] = $user;
    		}
			
			}
			else
			{
				$response['message'] = 'Your account has been blocked by Admin';
				$response['code'] = 400;
			}	
    	} else {
	    	$response['message'] = 'Invalid email or password';
	    	$response['code'] = 400;
    	}
    	$response = $this->vip->removeNullInResponseData($response);
    	$this->response($response,200);
    }
 	
    public function register_post()
    {
    	$data = array();
    	$response = array(
    			'message'=>'',
    			'data'	=> '',
    			'code'	=> ''
    			);
    	/*
    	 * Input validations
    	 */
    	$input = $this->myinput;
    	$input->setInput($this->post());
    	if (($data['password'] = $input->get('psw','required')) === false) {
    		$response['message'] = 'Password is required';
    		$response['code'] = 400;
    		$this->response($response,200);
    	}
    	if (($data['social_type'] = $input->get('socialtype','required')) === false) {
    		$response['message'] = 'Social type is required';
    		$response['code'] = 400;
    		$this->response($response,200);
    	}
    	$data['social_type'] = ucfirst(strtolower($data['social_type']));
    	if (!in_array($data['social_type'], array('General', 'Facebook', 'Twitter', 'Linkedin'))) {
    		$response['message'] = 'Invalid social type';
    		$response['code'] = 400;
    		$this->response($response,200);
    	}
    	if ($data['social_type'] == 'General') {
    		if (($data['email'] = $input->get('email','required')) === false) {
    			$response['message'] = 'Email is required';
    			$response['code'] = 400;
    			$this->response($response,200);
    		}
    	}else $data['email'] = $input->get('email');
    	$data['device_token'] = $input->get('devicetoken');
    	$data['user_name'] = $input->get('username');
    	$data['user_role'] = $input->get('userrole');
    	$data['profile_picture'] = $input->get('image');
    	$data['gender'] = $input->get('gender');
    	/*
    	 *  General user registration
    	 */
    	if ($data['social_type'] == 'General') {
    		$is_user_exists = $this->users_db->general_user_exists_by_email($data['email']);
    		if (!$is_user_exists) {
    			$user = array(
    					'password' => $data['password'],
    					'user_role' => $data['user_role'],
    					'email' => $data['email']
    			);
	    		$user_inserted = $this->users_db->insert_user($user);
	    		if ($user_inserted['data']) {
	    			/*$user_profile = array(
	    					'user_id' 	=> $user_inserted['data'],
	    					'user_name'	=> $data['device_token'],
	    					'device_token'=>$data['user_name']
	    					);
                                 */
                                 $user_profile = array(
	    					'user_id' 	=> $user_inserted['data'],
	    					'user_name'	=> $data['user_name'],
	    					'device_token'=>$data['device_token']
	    					);
                                 
	    			$user_profile_inserted = $this->users_db->insert_user_profile($user_profile);
	    			if ($user_profile_inserted['data']) {
	    				$response['message'] = 'User successfully registerd';
	    				$response['code'] = 200;
	    				$response['data'] = $this->users_db->general_user_by_id($user_inserted['data'],$data['device_token']);
	    			} else {
	    				$msg = explode(' ', $user_profile_inserted['message']);
	    				if ($msg[0] == 'Duplicate'){
	    					$response['message'] = ucfirst($this->cols[ str_replace("'", "", $msg[count($msg)-1])]). ' already exists';
	    				}
	    			}
	    		} else {
	    			$msg = explode(' ', $user_inserted['message']);
	    			if ($msg[0] == 'Duplicate'){
	    				$response['message'] = ucfirst($this->cols[ str_replace("'", "", $msg[count($msg)-1])]). ' already exists';
	    			}
	    		}
    		} else {
    			$response['message'] = 'User already registerd';
    			$response['code'] = 400;
    		}
    	} else {
    		/*
    		 * Social user registration
    		 */
    		$social_user = $this->users_db->sociallogin_by_social_id_and_socialtype($data['password'], $data['social_type']);
    		if ($social_user) {
    			// update user details
    			$this->users_db->update_user_by_social_id($data['password'], $data['social_type'], $data);
    			$user_data = $this->users_db->userdetails_by_user_id($social_user['user_id'], $social_user['social_type']);
    			if ($user_data) {
    				$response['message'] = 'Login success';
    				$response['data'] = $user_data;
    				$response['code'] = 200;
    			}
    		} else {
    			$user = array(
    					'user_role' => $data['user_role'],
    					'email' => $data['email']
    			);
    			$user_inserted = $this->users_db->insert_user($user);
    			if ($user_inserted['data']) {
    				/*$user_profile = array(
    						'user_id' 	=> $user_inserted['data'],
    						'user_name'	=> $data['device_token'],
    						'device_token'=>$data['user_name']
    				);
                                */
                                 $user_profile = array(
    						'user_id' 	=> $user_inserted['data'],
    						'user_name'	=> $data['user_name'],
    						'device_token'=>$data['device_token']
    				);
    				$user_profile_inserted = $this->users_db->insert_user_profile($user_profile);
    				if ($user_profile_inserted['data']) {
    					$social_detials = array(
    						'user_id' 	=> $user_inserted['data'],
    						'social_id'	=> $data['password'],
    						'social_type'=>$data['social_type']
    					);
    					$social_user = $this->users_db->insert_social_login($social_detials);
    					if ($social_user['data']) {
    						$response['message'] = 'User successfully registerd';
    						$response['code'] = 200;
    						$response['data'] = $this->users_db->userdetails_by_user_id($user_inserted['data'], $data['social_type']);
    					} else {
    						$msg = explode(' ', $social_user['message']);
    						if ($msg[0] == 'Duplicate'){
    							$response['message'] = ucfirst($this->cols[ str_replace("'", "", $msg[count($msg)-1])]). ' already exists';
    						}
    					}
    				} else {
    					$msg = explode(' ', $user_profile_inserted['message']);
    					if ($msg[0] == 'Duplicate'){
    						$response['message'] = ucfirst($this->cols[ str_replace("'", "", $msg[count($msg)-1])]). ' already exists';
    					}
    				}
    			} else {
    				$msg = explode(' ', $user_inserted['message']);
    				if ($msg[0] == 'Duplicate'){
    					$response['message'] = ucfirst($this->cols[ str_replace("'", "", $msg[count($msg)-1])]). ' already exists';
    				}
    			}
    		}
    	}    	
    	$response = $this->vip->removeNullInResponseData($response);
    	$this->response($response,200);
    }
    
    public function update_post(){
    	$where = array();
    	$values = array();
    	$response = array();
    	$response['data'] = '';
    	$response['message'] = '';
    	$response['code'] = '';
    	$input = $this->myinput;
    	$input->setInput($this->post());
    	if (($where['user_id'] = $input->get('id', 'required')) === false) {
    		$response['message'] = 'Id required to update';
    		$response['code'] = 400;
    		$this->response($response, 200);
    	}
    	$values['gender'] = $input->get('gender');
    	$values['profile_picture'] = $input->get('image1');
    	$values['user_role'] = $input->get('user_role');
    	$values['mobile'] = $input->get('mobile');
    	$values['device_token'] = $input->get('device_token');
    	$values['user_name'] = $input->get('user_name');
    	$result = $where;
    	if (!empty($where['user_id']) AND !empty($values)){
    		$result = $this->users_db->update_user_by_social_id($where['user_id'], 'General', $values);
    		if ($result) {
    			$response['message'] = 'User update successfully';
    			//$response['data'] = $user_data;
    			$response['code'] = 200;
    		} else {
    			$response['message'] = 'Failed to update';
    			$response['code'] = 400;
    		}
    		//$result = $where;
    	} else {
    		$response['message'] = 'Failed to updateq';
    		$response['code'] = 400;
    	}
    	$result['data'] = $this->vip->removeNullInResponseData($result['data']);
    	$this->response($response, 200);
    }
    
    public function delete_post() {
    	$data = $this->post();
    	$where = array();
    	$response = array();
    	if (!empty($data['id'])){
    		$where['user_id'] = $data['id'];
    	}
    	$result = $this->users_db->remove_user($where['user_id']);
    	if ($result['data']) {
    		$response['message'] = 'User deleted';
    		$response['code'] = 200;
    		$response['data'] = $result['message'];
    	} else {
    		$response['message'] = 'Failed to delete user';
    		$response['code'] = 400;
    		$response['data'] = $result['message'];
    	}
    	$this->response($response, 200);
    }
 
}