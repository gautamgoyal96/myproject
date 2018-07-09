<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MX_Controller {

    public function __construct() {

        parent::__construct();

        $this->load->model('login/login_model');

        if($this->session->userdata('back_login')){
       		redirect(site_url()."dashboard");
    	}
        
    }
	public function index()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('email','Email','required|valid_email');
		$this->form_validation->set_rules('password','Password','required');

		if($this->form_validation->run() == FALSE){
			$data['error'] = validation_errors();
			$this->load->view('login/login',$data);
		} else{
			$this->load->library('encrypt');
			$userData = array(
				'email' => $this->input->post('email'),
				'password' => md5($this->input->post('password'))
				);
			
			$data = $this->login_model->login($userData);
			
			if(!empty($data)){
				/*remember me*/
             	$remember = $this->input->post('rem');
				if($remember == 1) {	// if user check the remember me checkbox		
			   		setcookie('email', $userData['email'], time()+60*60*24*100, "/");
			   		setcookie('password', $this->input->post('password'), time()+60*60*24*100, "/");
				}
				else {   // if user not check the remember me checkbox
			   		setcookie('email', ' ', time()-60*60*24*100, "/");
			   		setcookie('password', ' ', time()-60*60*24*100, "/");			
				}
				redirect(site_url().'dashboard');
			} else{
				$data['error'] = "Invalid email or password.";
				$this->load->view('login/login',$data);
			}
		}       
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
