<?php

Class banner_app_model extends CI_Model
{

	function getbanners()
	{
		$burl=base_url();
		$q=$this->db->query("select BannerId,BannerName,concat('$burl',BannerImage) as BannerImage,BannerUrl,Timer,Status from banner where Status=0 order by BannerId desc");
		if($q->num_rows()>0)
		return $q->result();
		else
		return array();
	}
	
}
?>