<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends MX_Controller {

    public function __construct() {
        parent::__construct();
		if(!$this->session->userdata('back_login')){
			redirect('login');
		}
        $this->load->model('user_model');
    }

    function allOwners(){
        $this->template->build('all_owners');
    }
	
	function allOwnersListing(){

        $searchText = $this->input->post('search') ? $this->input->post('search') : '' ;        
		$this->load->library('ajax_pagination');
        
        $config = array();
        $config["base_url"] = base_url() . "user/allOwnersListing";
        $config["total_rows"] = $this->user_model->countAllOwners($searchText);
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
		$data['owner'] = $this->user_model->getAllOwners($config["per_page"], $page, $searchText);
    
		$data["sn"] = $page+1;
        
        $data["links"] = $this->ajax_pagination->create_links();
		$this->load->view('all_owners_listing',$data);
	}

    function activeOwners(){

        $id = $this->uri->segment(3);
        $data = $this->user_model->activeUsers(array('id'=>$id));
        if($data == true){
            $this->session->set_flashdata('success', 'Status updated successfully.');
            redirect('user/allOwners');
        }
    }

    function deleteOwners(){

        $id = $this->uri->segment(3);
        $data = $this->user_model->deleteUsers($id);
        if($data == true){
            $this->session->set_flashdata('success', 'Owner deleted successfully.');
            redirect('user/allOwners');
        }
    }

    function allCustomers(){
        $this->template->build('all_customers');
    }
    
    function allCustomersListing(){

        $searchText = $this->input->post('search') ? $this->input->post('search') : '' ;        
        $this->load->library('ajax_pagination');
        
        $config = array();
        $config["base_url"] = base_url() . "user/allCustomersListing";
        $config["total_rows"] = $this->user_model->countAllCustomers($searchText);
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
        $data['customer'] = $this->user_model->getAllCustomers($config["per_page"], $page, $searchText);
    
        $data["sn"] = $page+1;
        
        $data["links"] = $this->ajax_pagination->create_links();
        $this->load->view('all_customers_listing',$data);
    }

    function activeCustomers(){

        $id = $this->uri->segment(3);
        $data = $this->user_model->activeUsers(array('id'=>$id));
        if($data == true){
            $this->session->set_flashdata('success', 'Status updated successfully.');
            redirect('user/allCustomers');
        }
    }

    function deleteCustomers(){

        $id = $this->uri->segment(3);
        $data = $this->user_model->deleteUsers($id);
        if($data == true){
            $this->session->set_flashdata('success', 'Customer deleted successfully.');
            redirect('user/allCustomers');
        }
    }

    function addCategory(){

        $this->load->library('form_validation');

        $this->form_validation->set_rules('categoryName','Category name','required');

        //$this->form_validation->set_rules('brandId','Brand name','required');
        $data['brandName'] = $this->user_model->allBrandName();

        if($this->form_validation->run() == FALSE){
            $data['error'] = validation_errors();

        } else {

            $brandId = '';
              //  if(is_array($this->input->post('brandId')) && !empty($this->input->post('brandId')))
                //    $brandId = implode(",",$this->input->post('brandId'));
            $userData = array(
                'categoryName'  => $this->input->post('categoryName'),
                'brandId' => $brandId
            );
            $result = $this->user_model->addCategory($userData); 

            if($result == true){
                $this->session->set_flashdata('success', 'Category added successfully!!');
                redirect('user/allCategory');
            } else {
                $data['error'] = 'Record already exist.';
            }
        }
        $this->template->build('add_category',$data);   
    }


    function updateCategory(){
        $this->load->library('form_validation');

        $id = $this->uri->segment(3);
       $this->form_validation->set_rules('categoryName','Category Name','required');
     

        if($this->form_validation->run() == FALSE){
            $data['error'] = validation_errors();
            //$this->form_validation->set_rules('brandId','Brand name','required');
            $data['category'] = $this->user_model->showCategoryRecord($id);
           // $data['brandName'] = $this->user_model->allProBrandName($id);
            //$data['brand'] = $this->user_model->allBrandName($id);
           // $data['proBrand'] = $this->user_model->catOfBrandData($id);

           
        } else {
            
            $id = $this->uri->segment(3);
            $date = date('Y-m-d H:i:s');

            $brandId = '';
			//if(is_array($this->input->post('brandId')) && !empty($this->input->post('brandId')))
			//	$brandId = implode(",",$this->input->post('brandId'));
        
            $userData = array();

            $userData['categoryName'] = $this->input->post('categoryName');
            $userData['brandId'] = $brandId;//!empty($brandId) ? $brandId : '1';
            $userData['upd'] = $date;
            $result = $this->user_model->updateCategory($userData,$id);

            if($result == true){
                $this->session->set_flashdata('success', 'Record updated successfully.');
                redirect('user/allCategory');
            } else {
                $data['error'] = 'Record already exist.';
            }           
        }
        $this->template->build('update_category',$data);      
    }

    function allCategory(){
        $this->template->build('all_category');
    }
    
    function allCategoryListing(){

        $searchText = $this->input->post('search') ? $this->input->post('search') : '' ;        
        $this->load->library('ajax_pagination');
        
        $config = array();
        $config["base_url"] = base_url() . "user/allCategoryListing";
        $config["total_rows"] = $this->user_model->countAllCategory($searchText);
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
        $data['category'] = $this->user_model->getAllCategory($config["per_page"], $page, $searchText);
    
        $data["sn"] = $page+1;
        
        $data["links"] = $this->ajax_pagination->create_links();
        $this->load->view('all_category_listing',$data);
    }

    function activeCategory(){

        $id = $this->uri->segment(3);
        $data = $this->user_model->activeCategory(array('id'=>$id));
        if($data == 1){
            $this->session->set_flashdata('success', 'Status activated successfully.');
            redirect('user/allCategory');
        }elseif($data == 0){
            $this->session->set_flashdata('success', 'Status inactive successfully.');
            redirect('user/allCategory');
        }else{
            $this->session->set_flashdata('error', 'Something went wrong.');
            redirect('user/allCategory');
        }
    }

    function deleteCategory(){

        $id = $this->uri->segment(3);
        $data = $this->user_model->deleteCategory($id);
        if($data == true){
            $this->session->set_flashdata('success', 'Record deleted successfully.');
            redirect('user/allCategory');
        }else{
            $this->session->set_flashdata('error', "You can't delete this category,because product already added on this category.");
            redirect('user/allCategory');
        }
    }

    function addBrand(){

        $this->load->library('form_validation');

        $this->form_validation->set_rules('brandName','Brand name','required');

        if($this->form_validation->run() == FALSE){
            $data['error'] = validation_errors();

        } else {

            $date = date('Y-m-d H:i:s');

            $userData = array(
                'brandName'  => $this->input->post('brandName'),
                'crd' => $date,
                'upd' => $date
            );
            $result = $this->user_model->addBrand($userData); 

            if($result == true){
                $this->session->set_flashdata('success', 'Brand added successfully!!');
                redirect('user/allBrand');
            } else {
                $data['error'] = 'Record already exist.';
            }
        }
        $this->template->build('add_brand',$data);   
    }


    function updateBrand(){
        $this->load->library('form_validation');

        $id = $this->uri->segment(3);
        $data['brand'] = $this->user_model->showBrandRecord($id);
        $this->form_validation->set_rules('brandName','Category Name','required');

        if($this->form_validation->run() == FALSE){
            $data['error'] = validation_errors();
        } else {
            
            $id = $this->uri->segment(3);
            $date = date('Y-m-d H:i:s');
        
            $userData = array();

            $userData['brandName'] = $this->input->post('brandName');
            $userData['upd'] = $date;

            $result = $this->user_model->updateBrand($userData,$id);

            if($result == true){
                $this->session->set_flashdata('success', 'Record updated successfully.');
                redirect('user/allBrand');
            } else {
                $data['error'] = 'Record already exist.';
            }           
        }
        $this->template->build('update_brand',$data);  
    }

    function allBrand(){
        $this->template->build('all_brand');
    }
    
    function allBrandListing(){

        $searchText = $this->input->post('search') ? $this->input->post('search') : '' ;        
        $this->load->library('ajax_pagination');
        
        $config = array();
        $config["base_url"] = base_url() . "user/allBrandListing";
        $config["total_rows"] = $this->user_model->countAllBrand($searchText);
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
        $data['brand'] = $this->user_model->getAllBrand($config["per_page"], $page, $searchText);
        $data["sn"] = $page+1;
        
        $data["links"] = $this->ajax_pagination->create_links();
        $this->load->view('all_brand_listing',$data);
    }

    function activeBrand(){

        $id = $this->uri->segment(3);
        $data = $this->user_model->activeBrand(array('id'=>$id));
        if($data == 1){
            $this->session->set_flashdata('success', 'Status activated successfully.');
            redirect('user/allBrand');
        }elseif($data == 0){
            $this->session->set_flashdata('success', 'Status inactive successfully.');
            redirect('user/allBrand');
        }else{
            $this->session->set_flashdata('error', 'Something went wrong.');
            redirect('user/allBrand');
        }
    }

    function deleteBrand(){

        $id = $this->uri->segment(3);
        $data = $this->user_model->deleteBrand($id);
        if($data == true){
            $this->session->set_flashdata('success', 'Record deleted successfully.');
            redirect('user/allBrand');
        }else{
            $this->session->set_flashdata('error', "You can't delete this brand,because product already added on this brand");
            redirect('user/allBrand');
        }
    }

    function allProduct(){
       // $data['brand'] = $this->user_model->allBrandName();
        $data['category'] = $this->user_model->allCategoryName();
        $this->template->build('all_product',$data);
    }
    
    function allProductListing(){

        $bId = $this->input->post('bId'); 
        $userId = !empty($this->input->post('userId')) ? $this->input->post('userId') : "";        
        $cId = $this->input->post('cId');
        $price = $this->input->post('price');
        $searchType = $this->input->post('isRented');

        $where = '';
        if($searchType=="Booked"){
            $where = 1;
        }

        if($searchType=="Free"){
            $where =  2;
        }

        $start = $this->input->post('start');
        $fromDate = '';
        if(!empty($start))
            $fromDate = date("Y-m-d",strtotime($start));

        $end = $this->input->post('end');
        $toDate = '';
        if(!empty($end))
            $toDate = date("Y-m-d",strtotime($end));

        
        $searchText = $this->input->post('search') ? $this->input->post('search') : '';        
        $this->load->library('ajax_pagination');
        
        $config = array();
        $config["base_url"] = base_url() . "user/allProductListing";
        $config["total_rows"] = $this->user_model->countAllProduct($searchText,$bId,$cId,$where,$price,$fromDate,$toDate,$userId);
        $config["per_page"] = 12;
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
        $data['product'] = $this->user_model->getAllProduct($config["per_page"], $page, $searchText,$bId,$cId,$where,$price,$fromDate,$toDate,$userId);
    
        $data["sn"] = $page+1;
        
        $data["links"] = $this->ajax_pagination->create_links();
        $data["userId"] = $userId;
        $this->load->view('all_product_listing',$data);
    }

    function activeProduct(){

        $id = $this->uri->segment(3);
        $userId = $this->uri->segment(4);
        $data = $this->user_model->activeProduct(array('id'=>$id));
        if($data == true){
            $this->session->set_flashdata('success', 'Status updated successfully.');
            redirect('user/allProduct/'.$userId);
        }
    }

    function deleteProduct(){

        $id = $this->uri->segment(3);
        $userId = $this->uri->segment(4);
        $data = $this->user_model->deleteProduct($id);
        if($data == true){
            $this->session->set_flashdata('success', 'Product deleted successfully.');
            redirect('user/allProduct/'.$userId);
        }
    }

    function productDetail(){
        $id = $this->uri->segment(3); 
        $data['userId'] = $this->uri->segment(4);  
        $data['pImages'] = $this->user_model->getProductImg($id);      
        $data['productDetail'] = $this->user_model->productDetail($id);   
        $data['request'] = $this->user_model->getNewRequestList($id);   
        $data['renter'] = $this->user_model->productRenter($id);       
        $this->template->build('product_detail',$data);
    }

} //end of class

/* End of file user.php */
/* Location: ./application/controllers/user.php */
