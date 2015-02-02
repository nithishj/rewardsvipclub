<?php
class Lookup_Db extends CI_Model
{
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
	public function insert_rgb($data = null){
		if(!isset($data['r_value']) OR !isset($data['g_value']) OR !isset($data['b_value'])){
			return "Failed";
		}
		if($this->db->insert('color_lookup',$data)) {

			return 'Success';
		}
		return "Failed";
	}

	public function get_rgb($data = null){
			$this->db->order_by('color_lookup_id','asc');
			$res = $this->db->get('color_lookup');
			$res = $res->result();
                        foreach($res as $v)
                     {
                     $msg[]=array("color_lookup_id"=>$v->color_lookup_id,"r_value"=>$v->r_value,"g_value"=>$v->g_value,"b_value"=>$v->b_value,"r_fore_value"=>$v->r_fore_value,"g_fore_value"=>$v->g_fore_value,"b_fore_value"=>$v->b_fore_value,"color_images"=>!empty($v->color_images)?base_url('color_images')."/".$v->color_images:"");

                     }
			return $msg;
	}
}