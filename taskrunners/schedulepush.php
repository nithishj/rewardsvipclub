<?php
//database connection
require 'dbconnect.php';


  $q1=mysql_query("select PushScheduleId,AlertMessage from pushschedule where AlertType=1 and Status=0 and DATE_FORMAT(AlertDate,'%d-%m-%Y')=DATE_FORMAT(UTC_DATE(),'%d-%m-%Y') and DATE_FORMAT(AlertTime,'%H:%i')=TIME_FORMAT(UTC_TIME(),'%H:%i')");
		
		
		
		while($row1=mysql_fetch_array($q1))
		{
		  //echo "hello";
		  pushMessage($row1['AlertMessage']);
		}
		
		
  $q2=mysql_query("select ps.PushScheduleId,ps.AlertMessage from pushschedule ps inner join weekday wd where ps.AlertType=2  and wd.Name=DAYNAME(UTC_DATE()) and DATE_FORMAT(ps.AlertTime,'%H:%i')=TIME_FORMAT(UTC_TIME(),'%H:%i')");
		
		while($row2=mysql_fetch_array($q2))
		{
           pushMessage($row2['AlertMessage']);
		}
		

  $q3=mysql_query("select ps.PushScheduleId,ps.AlertMessage from pushschedule ps inner join weekday wd where ps.AlertType=3 and DATE_FORMAT(ps.AlertTime,'%H:%i')=TIME_FORMAT(UTC_TIME(),'%H:%i')");
		
		while($row3=mysql_fetch_array($q3))
		{
		  pushMessage($row3['AlertMessage']);
		}
		
		

 function gettokens()
{
	$devicetokens=array();
	$tq="select device_token from user_profile where device_token!='' group by device_token";
	$restq=mysql_query($tq);
	while($rowtq=mysql_fetch_array($restq))
    {
       $devicetokens[]=$rowtq['device_token'];
    }
	return $devicetokens;

} 

	
	function pushMessage($message)
    {
        
		//print_r($devicetoken);
		 $tokens=gettokens();
		 
		//echo $token.",".$message.",".$userid." || ";
      	
		 $time = time();
        $apnsHost = 'gateway.push.apple.com';
        $apnsPort = 2195;
        $apnsCert = '../vip.pem';
        $streamContext = stream_context_create();
        stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);
        $apns = stream_socket_client('ssl://' . $apnsHost . ':' . $apnsPort, $error, $errorString, 2, STREAM_CLIENT_CONNECT,$streamContext);
        if($apns)
        {
		    foreach($tokens as $v)
			{
	     	$q1=mysql_query("insert into temp values ('$v')");
			$q2=mysql_query("insert into temp values ('$message')");
            $payload = array();
            //$payload['aps'] = array('alert' => $message, 'badge' => 1, 'sound' => 'default','notifytype'=>$notifytype,'keyword'=>$keyword);strval($badge)
            $payload['aps'] = array('alert' => $message,'sound' => 'default','badge'=>1);
            $payload = json_encode($payload);
            $apnsMessage = chr(0) . chr(0) . chr(32) . pack('H*', str_replace(' ', '', $v)) . chr(0) . chr(strlen($payload)) . $payload;
            fwrite($apns, $apnsMessage);
			}
        }
      
        fclose($apns);

    }
?>