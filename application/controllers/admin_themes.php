<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class admin_themes extends CI_Controller
{

   function __construct()
	{
		parent::__construct();
		$this->load->helper('url'); 
		
	}

	function addtheme()
	{

		$json = json_decode(trim(file_get_contents('php://input')),true);
		if(!empty($json['Image']) && !empty($json['UserId']))
		{
		
		$d = array('Image'  => $json['Image'],
		  		   'UserId' => $json['UserId']);
		$this->db->insert("theme_lookup",$d);
        echo json_encode(array("message"=>"success","code"=>200));
		}
		else
		echo json_encode(array("message"=>"Required Fields","code"=>400));
	}

	function deletetheme()
	{
		$json = json_decode(trim(file_get_contents('php://input')),true);
		if(!empty($json['ThemeId']))
		{
          $this->db->delete('theme_lookup',array('theme_lookup_id'=>$json['ThemeId']));
          echo json_encode(array("message"=>"success","code"=>200));
		}
		else
	    echo json_encode(array("message"=>"Required Fields","code"=>400));

	}

	function listthemes()
	{
        $base=base_url();
        $thumb=$base."resize.php?height=100&width=150&path=";
        $q=$this->db->query("select theme_lookup_id as id,concat('$base',Image) as theme,concat('$thumb',Image) as thumb from theme_lookup order by theme_lookup_id desc");
        if($q->num_rows()>0)
        echo json_encode($q->result());
        else 
        echo json_encode(array("message"=>"Required Fields","code"=>400));

	}
}