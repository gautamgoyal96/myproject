<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaction extends MX_Controller {

    public function __construct() {

    parent::__construct();
    	$this->load->model('transaction_model');  
		$session_id = $this->session->all_userdata('email'); 

		if(!$this->session->userdata('back_login')){
			redirect('login');
		}
    }

	function index() {
		
		$this->template->build('all_transaction');
	}

	function alltransactionListing(){

        $this->load->library('ajax_pagination');
        
        $config = array();
        $config["base_url"] = base_url() . "transaction/alltransactionListing";
        $config["total_rows"] = $this->transaction_model->getAlltranjactionCount();
        $config["per_page"] = 10;
        $config['uri_segment'] =3;
        $config['num_links'] = 5;
        $config['first_link'] = FALSE;
        $config['last_link'] = FALSE;
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin cs-no-mr">';
        $config['full_tag_close'] = '</ul>';
        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';
        $config['anchor_class'] = 'class="paginationlink" ';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';
        $this->ajax_pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['customer'] = $this->transaction_model->getAlltranjaction($config["per_page"], $page);
    
        $data["sn"] = $page+1;
        
        $data["links"] = $this->ajax_pagination->create_links();
        $this->load->view('all_transaction_listing',$data);
    }
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
