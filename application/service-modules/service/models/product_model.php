<?php 
class Product_model extends CI_Model {

	private $renter = "renter";

	function upload_img($profileImage,$folder)
	{ 
		$this->makedirs($folder);

		if($profileImage == 'profileImage'){
			$allowed_types = "*"; 
		} 

		$config = array(
			'upload_path' => './uploads/'.$folder,
			'allowed_types' => $allowed_types,
			'overwrite' => false,
			//'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
			'encrypt_name'=>TRUE ,
			'remove_spaces'=>TRUE,
			'quality'			=> '100%'
		);

	  	$this->load->library('upload',$config);

	  	if(!$this->upload->do_upload('profileImage')){
   			$error = array('error' => $this->upload->display_errors());
			return $error;

		} else {

			$this->load->library('image_lib');
			$folder_thumb = $folder.'/thumb/';
			$this->makedirs($folder_thumb);

			$width = 450;
			$height = 400;

			$image_data = $this->upload->data(); //upload the image

			$resize['source_image'] = $image_data['full_path'];
			$resize['new_image'] = realpath(APPPATH . '../uploads/' . $folder_thumb);
			$resize['maintain_ratio'] = false;
			$resize['width'] = $width;
			$resize['height'] = $height;

			//send resize array to image_lib's  initialize function
			$this->image_lib->initialize($resize);
			$this->image_lib->resize();
			$this->image_lib->clear();

			return $image_data['file_name'];
		}
	}

	function updateGallery($fileName,$folder)
	{
		$this->makedirs($folder);
		$uploadPath = FCPATH . 'uploads/' . $folder; 
		$storedFile = array();

		$files = $_FILES[$fileName];		
		$number_of_files = sizeof($_FILES[$fileName]['tmp_name']);
		// we first load the upload library
		$this->load->library('upload');
		// next we pass the upload path for the images
		$overwrite = FALSE;
		$config['upload_path'] = $uploadPath;
		// also, we make sure we allow only certain type of images
		$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
		$config['max_size'] = '2048000';
		$config['encrypt_name'] = 'TRUE';
   
		for ($i = 0; $i < $number_of_files; $i++)
		{
			$_FILES[$fileName]['name'] = $files['name'][$i];
			$_FILES[$fileName]['type'] = $files['type'][$i];
			$_FILES[$fileName]['tmp_name'] = $files['tmp_name'][$i];
			$_FILES[$fileName]['error'] = $files['error'][$i];
			$_FILES[$fileName]['size'] = $files['size'][$i];

			//now we initialize the upload library
			$this->upload->initialize($config);
			if ($this->upload->do_upload($fileName))
			{
				$savedFile = $this->upload->data();//upload the image
				$folder_thumb = $folder.'/thumb/';
				$this->makedirs($folder_thumb);

				$width = 450;
				$height = 400;

				//your desired config for the resize() function
				$data = array(
					'image_library' => 'gd2',
					'source_image' =>$savedFile['full_path'], //get original image
					'overwrite' =>FALSE,
					'maintain_ratio' =>FALSE,
					'create_thumb' => FALSE,
					'width' => $width,
					'height' => $height,
					'new_image' => FCPATH.'uploads/'.$folder_thumb.$savedFile['file_name'],
				);				
				$this->load->library('image_lib'); //load image_library
				$this->image_lib->initialize($data);

				if ( ! $this->image_lib->resize()){
					$error = array('error' =>$this->image_lib->display_errors()); 
					
				} else {
					$thumb = $this->image_lib->resize($fileName); //generating thumb 
					$storedFile[$i]['name'] = $savedFile['file_name'];
					$storedFile[$i]['type'] = $savedFile['file_type'];
				}
				$this->image_lib->clear();
			} else {
				$storedFile[$i]['error'] = $this->upload->display_errors();
			}
		} 

		return $storedFile;
	}

	//Creates directory 
	function makedirs($folder='', $mode=DIR_WRITE_MODE, $defaultFolder='/uploads/'){

		if(!@is_dir(FCPATH . $defaultFolder)) {

			mkdir(FCPATH . $defaultFolder, $mode);
		}
		if(!empty($folder)) {

			if(!@is_dir(FCPATH . $defaultFolder . '/' . $folder)){
				mkdir(FCPATH . $defaultFolder . '/' . $folder, $mode,true);
			}
		} 
	}

	function getLatLong($data){ // get lat and long by city name

		$address = $data['address'];

	    if(!empty($address)){
	       
	        $formattedAddr = str_replace(' ','+',$address);

	        $url = 'http://maps.google.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=false';
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			$response = curl_exec($ch);
			curl_close($ch);
			$output = json_decode($response);
			if(isset($output->results[0]->geometry->location->lat)){
				$data['latitude']  = $output->results[0]->geometry->location->lat; 
				$data['longitude'] = $output->results[0]->geometry->location->lng;
				if(!empty($data)){
					return $data;
				}else{
					return false;
				}
			}else{
				return false;   
			}
		}else{
			return false;   
		}
	}

	public function addProduct($insertdata,$productImage){

		$query = $this->db->select('*')->where(array('status'=>1,'userType'=>1,'id'=>$this->authData->id))->get('users')->row_array();	
		
		if(!empty($query)){
			
			$check = $this->db->select('*')->where(array('brandName'=>$insertdata['brandId']))->get('brand')->row_array();
			if(empty($check)){
				$this->db->insert('brand',array('brandName'=>$insertdata['brandId'],'crd'=>$insertdata['crd'],'upd'=>$insertdata['upd']));
				$brandId = $this->db->insert_id();
				$insertdata['brandId'] = $brandId;
			}else{
				$insertdata['brandId'] = $check['id'];
			}

			if(!empty($insertdata['brandId'])){
				$chkCatBrand = $this->db->select('*')->where(array('categoryId'=>$insertdata['categoryId'],'brandId'=>$insertdata['brandId']))->get('catOfBrand')->row_array();
				if(empty($chkCatBrand)){
					$this->db->insert('catOfBrand',array('brandId'=>$insertdata['brandId'],'categoryId'=>$insertdata['categoryId'],'crd'=>$insertdata['crd'],'upd'=>$insertdata['upd']));
				}
			}

			$this->db->insert('product',$insertdata);
			$lastId = $this->db->insert_id();
			
			if(!empty($lastId)){
				$date = date('Y-m-d H:I:s');
				$imgData = array();
				if(is_array($productImage['productImages']) && !empty($productImage['productImages'])){
					$i = 0;
					foreach($productImage['productImages'] as $val) {
						
						$imgData[$i]['productImage'] = $val['name'];
						$imgData[$i]['productId'] = $lastId;
						$imgData[$i]['productId'] = $lastId;
						$imgData[$i]['crd'] = $date;
						$imgData[$i]['upd'] = $date;							

						$this->db->insert('productImages',$imgData[$i]);
						
						$i++;
					}
				}
				return 'PA'; // product added
			}else{
				return false;
			}					
		}else{
			return 'NA'; // not active
		}
	}
	
	public function bookProduct($data){

		$chkUser = $this->db->select('*')->where('id',$this->authData->id)->get('users')->row_array();

		if($chkUser['status'] == 1){
			$check = $this->db->select('*')->where(array('id'=>$data['productId']))->get('product')->row_array();
			if(!empty($check)){
				if($data['requestType'] == 1){

					$data['requestStatus'] = "accept";
					$data['requestType'] = "bookNow";
				}else{
					$data['requestStatus'] = "pending";
					$data['requestType'] = "requestToBook";
				}
				//$data['price'] = $check['totalPrice'];

				$this->db->where(array('productId' => $data['productId'],'userId' => $data['userId'],'requestStatus' => "reject"));
				$this->db->delete($this->renter);

				
				$this->db->insert($this->renter,$data);
				
				
				$ownerData = $this->db->select('id,firstName,lastName,deviceToken,deviceType')->get_where('users',array('id'=>$data['ownerId']))->row_array();

				if(!empty($ownerData)){
					$userData = $this->db->select('id,firstName,lastName')->get_where('users',array('id'=>$this->authData->id))->row_array();
					$aName = '';
					if(!empty($userData)){
						$aName = $userData['firstName'].' '.$userData['lastName'];
					}
					if($data['requestType'] == "bookNow"){
					$msg = $aName." has instantly booked your product.";
					}else{
						$msg = $aName." sent you a request to book this product.";
					}
					
					$this->load->model('notification_model');

					$token = array($ownerData['deviceToken']);
					$row = array('notficationType'=>"Product request",'productId' => $data['productId'],'userId' => $this->authData->id);
					if($ownerData['deviceType']==1 && !empty($ownerData['deviceToken'])){

						$this->notification_model->send_ios($token,$msg,$row);
 
					}elseif($ownerData['deviceType']==2 && !empty($ownerData['deviceToken'])){

					 $row['message'] = $msg;
					 	
					 	$this->notification_model->send_android($token,$row,'Product request');
					}
				}
				
				return 'RS'; // request send
			}else{
				return 'PNA'; // Product not available
			}
		}else{
			return 'NA'; // not active
		}
	}

	function requestStatusUpdate($data,$requestId,$modifyRequestStatus,$finishStatus,$extraPay){

			$type = "Request Update";

		$check1 = $this->db->select('*')->where(array('id'=>$requestId))->get($this->renter);

			if($check1->num_rows()!=0){

				$check = $check1->row_array();
				$aName = $this->authData->firstName.' '.$this->authData->lastName;


				if($data['requestStatus']=="accept"){

					$this->db->update($this->renter,array('requestStatus' => 'accept','notificationStatus' => "0"),array('id' => $requestId));
					$msg = $aName." has accepted your request";
					$this->requestAllReject($check['productId'],$requestId,$check['bookStartDate'],$check['bookEndDate']);

					

				}else if($data['requestStatus']=="reject"){

					$this->db->update($this->renter,array('requestStatus' => 'reject','notificationStatus' => "0"),array('id' => $requestId));
					$msg = $aName." has rejected your request";


				}else if($data['requestStatus']=="complete"){



					switch ($finishStatus) {

							case ACCEPT:


								$this->db->update('renter',array('requestStatus' => COMPLETE,'finishStatus'=>$finishStatus,'notificationStatus' => "0",'bookEndDate'=>date("Y-m-d"),'bookEndTime'=>date("H:i:s")),array('id' => $requestId));
								$msg = $aName." has accepted your finish request for this product";

							break;

							case REJECT:

								$this->db->update('renter',array('requestStatus' => ACCEPT,'finishStatus'=>'','notificationStatus' => "0"),array('id' => $requestId));
								$msg = $aName." has rejected your finish request for this product";
							
							break;

							case 'sendInvoice':

								$this->db->update('renter',array('requestStatus' => COMPLETE,'finishStatus'=>'sendInvoice','extraPay'=>$extraPay,'notificationStatus' => "0"),array('id' => $requestId));
								$msg = $aName." has sent you a invoice for this product";
							
							break;

							default:

							$type = "Product request";
								$this->db->update('renter',array('requestStatus' => COMPLETE,'bookEndDate'=>date("Y-m-d"),'bookEndTime'=>date("H:i:s"),'finishStatus'=>$finishStatus,'notificationStatus' => "0"),array('id' => $requestId));
								$msg = $aName." has finished the rental service for this product";

							break;

					}

					if($data['requestStatus']==COMPLETE && $finishStatus==ACCEPT && $type != "1"){

						$msg = $aName." has finished the rental service for this product";
					}
					
				}else if($data['requestStatus']=="modify"){


					if(!empty($modifyRequestStatus)){

						switch ($modifyRequestStatus) {
							case 'accept':
							$type = "User modification";

								$my = array();
								$my['requestStatus'] = "accept";
								$my['modifyRequestStatus'] = 'pending' ;

								if(!empty($check['modifyBookStartDate']))
									$my['bookStartDate'] = $check['modifyBookStartDate'];

								if(!empty($check['modifyBookEndDate']))
									$my['bookEndDate'] = $check['modifyBookEndDate'];

								if(!empty($check['modifyBookStartDate']))
									$my['bookStartDate'] = $check['modifyBookStartDate'];

								if(!empty($check['modifyPrice']))
									$my['price'] = $check['modifyPrice'];

								if(!empty($check['modifyAvailType']))
									$my['availType'] = $check['modifyAvailType'];

								if(!empty($check['modifyProductForRental']))
									$my['productForRental'] = $check['modifyProductForRental'];	

								if(!empty($check['modifyBookEndTime']))
									$my['bookEndTime'] = $check['modifyBookEndTime'];	

								if(!empty($check['modifyBookStartTime']))
									$my['bookStartTime'] = $check['modifyBookStartTime'];	

								$my['modifyBookStartDate']  = $my['modifyBookEndDate'] =$my['modifyPrice'] = $data_val['modifyAvailType'] = $my ['modifyProductForRental'] = $my ['modifyBookEndTime'] = $my ['modifyBookStartTime'] = $my ['modifyRequestStatus'] = '';							
								$my ['modifyRequestStatus'] = 'accept';
								$my['notificationStatus'] = "0";
								$this->db->update($this->renter,$my,array('id' => $requestId));
								
								$msg = "Your modification has accepted";
								break;
							
							default:

						$type = "User modification";
						$data_val = array();
						$data_val['modifyBookStartDate']  = $data_val['modifyBookEndDate'] =$data_val['modifyPrice'] = $data_val['modifyAvailType'] = $data_val ['modifyProductForRental'] = '';
						$data_val['modifyRequestStatus'] = "reject";
						$data_val['requestStatus'] = "pending";
						$data_val['notificationStatus'] = "0";

						if(!empty($check['requestType']) && $check['requestType'] =="bookNow")
								$data_val['requestStatus'] = "accept";

								
								$this->db->update($this->renter,$data_val,array('id' => $requestId));
								$msg = "Your modification has rejected";
								break;
						}

					}else{

						$data['requestStatus'] = 'modify';
						$data['modifyRequestStatus'] = 'pending';
						$data['notificationStatus'] = "0";
						$this->db->update($this->renter,$data,array('id' => $requestId));

						$data['requestStatus'] = 'modify';
						$msg = $aName." has modified your request";
		 	


					}
					
				}

				$this->load->model('user_model');

				if($this->authData->id != $check['userId']){
					$id = $check['userId'];

				}else{

					$id = $check['ownerId'];
				}


				$ownerData = $this->user_model->userInfo(array('id' => $id));
	
				
				if(!empty($ownerData)){
		
					
					$this->load->model('notification_model');

					$token = array($ownerData->deviceToken);
					
					$row = array('notficationType'=> $type,'productId' => $check['productId'],'userId' => $this->authData->id);
				
				
					if($ownerData->deviceType==1 && !empty($ownerData->deviceToken)){
						
						$this->notification_model->send_ios($token,$msg,$row);
 
					}elseif($ownerData->deviceType==2 && !empty($ownerData->deviceToken)){

					 $row['message'] = $msg;			
					 $this->notification_model->send_android($token,$row,$type);
					}	
				}

				return true; // request Update

			}else{
				return false; // request not available
			}
	}

	function requestAllReject($productId,$requestId,$bookStartDate,$bookEndDate){

		$this->db->where(array('productId'=>$productId,'requestStatus' => PENDING,'bookStartDate <= '=>$bookStartDate,'bookEndDate >=' => $bookEndDate));
		$row = $this->db->get($this->renter);
	
		if($row->num_rows()){

			$data = $row->result();


			foreach ($data as $key => $value) {

				$this->db->where('id',$value->id);
				$this->db->delete($this->renter);	
				$ownerData = $this->db->select('id,firstName,lastName')->get_where('users',array('id'=>$value->ownerId))->row_array();
				$aName = $ownerData['firstName'].' '.$ownerData['lastName'];
				$msg = $aName." has rejected your request";

				
				$userData = $this->db->select('id,deviceToken,deviceType')->get_where('users',array('id'=>$value->userId))->row();

				
				if(!empty($userData)){		
					
					$this->load->model('notification_model');
							$type = "Request Update";

					$token = array($userData->deviceToken);
					
					$row = array('notficationType'=> $type,'productId' => $productId,'userId' => $value->ownerId);					
				
					if($userData->deviceType==1 && !empty($userData->deviceToken)){
						
						$this->notification_model->send_ios($token,$msg,$row);
 
					}elseif($userData->deviceType==2 && !empty($userData->deviceToken)){

					 $row['message'] = $msg;					 	
					 $this->notification_model->send_android($token,$row,$type);
					}
				

					return true;
				}

			}

		}


	}
	
	function updateProduct($data,$productId){

		$chkProduct = $this->db->select('*')->where(array('id'=>$productId,'status'=>1))->get('product')->row_array();

		if(!empty($chkProduct)){
			$chkRent = $this->db->select('*')->where(array('productId'=>$chkProduct['id'],'requestStatus !=' => 1))->get('renter');
			if($chkRent->num_rows() > 0){
				$this->db->where(array('ownerId'=>$this->authData->id,'id'=>$productId));
				$this->db->update('product',$data);

				return 'PU'; // product update
			}else{
				$this->db->where(array('ownerId'=>$this->authData->id,'id'=>$productId));
				$this->db->update('product',$data);
			
				return 'PU'; // product update
			}
		}else{
			return 'PNA'; // product not available
		}		
	}
	
	function getNewRequestList($id,$data=''){

		$ownerId = $this->authData->id;
		$this->db->select('renter.id as requestId,renter.userId,renter.productId,renter.bookStartDate,renter.bookEndDate,renter.bookEndTime,renter.modifyRequestStatus,renter.requestType,renter.crd as postedTime,users.id as uId,renter.price as totalPrice,renter.extraPay,renter.availType,renter.requestStatus,renter.requestStatus,renter.finishStatus,renter.payStatus,renter.productForRental,renter.reviewStatus,users.firstName,users.lastName,users.rating,users.profileImage,users.firebaseToken,users.firebaseId,users.email,users.countryCode,users.contactNo,users.address,users.about')->from($this->renter)->join('users','users.id = renter.userId')->order_by('renter.crd','desc');
		$this->db->where(array('renter.requestStatus !=' => REJECT));
		if(!empty($data)){
			
			$this->db->where(array('renter.ownerId'=>$ownerId,'renter.productId' => $id,'renter.requestStatus' => PENDING));
			$this->db->or_where("(`renter`.`requestStatus` = 'modify' AND `renter`.`modifyRequestStatus` = 'pending' AND `renter`.`ownerId` = '$ownerId' AND `renter`.`productId` = '$id')");

			
		}else{

			$this->db->where("(`renter`.`ownerId` = '$ownerId' AND `renter`.`productId` = '$id')");
			$this->db->where("(`renter`.`requestStatus` = 'accept' OR `renter`.`requestStatus` = 'complete')");
		    $this->db->where("(`renter`.`payStatus` = 'pending')");
		}


			$req = $this->db->get();
			
			
			if(!empty($req->num_rows())){

				$rs = $req->result();

				foreach ($req->result() as $key => $value) {
					
					if (!empty($value->profileImage) && filter_var($value->profileImage, FILTER_VALIDATE_URL) === false) {
						$value->profileImage = base_url().UPLOAD_FOLDER.'/profile/'.$value->profileImage;
					}
					$this->load->model('service_model');
					$pro = $this->service_model->getProductInfo(array('productId' => $value->productId ,'ownerId' => $this->authData->id));
					$rs[$key]->title = $pro->title;
			
					$rs[$key]->postedTime = $this->timeElapsedString($value->postedTime);
					$my = $this->getNewRequestView1($value->requestId);
					$rs[$key]->rating = round($value->rating);
					if($value->requestStatus == MODIFY){

						$rs[$key]->bookStartDate    = $my->modifyBookStartDate;
						$rs[$key]->bookEndDate 	  = $my->modifyBookEndDate;
						$rs[$key]->totalPrice 	  = $my->modifyPrice;
						$rs[$key]->availType 		  = $my->modifyAvailType;
						$rs[$key]->productForRental = $my->modifyProductForRental;

					}

					
				}
			
				return $rs;

			}
			return false;
	}

	function getNewRequestView($id){

		
		$this->db->select('renter.id as requestId,renter.userId,renter.ownerId,renter.productId,renter.bookStartDate,renter.bookEndTime,renter.bookEndDate,renter.modifyRequestStatus,renter.requestType,renter.crd as postedTime,renter.price as totalPrice,renter.extraPay,renter.availType,renter.requestStatus,renter.finishStatus,renter.payStatus,renter.reviewStatus,renter.productForRental,users.firstName,users.lastName,users.rating,users.profileImage,users.firebaseToken,users.firebaseId,users.email,users.countryCode,users.contactNo,users.address,users.about')->from($this->renter)->order_by('renter.crd','desc');
		if($this->authData->userType == 1){
			
			$this->db->join('users','users.id = renter.userId')->where(array('renter.id' => $id));

		}else{

			$this->db->join('users','users.id = renter.ownerId')->where(array('renter.productId' => $id,'renter.userId' => $this->authData->id));
		}	
		$req = $this->db->get();
		/*echo $this->db->last_query();
		die();*/
		
		if(!empty($req->num_rows())){

			$rs = $req->row();

				
			if (!empty($rs->profileImage) && filter_var($rs->profileImage, FILTER_VALIDATE_URL) === false) {
				$rs->profileImage = base_url().UPLOAD_FOLDER.'/profile/'.$rs->profileImage;
			}
			$rs->rating = round($rs->rating);
			$this->load->model('service_model');
			$pro = $this->service_model->getProductInfo(array('productId' => $rs->productId ,'ownerId' => $rs->ownerId));
			$rs->title = $pro->title;
			$rs->productImage = $this->productImage($rs->productId);
	
			$rs->postedTime = $this->timeElapsedString($rs->postedTime);
			$my = $this->getNewRequestView1($rs->requestId);
			if($rs->requestStatus == MODIFY){

				$rs->bookStartDate    = $my->modifyBookStartDate;
				$rs->bookEndDate 	  = $my->modifyBookEndDate;
				$rs->totalPrice 	  = $my->modifyPrice;
				$rs->availType 		  = $my->modifyAvailType;
				$rs->productForRental = $my->modifyProductForRental;

			}

		
			return $rs;

		}

		return false;
	}

	function productImage($id){

		$imgs = $this->db->select('*')->where(array('productId'=>$id))->get('productImages')->result();

			$new = array();
			if(!empty($imgs)){
				foreach ($imgs as $key => $img) {					
					
					if(!empty($img->productImage)){

						$new[$key] = base_url().'uploads/productImage/'.$img->productImage;
					}					
				}
			}

			return $new;
	}

	function getNewRequestView1($id){

		$this->db->select('modifyPrice,modifyBookStartTime,modifyBookEndTime,modifyBookStartDate,modifyBookEndDate,modifyAvailType,modifyRequestStatus,modifyProductForRental')->from($this->renter)->where(array('renter.id'=>$id));
			$req = $this->db->get();
			if(!empty($req->num_rows())){

				$rs = $req->row();
				return $rs;

			}
			return false;
	}

	function paymentComplete($requestId,$paymentstatus){


	
		$type = "Product request";

		$checkRequest = $this->db->select('*')->where(array('id'=>$requestId))->get('renter');

		if($checkRequest->num_rows()!=0){

	
			$check = $checkRequest->row_array();

			$ownerData = $this->db->select('id,firstName,lastName')->get_where('users',array('id'=>$check['userId']))->row_array();

			if(!empty($ownerData)){

				$aName = $ownerData['firstName'].' '.$ownerData['lastName'];

				$this->db->update('renter',array('payStatus' => $paymentstatus,'notificationStatus' => "0",'transactionId' => (rand(10, 99)).(rand(11, 99)).(rand(21, 99))),array('id' => $requestId));
				$msg = "Payment has been completed by ".$aName;


				$userData = $this->db->select('id,deviceToken,deviceType')->get_where('users',array('id'=>$check['ownerId']))->row();
							
				
				if(!empty($userData)){		
					
					$this->load->model('notification_model');
					
					$token = array($userData->deviceToken);
				
				   $row = array('notficationType'=> $type,'productId' => $check['productId'],'userId' => $check['ownerId']);

				   if($userData->deviceType==1 && !empty($userData->deviceToken)){
					
						$this->notification_model->send_ios($token,$msg,$row);

					}elseif($userData->deviceType==2 && !empty($userData->deviceToken)){

						$row['message'] = $msg;					 	
						$this->notification_model->send_android($token,$row,$type);
					
					}							
				
					
				}
			}
			return true; 
		}else{
			return false; 
		}
	}

	function postRatingReview($data,$requestId) {

		$data['givenById'] = $this->authData->id;
		$type = "Product request";
		$req = $this->db->select('*')->where(array("productId"=>$data['productId'],"givenById"=>$this->authData->id,'requestId' => $requestId))->get('ratings');
		 if($req->num_rows()){

	 		$this->db->where(array('id'=>$req->row()->id));
			$this->db->update('ratings', $data);

		}else{

			$this->db->insert('ratings',$data);
		}

		$this->db->update('renter', array('reviewStatus'=>COMPLETE,'notificationStatus' => '0'),array('id'=>$requestId));
		$req = $this->db->select('*')->where(array("productId"=>$data['productId'],"stars != "=>""))->get('ratings');
		if($req->num_rows()){
			$count = $req->num_rows();
			$total = 0;
			foreach ($req->result() as $data_val) {

				$total = $data_val->stars+$total;
			}

			$rating = $total/$count;
			$this->db->where('id',$data['receiveById']);
			$this->db->update('users', array('rating'=>$rating));
		}

		$aName = $this->authData->firstName.' '.$this->authData->lastName;
		$msg = $aName." has given a review on your product";
		$ownerData = $this->db->select('id,deviceToken,deviceType')->get_where('users',array('id'=>$data['receiveById']))->row();
							
		
		if(!empty($ownerData)){		
			
			$this->load->model('notification_model');
			
			$token = array($ownerData->deviceToken);
		
		   $row = array('notficationType'=> $type,'productId' => $data['productId'],'userId' => $data['givenById']);

		   if($ownerData->deviceType==1 && !empty($ownerData->deviceToken)){
			
				$this->notification_model->send_ios($token,$msg,$row);

			}elseif($ownerData->deviceType==2 && !empty($ownerData->deviceToken)){

				$row['message'] = $msg;					 	
				$this->notification_model->send_android($token,$row,$type);
			
			}							
		
			
		}

		return true;
	
	}	//End Function Rating Review

	function gettransaction($id,$type,$page){
		
    	$limit = 6;
		$page1 = $page*$limit;	
		$this->db->select('renter.*,product.id as pId,product.title');
		$this->db->from('renter');
		$this->db->join('product','product.id = renter.productId');	

		if($this->authData->userType == 1){

		   $this->db->where("(renter.ownerId = $id)");

		}else{

			$this->db->where("(renter.userId = $id)");

		}
		if($type=="currentdata"){

			$this->db->where(array('payStatus' => 'complete','reviewStatus' => 'complete'));

		}else{

			$this->db->where(array('reviewStatus !=' => 'complete','requestStatus'=>'complete'));
			$this->db->where("(finishStatus = 'accept' || finishStatus = 'sendInvoice')");

		}
		$this->db->order_by('renter.id','desc');
		$this->db->limit($limit,$page1);	
		$query = $this->db->get();
		
		if($query->num_rows()>0){
			$result = $query->result();				
			foreach($result as $value){

				if( $id == $value->ownerId){

					$id = $value->userId;
				}
				if($this->authData->userType == 2){
					$id = $value->ownerId;
				}
				$user = $this->db->get_where('users',array('id'=>$id))->row();
				$url = base_url().FRONT_THEME."images/defaultUser.jpg";
			    if(!filter_var($user->profileImage, FILTER_VALIDATE_URL) === false) {

			        $url = $user->profileImage;

			    }else if(!empty($user->profileImage)){ 

			      $url = base_url().'uploads/profile/'.$user->profileImage;

			   }
				$value->uId = $user->id;
				$value->firstName = $user->firstName;
				$value->lastName = $user->lastName;
				$value->profileImage = $url;
				$value->rating = !empty($user->rating) ? round($user->rating) : "0.0";
				$adminData = $this->db->get('admin')->row();
				$value->adminFess = $adminData->percentage;
                $imgs = $this->db->select('*')->where(array('productId'=>$value->pId))->get('productImages')->row_array();

                if(!empty($imgs)){
                    if(!empty($imgs['productImage'])){
                        $value->productImage = base_url().'uploads/productImage/'.$imgs['productImage'];
                    }else{
                       $value->productImage = base_url().FRONT_THEME.'images/defaultProduct.png';
                    }
                }else{
                    $value->productImage = base_url().FRONT_THEME.'images/defaultProduct.png';
                }
                $data[] = $value;
            } 
            
			return $data;
		}
		return false;
	}

	function gettransactiontotal($id,$type){
		$total = "0";
		$this->db->select('renter.*,product.id as pId,product.title');
		$this->db->from('renter');
		$this->db->join('product','product.id = renter.productId');	

		if($this->authData->userType == 1){

		   $this->db->where("(renter.ownerId = $id)");

		}else{

			$this->db->where("(renter.userId = $id)");

		}
		if($type=="currentdata"){

			$this->db->where(array('payStatus' => 'complete','reviewStatus' => 'complete'));

		}else{

			$this->db->where(array('reviewStatus !=' => 'complete','requestStatus'=>'complete'));
			$this->db->where("(finishStatus = 'accept' || finishStatus = 'sendInvoice')");

		}
		$this->db->order_by('renter.id','desc');
		$query = $this->db->get();
		
		if($query->num_rows()>0){
			$result = $query->result();				
			foreach($result as $value){

				$t = $value->price+$value->extraPay;
				$total = $t+$total;
            } 
            
		}
		if($this->authData->userType == 1){

			$adminData = $this->db->get('admin')->row();
			$adminFess = $total/$adminData->percentage;
			$total = $total- $adminFess;
		}
		return $total;

	}

	function gettransactionDetail($id){
		
		$this->db->select('renter.*,product.id as pId,product.title,product.condition,product.productAge,product.address');
		$this->db->from('renter');
		$this->db->join('product','product.id = renter.productId');	
		$this->db->where("(renter.id = $id)");
		$query = $this->db->get();
		
		if($query->num_rows()>0){
			$value = $query->row();	
			$id = $this->authData->id;			
				if( $id == $value->ownerId){

					$id = $value->userId;
				}
				if($this->authData->userType == 2){
					$id = $value->ownerId;
				}
				$user = $this->db->get_where('users',array('id'=>$id))->row();
				$url = base_url().FRONT_THEME."images/defaultUser.jpg";
			    if(!filter_var($user->profileImage, FILTER_VALIDATE_URL) === false) {

			        $url = $user->profileImage;

			    }else if(!empty($user->profileImage)){ 

			      $url = base_url().'uploads/profile/'.$user->profileImage;

			   }
				$value->uId = $user->id;
				$value->firstName = $user->firstName;
				$value->lastName = $user->lastName;
				$value->profileImage = $url;
				$value->rating = !empty($user->rating) ? round($user->rating) : "0.0";
				$adminData = $this->db->get('admin')->row();
				$value->adminFess = $adminData->percentage;
				$this->load->model('service_model');
                $value->productImage = $this->service_model->productImage($value->pId);  
            
			return $value;
		}
		return false;
	}

    function timeElapsedString($datetime, $full = false) {

	    $now = new DateTime;
	    $ago = new DateTime($datetime);
	    $diff = $now->diff($ago);

	    $diff->w = floor($diff->d / 7);
	    $diff->d -= $diff->w * 7;

	    $string = array(
	        'y' => 'year',
	        'm' => 'month',
	        'w' => 'week',
	        'd' => 'day',
	        'h' => 'hour',
	        'i' => 'minute',
	        's' => 'second',
	    );
	    foreach ($string as $k => &$v) {
	        if ($diff->$k) {
	            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
	        } else {
	            unset($string[$k]);
	        }
	    }

	    if (!$full) $string = array_slice($string, 0, 1);
	    return $string ? implode(', ', $string) . ' ago' : 'just now';
	} //end function
			
}
