<?php
class User_model extends CI_Model {

	function upload_img($profileImage,$folder){ 
		
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
			'remove_spaces'=>TRUE
		);

	  	$this->load->library('upload',$config);

	  	if(!$this->upload->do_upload('profileImage')){
   			$error = array('error' => $this->upload->display_errors());
			return $error;

		} else {

			$this->load->library('image_lib');
			$folder_thumb = $folder.'/thumb/';
			$this->makedirs($folder_thumb);

			$width = 100;
			$height = 100;

			$image_data = $this->upload->data(); //upload the image

			$resize['source_image'] = $image_data['full_path'];
			$resize['new_image'] = realpath(APPPATH . '../uploads/' . $folder_thumb);
			$resize['maintain_ratio'] = true;
			$resize['width'] = $width;
			$resize['height'] = $height;

			//send resize array to image_lib's  initialize function
			$this->image_lib->initialize($resize);
			$this->image_lib->resize();
			$this->image_lib->clear();

			return $image_data['file_name'];
		}
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


	public function profile($id){
		
		$userDetail = $this->db->select('*')->get_where('users',array('id'=>$id))->row_array();
		if(!empty($userDetail)){
			$rating = $this->db->select_avg('stars')->from('ratings')->where('receiveById',$id)->get()->row_array();				
			$userDetail['stars'] = !empty($rating['stars']) ? $rating['stars'] : '';				
			return $userDetail;
		}
	}

	public function profilegetByChatId($id){

		$ownerDetail = $this->db->select('*')->get_where('users',array('firebaseId'=>$id))->row_array();
		if(!empty($ownerDetail)){

			$url = base_url().FRONT_THEME."images/defaultUser.jpg";
		   if(!filter_var($ownerDetail['profileImage'], FILTER_VALIDATE_URL) === false) {

		        $url = $ownerDetail['profileImage'];

		   }else if(!empty($ownerDetail['profileImage'])){ 

		      $url = base_url().'uploads/profile/'.$ownerDetail['profileImage'];

		   }

		   return array('name'=>$ownerDetail['firstName']." ".$ownerDetail['lastName'],'image'=>$url);
			
		}


	}

	function adminFees(){

		$adminFees = $this->db->get('admin')->row();
		return $adminFees->percentage;
	}

	public function getReviews($id){
			
		$this->db->select('ratings.*,ratings.id as ratingId,users.id as uId,users.firstName,users.lastName,users.profileImage,product.title');
		$this->db->from('ratings');
		$this->db->join('users','users.id = ratings.givenById');
		$this->db->join('product','product.id = ratings.productId');				
		$this->db->where('ratings.receiveById',$id);
		$this->db->order_by('ratings.id','desc');
		$query = $this->db->get();
		if($query->num_rows()>0){
			$result = $query->result();				
			return $result;
		}
	}

	public function getRentedRecord($id,$type){
			
		$this->db->select('renter.*,product.id as pId,product.title,users.id as uId,users.firstName,users.lastName,users.profileImage');
		$this->db->from('renter');
		$this->db->join('product','product.id = renter.productId');	
		if($type=="rented"){

			$this->db->join('users','users.id = renter.userId');
			$this->db->where(array('renter.ownerId'=>$id,'payStatus' => 'complete'));

		}else{

			$this->db->where(array('renter.userId'=>$id,'payStatus' => 'complete'));
			$this->db->join('users','users.id = renter.ownerId');

		}		
		$this->db->order_by('renter.id','desc');
		$query = $this->db->get();
		if($query->num_rows()>0){
			$result = $query->result();				
			foreach($result as $value){
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
	}

	function getUserType($id){
		$req = $this->db->select('userType')->get_where('users',array('id'=>$id))->row_array();
		if(!empty($req)){
			return $req['userType'];
		}
	}

	function latandLong($address){
		
       /* $url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response);
        if(empty($response_a['error_message'])){

	        $lat = $response_a->results[0]->geometry->location->lat;
	        $long = $response_a->results[0]->geometry->location->lng;
			return array('lat' =>$lat ,'long'=>$long);

		}*/
		return array('lat' =>'22.7196' ,'long'=>'75.8577');
	}//End Function 

	function updateuserType($id){


		$data = $this->db->select('userType')->from('users')->where('id',$id)->get();
		$getStatus = $data->row()->userType;
		
		if($getStatus == 1){
			$status = "2";
		}else{
			$status = "1";
		}

		$this->load->model('home/home_model');		

		$this->db->where('id', $id)->update('users',array('userType'=>$status));
		$this->home_model->session_create($id);
		return  $status;
	}

	function _authTokenCheck(){

		$data = $this->db->select('*')->from('users')->where('authToken',$this->session->userdata('authToken'))->get();		
		if($data->num_rows()){

			return true;

		}else{

			return false;
		}

	}

	function proofileUpdate($data){

		$this->db->update("users",$data,array('id'=>$this->session->userdata('id')));
		return true;

	}

	function chatIdUpdate($data){

		$row = $this->db->get_where("users",array('id'=>$this->session->userdata('id'),"firebaseId" => ""))->num_rows();

		if($row){

			$this->db->update("users",$data,array('id'=>$this->session->userdata('id')));
			return true;
		}

	}

	function notifcationCheck(){


		$data = $this->db->select('*')->from('renter')->where(array('ownerId' => $this->session->userdata('id'),'notificationStatus'=>"0"))->get();		
	
		if($data->num_rows()){
			$my1 = array();
			$my = $data->row();
			$userData = $this->db->select('id,firstName,lastName')->get_where('users',array('id'=>$my->userId))->row_array();

			if(!empty($userData)){
				
					$aName = $userData['firstName'].' '.$userData['lastName'];
			}
			$url = base_url('products/viewProduct')."/".$my->productId;
			
			if(($my->requestStatus == "pending" && $my->requestType == "requestToBook" && empty($my->modifyRequestStatus)) || ($my->requestStatus == "accept" && $my->requestType == "bookNow" && empty($my->modifyRequestStatus))){
				
				if($my->requestType == "bookNow"){

					$msg = $aName." instantly book this product now.";

				}else{

					$msg = $aName." send you a request to book this product.";
				}
				$my1 = array("type" => "1",'msg' => $msg ,'url' => $url);


			}else if($my->modifyRequestStatus == "reject"){

				$msg ="Your modification has been rejected";
				$my1 = array("type" => "1",'msg' => $msg ,'url' => $url);



			}else if($my->modifyRequestStatus == "accept" && $my->requestStatus == "accept"){

				$msg = "Your modification has been accepted";
				$my1 = array("type" => "1",'msg' => $msg ,'url' => $url);

				
			}else if($my->requestStatus == "complete" && $my->finishStatus == "pending"){

				$msg = $aName." has been finished the rental service for this product";
				$my1 = array("type" => "1",'msg' => $msg ,'url' => $url);

				
			}else if($my->requestStatus == "complete" && $my->finishStatus == "sendInvoice" && $my->payStatus == "complete" && $my->reviewStatus == "pending"){

				$msg = $aName." payment has been completed";
				$my1 = array("type" => "1",'msg' => $msg ,'url' => $url);

			}else if($my->requestStatus == "complete" && $my->finishStatus == "sendInvoice" && $my->payStatus == "complete" && $my->reviewStatus == "complete"){

				$msg = $aName." has been reviewed your product";
				$my1 = array("type" => "1",'msg' => $msg ,'url' => $url);

				
			}

			$this->db->update('renter',array('notificationStatus'=>'1'),array('id' => $my->id));

			return json_encode($my1);


		}else{


				$data = $this->db->select('*')->from('renter')->where(array('userId' => $this->session->userdata('id'),'notificationStatus'=>"0"))->get();	
				if($data->num_rows()){

					$my = $data->row();
					$userData = $this->db->select('id,firstName,lastName')->get_where('users',array('id'=>$my->ownerId))->row_array();
					if(!empty($userData)){
						
							$aName = $userData['firstName'].' '.$userData['lastName'];
					}
					$url = base_url('products/viewProduct')."/".$my->productId;

					if($my->requestType == "requestToBook" && $my->requestStatus == "accept"  && empty($my->modifyRequestStatus)){

						$msg = $aName." has been accept your request";
						$my1 = array("type" => "1",'msg' => $msg ,'url' => $url);

					}else if($my->requestStatus == "reject" && empty($my->modifyRequestStatus)){

						$msg = $aName." has been reject your request";
						$my1 = array("type" => "1",'msg' => $msg ,'url' => $url);


					}else if($my->requestStatus == "modify"){

						$msg = $aName." has been modify your request";
						$my1 = array("type" => "1",'msg' => $msg ,'url' => $url);
						
					}else if($my->requestStatus == "complete" && $my->finishStatus == "accept"){

						$msg = $aName." has been accepted your finish request for this product";
						$my1 = array("type" => "1",'msg' => $msg ,'url' => $url);
				
					}else if($my->requestStatus == "complete" && $my->finishStatus == "sendInvoice" && $my->payStatus != "complete"){

						$msg = $aName." has been send your invoice for this product";
						$my1 = array("type" => "1",'msg' => $msg ,'url' => $url);
				
					}
					$this->db->update('renter',array('notificationStatus'=>'1'),array('id' => $my->id));

					return json_encode($my1);


				}//User Side
		}		

		return json_encode(array("type" => "0"));

	}
}
?>
