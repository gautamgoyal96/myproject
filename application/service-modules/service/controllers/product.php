<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
//load rest library
require APPPATH . '/libraries/REST_Controller.php';

class Product extends Rest_Controller {

	public function __construct(){

		parent::__construct();
		$this->load->model('product_model');
	}

	function addProduct_post(){

		$date = date('Y-m-d H:i:s');
		$productImages = '';

		if(!empty($_FILES['productImages']['name'])){
			$folder = 'productImage';
			$productImages = $this->product_model->updateGallery('productImages',$folder);
		}

		$productImage['productImages'] = isset($productImages) ? $productImages : '';

		$insertdata['availType'] = $this->post('availType');
		$insertdata['availStartDate'] = !empty($this->post('availStartDate')) ? $this->post('availStartDate') : "";
		$insertdata['availEndDate'] = !empty($this->post('availEndDate')) ? $this->post('availEndDate') : "";
		$insertdata['ownerId'] = $this->authData->id;		
		$insertdata['title'] = $this->post('title');		
		$insertdata['categoryId'] = $this->post('categoryId');
		$insertdata['brandId'] = $this->post('brandId');
		$price = explode(",",$this->post('totalPrice'));
		$insertdata['price'] = $price[0];
		$insertdata['totalPrice'] = $this->post('totalPrice');
		$insertdata['condition'] = $this->post('condition');
		$insertdata['productAge'] = $this->post('productAge');
		$insertdata['productForRental'] = $this->post('productForRental');
		$insertdata['instantBooking'] = $this->post('instantBooking');
		$insertdata['address'] = $this->post('address');
		$insertdata['latitude'] = $this->post('latitude');
		$insertdata['longitude'] = $this->post('longitude');
		$insertdata['description'] = $this->post('description');
		$insertdata['crd'] = $date;
		$insertdata['upd'] = $date;
		
		$result = $this->product_model->addProduct($insertdata,$productImage);

		if(is_string($result) && $result == 'PA'){			
			$responseArray = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(125));
			$status = OK;			
		}elseif(is_string($result) && $result == 'NA') {
			$responseArray = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(126));
			$status = OK;
		} else {
			$responseArray = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(118));
			$status = OK;
		}
		$response = $this->generate_response($responseArray);
		$this->response($response,$status);	
	}
	
	function bookProduct_post(){

		$this->load->library('form_validation');
		$this->form_validation->set_rules('ownerId','Owner Id','required');
		$this->form_validation->set_rules('productId','Product Id','required');

		if($this->form_validation->run() == FALSE){

			$responseArray = array('status'=>FAIL,'message'=>strip_tags(validation_errors()));
			$response = $this->generate_response($responseArray);
			$this->response($response);
		} else {
			$date = date('Y-m-d H:i:s');

			$userData['userId'] = $this->authData->id;
			$userData['productId'] = $this->post('productId');
			$userData['ownerId'] = $this->post('ownerId');
			$userData['requestType'] = $this->post('requestType');
			$userData['productForRental'] = !empty($this->post('productForRental')) ? $this->post('productForRental') : '';

			
			$userData['availType'] = $this->post('availType');

			$userData['bookStartDate'] = !empty($this->post('bookStartDate')) ? $this->post('bookStartDate') : "";
			$userData['bookEndDate'] = !empty($this->post('bookEndDate')) ? $this->post('bookEndDate') : "";
			$userData['bookStartDate'] = !empty($this->post('bookStartDate')) ? $this->post('bookStartDate') : "";
			$userData['bookStartTime'] = !empty($this->post('bookStartTime')) ? $this->post('bookStartTime') : "";
			$userData['bookEndTime'] = !empty($this->post('bookEndTime')) ? $this->post('bookEndTime') : "";	
			$userData['price'] = !empty($this->post('price')) ? $this->post('price') : "";			
			
			$userData['crd'] = $userData['upd'] = $date;

			$result = $this->product_model->bookProduct($userData);

			if(is_string($result) && $result == 'RS'){			
				$responseArray = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(127));
				$status = OK;			
			}elseif(is_string($result) && $result == 'PNA') {
				$responseArray = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(128));
				$status = OK;
			}elseif(is_string($result) && $result == 'NA') {
				$responseArray = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(126));
				$status = OK;
			} else {
				$responseArray = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(118));
				$status = OK;
			}
			$response = $this->generate_response($responseArray);
			$this->response($response,$status);	
		}
	}

	function requestStatusUpdate_post(){

		$this->load->library('form_validation');
		$this->form_validation->set_rules('requestId','Request Id','required');
		$this->form_validation->set_rules('requestStatus','Request Status','required');

		if($this->form_validation->run() == FALSE){

			$responseArray = array('status'=>FAIL,'message'=>strip_tags(validation_errors()));
			$response = $this->generate_response($responseArray);
			$this->response($response);
		} else {
			$data = array();

			$requestId = $this->post('requestId');
			$data['requestStatus'] = $this->post('requestStatus');
			$price = !empty($this->post('price')) ? $this->post('price') : '';
			$finishStatus  = !empty($this->input->post('finishStatus')) ? $this->input->post('finishStatus') : "";
			$extraPay  = !empty($this->input->post('extraPay')) ? $this->input->post('extraPay') : "";
            $type  = !empty($this->input->post('type')) ? $this->input->post('type') : "";

			if($price)
			$data['modifyPrice'] = $price;

			$bookStartTime = !empty($this->post('bookStartTime')) ? $this->post('bookStartTime') : '';;
			if($bookStartTime)
			$data['modifyBookStartTime'] = $bookStartTime;

			$bookEndTime = !empty($this->post('bookEndTime')) ? $this->post('bookEndTime') : '';
			if($bookEndTime)
			$data['modifyBookEndTime'] = $bookEndTime;

			$bookStartDate = !empty($this->post('bookStartDate')) ? $this->post('bookStartDate') : '';
			if($bookStartDate)
			$data['modifyBookStartDate'] = $bookStartDate;

			$bookEndDate = !empty($this->post('bookEndDate')) ? $this->post('bookEndDate') : '';
			if($bookEndDate)
			$data['modifyBookEndDate'] = $bookEndDate;

			$productForRental = !empty($this->post('productForRental')) ? $this->post('productForRental') : '';
			if($productForRental)
			$data['modifyProductForRental'] = $productForRental;

			$availType = !empty($this->post('availType')) ? $this->post('availType') : '';
			if($availType)
			$data['modifyAvailType'] = $availType;

			//$data['requestType'] = '2';	
	/*		$req = $this->product_model->gettransactionDetail($requestId);

			if($data['requestStatus']=="complete" && $finishStatus=="accept" && $req->bookEndDate>=date("Y-m-d")){

			}*/

			


			$modifyRequestStatus = !empty($this->post('modifyRequestStatus')) ? $this->post('modifyRequestStatus') : '';
			$result = $this->product_model->requestStatusUpdate($data,$requestId,$modifyRequestStatus,$finishStatus,$extraPay);
			

			if(($result==true) && $data['requestStatus'] == 'accept'){	

				$responseArray = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(132));
				$status = OK;	

			}elseif(($result==true) && $data['requestStatus'] == 'reject') {

				$responseArray = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(133));
				$status = OK;

			}else if(($result==true) && $data['requestStatus']==COMPLETE &&  $finishStatus=="sendinvoice"){
                
                $responseArray = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(142));
				$status = OK;

            }else if(($result==true) && $data['requestStatus']==COMPLETE &&  $type != "1"){

               $responseArray = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(139));
			   $status = OK;

            }else if(($result==true) && $data['requestStatus']==COMPLETE  &&  $type == "1"  &&  $finishStatus==ACCEPT){


                $responseArray = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(140));
				$status = OK;

            }else if(($result==true) && $data['requestStatus']==COMPLETE &&  $type == "1"  &&  $finishStatus==REJECT){
                
                $responseArray = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(141));
				$status = OK;

            }else if(($result==true) && !empty($data['modifyRequestStatus']) && $data['modifyRequestStatus'] == 'accept' && $data['requestStatus'] == 'modify'){	

				$responseArray = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(135));
				$status = OK;	

			}elseif(($result==true) && !empty($data['modifyRequestStatus']) && $data['modifyRequestStatus'] == 'reject' && $data['requestStatus'] == 'modify') {

				$responseArray = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(136));
				$status = OK;

			}else if(($result==true) && $data['requestStatus'] == 'modify') {

				$responseArray = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(134));
				$status = OK;

			} else {

				$responseArray = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(118));
	
				$status = OK;
			}


			$response = $this->generate_response($responseArray);
			$this->response($response,$status);	
		}
	}
	
	function updateProduct_post(){

		$date = date('Y-m-d H:i:s');
		$userData['availEndDate'] = '';
		$userData['ownerId'] = $this->authData->id;
		if(!empty($this->post('price'))){
			$userData['totalPrice'] = $this->post('price');
			$price = explode(",",$this->post('price'));
			$userData['price'] = $price[0];
		}
		if(!empty($this->post('productId'))){
			$productId = $this->post('productId');
		}

		if(!empty($this->post('productForRental'))){
			$userData['productForRental'] = $this->post('productForRental');
		}			

		if(!empty($this->post('availType'))){
			$userData['availType'] = $this->post('availType');
		}

	

		$userData['availStartDate'] = $this->post('availStartDate');


		$userData['availEndDate'] = $this->post('availEndDate');

		$userData['instantBooking'] = !empty($this->post('instantBooking')) ? $this->post('instantBooking') : "0";


		$userData['crd'] = $userData['upd'] = $date;

		$result = $this->product_model->updateProduct($userData,$productId);

		if(is_string($result) && $result == 'PU'){			
			$responseArray = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(129));
			$status = OK;			
		}elseif(is_string($result) && $result == 'PNA') {
			$responseArray = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(128));
			$status = OK;
		} else{
			$responseArray = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(118));
			$status = OK;
		}
		$response = $this->generate_response($responseArray);
		$this->response($response,$status);	
	}
	
	function getTransactionsList_get(){

		$getData['userType'] = $this->get('userType');
		$getData['type'] = $this->get('type');
		
		$result = $this->product_model->getTransactionsList($getData);

		if(!empty($result)){
			$responseArray = array('status'=>SUCCESS,'message' =>ResponseMessages::getStatusCodeMessage(200),'transactionList'=>$result);
			$response = $this->generate_response($responseArray);
			$this->response($response,OK);
		}else {
			$responseArray = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(114));
			$response = $this->generate_response($responseArray);
			$this->response($response,OK);
		}
	}

	function getNewRequestList_get(){

		$id = $this->get('productId');
		if(empty($id)){

			$responseArray = array('status'=>FAIL,'message' =>"Product id is required");
			$response = $this->generate_response($responseArray);
			$this->response($response,OK);
		}
		$result = $this->product_model->getNewRequestList($id,'request');
		$data = $this->product_model->getNewRequestList($id);
		$productImage = $this->product_model->productImage($id);
		$this->load->model('service_model');
		$row = $this->service_model->getProductInfo(array('productId' => $id ,'ownerId' => $this->authData->id));

		
		$responseArray = array('status'=>SUCCESS,'message' =>ResponseMessages::getStatusCodeMessage(200),'requestList'=> !empty($result) ? $result :array(),'renterList' => !empty($data) ? $data : array(),'userStatus' => $this->authData->status,"availableDate" => !empty($row->availStartDate) ? $row->availStartDate : "","productImage" => $productImage);
		$response = $this->generate_response($responseArray);
		$this->response($response,OK);
	}

	function getRequestView_get(){

		$id = $this->get('requestId');
		if(empty($id)){

			$responseArray = array('status'=>FAIL,'message' =>"Request id is required");
			$response = $this->generate_response($responseArray);
			$this->response($response,OK);
		}
		$result = $this->product_model->getNewRequestView($id);

		if(!empty($result)){
			$responseArray = array('status'=>SUCCESS,'message' =>ResponseMessages::getStatusCodeMessage(200),'data'=>$result,'userStatus' => $this->authData->status);
			$response = $this->generate_response($responseArray);
			$this->response($response,OK);
		}else {
			$responseArray = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(114));
			$response = $this->generate_response($responseArray);
			$this->response($response,OK);
		}
	}

	function paymentStatusUpdate_post(){

		$this->load->library('form_validation');
		$this->form_validation->set_rules('requestId','Request Id','required');
		$this->form_validation->set_rules('paymentstatus','payment Status','required');

		if($this->form_validation->run() == FALSE){

			$responseArray = array('status'=>FAIL,'message'=>strip_tags(validation_errors()));
			$response = $this->generate_response($responseArray);
			$this->response($response);

		} else {
			
			$data = array();

			$requestId = $this->post('requestId');
			$paymentstatus = $this->post('paymentstatus');
			

			$result = $this->product_model->paymentComplete($requestId,$paymentstatus);
			

			if(($result==true)){	

				$responseArray = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(143));
				$status = OK;	

			} else {

				$responseArray = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(118));
	
				$status = OK;
			}


			$response = $this->generate_response($responseArray);
			$this->response($response,$status);	
		}
	}

	function postRatingReview_post(){ 
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('productId', 'product Id', 'required');
		$this->form_validation->set_rules('requestId', 'request Id', 'required');
		$this->form_validation->set_rules('receiveById', 'receiver Id', 'required');

		if($this->form_validation->run() == FALSE){

			$responseArray = array('status'=>FAIL,'message'=>validation_errors());
			$response = $this->generate_response($responseArray);
			$this->response($response,OK);

		} else {

			$data_val = array();
			$data_val['productId'] = $this->post('productId');
			$data_val['receiveById'] = $this->post('receiveById');
			$data_val['requestId'] = $this->post('requestId');
			if($this->post('stars')){

				$data_val['stars'] = $this->post('stars');
			}
			if($this->post('comment')){

				$data_val['comment'] = $this->post('comment');
			}
			

			$result = $this->product_model->postRatingReview($data_val,$this->post('requestId'));

			if(!empty($result)){

				$responseArray = array('status'=>SUCCESS,'message'=>ResponseMessages::getStatusCodeMessage(144));

			}else{

	            $responseArray = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(114));	

			}

			$response = $this->generate_response($responseArray);
			$this->response($response,OK);

		}

    }//End Function

    function getTransaction_get(){

    	$page = !empty($this->get('page')) ? $this->get('page') : '0';
    	$type = $this->get('type');
		if(empty($type)){

			$responseArray = array('status'=>FAIL,'message' =>"Type is required");
			$response = $this->generate_response($responseArray);
			$this->response($response,OK);
		}

		$id = $this->authData->id;
		$data = $this->product_model->gettransaction($id,$type,$page);
		$total = $this->product_model->gettransactiontotal($id,$type);

		if(!empty($data)){

		     $responseArray = array('status'=>SUCCESS,'message' =>ResponseMessages::getStatusCodeMessage(200),'data'=>$data,'total'=>$total,'userStatus' => $this->authData->status);

			}else{

	            $responseArray = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(114),'userStatus' => $this->authData->status);	

			}

		$response = $this->generate_response($responseArray);
		$this->response($response,OK);
	}

	function getTransactionDetail_get(){

    	$id = $this->get('id');
		if(empty($id)){

			$responseArray = array('status'=>FAIL,'message' =>"Id is required");
			$response = $this->generate_response($responseArray);
			$this->response($response,OK);
		}

		$data = $this->product_model->gettransactionDetail($id);

		if(!empty($data)){

		    $responseArray = array('status'=>SUCCESS,'message' =>ResponseMessages::getStatusCodeMessage(200),'data'=>$data,'userStatus' => $this->authData->status);

		}else{

            $responseArray = array('status'=>FAIL,'message'=>ResponseMessages::getStatusCodeMessage(114),'userStatus' => $this->authData->status);	

		}

		$response = $this->generate_response($responseArray);
		$this->response($response,OK);
	}

	

  
}

