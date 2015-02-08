<?php

Class banner_admin_model extends CI_Model
{

function addbanner($Name,$Image,$UserId)
{
$a=array("BannerName"=>$Name,"BannerImage"=>$Image,"UserId"=>$UserId);
$q=$this->db->insert('Banner',$a);
return array("code"=>200,"message"=>"success");
}

function editbanner($BannerId,$Name,$Image,$UserId)
{
$a=array("BannerName"=>$Name,"BannerImage"=>$Image,"UserId"=>$UserId);
$this->db->where('BannerId',$BannerId);
$this->db->update('Banner',$a);
return array("code"=>200,"message"=>"success");
}

function deletebanner($ids)
{
$q=$this->db->query("delete from Banner where BannerId IN ($ids)");
if($q)
return array("code"=>200,"message"=>"success");
else
return array("code"=>400,"message"=>"fail");
}

function listbanners($id)
{
if(empty($id))
$q=$this->db->query("select up.user_name,ba.* from banner ba inner join user_profile up on ba.UserId=up.user_id order by BannerId desc");
else
$q=$this->db->query("select up.user_name,ba.* from banner ba inner join user_profile up on ba.UserId=up.user_id where ba.BannerId='$id'");
if($q->num_rows()>0)
return $q->result();
else
return array();

}

}