<?php 
$production=0;
//$apnsServer = 'ssl://gateway.sandbox.push.apple.com:2195';
//if ($production) {
   // $gateway = 'gateway.push.apple.com:2195';
   // $deviceToken ='a174f5fdb7d2a9c14965ed01774e9f981ec0439ef6111586baa0b3bc93b64e6a';
//} else { 
    $gateway = 'gateway.sandbox.push.apple.com:2195';
    $deviceToken ='f274a28cb9a3a2f7382a99e15dbd983cdd4bd963aae91464623059e32a7706f7';
//}
$apnsServer = 'ssl://'.$gateway ;
$privateKeyPassword = 'entrust_root_certification_authority.pem';
$message = array( "title"=>"Promotion",
                "subtitle"=>"" ,"body"=>"Add multimedia content to your notifications","points"=>"0","businessId"=>1,"isFavourite"=> "no"
              );
                $attrs=array("attachment-url"=>"https://framework.realtime.co/blog/img/ios10-video.mp4");



///$pushCertAndKeyPemFile = 'WeedRewards.pem';
$pushCertAndKeyPemFile = 'AVA_DevNew.pem';
$stream = stream_context_create();
stream_context_set_option($stream,'ssl','passphrase',$privateKeyPassword);
stream_context_set_option($stream,'ssl','local_cert',$pushCertAndKeyPemFile);
$connectionTimeout = 30;
$connectionType = STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT;
$connection = stream_socket_client($apnsServer, $errorNumber, $errorString, $connectionTimeout,$connectionType,$stream);

if (!$connection){
    echo "Failed to connect to the APNS server. Error = $errorString <br/>";
    exit;
}
else{
    echo "Successfully connected to the APNS. Processing...</br>";
}
$messageBody['aps'] = array('alert' => $message,'badge' => 1, 'sound' => 'default','mutable-content'=>1,'data'=> $attrs);
$messageBody['data'] = attrs;
$payload = json_encode($messageBody);
$notification = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
$wroteSuccessfully = fwrite($connection, $notification, strlen($notification));

if (!$wroteSuccessfully){
    echo "Could not send the message<br/>";
} else {
    echo "Successfully sent the message<br/>";
}

?>
