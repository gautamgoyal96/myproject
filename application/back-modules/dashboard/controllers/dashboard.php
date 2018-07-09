<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MX_Controller {

    public function __construct() {

    parent::__construct();
    	$this->load->model('dashboard/admin_model');  
		$session_id = $this->session->all_userdata('email'); 
		$this->load->model('common_model');		

		if(!$this->session->userdata('back_login')){
			redirect('login');
		}
    }

	function index() {   
		$data['ownersCount'] = $this->admin_model->countOwners();
		$data['customersCount'] = $this->admin_model->countCustomers();
		$data['categoryCount'] = $this->admin_model->countCategory();
		$data['productCount'] = $this->admin_model->countProduct();
		$this->template->build('dashboard',$data);  
	}

	function adminProfile(){

		$id = $this->uri->segment(3);

		$this->load->library('form_validation');

		$this->form_validation->set_rules('email','email','required|valid_email');
		
		$data ['get']= $this->admin_model->admin_profile($id);

		if($this->form_validation->run() == FALSE){
			$data['error_msg'] = validation_errors();
		} else{		
			
			$userData = array(
				'email' => $this->input->post('email'),
			);
			
			$data = $this->admin_model->update_profile($userData,$id);
			
			if($data == true){

				$sessionData = array(
					'email'=> $this->input->post('email'),
					'id' => $id
				);
		
				$this->session->set_userdata($sessionData);
				$this->session->set_flashdata('success', 'Updated successfully.');
				redirect("dashboard");
			}
		} 
		$this->template->build('admin_profile',$data);  
	}

	function changePassword(){
		$id = $this->uri->segment(3);

		$this->load->library('form_validation');

		$this->form_validation->set_rules('newpassword', 'Password', 'required|matches[confirmpassword]|min_length[6]');
		$this->form_validation->set_rules('confirmpassword', 'Password Confirmation', 'required|min_length[6]');
		$this->form_validation->set_rules('oldpassword','Old password', 'required');
		$data ['get']= $this->admin_model->admin_profile($id);

		if($this->form_validation->run() == FALSE){
			
			$data['error_msg'] = validation_errors();
		} else{	
			
			$existPass = $this->common_model->get_records_by_id('admin',true,array('password'=>md5($this->input->post('oldpassword'))),"*","","");
			
						
			if(empty($existPass)){
				
				$this->session->set_flashdata('success', 'You are not a valid User.');
				redirect("dashboard/changePassword");
			}				
			
			$userData = array(
				'password'=>md5($this->input->post('newpassword'))
			);
			
			$data = $this->admin_model->update_profile($userData,$id);
			
			if(!empty($data)){
				$this->session->set_flashdata('success', 'Updated successfully.');
				redirect("dashboard");
			}
		} 
		$this->template->build('change_password',$data);  
	}

	function logout(){

		$this->session->sess_destroy();
		redirect(base_url('index.php/login'));
	}
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
