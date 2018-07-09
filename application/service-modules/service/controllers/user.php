<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
//load rest library
require APPPATH . '/libraries/REST_Controller.php';

class User extends Rest_Controller {

	public function __construct(){

		parent::__construct();
		$this->load->model('user_model');
	}

	function updateProfile_post(){
		$userData = array();
		if(!empty($_POST['email']))
			$userData['email'] = $this->post('email');

		if(!empty($_POST['firstName']))
			$userData['firstName'] = $this->post('firstName');

		if(!empty($_POST['lastName']))
			$userData['lastName'] = $this->post('lastName');

		if(!empty($_POST['firebaseToken']))
			$userData['firebaseToken'] = $this->post('firebaseToken');

		if(!empty($_POST['firebaseId']))
			$userData['firebaseId'] = $this->post('firebaseId');


		if(!empty($_POST['about']))
			$userData['about'] = $this->post('about');

		if(!empty($_POST['notifcationstatus']))
			$userData['notifcationstatus'] = $this->post('notifcationstatus');

		if(!empty($_POST['deviceToken']))
			$userData['deviceToken'] = $this->post('deviceToken');

		
		if(!empty($_POST['deviceType']))
			$userData['deviceType'] = $this->post('deviceType');


		if(!empty($_POST['address'])){

			$userData['address'] = $this->post('address');
			$userData['zipCode'] = $this->post('address');
			$userData['latitude'] = $this->post('latitude');
			$userData['longitude'] = $this->post('longitude');
		}

		if(!empty($_POST['type'])){

			$userData['deviceToken'] = $userData['firebaseToken'] = "";
			
		}
		
		$profileImage = '';
		$folder = 'profile';
		if(isset($_FILES['profileImage']) && is_array($_FILES['profileImage'])){
			
			$profileImage = $this->user_model->upload_img('profileImage',$folder);

			if(is_array($profileImage)){
				$responseArray = array('status'=>FAIL,'message'=>$profileImage['error']);
				$response = $this->generate_response($responseArray);
				$this->response($response);
			}
		}

		if(!empty($profileImage)){
			$userData['profileImage'] = $profileImage;
		}
		
		$updateData = $this->user_model->updateProfile($userData);

		if(!empty($_POST['type'])){

			$response = array('status'=>SUCCESS,'message'=>'Log out successfully');

		}else if(!empty($updateData)){

			$response = array('status'=>SUCCESS,'message'=>'Your profile has been updated successfully','userData'=>$updateData);

		}else{

			$response = array('status'=>FAIL,'message'=>"Email already exist");
			
		}
		
		$this->response($response);
	}


	function changePassword_post(){

		$this->load->library('form_validation');
		$this->form_validation->set_rules('oldPassword', 'Old Password', 'required');
		$this->form_validation->set_rules('newPassword', 'New Password', 'required');

		if($this->form_validation->run() == FALSE):

			$response = array('status' => FAIL, 'message' => strip_tags(validation_errors()));
			$this->response($response);

		else:
			
			$this->load->library('encrypt');
			$userData = array();
			$userData['oldPassword'] = $this->post('oldPassword');
			$userData['newPassword']  = $this->post('newPassword');
	
			$result = $this->user_model->changePassword($userData);

			if($result == 'SE'):

				$response = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(138));

			else:

				$response = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(137));

			endif;

			$this->response($response);
		
		endif;

	}//ENd FUnction
	
	function emailVerifyStatus_get(){
		$result = $this->user_model->emailVerifyStatus();

		if(!empty($result)){
			$responseArray = array('status'=>SUCCESS,'message' =>ResponseMessages::getStatusCodeMessage(200),'UserDetail'=>$result);
			$response = $this->generate_response($responseArray);
			$this->response($response,OK);
		}else {
			$responseArray = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(118));
			$response = $this->generate_response($responseArray);
			$this->response($response,OK);
		} 
	}
	
	function updateUserType_post(){
		
		$responseArray = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(118));
		$response = $this->generate_response($responseArray);
		$userData = array();
		if(!empty($this->post('userType'))){
			$userData['userType'] = $this->post('userType');
			
			$result = $this->user_model->updateUserType($userData);

			if(!empty($result)){
				$responseArray = array('status'=>SUCCESS,'message' =>ResponseMessages::getStatusCodeMessage(200),'UserProfile'=>$result);
				$response = $this->generate_response($responseArray);			
			}
		}
		$this->response($response,OK);		
	}

	function userInfo_Get() {

			$userId = $this->get('id') ? $this->get('id') : $this->authData->id;
			$data = array('id' =>$userId);
			if(!empty($this->get('chatId'))){

				$userId =  $this->get('chatId');
				$data = array('firebaseId' =>$userId);
			}
			$user = $this->user_model->userInfo($data);

			if(!empty($user)){

				$responseArray = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(200),'userDetail'=>$user,'userStatus' => $this->authData->status);
				$response = $this->generate_response($responseArray);
				$this->response($response,OK);

			}
	
	} //End Function

	function getRentersData_Get() {

			$userId = $this->get('id') ? $this->get('id') : $this->authData->id;
			$type = $this->get('type') ? $this->get('type') : "rented";

			$data = $this->user_model->getRentedRecord($userId,$type);

			if(!empty($data)){

				$responseArray = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(200),'userDetail'=>$data,'userStatus' => $this->authData->status);
				$response = $this->generate_response($responseArray);
				$this->response($response,OK);

			}else{

				$responseArray = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(114),'userStatus' => $this->authData->status);
				$response = $this->generate_response($responseArray);
				$this->response($response,OK);

			}
	
	} //End Function

	function getReview_get() {

		$userId = $this->get('id') ? $this->get('id') : $this->authData->id;
		$review = $this->user_model->getReviews($userId);

        if(!empty($review)){

			$responseArray = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(200),'data'=>$review,'userStatus' => $this->authData->status);

		}else{

			 $responseArray = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(114),'userStatus' => $this->authData->status);	
		}

		$response = $this->generate_response($responseArray);
		$this->response($response,OK);

	} //End Function

	function getAdminFee_get() {

		$review = $this->user_model->getAdminFee();

        if(!empty($review)){

			$responseArray = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(200),'data'=>$review,'userStatus' => $this->authData->status);

		}else{

			 $responseArray = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(114),'userStatus' => $this->authData->status);	
		}

		$response = $this->generate_response($responseArray);
		$this->response($response,OK);

	} //End Function

	function getMessage_get() {

		$page = !empty($this->get('page')) ? $this->get('page') : '0';

		$data = $this->user_model->getMessage($page);

        if(!empty($data)){

			$responseArray = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(200),'data'=>$data,'userStatus' => $this->authData->status);

		}else{

			 $responseArray = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(114),'userStatus' => $this->authData->status);	
		}

		$response = $this->generate_response($responseArray);
		$this->response($response,OK);

	} //End Function

	function messagePost_post(){

		$this->load->library('form_validation');		
			$data = array();

			$chatImage = '';
			$folder = 'chat';
			if(isset($_FILES['message']) && is_array($_FILES['message'])){
				
				$chatImage = $this->user_model->upload_img('message',$folder);

				if(is_array($chatImage)){
					$responseArray = array('status'=>FAIL,'message'=>$chatImage['error']);
					$response = $this->generate_response($responseArray);
					$this->response($response);
				}
			}		

			$data['message'] = !empty($chatImage) ? $chatImage : $this->post('message');
			$data['senderId'] = $this->authData->id;
			$data['receiverId'] = "1";
			$data['senderType'] ="1";
			$data['postType'] = !empty($chatImage) ? '1' : '0';	
			$data['senderType'] = "1";		

			$result = $this->user_model->message($data);
			

			if(($result==true)){	

				$responseArray = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(200),'data'=>$this->user_model->getMessage('0'));
				$status = OK;	

			} else {

				$responseArray = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(118));
	
				$status = OK;
			}


			$response = $this->generate_response($responseArray);
			$this->response($response,$status);	
	
	}


	
}

