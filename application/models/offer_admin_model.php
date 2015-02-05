<?php

Class offer_admin_model extends CI_Model
{

function addoffer($OfferName,$Description,$Points,$UserId,$Image)
{
$a=array("OfferName"=>$OfferName,"Description"=>$Description,"Points"=>$Points,"UserId"=>$userid,"Image"=>$image);
$q=$this->db->insert('offer',$a);
$id=$this->db->insert_id();
$offercode=md5(uniqid($id, true));
$u=$this->db->query("update offer set OfferCode='$offercode' where OfferId='$id'");
return array("code"=>200,"message"=>"success");
}

function editoffer($OfferId,$OfferName,$Description,$Points,$UserId,$Image)
{
$a=array("OfferName"=>$OfferName,"Description"=>$Description,"Points"=>$Points,"UserId"=>$userid,"Image"=>$image);
$this->db->where('OfferId',$OfferId);
$this->db->update('offer',$a);
return array("code"=>200,"message"=>"success");
}

function llistoffers()
{
$q=$this->db->query("select up.user_name,of.* from offer of inner join user_profile up on of.UserId=up.user_id");
if($q->num_rows()>0)
return $q->result();
else
return array();

}

} 