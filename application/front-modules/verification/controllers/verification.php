<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Verification extends MX_Controller {

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
       	$this->load->model('verification_model'); 
    }
    
	function mailverify(){
		$id= base64_decode(base64_decode($this->uri->segment(3)));
		//$msg ='Something going wrong';
		$msg = "Failed...";
		if(is_numeric($id)):
			$responce=$this->verification_model->mailverify($id);
			$msg ='Your email address has been successfully verified! Please login to access your account!';
		endif;
		$this->session->set_flashdata('success',$msg);
		redirect(base_url());
	}//ENd Function
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
