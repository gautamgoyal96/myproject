<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends MX_Controller {
	

    function __construct() {
        parent::__construct();
        if($this->uri->segment(2) == 'myProduct' || $this->uri->segment(2) == 'addProduct'){
            if($this->session->userdata('front_login') == FALSE ){
                redirect(site_url().'user/logout');
            }
        }
        $this->load->model('products_model');   
        require APPPATH . '/libraries/REST_Controller.php';     
    }

 	function category(){

        $data['category'] = $this->products_model->getAllCategory();
        $viewData['addJs'] = array("js/search-product.js");
		$this->template->build('category',$data);
	}

	function searchProduct(){
		$searchData = array(
			'address' => $this->input->post('address'),
			'categoryId' => $this->input->post('categoryId')
		);

		$searchData['category'] = $this->products_model->getAllCategory();
        $searchData['addCss'] = array("css/calendar.css","css/flexslider.css");
        $searchData['addJs'] = array("js/wow.min.js","js/owl.carousel.js","js/jquery.flexslider.js","js/element.js","js/jquery.fancybox.js");
		$this->template->build('searchResult',$searchData);
	}
	
	function allProductListing(){

        $this->load->library('ajax_pagination');

        $params = array('address','categoryId','radioValue','prcMin','prcMax','distMin','distMax','checkedCat','checkedBrand','title');

        foreach ($params as $value) {
            $searchArray[$value] = $this->input->post($value);
        }

        $checkedBrand = $searchArray['checkedBrand'];
        $this->session->set_userdata('brandsId',$checkedBrand);

        $config = array();
        $config["base_url"] = base_url() . "products/allProductListing";
        $config["total_rows"] = $this->products_model->countAllProduct($searchArray);
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
       	$data['productData'] = $this->products_model->searchProduct($config["per_page"], $page,$searchArray);
    
        $data["sn"] = $page+1;
        
        $data["links"] = $this->ajax_pagination->create_links();

        $this->load->view('productList',$data);
    }
    
    function getCategoryBrands(){
		
		$prvBrand = $this->session->userdata('brandsId');
        $data['prvBrand'] = $prvBrand;  
        $catIds = $this->input->post('checkedVals');
        $data['brands'] = $this->products_model->getCategoryBrands($catIds);
        $this->load->view('brandList',$data);
    }

	function viewProduct(){
		
		$uId = $this->session->userdata('id');
		$pId = $this->uri->segment('3');
		$d = $this->products_model->viewProduct($pId);
		if(empty($d)){

			redirect(base_url());

		}else{

			$viewData = array();
			$viewData['details'] = $d;
			$viewData['images'] = $this->products_model->getProductImages($pId);
			$viewData['related'] = $this->products_model->getRelatedProducts($pId);
			$viewData['reviews'] = $this->products_model->getReviews($pId);		
			$viewData['ownerDetail'] = $this->products_model->getOwnerdetails($pId);
			$viewData['countReviews'] = $this->products_model->countReviews($pId);
			$viewData['currentRenters'] = $this->products_model->currentRenter($pId,$uId);
	        $viewData['allRequest'] = $this->products_model->allRequest($pId,$uId);
			$viewData['prevRequest'] = $this->products_model->previousRequest($pId,$uId);
	        $viewData['adminFees'] = $this->products_model->adminFees();
	        $id = $this->session->userdata('id');
	        $this->load->model('user/user_model');
	        $viewData['userDetail'] = $this->user_model->profile($id);
	        $viewData['addCss'] = array("css/calendar.css","css/buttonLoader.css","css/owl.carousel.min.css","css/jquery.fancybox.css","css/flexslider.css","js/lib/css/emoji.css");
	        $viewData['addJs'] = array("js/view-product.js","js/custom-callendar.js","js/jquery.buttonLoader.js","js/wow.min.js","js/owl.carousel.js","js/element.js","js/imagezoom.js","js/jquery.fancybox.js","js/jquery.flexslider.js","js/lib/js/config.js","js/lib/js/util.js","js/lib/js/jquery.emojiarea.js","js/lib/js/emoji-picker.js");

			$this->template->build('viewProduct',$viewData);

		}
	}
	
    function bookProduct(){

        $rentData['productId'] = $this->input->post('id');
        $rentData['userId']  = $this->session->userdata('id');
        $details = $this->products_model->viewProduct($rentData['productId']);

        $rentData['availType']  = $this->input->post('availType');
        $rentData['bookStartDate']  =  $this->input->post('requestDate') ? date('Y-m-d',strtotime($this->input->post('requestDate'))) : "";
        $rentData['bookEndDate']  =  $this->input->post('requestEndDate') ? date('Y-m-d',strtotime($this->input->post('requestEndDate'))) : $rentData['bookStartDate'];
        $rentData['requestType']  = $this->input->post('requestType');
        $rentData['requestStatus']  = ($this->input->post('requestType')==1) ? ACCEPT : PENDING ;       
        $rentData['ownerId']  = $this->input->post('ownerId');
        $slot = $this->input->post('slot');
        $price = explode(",",$this->input->post('price'));
        $productForRental = explode(",",$details->productForRental);
        $key = array_search($slot, $productForRental); // $key = 2;
        $rentData['price']  = $price[$key];
        $rentData['productForRental']  = $slot;

        $result = $this->products_model->bookProduct($rentData);

        if($result == true){
            $this->session->set_flashdata('success', ResponseMessages::getStatusCodeMessage(127));
            echo 1;

        }else{

            $this->session->set_flashdata('success', ResponseMessages::getStatusCodeMessage(118));
            echo 0;

        }
    }

    function myProduct(){

        $data['addCss'] = array("css/calendar.css");
        
        $this->template->build('myProduct',$data);
    }
    
    function allMyProductListing(){

        $id = $this->session->userdata('id');
        $this->load->library('ajax_pagination');

        $config = array();
        $config["base_url"] = base_url() . "products/allMyProductListing";
        $config["total_rows"] = $this->products_model->countAllMyProduct($id);
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
        $data['productData'] = $this->products_model->allMyProductListing($config["per_page"], $page,$id);
    
        $data["sn"] = $page+1;
        
        $data["links"] = $this->ajax_pagination->create_links();

        $this->load->view('myProductList',$data);
    }

    function addProduct(){
        
        $this->load->library('form_validation');

        $this->form_validation->set_rules('title','Title','required');
        $this->form_validation->set_rules('description','Description','required');
        $this->form_validation->set_rules('condition','Condition','required');
        $this->form_validation->set_rules('address','Address','required');
        $this->form_validation->set_rules('brandId','Brand Name','required');
        $this->form_validation->set_rules('instantBooking','Instant Booking','required');
        $this->form_validation->set_rules('categoryId','Category Name','required');
        $data['cat'] = $this->products_model->getAllCategory();
		$data['zipCode'] = $this->products_model->getUserDetail();
		
        if($this->form_validation->run() == FALSE){
            $data['error'] = validation_errors();

        } else {

            $date = date('Y-m-d H:i:s');
            $productImages = '';

            if(!empty($_FILES['productImages']['name'])){
                $folder = 'productImage';
                $productImages = $this->products_model->updateGallery('productImages',$folder);
            }

            $productImages['productImages'] = isset($productImages) ? $productImages : '';          

            $userData = array(
                'ownerId' => $this->session->userdata('id'),
                'title'  => $this->input->post('title'),
                'description'  => $this->input->post('description'),
                'condition'  => $this->input->post('condition'),                
                'address'  => $this->input->post('address'),
                'categoryId'  => $this->input->post('categoryId'),
                'brandId'  => $this->input->post('brandId'),
                'price'  => $this->input->post('price'),
                'instantBooking'  => $this->input->post('instantBooking'),
                'crd' => $date,
                'upd' => $date
            ); 

            $productForRental="";
            $totalPrice="";



            if(!empty($this->input->post('totalPrice1'))){
                $totalPrice.= $this->input->post('totalPrice1').',';
                $productForRental.='1,';

            }
            if(!empty($this->input->post('totalPrice2'))){
                $totalPrice.= $this->input->post('totalPrice2').',';
                $productForRental.='2,';
            }
            if(!empty($this->input->post('totalPrice3'))){
                $totalPrice.= $this->input->post('totalPrice3').',';
                $productForRental.='3,';
            }
            if(!empty($this->input->post('totalPrice4'))){
                $totalPrice.= $this->input->post('totalPrice4').',';
                $productForRental.='4,';
            }
            if(!empty($this->input->post('totalPrice5'))){
                $totalPrice.= $this->input->post('totalPrice5').',';
                $productForRental.='5,';
            }

           $userData['productForRental'] = substr(trim($productForRental), 0, -1);

            $userData['totalPrice'] = substr(trim($totalPrice), 0, -1);

            $price = explode(',', $userData['totalPrice']);

            $userData['price'] = $price[0];
             
            if($userData['condition'] == 'new'){
				$userData['productAge']  = '';
			} else{
				$userData['productAge']  = $this->input->post('productAge').' Year';
			} 

            $userData['availStartDate'] = $this->input->post("datePicker");

            $result = $this->products_model->addProduct($userData,$productImages); 

            if(is_string($result) && $result == "PA"){

                redirect('products/myProduct');

            } elseif(is_string($result) && $result == "AE") {

                $data['error'] = 'Record already exist.';

            } elseif(is_string($result) && $result == "ED") {

                $data['error'] = 'Please select valid address';

            } else{

                $data['error'] = ResponseMessages::getStatusCodeMessage(118);
            }
        }
         $this->load->model('user/user_model');  
        $data['userData'] = $this->user_model->profile($this->session->userdata('id'));
        $data['addCss'] = array("css/calendar.css","css/buttonLoader.css");
        $data['addJs'] = array("js/add-product.js","js/custom-callendar.js","js/jquery.buttonLoader.js");
        $data['adminFees'] = $this->products_model->adminFees();

        $this->template->build('addProduct',$data);
    }

    function productEdit(){

        $pId = $this->uri->segment('3');
        $data['details'] = $this->products_model->viewProduct($pId);
        $data['addCss'] = array("css/calendar.css");
        $data['addJs'] = array("js/edit-product.js","js/custom-callendar.js");
        $this->template->build('updateProduct',$data);

    }

    function productUpdate(){
      

        $productForRental="";
        $totalPrice="";

        if(!empty($this->input->post('totalPrice1'))){
            $totalPrice.= $this->input->post('totalPrice1').',';
            $productForRental.='1,';
        }
        if(!empty($this->input->post('totalPrice2'))){
            $totalPrice.= $this->input->post('totalPrice2').',';
            $productForRental.='2,';
        }
        if(!empty($this->input->post('totalPrice3'))){
            $totalPrice.= $this->input->post('totalPrice3').',';
            $productForRental.='3,';
        }
        if(!empty($this->input->post('totalPrice4'))){
            $totalPrice.= $this->input->post('totalPrice4').',';
            $productForRental.='4,';
        }
        if(!empty($this->input->post('totalPrice5'))){
            $totalPrice.= $this->input->post('totalPrice5').',';
            $productForRental.='5,';
        }
        $data['productForRental'] = substr(trim($productForRental), 0, -1);

        $data['totalPrice'] = substr(trim($totalPrice), 0, -1);

        $price = explode(',', $data['totalPrice']);

        $data['price'] = $price[0];
         
        $data['availStartDate'] = $this->input->post("datePicker");
        $data['instantBooking'] = $this->input->post("instantBooking");

        $id = $this->input->post('id');   
       
        $result = $this->products_model->updateProduct($data,$id); 

        if($result){

            redirect('products/myProduct');

        }

    }

    function SendNotifcation(){


        if(!empty($this->input->post('receiverToken'))){

            $token = $this->input->post('receiverToken');
            $msg  = $this->input->post('msg');
            $title  = $this->input->post('title');
            $productId  = $this->input->post('productId');
            $productImage  = $this->input->post('productImage');
            $productName  = $this->input->post('productName');
            $senderId  = $this->input->post('senderId');
            $senderToken  = $this->input->post('senderToken');
            $chatRoomId  = $this->input->post('chatRoomId');
            $notification = array('title' =>$title , 'body' => $msg,'icon'=>'icnon','sound'=>"default","type"=>"chat","chatRoomId"=>$chatRoomId,"opponentChatId"=>$senderId,"badge"=>1,"opponentToken"=>$senderToken,'click_action'=>'ChatActivity');

            $dataKey = array('title' =>$title , 'message' => $msg,'productId' =>$productId,'productImage'=>$productImage,"productName"=>$productName,"type"=>"chat","senderId"=>$senderId,"senderToken"=>$senderToken,'click_action'=>'ChatActivity');
            $this->load->model('notification_model'); 
            $a = $this->notification_model->send_chatNotification($token,$notification,$dataKey);
            print_r($a);
            die();


        }

        
    }
    
    function requestUpdate(){

        $productId = $this->input->post('id');
        $requestId  = $this->input->post('requestid');
        $requestStatus  = $this->input->post('requestStatus');
        $requestDate  = !empty($this->input->post('requestDate')) ? $this->input->post('requestDate') : "";
        $finishstatus  = !empty($this->input->post('finishstatus')) ? $this->input->post('finishstatus') : "";
        $extrapayment  = !empty($this->input->post('extrapayment')) ? $this->input->post('extrapayment') : "";
        $type  = !empty($this->input->post('type')) ? $this->input->post('type') : "";
        $requestEndDate  = !empty($this->input->post('requestEndDate')) ? $this->input->post('requestEndDate') : $this->input->post('requestDate');
        $availType  = $this->input->post('availType') ? $this->input->post('availType') : "";
        $price  = !empty($this->input->post('price')) ? $this->input->post('price') : "";
        $slot  = !empty($this->input->post('slot')) ? $this->input->post('slot') : "";
        $modifyStatus  = !empty($this->input->post('modifyStatus')) ? $this->input->post('modifyStatus') : "";

        $result = $this->products_model->requestUpdate($productId,$requestId,$requestStatus,$requestDate,$requestEndDate,$availType,$price,$slot,$modifyStatus,$finishstatus,$extrapayment);

        $req = $this->product_model->gettransactionDetail($requestId);

        if($data['requestStatus']=="complete" && $finishStatus=="accept" && $req->bookEndDate>=date("Y-m-d")){

        }


        if($result == true){

            if($requestStatus==ACCEPT){

                $this->session->set_flashdata('success', ResponseMessages::getStatusCodeMessage(132));
                echo 1;

            }else if($requestStatus==REJECT){

                $this->session->set_flashdata('success', ResponseMessages::getStatusCodeMessage(133));
                echo 1;

            }else if(($result==true) && $requestStatus == COMPLETE &&  $finishstatus == "sendInvoice"){

                $this->session->set_flashdata('success', ResponseMessages::getStatusCodeMessage(142));
                echo 1;


            }else if($requestStatus==COMPLETE &&  $type != "1"){

                $this->session->set_flashdata('success', ResponseMessages::getStatusCodeMessage(139));
                echo 1;

            }else if($requestStatus==COMPLETE  &&  $type == "1"  &&  $finishstatus==ACCEPT){
                $this->session->set_flashdata('success', ResponseMessages::getStatusCodeMessage(140));
                echo 1;

            }else if($requestStatus==COMPLETE &&  $type == "1"  &&  $finishstatus==REJECT){
                
                $this->session->set_flashdata('success', ResponseMessages::getStatusCodeMessage(141));
                echo 1;

            }else if($requestStatus==MODIFY && $modifyStatus==ACCEPT){

                $this->session->set_flashdata('success', ResponseMessages::getStatusCodeMessage(135));
                echo 1;

            }else if($requestStatus==MODIFY && $modifyStatus==REJECT){

                $this->session->set_flashdata('success', ResponseMessages::getStatusCodeMessage(136));
                echo 1;

            }else{

                $this->session->set_flashdata('success', ResponseMessages::getStatusCodeMessage(134));
                echo 1;

            }

        }else{

            $this->session->set_flashdata('success', ResponseMessages::getStatusCodeMessage(118));
            echo 0;

        }

    }

    function paymentComplete(){

        $productId = $this->input->post('id');
        $requestId  = $this->input->post('requestid');
       

        $result = $this->products_model->paymentComplete($productId,$requestId);

        if($result == true){

            $this->session->set_flashdata('success', ResponseMessages::getStatusCodeMessage(143));
            echo 1;

        }else{

            $this->session->set_flashdata('success', ResponseMessages::getStatusCodeMessage(118));
            echo 0;

        }

    }

    function postRatingReview(){ 
        
        $data_val = array();
        $data_val['productId'] = $this->input->post('productId');
        $data_val['receiveById'] = $this->input->post('receiveById');
        if($this->input->post('stars')){

            $data_val['stars'] = $this->input->post('stars');
        }
        if($this->input->post('comment')){

            $data_val['comment'] = $this->input->post('comment');
        }
        

        $result = $this->products_model->postRatingReview($data_val,$this->input->post('requestId'));

        if(!empty($result)){

            $this->session->set_flashdata('success', ResponseMessages::getStatusCodeMessage(144));
            echo 1;

        }else{

            $this->session->set_flashdata('success', ResponseMessages::getStatusCodeMessage(114));
            echo 0;

        }

    }//End Function

}	
