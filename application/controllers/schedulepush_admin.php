<?php defined('BASEPATH') OR exit('No direct script access allowed');

class schedulepush_admin extends CI_Controller
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
   
    function addpush()
	{
		$json = json_decode(trim(file_get_contents('php://input')),true);
		if(!empty($json['UserId']) && !empty($json['AlertMessage']) && !empty($json['AlertType']) && ((!empty($json['AlertDate']) && !empty($json['AlertTime'])) || (!empty($json['AlertDay']) && !empty($json['AlertTime'])) || (!empty($json['AlertTime']))))
		{
			if($json['AlertType']==1)
			{
				$json['AlertDay']="";
			}
			elseif ($json['AlertType']==2)
		    {
				$json['AlertDate']="";
			}
			elseif ($json['AlertType']==3)
		    {
				$json['AlertDate']="";
				$json['AlertDay']="";
			}	
		$this->load->model('schedulepush_admin_model');
		$res=$this->schedulepush_admin_model->addpush($json['UserId'],$json['AlertMessage'],$json['AlertType'],!empty($json['AlertDate'])?$json['AlertDate']:"",$json['AlertTime'],!empty($json['AlertDay'])?$json['AlertDay']:'');
		
		}
		else
		$res=array("Message"=>"Required Fields","code"=>400);
	    echo json_encode($res);
	
	
	}
	
	function editpush()
	{
		$json = json_decode(trim(file_get_contents('php://input')),true);
		if(!empty($json['SchedulePushId']) &&!empty($json['UserId']) && !empty($json['AlertMessage']) && !empty($json['AlertType']) && ((!empty($json['AlertDate']) && !empty($json['AlertTime'])) || (!empty($json['AlertDay']) && !empty($json['AlertTime'])) || (!empty($json['AlertTime']))))
		{
			if($json['AlertType']==1)
			{
				$json['AlertDay']="";
			}
			elseif ($json['AlertType']==2)
		    {
				$json['AlertDate']="";
			}
			elseif ($json['AlertType']==3)
		    {
				$json['AlertDate']="";
				$json['AlertDay']="";
			}	
		$this->load->model('schedulepush_admin_model');
		$res=$this->schedulepush_admin_model->editpush($json['SchedulePushId'],$json['UserId'],$json['AlertMessage'],$json['AlertType'],!empty($json['AlertDate'])?$json['AlertDate']:"",$json['AlertTime'],!empty($json['AlertDay'])?$json['AlertDay']:'');
		}
		else
		$res=array("Message"=>"Required Fields","code"=>400);
	    echo json_encode($res);
	
	}
	
	function deletepush()
	{
		$json = json_decode(trim(file_get_contents('php://input')),true);
		if(!empty($json['SchedulePushId']))
		{
		$this->load->model('schedulepush_admin_model');
		$res=$this->schedulepush_admin_model->deletepush($json['SchedulePushId']);
		
		}
		else
		$res=array("Message"=>"Required Fields","code"=>400);
	    echo json_encode($res);
	
	}
	
	function getpush($id)
	{
		$this->load->model('schedulepush_admin_model');
		$res=$this->schedulepush_admin_model->getpush($id);
		echo json_encode($res);
	}
	
	function gettokens()
	{
	   $q=$this->db->query("select device_token from user_profile where device_token!='' group by device_token");
	   if($q->num_rows()>0)
	   return $q->result();
	   else
	   return array();
	
	}

	function scheduleCron()
	{
	   $q=$this->db->query("insert into temp values ('hello hello')");
        $time = time();
        $apnsHost = 'gateway.push.apple.com';
        $apnsPort = 2195;
        $apnsCert = 'vip.pem';
        $streamContext = stream_context_create();
        stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);
        $apns = stream_socket_client('ssl://' . $apnsHost . ':' . $apnsPort, $error, $errorString, 2, STREAM_CLIENT_CONNECT,$streamContext);

	   // $q= $this->db->query("select ps.AlertMessage,ps.AlertTime,DATE_FORMAT(ps.AlertDate,'%d-%m-%Y'),DATE_FORMAT(UTC_DATE(),'%d-%m-%Y'),TIME_FORMAT(UTC_TIME(),'%H:%i'),DATE_FORMAT(ps.AlertTime,'%H:%i'),DAYNAME(UTC_DATE()),wd.Name from pushschedule ps left join weekday wd on ps.AlertDay=wd.WeekDayId where ps.Status=0");
       
	   $tokens=$this->gettokens();
	   $q1=$this->db->query("select PushScheduleId,AlertMessage from pushschedule where AlertType=1 and Status=0 and DATE_FORMAT(ADDDATE(AlertDate, 1),'%d-%m-%Y')=DATE_FORMAT(UTC_DATE(),'%d-%m-%Y') and DATE_FORMAT(AlertTime,'%H:%i')=TIME_FORMAT(UTC_TIME(),'%H:%i')");
		if($q1->num_rows()> 0)
		{
		$r1=$q1->result();
		foreach($r1 as $v)
		{
		   $this->iosnotify($tokens,$v->AlertMessage,$apns);
		}
		}
	   
	   $q2=$this->db->query("select ps.PushScheduleId,ps.AlertMessage from pushschedule ps inner join weekday wd where ps.AlertType=2  and wd.Name=DAYNAME(UTC_DATE()) and DATE_FORMAT(ps.AlertTime,'%H:%i')=TIME_FORMAT(UTC_TIME(),'%H:%i')");
		if($q2->num_rows()> 0)
		{
		$r2=$q2->result();
		foreach($r2 as $v)
		{
           $this->iosnotify($tokens,$v->AlertMessage,$apns);
		}
		}
		
		$q3=$this->db->query("select ps.PushScheduleId,ps.AlertMessage from pushschedule ps inner join weekday wd where ps.AlertType=3 and DATE_FORMAT(ps.AlertTime,'%H:%i')=TIME_FORMAT(UTC_TIME(),'%H:%i')");
		if($q3->num_rows()> 0)
		{
		$r3=$q3->result();
		foreach($r3 as $v)
		{
           $this->iosnotify($tokens,$v->AlertMessage,$apns);
		}
		}

		 fclose($apns);

	}
	
	function iosnotify($devicetoken,$message,$apns)
    {
        
        if($apns)
        {
		    foreach($devicetoken as $v)
			{
            $payload = array();
            $payload['aps'] = array('alert' => $message,'sound' => 'default','badge'=>1);
            $payload = json_encode($payload);
            $apnsMessage = chr(0) . chr(0) . chr(32) . pack('H*', str_replace(' ', '', $v->device_token)) . chr(0) . chr(strlen($payload)) . $payload;
            fwrite($apns, $apnsMessage);
			}
           
        }
        else
        {
            /*echo "Connection Failed - iPhone Push Notifications Server";
            echo $errorString."<br />";
            echo $error."<br />";*/
        }

    }
}