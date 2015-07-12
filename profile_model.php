<?php
Class profile_model extends CI_Model
{

function forgotpassword($email)
{
  $q=$this->db->query("select user_id from users where email='$email' and password is not null or password=!=''");
  if($q->num_rows()>0)
  {
  $href = base_url()."mailer/page/".base64_encode($to_email);
		$link = '<a href="'.$href.'">Click Here</a>';
		$notes="<html><body>Hello!"."<br/><br/>"."We received a request to provide you with your RVC App Login Credentials, Please click on the link below to Set your Password."."<br/><br/>".
				"Username : ".$to_email."<br/> Link :".$link."<br/><br/>"."Thank you for using RVC!"."<br/><br/>".
				"RVC Team</body></html>";
 
  $config=array('protocol'=>'smtp','smtp_host'=>'dedrelay.secureserver.net','smtp_port'=>25,'smtp_user'=>'','smtp_pass'=>'');
                $this->load->library('email',$config);
                $this->email->set_newline("\r\n");
                $this->email->from('rvc914@rvc.com', 'RVC');
                $this->email->to($to_email);
                $this->email->subject("Set RVC Password");
                $this->email->message($notes);
				$this->email->set_mailtype("html");
	
    if ($this->email->send()){
    
				    $a=array("email"=>$to_email,"Status"=>3,"user_role"=>$role);
		            $this->db->insert('users',$a);
					$id=$this->db->insert_id();
					$b=array("user_id"=>$id,"user_name"=>$username,"gender"=>$gender);
					$this->db->insert('user_profile',$b);
					
				    return array("code"=>"200","message"=>"User added successfully");
				}
				else
				{
					// failed message
					 return array("code"=>400,"message"=>"Mail delivery failed or Invalid Email.");
				}
  
  
  }
  else
  return array("code"=>400,"message"=>"Email doesnot exist");
  
}

function changepassword($userid,$oldpassword,$newpassword)
{
	$q=$this->db->query("select user_id from users where user_id='$userid' and password='$oldpassword'");
	if($q->num_rows()>0)
	{
		$this->db->query("update users set password='$newpassword' where user_id='$userid'");
	     return array("message"=>"Password Changed Successfully","code"=>200);
	}
	else
	{
		return array("message"=>"Wrong Password","code"=>400);
	}

}

function getmysettings($userid)
{
     $baseurl=base_url();
	$thumb=$baseurl."resize.php?height=125&width=125&path=";
    $q=$this->db->query("SELECT uu.user_id,uu.password,uu.user_role,uu.email,uu.Status,uu.OnStatus,case when sl.social_type is not null then sl.social_type else 'General' End as socialtype,case when up.gender is not null then up.gender else '' END as gender,case when (up.profile_picture is  null or char_length(up.profile_picture)=0) then '' else concat('$thumb',up.profile_picture) END as profie_picture,case when up.mobile is not null then up.mobile else '' END as mobile,up.user_name   FROM user_profile up inner join users uu on uu.user_id=up.user_id left join social_login sl on uu.user_id=sl.user_id where uu.user_id=$userid");
    if($q->num_rows()>0)
	return $q->row();
	else
	return array();
}


function updateprofile($userid,$usertype,$username,$profilepic)
{

$a=array("user_role"=>$usertype);
$this->db->where("user_id",$userid);
$this->db->update("users",$a);

if(empty($profilepic))
$b=array("user_name"=>$username);

else
$b=array("user_name"=>$username,"profile_picture"=>$profilepic);

$this->db->where("user_id",$userid);
$this->db->update("user_profile",$b);

return array("message"=>"Profile Updated Successfully","code"=>200);
}

function terminate($userid,$password)
{
$a=$this->db->query("select social_type from social_login where user_id='$userid'");
if($a->num_rows()>0)
{
$q=$this->db->query("Delete from users where user_id=$userid");
return array("message"=>"User Deleted Successfully","code"=>200);
}
else
{

if(empty($password))
return array("message"=>"Required Fields","code"=>400);

$q=$this->db->query("select user_id from users where user_id=$userid and password='$password'");
if($q->num_rows()>0)
{
$q=$this->db->query("Delete from users where user_id=$userid");
return array("message"=>"User Deleted Successfully","code"=>200);
}
else
{
return array("message"=>"Wrong Password","code"=>400);
}
}

}
}