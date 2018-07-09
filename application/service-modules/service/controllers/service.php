<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
//load rest library
require APPPATH . '/libraries/REST_Controller.php';

class Service extends Rest_Controller {

	public function __construct(){

		parent::__construct();
		$this->load->model('service_model');
		$this->load->model('common_model');
		$this->load->library('Smtp_email');
	}

	public function userRegistration_post() {

		$this->load->library('form_validation');
		$socialId = $this->post('socialId');
		if(empty($socialId)){			
			$this->form_validation->set_rules('firstName','FirstName','required');
			$this->form_validation->set_rules('lastName','LastName','required');
			$this->form_validation->set_rules('email','Email','required|valid_email');
			$this->form_validation->set_rules('password','Password','required');
			//$this->form_validation->set_rules('countryCode','Country Code','required');
			//$this->form_validation->set_rules('contactNo','Contact Number','required');		
			$this->form_validation->set_rules('zipCode','ZipCode','required');
			$this->form_validation->set_rules('latitude','Latitude','required');
			$this->form_validation->set_rules('longitude','Longitude','required');	
		} else{
			$this->form_validation->set_rules('socialType','SocialType','required');
		} 
		if($this->form_validation->run() == FALSE){
			$response = array('status'=>FAIL,'message'=>validation_errors());
			$this->response($response);
		} else {
			$this->load->library('encrypt');
			$userData = array();
			$authToken = $this->service_model->_generate_token();
			$socialType = $this->post('socialType');
			
			$profileImage = '';
			$folder = 'profile';
			if(empty($socialId) && empty($socialType)){
				if(!empty($_FILES['profileImage']['name'])){
					$folder = 'profile';
					$profileImage = $this->service_model->upload_img('profileImage',$folder);
				}
			} else{
				$userData['emailVerified'] = '1';
				$profileImage = $this->post('profileImage');
			}
			
			$userData['firstName'] = $this->post('firstName');
			$userData['lastName'] = $this->post('lastName');
			$userData['email'] = $this->post('email');
			$userData['password'] = $this->encrypt->encode($this->post('password'));
			$userData['countryCode'] = $this->post('countryCode');
			$userData['contactNo'] = $this->post('contactNo');
			$userData['latitude'] = $this->post('latitude');
			$userData['longitude'] = $this->post('longitude');
			$userData['zipCode'] = $this->post('zipCode');
			$userData['address'] = $this->post('zipCode');
			$userData['otpVerified'] = '1';
			$userData['OTP'] = "checked";
			$userData['deviceToken'] = $this->post('deviceToken');
			$userData['deviceType'] = $this->post('deviceType');
			$userData['profileImage'] =  (empty($profileImage)) ? '' : $profileImage;
			$userData['socialId'] = $socialId;
			$userData['socialType'] = $socialType;
			$userData['authToken'] = $authToken;
			$userData['crd'] = date('Y-m-d H:i:s');
				
			$isRegister = $this->service_model->userRegistration($userData);
			
			if(is_array($isRegister) && $isRegister['regType'] == 'NR'){
				$response = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(110),'userDetail'=>$isRegister['data']);
			
			} elseif(is_string($isRegister) && $isRegister == 'AE'){
				$response = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(116));
			
			} elseif(is_array($isRegister) && $isRegister['regType'] == 'SL'){
				$response = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(106),'userDetail'=>$isRegister['data']);
			
			} elseif(is_array($isRegister) && $isRegister['regType'] == 'SR'){
				$response = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(110),'userDetail'=>$isRegister['data']);
			
			} elseif(is_string($isRegister) && $isRegister == 'SGW'){
				$response = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(118));
			
			} elseif(is_string($isRegister) && $isRegister == 'CNAE'){
				$response = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(122));
			
			} elseif(is_string($isRegister) && $isRegister == 'FT'){
				
				$response = array('status'=>SUCCESS,'message'=>'User first time social register');
			
			}else {
				$response = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(118));
			}
			$this->response($response);
		}
    } //end function

    public function userLogin_post()
	{  
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email','Email','required|valid_email');
		$this->form_validation->set_rules('password','Password','required');

		if($this->form_validation->run() == FALSE){

			$responseArray = array('status'=>FAIL,'message'=>strip_tags(validation_errors()));
			$response = $this->generate_response($responseArray);
			$this->response($response);
		} else {
			
			$authToken = $this->service_model->_generate_token();
			$this->load->library('encrypt');

			$userData = array();
			$userData['email'] = $this->post('email');
			$userData['password'] = $this->post('password');
			$userData['deviceToken'] = $this->post('deviceToken');
			$userData['deviceType'] = $this->post('deviceType');
			$userData['authToken'] = $authToken;
			
			$isLoggedIn = $this->service_model->userLogin($userData,$authToken);
			
			if(is_string($isLoggedIn['type']) && $isLoggedIn['type'] == 'NA'){
				
				$responseArray = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(121), 'userDetail'=>$isLoggedIn['userDetail']);
			
			} elseif(is_string($isLoggedIn['type']) && $isLoggedIn['type'] == 'WP'){

				$responseArray = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(105), 'userDetail'=>$isLoggedIn['userDetail']);
			} elseif(is_string($isLoggedIn['type']) && $isLoggedIn['type'] == 'LS'){
				
				$responseArray = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(106),'userDetail'=>$isLoggedIn['userDetail']);
			}else{
				$responseArray = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(105));
			}
			$response = $this->generate_response($responseArray);
			$this->response($response);
		}
	} //end function

	public function forgotPassword_post(){
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email','Email','required');
		if($this->form_validation->run() == FALSE){
			$responseArray = array('status'=>FAIL,'message'=>validation_errors());
			$response = $this->generate_response($responseArray);
			$this->response($response);
		} else {
			$result= $this->service_model->forgotPassword($this->post('email'));
			if(is_array($result) && $result['emailType'] == 'ES'){
				$responseArray = array('status'=>SUCCESS,'message'=>$result['email']);	
			}elseif (is_array($result) && $result['emailType'] == 'ES') {
				$responseArray = array('status'=>'SERVER_ERROR','message'=>$result['email']);
			}else{
				$responseArray = array('status'=>FAIL,'message'=>'Email id does not exist');
			}
				$response = $this->generate_response($responseArray);
				$this->response($response);
		}

	}//end function
	
	// code for otp send using twillo
	public function verifyNo_post(){ 
    // Created otp and send on mobile number
		$this->load->library('form_validation');
		$this->form_validation->set_rules('contactNo','Contact No','trim|required|numeric');
		$this->form_validation->set_rules('countryCode','Country Code','trim|required');

		if($this->form_validation->run() == FALSE){
			$responseArray = array('status'=>FAIL,'message'=>strip_tags(validation_errors()));
			$response = $this->generate_response($responseArray);
			$this->response($response);
		} else {
			$conform = (rand(10, 99)).(rand(11, 99));
			//$mobileNumber = ("+").($this->post('mobileNumber'));
			$data_val['contactNo']		=	$this->post('contactNo');
			$data_val['countryCode']	=	$this->input->post('countryCode');
			$data_val['OTP']			=	$conform;
			//$data_val['OTP']			=	"1234";

			$existContact = $this->common_model->get_records_by_id("users",true,array('contactNo'=>$data_val['contactNo'],'countryCode'=>$data_val['countryCode'],'otpVerified'=>'1'),"*","","");

			if(empty($existContact)){
				$verifyNo = $this->service_model->verifyNo($data_val);
				if(is_array($verifyNo)){
					switch ($verifyNo['status']) {
						case "1":
							$responseArray = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(124),'otp'=>$verifyNo['otp'],'countryCode'=>$verifyNo['countryCode'],'contactNo'=>$verifyNo['contactNo']);
							break;
						case "0":
							$responseArray = array('status'=>FAIL,'message'=>$verifyNo['error']);
							break;
						default:
							$responseArray = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(118));
					}
				}
			} else{
				$responseArray = array('status'=>FAIL,'message'=>'This mobile number is already registered.');
			}
			$response = $this->generate_response($responseArray);
			$this->response($response);	
		}		
	}//ENd Function
	
	function getAllCategory_get(){

		$result = $this->service_model->getAllCategory();

		if(!empty($result)){
			$responseArray = array('status'=>SUCCESS,'message' =>ResponseMessages::getStatusCodeMessage(200),'categoryList'=>$result);
			$response = $this->generate_response($responseArray);
			$this->response($response,OK);
		}else {
			$responseArray = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(114));
			$response = $this->generate_response($responseArray);
			$this->response($response,OK);
		} 
	}
	
	function getAllBrands_get(){

		$result = $this->service_model->getAllBrands();

		if(!empty($result)){
			$responseArray = array('status'=>SUCCESS,'message' =>ResponseMessages::getStatusCodeMessage(200),'brandList'=>$result);
			$response = $this->generate_response($responseArray);
			$this->response($response,OK);
		}else {
			$responseArray = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(114));
			$response = $this->generate_response($responseArray);
			$this->response($response,OK);
		} 
	}


	function searchProduct_post(){

		$data['categoryId'] = $this->input->post('categoryId');		
		$data['latitude'] 	= $this->input->post('latitude'); 
		$data['longitude']	= $this->input->post('longitude');  
		$data['ownerId']	= $this->input->post('ownerId');  
		$data['userId'] 	= !empty($this->input->post('userId')) ? $this->input->post('userId') : "";  
		$data['userType'] 	= $this->input->post('userType');  
		$data['distance'] 	= $this->input->post('distance') ? $this->input->post('distance') : "25"; 
		$data['startPrice'] = $this->input->post('startPrice') ? $this->input->post('startPrice') : "";
		$data['endPrice'] = $this->input->post('endPrice') ? $this->input->post('endPrice') : "";  
		$data['condition'] 	= $this->input->post('condition') ? $this->input->post('condition') : "";  
		$data['brand'] 		= $this->input->post('brand') ? $this->input->post('brand') : "";  
		
		$result = $this->service_model->searchProduct($data);

		if(!empty($result)){
			$responseArray = array('status'=>SUCCESS,'message' =>ResponseMessages::getStatusCodeMessage(200),'productData'=>$result,'userStatus' => $this->service_model->userStatus(array('id'=>$data['userId'])));
			$response = $this->generate_response($responseArray);
			$this->response($response,OK);
		}else {
			$responseArray = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(114),'userStatus' => $this->service_model->userStatus(array('id'=>$data['userId'])));
			$response = $this->generate_response($responseArray);
			$this->response($response,OK);
		} 
	}

	function getProductInfo_get(){

		$data['ownerId'] = $this->get('ownerId');		
		$data['productId'] = $this->get('productId'); 
		$data['userId'] = $this->get('userId') ? $this->get('userId') : ''; 
		
		$result = $this->service_model->getProductInfo($data);

		if(!empty($result)){
			$responseArray = array('status'=>SUCCESS,'message' =>ResponseMessages::getStatusCodeMessage(200),'productData'=>$result,'userStatus' => $this->service_model->userStatus(array('id'=>$data['userId'])));
			$response = $this->generate_response($responseArray);
			$this->response($response,OK);
		}else {
			$responseArray = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(114),'userStatus' => $this->service_model->userStatus(array('id'=>$data['userId'])));
			$response = $this->generate_response($responseArray);
			$this->response($response,OK);
		}
	}

	function getProductStatus_get(){

		$data = $this->get('productId'); 
		
		$result = $this->service_model->getProductStatus($data);

		if(!empty($result)){
			$responseArray = array('status'=>SUCCESS,'message' =>ResponseMessages::getStatusCodeMessage(200),'productData'=>$result);
			$response = $this->generate_response($responseArray);
			$this->response($response,OK);
		}else {
			$responseArray = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(114));
			$response = $this->generate_response($responseArray);
			$this->response($response,OK);
		}
	}

	function getFaq_get() {

		$faq = $this->service_model->getFaq();

        if(!empty($faq)){

			$responseArray = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(200),'data'=>$faq);

		}else{

			$responseArray = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(114));	
		}

		$response = $this->generate_response($responseArray);
		$this->response($response,OK);

	} //End Function
	



} //end of class
