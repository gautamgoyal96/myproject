<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Help extends MX_Controller {

    public function __construct() {

    parent::__construct();
    	$this->load->model('help/help_model');  
    	$this->load->model('notification_model');  
		$session_id = $this->session->all_userdata('email'); 
		
		if(!$this->session->userdata('back_login')){
			redirect('login');
		}
		$this->load->library('ajax_pagination');
    }//End Function

    function index(){

		$this->template->build('userlist'); 

	}//End Function
    
    function addProspect(){
    	$data['category']= $this->prospect_model->category();
    	$this->load->library('form_validation');
		$this->form_validation->set_rules('fullName','full Name','trim|required');
		$this->form_validation->set_rules('email','E-mail','trim|required|is_unique[users.email]');
		$this->form_validation->set_rules('password','Password','trim|required|min_length[6]');
		$this->form_validation->set_rules('categoryId','Category Id','trim|required');
		$this->form_validation->set_message('is_unique', 'The %s is already registered.');
		$this->form_validation->set_error_delimiters('<div class="err_msg"  style="color:red">', '</div>');
		if($this->form_validation->run() == FALSE){
			$data['error'] = strip_tags(validation_errors());
			
		}else{
			
			$profileImage = array();
			if(isset($_FILES['profileImage']['name']) && !empty($_FILES['profileImage']['name'])){
				$folder = 'userImage';
				$profileImage = $this->prospect_model->uploadImage('profileImage',$folder);
			}
			
			$this->load->library('encrypt');
			$password = $this->input->post('password');
			$userData = array(
				'email'        => $this->input->post('email'),
				'userName'     => $this->input->post('fullName'),
				'fullName'     => $this->input->post('fullName'),
				'profileImage' => (is_array($profileImage)) ? '' : $profileImage,
				'password'     => $this->encrypt->encode($password),
				'categoryId'   => $this->input->post('categoryId'),
			);
			
			$result = $this->prospect_model->signUp($userData);
			if($result == true){
				  $this->session->set_flashdata('success', 'Add Prospect successfully..!');
				redirect('prospect/addProspect'); 
			}else{
				$data['error'] = 'Something going wrong..!';
			}
		}
		$this->template->build('addProspect',$data); 
		
	}//End Function

	
	function qualifiedProspects(){
		$data['users']= $this->prospect_model->getUser();
		$data['category']= $this->prospect_model->category();
		$this->template->build('getProspect',$data); 
		//~ echo "getClient";
	}//End Function
	
	function unqualifiedProspects(){
		$data['users']= $this->prospect_model->getUser();
		$data['category']= $this->prospect_model->category();
		$this->template->build('getProspect',$data); 
		//~ echo "getClient";
	}//End Function
	
	function getUserList(){
		$ser 	= trim($this->input->post('search'));
		$type 	= trim($this->input->post('type'));
		$search = !empty($ser) ? $ser : '';
		$where = '';
		if($type):
		$where = array('questionStatus' => $type);
		endif;
		$this->load->library('ajax_pagination');
		$config['base_url'] 		= base_url().'help/getUserList';
		$config['total_rows'] 		= $this->help_model->countHelpUser();
		$config['uri_segment'] 		= '3';
		$config['per_page'] 		= '10';
		$config['num_links'] 		= '3';
		$config['first_link'] 		= FALSE;
		$config['last_link'] 		= FALSE;
		$config['full_tag_open'] 	= '<ul class="pagination pagination-sm no-margin">';
		$config['full_tag_close'] 	= '</ul>';
		$config['next_link'] 		= '&raquo;';
		$config['next_tag_open'] 	= '<li class="next page">';
		$config['next_tag_close'] 	= '</li>';
		$config['anchor_class'] 	= 'class="paginationlink" ';
		$config['prev_link'] 		= '&laquo;';
		$config['prev_tag_open'] 	= '<li class="prev page">';
		$config['prev_tag_close'] 	= '</li>';
		$config['cur_tag_open'] 	= '<li class="active"><a>';
		$config['cur_tag_close'] 	= '</a></li>';
		$config['num_tag_open'] 	= '<li class="page">';
		$config['num_tag_close'] 	= '</li>';
		$page 	= $this->uri->segment(3);
		$limit 	= $config['per_page'];
		$start 	= $page > 0 ? $page : 0;
		$this->ajax_pagination->initialize($config);
		$result['users'] 			= $this->help_model->getHelpUserList($limit,$start);
		$result['links'] 			= $this->ajax_pagination->create_links();
		$result['startFrom'] 		= $start + 1;
		$this->load->view('all_user_list',$result);
	}//End Function
	function helpList(){
		$userId = $this->uri->segment(3);

		if(!is_numeric($userId)):
			redirect('helpList');
		endif;
		$result['userDetail'] = $this->help_model->getHelpUserDetail($userId);

		$this->template->build('helpList',$result);
	}//End Function
	
	function send(){
		$message = $this->input->post('message');
		$userId  = $this->input->post('userId');
		$data['message'] = $message;
		$data['senderId'] = 1;
		$data['receiverId'] = $userId;
		echo $this->help_model->message($data);
	}//ENd FUnction
	function messagelist(){
		$userId  = $this->input->get('userId');
		$fullName  = $this->input->get('fullName');
		$orderM  = $this->input->get('orderM');
		$data['chat'] = $this->help_model->getMessage($userId,$orderM);
		$data['fullName'] = $fullName;
		$this->load->view('messagelist',$data);
	}//ENd FUnction
	
	
	function ios(){
		$deviceToken =array('a5107b01c7cb26b1b44fc302e4b95fe073a2493ccade5b774be094c4bdbc90b9');
		$msg['message']="hiii";
		$msg['title']="Imarke";
		$r=$this->notification_model->send_ios($deviceToken,$msg['title'],$msg);
		print_r($r);
	}
	
}//End CLass
