<?php
//database connection
require 'dbconnect.php';

        $q1=mysql_query("select EventName,UserId from event where DATE_FORMAT(EventDate,'%d-%m-%Y %H:%i')=DATE_FORMAT(UTC_TIMESTAMP(),'%d-%m-%Y %H:%i')");
		
        while($row1=mysql_fetch_array($q1))
		{
		  $token=getusertoken($row1['UserId']);
		  iosnotify($token,$row1['EventName']);
		}
				
 function getusertoken($userid)
{
	$devicetoken="";
	$tq="select device_token from user_profile where user_id='$userid' and device_token!='' group by device_token";
	$restq=mysql_query($tq);
    $rowtq=mysql_fetch_array($restq);
    $devicetoken=$rowtq['device_token'];
	return $devicetoken;

} 

	function iosnotify($devicetoken,$message)
    {
	 // echo $devicetoken.",".$message." || ";
        $time = time();
        $apnsHost = 'gateway.push.apple.com';
        $apnsPort = 2195;
        $apnsCert = '../vip.pem';
        $streamContext = stream_context_create();
        stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);
        $apns = stream_socket_client('ssl://' . $apnsHost . ':' . $apnsPort, $error, $errorString, 2, STREAM_CLIENT_CONNECT,$streamContext);
        if($apns)
        {
		    $q1=mysql_query("insert into temp values ('$token')");
			$q2=mysql_query("insert into temp values ('$message')");
            $payload = array();
            //$payload['aps'] = array('alert' => $message, 'badge' => 1, 'sound' => 'default','notifytype'=>$notifytype,'keyword'=>$keyword);strval($badge)
            $payload['aps'] = array('alert' => $message,'sound' => 'default','badge'=>1);
            $payload = json_encode($payload);
            $apnsMessage = chr(0) . chr(0) . chr(32) . pack('H*', str_replace(' ', '', $devicetoken)) . chr(0) . chr(strlen($payload)) . $payload;
            fwrite($apns, $apnsMessage);
            //echo 'Push Message Sent Successfully';
            //echo $payload;
            //print_r($payload);
            //echo $notifytype.'/'.$deviceToken.'/'.$message.'/'.$keyword;
            //echo $payload;
        }
        else
        {
            /*echo "Connection Failed - iPhone Push Notifications Server";
            echo $errorString."<br />";
            echo $error."<br />";*/
        }
        fclose($apns);

    }

function pushMessage($userid,$message)
    {
        
		//print_r($devicetoken);
		 $token=getusertoken($userid);
		 
		echo $token.",".$message.",".$userid." || ";
      	
		 $time = time();
        $apnsHost = 'gateway.push.apple.com';
        $apnsPort = 2195;
        $apnsCert = '../vip.pem';
        $streamContext = stream_context_create();
        stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);
        $apns = stream_socket_client('ssl://' . $apnsHost . ':' . $apnsPort, $error, $errorString, 2, STREAM_CLIENT_CONNECT,$streamContext);
        if($apns)
        {
	     	$q1=mysql_query("insert into temp values ('$token')");
			$q2=mysql_query("insert into temp values ('$message')");
            $payload = array();
            //$payload['aps'] = array('alert' => $message, 'badge' => 1, 'sound' => 'default','notifytype'=>$notifytype,'keyword'=>$keyword);strval($badge)
           $payload['aps'] = array('alert' => $message,'sound' => 'default','badge'=>1);
            $payload = json_encode($payload);
            $apnsMessage = chr(0) . chr(0) . chr(32) . pack('H*', str_replace(' ', '', $devicetoken)) . chr(0) . chr(strlen($payload)) . $payload;
            fwrite($apns, $apnsMessage);
         
        }
        else
        {
            /*echo "Connection Failed - iPhone Push Notifications Server";
            echo $errorString."<br />";
            echo $error."<br />";*/
        }
        fclose($apns);

    }
?>