<?php

Class admin_model extends CI_Model
{

function listusers($start)
{

$defaultimg=base_url('includes/images').'/a5.jpg';
$q=$this->db->query("select uu.user_id,uu.email,uu.user_role,case when sl.social_type IS NULL then 'General' ELSE sl.social_type END as  login_type,
case when CHAR_LENGTH(up.gender)>0 then up.gender ELSE 'NA' END as gender,case when up.profile_picture IS NULL or CHAR_LENGTH(up.profile_picture)=0 then '$defaultimg' ELSE up.profile_picture END as profile_picture,case when up.mobile IS NULL then '--' ELSE up.mobile END as mobile,up.user_name,case when uu.Status=1 then 'Active' when uu.Status=2 then 'Suspended' ELSE 'Pending' END as Status,case when uu.Status=1 then 'bg-success'  when uu.Status=2 then 'bg-warning' ELSE 'bg-info'END as Statclass,uu.Deleted,uu.CreatedDate,up.UpdatedDate from users uu left join user_profile up on uu.user_id=up.user_id left join social_login sl on uu.user_id=sl.user_id where uu.Deleted=0 order by uu.user_id desc limit $start,100 ");

if($q->num_rows()>0)
return $q->result();
else
return array();
}

function portal_signin($email,$password)
{
$defaultimg=base_url('includes/images').'/a5.jpg';
$q=$this->db->query("select uu.user_id,uu.email,uu.user_role,up.gender,
case when up.profile_picture IS NULL or CHAR_LENGTH(up.profile_picture)=0 then '$defaultimg' ELSE up.profile_picture END as profile_picture,
up.user_name from users uu left join user_profile up on uu.user_id=up.user_id where uu.email='$email' and uu.password='$password' and (uu.user_role='Admin') and uu.Deleted=0 and uu.Status=1");

if($q->num_rows()==1)
{
$this->session->set_userdata($q->row_array());
return array("msg"=>200);
}
else
{
return array("msg"=>"Invalid Email/Password");
}
}

function plususer($username,$email,$role)
{
 $q=$this->db->query("select userid from users where email='$email'");
 
 if($q->num_rows()==0)
 {
    $href = base_url()."/mailer/setpassword/".urlencode(base64_encode($email));
				$link = '<a href="'.$href.'">Click Here</a>';
				$to_email=$email;
				
				//sending mail to user for recovery of password
				$subject = "VIP Password";
			  /*$notes="Hello!"."<br/><br/>"."We received a request to provide you with your FlyInStyle App Login Credentials, which are noted below."."<br/><br/>".
				"Username : ".$to_email."<br/> Password : ".$password."<br/><br/>"."Thank you for using FlyInStyle!"."<br/><br/>".
				"FlyInStyle Team";  */
				$notes="<html><body>Hello $username,"."<br/><br/>"."We received a request to provide you with your VIP App Login Credentials, Please click on the link below to set your Password."."<br/><br/>".
				"Email: ".$to_email."<br/> Link :".$link."<br/><br/>"."Thank you for using VIP!"."<br/><br/>".
				"FlyInStyle Team</body></html>";
				$this->email->from('info@vip.com', 'FlyInStyle');
				$this->email->to($to_email); 
				$this->email->subject($subject);
				$this->email->message($notes);
				$this->email->reply_to('',''); 
				$this->email->set_mailtype("html");
				$result=$this->email->send();
				if($result)
				{
				    $a=array("email"=>$email,Status=>3,user_role=>$role);
		            $this->db->insert('users',$a);
					$id=$this->db->insert_id();  
					$b=array("user_id"=>$id,"user_name"=>$username);
					$this->db->insert('users',$b);
					
				    return array("code"=>"200","User added successfully");
				}
				else
				{
					// failed message
					 return array("code"=>400,"message"=>"Mail delivery failed or Invalid Email.");
				}

 }
 else
 {
   return array("code"=>400,"message"=>"User with this Email already Exists");
 }
}

}
?>