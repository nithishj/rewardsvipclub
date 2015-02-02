<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class pushmessage extends CI_Controller
{

	
	function iosnotify($devicetoken)
    {
        $time = time();
        $apnsHost = 'gateway.push.apple.com';
        $apnsPort = 2195;
        $apnsCert = 'vip.pem';
        $streamContext = stream_context_create();
        stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);
        $apns = stream_socket_client('ssl://' . $apnsHost . ':' . $apnsPort, $error, $errorString, 2, STREAM_CLIENT_CONNECT,$streamContext);
        if($apns)
        {
            $payload = array();
            //$payload['aps'] = array('alert' => $message, 'badge' => 1, 'sound' => 'default','notifytype'=>$notifytype,'keyword'=>$keyword);strval($badge)
            $payload['aps'] = array('alert' => "hello",'sound' => 'default','badge'=>1);
            $payload = json_encode($payload);
            $apnsMessage = chr(0) . chr(0) . chr(32) . pack('H*', str_replace(' ', '', $devicetoken)) . chr(0) . chr(strlen($payload)) . $payload;
            fwrite($apns, $apnsMessage);
            //echo 'Push Message Sent Successfully';
            //echo $payload;
            //print_r($payload);
            //echo $notifytype.'/'.$deviceToken.'/'.$message.'/'.$keyword;
            echo $payload;
        }
        else
        {
            /*echo "Connection Failed - iPhone Push Notifications Server";
            echo $errorString."<br />";
            echo $error."<br />";*/
        }
        fclose($apns);



    }
}