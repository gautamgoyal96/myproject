<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class payment extends MX_Controller {


    public function __construct() {
		parent::__construct();
        if($this->session->userdata('front_login') == FALSE ){
        	redirect(site_url().'user/logout');
        }
   
        $this->load->model('payment_model');
        $this->load->model('user/user_model');
    }
	
	function index() {

		$data['addCss'] = array("css/calendar.css","css/payment.css","css/buttonLoader.css");
        $data['addJs'] = array("js/easyResponsiveTabs.js","js/jquery.buttonLoader.js","js/payment.js");
        $id = $this->session->userdata('id');
        $data['city'] = $this->payment_model->cityList();
		$this->template->build('payment',$data);
	}

    function addBankAccount() {

        $data['addCss'] = array("css/calendar.css","css/payment.css","css/buttonLoader.css");
        $data['addJs'] = array("js/easyResponsiveTabs.js","js/jquery.buttonLoader.js","js/payment.js");
        $id = $this->session->userdata('id');
        $id = $this->uri->segment(3);
        $data['ownerDetail'] = $this->user_model->profile($id);
        $data['city'] = $this->payment_model->cityList();
        $this->template->build('addBankAccount',$data);
    }

}


/* End of file welcome.php */
/* Location: ./application/controllers/user.php */
