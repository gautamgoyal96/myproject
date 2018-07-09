<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AdminFee extends MX_Controller {

    public function __construct() {

    parent::__construct();
    	$this->load->model('adminfee_model');  
		$session_id = $this->session->all_userdata('email'); 

		if(!$this->session->userdata('back_login')){
			redirect('login');
		}
    }

	function index() {

		$id = 1;

		$this->load->library('form_validation');

		$this->form_validation->set_rules('percentage','Admin Fee','required|number');
		
		$data ['get']= $this->adminfee_model->admin_profile($id);

		if($this->form_validation->run() == FALSE){
			$data['error_msg'] = validation_errors();
		} else{		
			
			$userData = array(
				'percentage' => $this->input->post('percentage'),
			);
			
			$data = $this->adminfee_model->update_profile($userData,$id);
			
			if($data == true){

		
				$this->session->set_userdata($sessionData);
				$this->session->set_flashdata('success', 'Updated successfully.');
				redirect("dashboard");
			}
		} 
		$this->template->build('adminFee',$data);
	}
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
