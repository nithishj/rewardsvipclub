<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Uploadfile extends CI_Controller
{  

        function __construct()
	{
		parent::__construct();
		$this->load->helper('url');  
		header("Access-Control-Allow-Origin: *");
		header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
		header('content-type: application/json;charset=utf-8');
		error_reporting(E_ALL); ini_set('display_errors', '1');
		error_reporting(E_ERROR | E_PARSE);

	}

		function upload()
		{

                       
			$userid=$_POST['userid'];
			$image = $_FILES['image']['name'];
			$message=$_POST['message'];
			$audio=$_FILES['audio']['name'];
			$video=$_FILES['video']['name'];
			$color=$_POST['color'];
			$latitude=$_POST['latitude'];
			$longitude=$_POST['longitude'];
			$address=$_POST['address'];

			if(!empty($message) && !empty($userid))
			{
				$myimage=(!empty($image))?$this->uploadmyfile($image,"image"):"";
				$myaudio=(!empty($image))?$this->uploadmyfile($audio,"audio"):"";
				$myvideo=(!empty($video))?$this->uploadmyfile($video,"video"):"";
				$this->load->model('upload_model');
				$msg=$this->upload_model->upload($userid,$message,$color,$myimage,$myaudio,$myvideo,$latitude,$longitude,$address);
				echo json_encode($msg);
			}
			else
			{
				echo json_encode(array('message'=>'required fields','code'=>400));
			} 
		}
              
		function uploadmyfile($file,$type)
		{

		//getting image path info
			$imagepath = pathinfo($file);
			//renaming image name with current server date and image path extension
			$pic=date('YmdHis').'.'.$imagepath['extension'];
			$config['max_size']	= '0';
			$config['max_width']  = '0';
			$config['max_height']  = '0';
			$config['file_name'] = $pic; 


			if($type=="image")
			{

				$config['upload_path'] = './user_images/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png';

				//$config['upload_path'] = './user_audio/';
				//$config['allowed_types'] = 'mp3';


				$this->load->library('upload', $config);

				if ($this->upload->do_upload('image'))
				{
					$upload_data = $this->upload->data();
					$profilepicture=$upload_data['file_name'];
					return $profilepicture;
				}
			}

			if($type=="video")
			{

				$config['upload_path'] = './user_video/';
				$config['allowed_types'] = 'mp4';

				//$config['upload_path'] = './user_audio/';
				//$config['allowed_types'] = 'mp3';


				$this->load->library('upload', $config);

				if ($this->upload->do_upload('video'))
				{
					$upload_data = $this->upload->data();
					$profilepicture=$upload_data['file_name'];
					return $profilepicture;
				}


			}

			if($type=="audio")
			{

				$config['upload_path'] = './user_audio/';
				$config['allowed_types'] = 'mp3|m4a';

				//$config['upload_path'] = './user_audio/';
				//$config['allowed_types'] = 'mp3';


			$this->load->library('upload', $config);

				if ($this->upload->do_upload('audio'))
				{
					$upload_data = $this->upload->data();
					$profilepicture=$upload_data['file_name'];
					return $profilepicture;
				}


			}
					
	    }	

		function getupload()
		{
		     $broadcasttype=!empty($_GET['broadcast_type'])?$_GET['broadcast_type']:"push";
			$this->load->model('upload_model');
			$msg=$this->upload_model->getupload($broadcasttype);
			//$this->output->set_content_type('application/json')->set_output(json_encode($msg));
			echo json_encode($msg);
		
		}

function testupload()
{			 
		$data = json_decode(trim(file_get_contents('php://input')),true);
		foreach ($data['data'] as $v)
		{
		  $userid=$v['userid'];
		  $image=$v['image'];
                  $image_ext=$v['image_ext'];
		  $message=$v['message'];
		  $audio=$v['audio'];
                  $audio_ext=$v['audio_ext'];
		  $video=$v['video'];
                  $video_ext=$v['video_ext'];
                  $video_thumb=$v['video_thumb'];
                  $broadcast_type=!empty($v['broadcast_type'])?$v['broadcast_type']:"push";

		  $color=$v['color'];
		  $latitude=!empty($v['latitude'])?$v['latitude']:"";
			$longitude=!empty($v['longitude'])?$v['longitude']:"";
			$address=!empty($v['address'])?$v['address']:"";
			$iconid=!empty($v['iconid'])?$v['iconid']:0;
             if(!empty($userid) && !empty($message))
                {
                   if(!empty($image) && !empty($image_ext))
		  $myimage=$this->getmyfile($image,$image_ext,"user_images/");
                   if(!empty($audio) && !empty($audio_ext))
                  $myaudio=$this->getmyfile($audio,$audio_ext,"user_audio/");
                  if(!empty($video) && !empty($video_ext))
                  $myvideo=$this->getmyfile($video,$video_ext,"user_video/");
                  if(!empty($video_thumb))
                  $myvideothumb=$this->getmyfile($video_thumb,".jpeg","user_video/");
                  $this->load->model('upload_model');
	$msg=$this->upload_model->upload($userid,$message,$color,$myimage,$myaudio,$myvideo,$myvideothumb,$broadcast_type,$latitude,$longitude,$address,$iconid);
		  echo json_encode($msg);
               }
              else
                { 
		   echo json_encode(array("code"=>400,"message"=>"required fields"));
                }
	       }
	       
}


function delbroadcast()
{
$broadcastid=$_REQUEST['broadcastid'];
if(!empty($broadcastid))
{
      $this->load->model('upload_model');
      $msg=$this->upload_model->delbroadcast($broadcastid);
       echo json_encode($msg);
}
else
{
       echo json_encode(array("code"=>400,"message"=>"required fields"));
}

}


function getmyfile($file,$file_ext,$filedest)
{
  $d = base64_decode($file);
  $myfile = $filedest. uniqid() .$file_ext;
  $success = file_put_contents($myfile, $d);
 if($success==true)
 {
  $filepath = $myfile;
  return $filepath;
 }  

}
function clonebroadcast()
{

$broadcastid=$_GET['broadcastid'];
$userid=$_GET['userid'];
if(!empty($broadcastid) && !empty($userid))
{
$this->load->model('upload_model');
$msg=$this->upload_model->clonebroadcast($broadcastid,$userid);
}
else
$msg=array("message"=>"Required fields");

echo json_encode($msg);

}

   function getcolorcodes()
               {

                        $q=$this->db->get('color_lookup');
                        $r=$q->result();
						foreach($r as $v)
						{
						  $msg[]=array("color_lookup_id"=>$v->color_lookup_id,"r_value"=>$v->r_value,"g_value"=>$v->g_value,"b_value"=>$v->b_value,"r_fore_value"=>$v->r_fore_value,"g_fore_value"=>$v->g_fore_value,"b_fore_value"=>$v->b_fore_value);
						}
                        echo json_encode($msg);
               }
    function updatecolor($colorid,$rforcolor,$gforcolor,$bforcolor)
		{

           $a=array("r_fore_value"=>$rforcolor,
		            "g_fore_value"=>$gforcolor,
					"b_fore_value"=>$bforcolor);
           $this->db->where("color_lookup_id",$colorid);
		   $this->db->update('color_lookup',$a);
		   

		}	
		
}					