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

class lookup extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
                $this->load->helper('url');
		$this->load->model('lookup_db');
	}
	
    function rgb_get()
    {
  	$rgb_data = $this->get();
  	if(!isset($rgb_data['r']) OR !isset($rgb_data['g']) OR !isset($rgb_data['b']) )
  	  	$this->response('Failed', 200);
  	$data['r_value'] = $rgb_data['r'];
  	$data['g_value'] = $rgb_data['g'];
  	$data['b_value'] = $rgb_data['b'];
  	$response = $this->lookup_db->insert_rgb($data);
    	$this->response($response , 200);
    } 

    function rgbvalues_get()
    {
    	$response = $this->lookup_db->get_rgb();
    	$this->response($response , 200);
    }
}