<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Faq extends MX_Controller {

    public function __construct() {

    parent::__construct();
    	$this->load->model('faq_model');  
		$session_id = $this->session->all_userdata('email'); 

		if(!$this->session->userdata('back_login')){
			redirect('login');
		}
    }

	 function index(){

        $this->load->library('form_validation');

        $this->form_validation->set_rules('question','Question','required');
         $this->form_validation->set_rules('answer','Answer','required');

        if($this->form_validation->run() == FALSE){
            $data['error'] = validation_errors();

        } else {

            $userData = array(
                'question'  => $this->input->post('question'),
                'answer'  => $this->input->post('answer')
            );
            $result = $this->faq_model->addFaq($userData); 

            if($result == true){
                $this->session->set_flashdata('success', 'Faq added successfully!!');
                redirect('faq/allFaq');
            } else {
                $data['error'] = 'Record already exist.';
            }
        }
        $this->template->build('add_faq',$data);   
    }


    function updateFaq(){
        $this->load->library('form_validation');

        $id = $this->uri->segment(3);
        $this->form_validation->set_rules('question','Question','required');
        $this->form_validation->set_rules('answer','Answer','required');
     

        if($this->form_validation->run() == FALSE){
            $data['error'] = validation_errors();
            $data['faq'] = $this->faq_model->showFaqRecord($id);

           
        } else {
            
            $id = $this->uri->segment(3);

			$userData = array();

            $userData['question'] = $this->input->post('question');
         	$userData['answer'] = $this->input->post('answer');
            $result = $this->faq_model->updateFaq($userData,$id);

            if($result == true){
                $this->session->set_flashdata('success', 'Record updated successfully.');
                redirect('faq/allFaq');
            } else {
                $data['error'] = 'Record already exist.';
            }           
        }
        $this->template->build('update_faq',$data);      
    }

    function allFaq(){

        $this->template->build('all_faq');

    }
    
    function allfaqListing(){

        $this->load->library('ajax_pagination');
        
        $config = array();
        $config["base_url"] = base_url() . "faq/allfaqListing";
        $config["total_rows"] = $this->faq_model->countAllFaq();
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
        $data['category'] = $this->faq_model->getAllFaq($config["per_page"], $page);
    
        $data["sn"] = $page+1;
        
        $data["links"] = $this->ajax_pagination->create_links();
        $this->load->view('all_faq_listing',$data);
    }

    function activeFaq(){

        $id = $this->uri->segment(3);
        $data = $this->faq_model->activeFaq(array('id'=>$id));
        if($data == 1){
            $this->session->set_flashdata('success', 'Status activated successfully.');
            redirect('faq/allFaq');
        }elseif($data == 0){
            $this->session->set_flashdata('success', 'Status inactive successfully.');
            redirect('faq/allFaq');
        }else{
            $this->session->set_flashdata('error', 'Something went wrong.');
            redirect('faq/allFaq');
        }
    }

    function deleteFaq(){

        $id = $this->uri->segment(3);
        $data = $this->faq_model->deleteFaq($id);
        if($data == true){
            $this->session->set_flashdata('success', 'Record deleted successfully.');
            redirect('faq/allFaq');
        }else{
            $this->session->set_flashdata('error', "Something went wrong.");
            redirect('faq/allFaq');
        }
    }

}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */
