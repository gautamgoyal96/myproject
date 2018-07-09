<?php

if(!defined('BASEPATH')) exit('No direct script access allowed');

class Notification_model extends CI_Model {

    protected $apnsDir = '';

    // -----------------------------------------------

    /**
     * Setup some basic stuffs
     * @param void
     * @return void
     * @access public 
     */
    public function __construct() {

        parent::__construct();

        /* get all the APNS files */
        //$this->apnsDir = $_SERVER['DOCUMENT_ROOT'].'/application/third_party/ApnsPHP/';
        $this->apnsDir = realpath(APPPATH)."/third_party/ApnsPHP/";
        $this->_apns_req();

        return;

    } /* /__construct() */

    // -----------------------------------------------

    /**
     * Will send the actual iOS notification to the user
     * @param $token string iOS device token
     * @param $msg string 
     * @param $attrs array Key/value pairs to be sent as meta with APN
     * @return void
     * @access public
     */
    function send_ios($token, $msg, $attrs=array()) {
    	
		
        if(!$token || !$msg) return;
		//ENVIRONMENT_PRODUCTION
        // Instantiate a new ApnsPHP_Push object
        $push = new ApnsPHP_Push(
              ApnsPHP_Abstract::ENVIRONMENT_PRODUCTION,
          //  ApnsPHP_Abstract::ENVIRONMENT_SANDBOX,
            $this->apnsDir.'pem/MenuPlussPushProduction.pem'
           // $this->apnsDir.'pem/MenuPlussPushSandbox.pem'
        );

        // Set the Provider Certificate passphrase
        // $push->setProviderCertificatePassphrase('tablecan29');

        // Set the Root Certificate Autority to verify the Apple remote peer
        $push->setRootCertificationAuthority($this->apnsDir.'pem/entrust_root_certification_authority.pem');

        // Connect to the Apple Push Notification Service
        $push->connect();

		for($i=0; $i < count($token); $i++){
		
			// Instantiate a new Message with a single recipient
			$message = new ApnsPHP_Message($token[$i]);
			
			// over a ApnsPHP_Message object retrieved with the getErrors() message.
			$message->setCustomIdentifier(sprintf("Message-Badge-%03d", $i));
			// Set badge icon to "3"
			$message->setBadge(1);
			
			// Set a simple welcome text
			$message->setText($msg);
			$message->setCustomProperty('PEload', $attrs);
			$message->setContentAvailable();
			$message->setSound('default');
			// Add the message to the message queue
			$push->add($message);
			
		}

		// Send all messages in the message queue
		$push->send();
		// Disconnect from the Apple Push Notification Service
		$push->disconnect();
		
		// Examine the error message container
		$aErrorQueue = $push->getErrors();
		if (!empty($aErrorQueue)) {
			//var_dump($aErrorQueue);
		}


        return TRUE;

    } /* /send_ios() */

    // -----------------------------------------------

    private function _apns_req() {

        require_once $this->apnsDir.'Abstract.php';
        require_once $this->apnsDir.'Exception.php';
        require_once $this->apnsDir.'Feedback.php';
        require_once $this->apnsDir.'Message.php';
        require_once $this->apnsDir.'Log/Interface.php';
        require_once $this->apnsDir.'Log/Embedded.php';
        require_once $this->apnsDir.'Message/Custom.php';
        require_once $this->apnsDir.'Message/Exception.php';
        require_once $this->apnsDir.'Push.php';
        require_once $this->apnsDir.'Push/Exception.php';
        require_once $this->apnsDir.'Push/Server.php';
        require_once $this->apnsDir.'Push/Server/Exception.php';

        return;

    } /* /_apns_req() */
    
    function send_android($registrationIds,$notificationMsg,$title)
    {     
		@define('API_ACCESS_KEY','AAAAoLgxV4c:APA91bFcy2qb9VBQaHaygNUoDkRmv2dE1dJ5ry8bRqyvNOHVbNUeLDuXLEYan3_gJOn3vvVNIaWB1XPf7440Dy83ja1AfiBmBonQoTRzgmdOKjkQGzAZ8-cqGuBiFnzpOnwqrT4bXZ18Be_zPAmwgGAWk_rwP3wAfw');
		//if (!defined('API_ACCESS_KEY')) define('API_ACCESS_KEY', 'AIzaSyDipWTjctvyiBIcIGbnJMna5nqCo2tV5Jg');
		// prep the bundle
		$msg = array
		(
			'message' 	=> $notificationMsg,
			'title'		=> $title,
		);
		
		$fields = array
		(
			'registration_ids' 	=> $registrationIds,
			'data'			=> $msg
		);
		 
		$headers = array
		(
			'Authorization: key=' . API_ACCESS_KEY,
			'Content-Type: application/json'
		);
		
		$ch = curl_init();
		
		curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		$result = curl_exec($ch );
		curl_close( $ch );
		
		/*print_r($result);
		print_r($ch);*/
	
		
		return $result;
	}
	
	function getUserDeviceId($id){
		$query = $this->db->select('device_id')->from('users')->where(array('id' => $id,'notify_status'=>1))->get();
		if($query->num_rows() > 0){
		$ret = $query->row();
		return $ret;
		}else{
			return FALSE;
		}
	}
	
	function notification_log($notData){
		$data['crd']= date('Y-m-d H:i:s');
		$data['upd']= date('Y-m-d H:i:s');
		$data['notification_msg']= $notData['notification_msg']['msg'];
		$data['send_status']= $notData['send_status'];
		
		$resultdata = $this->db->select('id')->from('notification')->where(array('sender'=>$this->authData->id,'receiver'=> $notData['receiver'],'notification_type' => $notData['notification_type'],'type_id'=> $notData['type_id']))->get();
		
			if($resultdata->num_rows() == 0){
			$this->db->insert('notification_log',$data);
			
			if($notData['send_status'] == '1'){
			$result = $this->db->select('*')->from('notification_log')->where('id',mysql_insert_id())->get();
			
			$notifydata = array(
				'notification_id'  	=> $result->row()->id,
				'sender'			=> $this->authData->id,
				'receiver'			=> $notData['receiver'],
				'notification_type' => $notData['notification_type'],
				'type_id'			=> $notData['type_id'],
				'crd'				=> date('Y-m-d H:i:s'),
				'upd'				=> date('Y-m-d H:i:s'),
			);
			$this->db->insert('notification',$notifydata);
			}
		}
		return TRUE;
	}

} /* /Notification_model{} */

/* End of file notification_model.php */
/* Location: ./application/models/notification_model.php */
