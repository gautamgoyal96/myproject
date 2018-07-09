<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AboutUs extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library("form_validation");
        $this->load->helper('cookie');
       
    }
	public function index() {

		$data['addCss'] = array("css/owl.carousel.min.css");
        $data['addJs'] = array("js/wow.min.js","js/additional-methods.js","js/owl.carousel.js","js/element.js","js/jquery.fancybox.js");
	   $this->template->build('aboutUs',$data);
	}

	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */