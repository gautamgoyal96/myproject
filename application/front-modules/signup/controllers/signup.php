<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signup extends MX_Controller {

    function __construct() {

        parent::__construct();
        $this->load->library("form_validation");
        $this->load->helper('cookie');
        $this->load->model('home/home_model');
        $this->load->library('Smtp_email');         
        if($this->session->userdata('front_login') == TRUE ){
        	redirect(site_url().'user/');
        }

    }
    
	function index() {

		$data['addCss'] = array("css/form_wizard.css","css/buttonLoader.css");
        $data['addJs'] = array("js/additional-methods.js","js/owl.carousel.js","js/wow.min.js","js/jquery.fancybox.js","js/modernizr.js","js/classie.js","js/jquery.flexslider.js","js/imagezoom.js","js/velocity.min.js","js/element.js","js/jquery.buttonLoader.js");	
	    $this->template->build('signup',$data);
	}

	function login() {

		$data['addJs'] = array("js/facebook-login.js");	
	    $this->template->build('login',$data);
	}

	function sendSms(){

		$this->load->library('twilio');
        $from   = '+7154084595';
        $to     = "+919993797470";
        $message = '123';
        $response = $this->twilio->sms($from, $to, $message);
        print_r($response);
        die();
	}

	function register(){

		$data = array(
			'firstName'	=>	$this->input->post('fName'),
			'lastName'	=>	$this->input->post('lName'),
			'email'	=>	$this->input->post('email'),
			'socialId' => $this->input->post('socialId'),
			'profileImage'	=>	$this->input->post('image'),
			'socialType' => $this->input->post('socialType')
			);
	
		$isAdded = $this->home_model->Register($data);
		
		echo json_encode($isAdded);
	
	}//End Function	

	function phoneVerification(){

		$data = array(
			'contactNo'	=>	$this->input->post('phone'),
			'userId'	=>	$this->input->post('userId') ? $this->input->post('userId') : '',
			'countryCode' => "+91",
			'OTP' => (rand(10, 99)).(rand(11, 99))
		);
	
		$isAdded = $this->home_model->verifyNo($data);
		
		echo json_encode($isAdded);
	
	}//End Function	

	function signupSecondStep(){

		$this->load->library('encrypt');
		$profileImage = '';
		if(!empty($_FILES['profileImage']['name'])){

			$folder = 'profile';
			$this->load->model('home/image_model');
			$profileImage = $this->image_model->upload_img('profileImage',$folder);
		}else{

			$profileImage = $this->input->post('image2');
		}
		$data = array(
			'socialId'	=>	$this->input->post('socialId2') ? $this->input->post('socialId2') : '',
			'socialType'	=>	$this->input->post('socialType2') ? $this->input->post('socialType2') : '',
			'firstName' => $this->input->post('fName'),
			'lastName' => $this->input->post('lName'),
			'email' => $this->input->post('email'),
			'password' => $this->encrypt->encode($this->input->post('password')),
			'contactNo' => $this->input->post('phone2'),
			'zipCode'	=>	$this->input->post('zipCode'),
			'countryCode' => "+91",
			'otpVerified' => '1',
			'status' => '1',
			'OTP' => 'checked',
			'deviceType' => '3',
			'profileImage' => $profileImage,
			'address'	=>	$this->input->post('zipCode')
			);

		$isAdded = $this->home_model->signupSecondStep($data,$this->input->post('userId'));
		if($isAdded==true){
			redirect('user');
		}else{

			redirect(base_url());
		}
	}//End Function	

	function loginSecond(){

		$data_val = array();

		$data_val['email'] 			=  $this->input->post('email');

		$data_val['password'] 		=  $this->input->post('password');

		$this->session->unset_userdata('memberEmail');
		$this->session->unset_userdata('memberPassword');
		$responce = $this->home_model->login($data_val);

		if($responce=="true"):

			if($this->input->post('remember')==1){

				$rememberMe =array('memberEmail'=>$data_val['email'],'memberPassword'=>$data_val['password']);		
				$this->session->set_userdata($rememberMe);
			}
		$my = array('type' => '1',"userType" => $this->session->userdata('userType'));

		echo json_encode($my);

		elseif($responce=="IA"):

		echo 2;

		else:

		echo 0;

		endif;
	
	}//end function 

	function emailCheck(){

		$data_val = array();

		$data_val['email'] 			=  $this->input->post('email');
		
		$responce = $this->home_model->emailCheck($data_val);

		if($responce==true):

			echo 1;

		else:

		echo 0;

		endif;
	
	}//end function  
	
	function forgotPassword(){

		$this->load->library('form_validation');
		$this->form_validation->set_rules('email','Email','required|valid_email');

		if($this->form_validation->run() == FALSE){
			$data = array('status'=>0,'error'=>validation_errors());
			echo json_encode($data);
		}else{
			$this->load->library('encrypt');
			$email = $this->home_model->forgotPassword($this->input->post('email'));
			
			if($email){

				if($email==1){

					$data=array('status'=>1);
                	echo json_encode($data);
                	die();

				}else if($email==2){

					$data=array('status'=>0,'error'=>"Not able to send a password in your entered email address");
					echo json_encode($data); 
					die(); 
				}

				
			} else {
				$data=array('status'=>0,'error'=>"emailId is not exist");
				echo json_encode($data);  
			}	
		}
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
