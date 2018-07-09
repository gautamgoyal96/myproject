<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends MX_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
         * 
	 */
    public function __construct() {
		parent::__construct();
		if($this->uri->segment(2) == 'myProfile'){
            if($this->session->userdata('front_login') == FALSE ){
            	redirect(site_url().'user/logout');
            }
        }
        $this->load->model('user_model');

    }
	
	public function authTokenCheck(){

		$data = $this->user_model->_authTokenCheck();
		if($data==TRUE){

			echo "1";

		}else{

			echo "0";
		}
	}

	public function index() {

		$this->load->model('home/home_model');
	    $data['category'] = $this->home_model->getAllCategory();
	    $data['products'] = $this->home_model->getAllProducts();


	    $this->session->set_userdata('categoryId','');
	    $this->session->set_userdata('latitude','');
		$this->session->set_userdata('longitude', '');

	    $ip = $_SERVER['REMOTE_ADDR'];

		$city_name = $this->home_model->getCityNameByIpAddress($ip);

		if(!empty($city_name['city'])){
			$data['city_name'] = $city_name['city'];
		}else{
			$data['city_name'] = "";
		}
		$data['addCss'] = array("css/owl.carousel.min.css");
        $data['addJs'] = array("js/wow.min.js","js/additional-methods.js","js/owl.carousel.js","js/element.js","js/jquery.fancybox.js");		    
		$this->template->build('home/home',$data);
	}
	
	function profile(){
		$id = $this->uri->segment(3);
		$data['ownerDetail'] = $this->user_model->profile($id);
		$data['reviews'] = $this->user_model->getReviews($id);
		$data['rentedData'] = $this->user_model->getRentedRecord($id,'rented');
		$data['rentalsData'] = $this->user_model->getRentedRecord($id,'rentals');
		$data['addCss'] = array("css/chat.css","js/lib/css/emoji.css","css/calendar.css");
		$this->template->build('profile',$data);
	}

	function profilegetByChatId(){
		
		$id = $this->input->post('chatId');
		$data = $this->user_model->profilegetByChatId($id);
		echo json_encode($data);
	}

	function myProfile(){
		$id = $this->session->userdata('id');
		$data['ownerDetail'] = $this->user_model->profile($id);
		$data['reviews'] = $this->user_model->getReviews($id);
		$data['rentedData'] = $this->user_model->getRentedRecord($id,'rented');
		$data['rentalsData'] = $this->user_model->getRentedRecord($id,'rentals');
		$data['userType'] = $this->user_model->getUserType($id);
		$data['adminFee'] = $this->user_model->adminFees();
		$data['addCss'] = array("css/chat.css","js/lib/css/emoji.css","css/calendar.css");	
		$this->template->build('profile',$data);
	}

	function updateProfile(){

		$userData = array();

		$userData['firstName'] = $this->input->post('firstName');

		$userData['lastName'] = $this->input->post('lastName');

		$userData['address'] = $this->input->post('address');
		$userData['zipCode'] = $this->input->post('address');

		$userData['about'] = $this->input->post('about');

		$data = $this->user_model->latandLong(str_replace(' ','+',$this->input->post('address')));
		$userData['latitude']  = $data['lat'];

		$userData['longitude'] = $data['long'];

		
		$profileImage = '';
		$folder = 'profile';
		if(!empty($_FILES['profileImage']) && is_array($_FILES['profileImage'])){
			
			$profileImage = $this->user_model->upload_img('profileImage',$folder);

			if(is_array($profileImage)){
				$data['error'] = $profileImage['error'];

			}
		}

		if(!empty($profileImage) && is_string($profileImage)){
			$userData['profileImage'] = $profileImage;
		}
		
		$updateData = $this->user_model->proofileUpdate($userData);

		if(!empty($updateData)){

			redirect('user/myProfile');
		}
	}

	function passwordChange(){

		$userData = array();
		$this->load->library('encrypt');
		$userData['password'] = $this->encrypt->encode($this->input->post('password'));

		
		$updateData = $this->user_model->proofileUpdate($userData);

		if(!empty($updateData)){

			redirect('user/logout');
		}
	}



	function editProfile(){
		
		$this->load->library('encrypt');
		$id = $this->session->userdata('id');
		$data['ownerDetail'] = $this->user_model->profile($id);
		$data['addJs'] = array("js/edit-profile.js");
		$this->template->build('edit-profile',$data);
	}

	function updateuserType(){
		$type= !empty($_GET['pId']) ? $_GET['pId'] :"";
		$id = $this->session->userdata('id');
		$result = $this->user_model->updateuserType($id);
		if(!empty($type)){
			redirect('products/viewProduct/'.$type);
		}
		redirect('user/myProfile');
	}

	function logout(){
		//$this->session->sess_destroy();
		$this->session->unset_userdata('front_login');
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('userType');
		$this->session->unset_userdata('status');
		$this->session->unset_userdata('id');
		$this->session->unset_userdata('authToken');
		$this->session->unset_userdata('pId');
        $this->session->unset_userdata('slot');
        $this->session->unset_userdata('requestDate');
        $this->session->unset_userdata('calType');
        $this->session->unset_userdata('slot');
		redirect('signup/login');

	} //End Function

	function notifcationCheck(){

		echo $data = $this->user_model->notifcationCheck();
	}

	function chatIdUpdate(){

		$chatId = $this->input->post('chatId');
		$this->user_model->chatIdUpdate(array('firebaseId' => $chatId,'firebaseToken' => ""));
	}

}


/* End of file welcome.php */
/* Location: ./application/controllers/user.php */
