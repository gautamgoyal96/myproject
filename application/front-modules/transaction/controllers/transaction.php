<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaction extends MX_Controller {


    public function __construct() {
		parent::__construct();
        if($this->session->userdata('front_login') == FALSE ){
        	redirect(site_url().'user/logout');
        }
   
        $this->load->model('transaction_model');

    }
	
	function index() {

		$id = $this->session->userdata('id');
		$data1 = $this->transaction_model->getRentedRecord($id,'currentdata');
		$data['currentData'] = $data1['data'];
		$data['total']  = $data1['total'];
		$row =  $this->transaction_model->getRentedRecord($id,'pendingData');
		$data['pendingData'] = $row['data'];
		$this->template->build('transaction',$data);
	}

	function transactionInfo(){

		$this->load->model('products/products_model');
		$uId = $this->session->userdata('id');
		$tId = $this->uri->segment(3);
		$data = $this->transaction_model->transactionInfo($tId);;
		$viewData['transactionInfo'] = $data;
		$pId = $data->productId;
		$viewData['details'] = $this->products_model->viewProduct($pId);
		$viewData['images'] = $this->products_model->getProductImages($pId);
        $viewData['addCss'] = array("css/buttonLoader.css","css/owl.carousel.min.css","css/jquery.fancybox.css","css/flexslider.css","js/lib/css/emoji.css","css/calendar.css");
        $viewData['addJs'] = array("js/view-product.js","js/jquery.buttonLoader.js","js/wow.min.js","js/owl.carousel.js","js/element.js","js/imagezoom.js","js/jquery.fancybox.js","js/jquery.flexslider.js","js/lib/js/config.js","js/lib/js/util.js","js/lib/js/jquery.emojiarea.js","js/lib/js/emoji-picker.js","js/additional-methods.js","js/social-sharing.js");


		$this->template->build('transactionInfo',$viewData);
	}
}


/* End of file welcome.php */
/* Location: ./application/controllers/user.php */
