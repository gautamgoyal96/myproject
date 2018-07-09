<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat extends MX_Controller {

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
		
            if($this->session->userdata('front_login') == FALSE ){
            	redirect(site_url().'user/logout');
            }
   
        $this->load->model('chat_model');

    }
	

	public function index() {

		$this->load->model('products/products_model');  
		$senderId = $this->session->userdata('id');
		$pId = $this->uri->segment('4');
		if(empty($pId)){

			redirect(site_url().'user/logout');
		}

		$reciverId = $this->uri->segment('3');
		if(empty($reciverId)){

			redirect(site_url().'user/logout');
		}
		$data['details'] = $this->products_model->viewProduct($pId);
		$data['reciverDetail'] = $this->chat_model->profile($reciverId);
		$data['senderDetail'] = $this->chat_model->profile($senderId);	
		$data['images'] = $this->products_model->getProductImages($pId);  
		$data['addCss'] = array("css/chat.css","js/lib/css/emoji.css");
		$data['addJs'] = array("js/lib/js/config.js","js/lib/js/util.js","js/lib/js/jquery.emojiarea.js","js/lib/js/emoji-picker.js");		    
		$this->template->build('chat/chat',$data);
	}

}


/* End of file welcome.php */
/* Location: ./application/controllers/user.php */
