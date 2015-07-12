<?php

Class offer_app_model extends CI_Model
{
    function get_offers($start)
	{
	 $base=base_url();
	 $q=$this->db->query("select oo.OfferId,oo.OfferName,oo.Description,oo.OfferCode,oo.Points,oo.UserId,case when char_length(oo.Image)>0 then concat('$base',oo.Image) else '' end as Image,oo.CreatedDate from offer oo order by oo.OfferId desc limit $start,20");
	if($q->num_rows()>0)
	 return $q->result();
	 else
	 return array();
	
	}
	
	function useoffer($userid,$offercode)
	{
	  $q=$this->db->query("select OfferLogId from offerlog ol inner join offer of on ol.OfferId=of.OfferId where of.OfferCode='$offercode' and ol.UserId='$userid'");
	  if($q->num_rows()>0)
	  return array("message"=>"You Have Used This Offer Already");
	  else
	  {
	    $q1=$this->db->query("select OfferId,Points from offer where OfferCode='$offercode'");
		if($q1->num_rows()>0)
	    {
		  $r1=$q1->row();	  
		  $q3=$this->db->query("update user_profile set Points=Points+'$r1->Points' where user_id='$userid'");
		  
		  $a4=array("OfferId"=>$r1->OfferId,"UserId"=>$userid);
		  $q4=$this->db->insert('offerlog',$a4);
		  return array("message"=>"Points added Successfully");
		}
		else
		return array("message"=>"Wrong Offer Code");
	  
	  }
	}
}