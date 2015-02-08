<?php

Class offer_admin_model extends CI_Model
{

function addoffer($OfferName,$Description,$Points,$UserId,$Image)
{
$a=array("OfferName"=>$OfferName,"Description"=>$Description,"Points"=>$Points,"UserId"=>$UserId,"Image"=>$Image);
$q=$this->db->insert('offer',$a);
$id=$this->db->insert_id();
$offercode=md5(uniqid($id, true));
$u=$this->db->query("update offer set OfferCode='$offercode' where OfferId='$id'");
return array("code"=>200,"message"=>"success");
}

function editoffer($OfferId,$OfferName,$Description,$Points,$UserId,$Image)
{
$a=array("OfferName"=>$OfferName,"Description"=>$Description,"Points"=>$Points,"UserId"=>$UserId,"Image"=>$Image);
$this->db->where('OfferId',$OfferId);
$this->db->update('offer',$a);
return array("code"=>200,"message"=>"success");
}

function deleteoffer($ids)
{

$q=$this->db->query("delete from offer where OfferId IN ($ids)");
if($q)
return array("code"=>200,"message"=>"success");
else
return array("code"=>400,"message"=>"fail");
}

function listoffers()
{
$q=$this->db->query("select up.user_name,of.* from offer of inner join user_profile up on of.UserId=up.user_id");
if($q->num_rows()>0)
return $q->result();
else
return array();

}

} 