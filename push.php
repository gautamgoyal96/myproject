<?php
		//define('API_ACCESS_KEY','AIzaSyC8iaZMykeh8n0qi6paTe42TY8pSe8RzMs');
		define('API_ACCESS_KEY','AAAA1eEQ060:APA91bHzVxblyapYPsfXqf8PxmgirM_qsspp6nGP_IPMMpWdHHyvDLr06hp4ry65QYl3z0NGhO2IK0Rdbvu24NLFy66zPtpO_9R9PEKIAh_EBJ6U-KUQ_bQ4MeG8o7MnC8VcOSgI56RX');



		// prep the bundle
		//$msg = array
		//(
			//'message' 	=> $notificationMsg,
			//'title'		=> $title,
		//);
		$msg = $notificationMsg;
		$fields = array
		(
			'registration_ids' 	=> array('eou7rYn8v-Y:APA91bF-6PF_FBOKyrkzeSHTV12AX6b33a-JsOnAfLwJd2X3p2IOQ99wOu288DzNfrDUUz9E7EFkID0AGK6tamuDaeKPtQZ7hatlfD5RvHoFmKByWxwcHlxl-pc5CRMsG5bcJmB-I4GG'),
			'data'=> array('points'=>"",'message'=> "10 % Off On this occassion" ,'businessId'=>1,'title'=> 'promotion','isFavourite'=> "no")
		);
		 
		$headers = array
		(
			'Authorization: key=' . API_ACCESS_KEY,
			'Content-Type: application/json'
		);
		
		$ch = curl_init();
	
		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
		//curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		$result = curl_exec($ch );
		curl_close( $ch );
		
		print_r($result);
		print_r($ch);
		die('check');
		//return $result;

	
 ?>
