<?php
class Products_model extends CI_Model {
	
	private $product = "product";
	private $renter  = "renter";	
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

	function updateGallery($fileName,$folder)
	{
		//print_r($fileName);die;
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

	
    public function getLatLong($address){ // get lat and long by city name

		//$address = $data['address'];

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
	
	public function getAllCategory(){

		$q = $this->db->select('*')->where('status',1)->order_by('categoryName','ASC')->get('category');
		if($q->num_rows()>0){ 
			return $q->result();
		}
	}
	
	public function searchProduct($limit,$start,$searchArray){
		
		$data = array();
		if(!empty($searchArray['address'])){
			
			$var = $this->getLatLong($searchArray['address']);
	
			$data['latitude'] = $var['latitude'];
			$data['longitude'] = $var['longitude'];
		}
		$wherePrice = '';
		if(!empty($searchArray['prcMin']) && !empty($searchArray['prcMax']) && trim($searchArray['prcMax']) != 5000){
			$wherePrice = "price BETWEEN ".$searchArray['prcMin']." AND ".$searchArray['prcMax']."";
		}elseif(trim($searchArray['prcMax']) == 5000){
			$wherePrice = "(price >= ".$searchArray['prcMax']." OR price >=  ".$searchArray['prcMin'].")";
		}

		if(!empty($data['latitude']) && !empty($data['longitude'])){
			$this->session->set_userdata('latitude', $data['latitude']);
			$this->session->set_userdata('longitude', $data['longitude']);
		}

		/*if(empty($categoryId)){
			$this->session->set_userdata('categoryId', $categoryId);		
		}*/
		
		$lat = $this->session->userdata('latitude');
		$long = $this->session->userdata('longitude');
		//$catId = $this->session->userdata('categoryId');
		
		$distMin = (!empty($searchArray['distMin'])) ? $searchArray['distMin'] : 0;
		$distMax = (!empty($searchArray['distMax'])) ? $searchArray['distMax'] : 20;

		if(!empty($lat) && !empty($long)){
			
			$this->db->select("product.id as pId,product.title,product.price,product.productAge,product.condition,product.availType,product.productForRental,product.brandId as bId ,category.id,brand.id, ( 6371 * acos( cos( radians( ".$lat."  ) ) * cos( radians( product.latitude ) ) * cos( radians( product.longitude ) - radians(".$long.") ) + sin( radians(".$lat.") ) * sin( radians( product.latitude ) ) ) ) AS distance");			
		
		}else{
			$this->db->select('product.id as pId,product.title,product.price,product.productAge,product.condition,product.availType,product.productForRental,product.brandId as bId ,category.id,brand.id'); 
			$this->db->order_by('product.id','desc'); 
		}

		$this->db->from('product');
		$this->db->join('category','category.id = product.categoryId');                     
		$this->db->join('brand','brand.id = product.brandId'); 

		if(empty($searchArray['checkedCat']) && !empty($searchArray['categoryId'])){                  
			!empty($searchArray['categoryId']) ? $this->db->where(array('product.categoryId'=>$searchArray['categoryId'])) : '';
		}

		(!empty($searchArray['radioValue']) && $searchArray['radioValue'] != 'all') ? $this->db->where('product.condition',$searchArray['radioValue']) : '';

		(!empty($searchArray['checkedCat'])) ? $this->db->where_in('product.categoryId', $searchArray['checkedCat']) : '';

		(!empty($searchArray['checkedBrand'])) ? $this->db->where_in('product.brandId', $searchArray['checkedBrand']) : '';
		(!empty($searchArray['title'])) ? $this->db->like('product.title',trim($searchArray['title'])) : '';

		(!empty($wherePrice)) ? $this->db->where($wherePrice) : '';	

		//if($this->session->userdata('userType') == 2){
        	(!empty($this->session->userdata('id'))) ? $this->db->where(array('product.ownerId !='=>$this->session->userdata('id'))) : '';
        //}

        //if($this->session->userdata('userType') == 1){
        	//(!empty($this->session->userdata('id'))) ? $this->db->where(array('product.ownerId'=>$this->session->userdata('id'))) : '';
        //}
		$this->db->where(array('product.status'=>1));
		$this->db->limit($limit,$start); 
		
		if(!empty($lat) && !empty($long)){
			$this->db->having('distance >= ' . $distMin);                     
			$this->db->having('distance <= ' . $distMax);                
			$this->db->order_by('distance'); 
		}		
		$data = $this->db->get();	
/*		echo $this->db->last_query();		
*/		$newData = array();
		if($data->num_rows()){
			
			$detail =  $data->result();
			foreach ($detail as $k => $value) {

				$newData[$k] = array(
					'productId' => $value->pId,
					'title' => $value->title,
					'price' => '$ '.$value->price,
					'productAge' => $value->productAge,
					'condition' => $value->condition,
					'availType' => $value->availType,
					'productForRental' => $value->productForRental
				);

				$my = explode(",", $value->productForRental);
				$newData[$k]['myPerProduct'] = $this->productperHour($my[0]);
				$newData[$k]['isRented'] 	= $this->isRented($value->pId);


				$newData[$k]['distance'] = '';
				if(!empty($value->distance)){
					$newData[$k]['distance'] = round($value->distance,2);
				}
				
				$imgs = $this->db->select('*')->where(array('productId'=>$value->pId))->get('productImages')->row_array();
				
				if(!empty($imgs)){
					if(!empty($imgs['productImage'])){
						$newData[$k]['productImage'] = base_url().'uploads/productImage/'.$imgs['productImage'];
					}else{
					   $newData[$k]['productImage'] = base_url().FRONT_THEME.'images/defaultProduct.png';
					}
				}else{
					$newData[$k]['productImage'] = base_url().FRONT_THEME.'images/defaultProduct.png';
				}				
			}
		}		
		return $newData;				
	}

	function isRented($productId){
		
		$this->db->where(array('requestStatus != ' => "pending"));
		$this->db->where(array('productId'=>$productId,'requestStatus != ' => "reject",'payStatus != ' => COMPLETE));
		$isRented = $this->db->get('renter')->num_rows();
	
		return $isRented ? "$isRented" : "0";
	}

	function countAllProduct($searchArray) {
		//print_r($searchArray['sType']);die();
		$data = array();
		$var = $this->getLatLong($searchArray['address']);
		$data['latitude'] = $var['latitude'];
		$data['longitude'] = $var['longitude'];
		
		$wherePrice = '';
		if(!empty($searchArray['prcMin']) && !empty($searchArray['prcMax']) && trim($searchArray['prcMax']) != 5000){
			$wherePrice = "price BETWEEN ".$searchArray['prcMin']." AND ".$searchArray['prcMax']."";

		}elseif(trim($searchArray['prcMax']) == 5000){
			$wherePrice = "(price >= ".$searchArray['prcMax']." OR price >=  ".$searchArray['prcMin'].")";
		}	

		if(!empty($data['latitude']) && !empty($data['longitude'])){
			$this->session->set_userdata('latitude', $data['latitude']);
			$this->session->set_userdata('longitude', $data['longitude']);
		}

		/*if(!empty($categoryId)){
			$this->session->set_userdata('categoryId', $categoryId);		
		}*/
		
		$lat = $this->session->userdata('latitude');
		$long = $this->session->userdata('longitude');
		//$catId = $this->session->userdata('categoryId');		
		
		$distMin = (!empty($searchArray['distMin'])) ? $searchArray['distMin'] : 0;
		$distMax = (!empty($searchArray['distMax'])) ? $searchArray['distMax'] : 20;

		if(!empty($lat) && !empty($long)){
			$this->db->select("product.id as pId, ( 6371 * acos( cos( radians( ".$lat."  ) ) * cos( radians( product.latitude ) ) * cos( radians( product.longitude ) - radians(".$long.") ) + sin( radians(".$lat.") ) * sin( radians( product.latitude ) ) ) ) AS distance");			

		}else{
			$this->db->select('product.id as pId'); 
			$this->db->order_by('product.id','desc'); 
		}

		$this->db->from('product');
		$this->db->join('category','category.id = product.categoryId');                     
		$this->db->join('brand','brand.id = product.brandId'); 

		if(empty($searchArray['checkedCat']) && !empty($searchArray['categoryId'])){                  
			!empty($searchArray['categoryId']) ? $this->db->where(array('product.categoryId'=>$searchArray['categoryId'])) : '';
		}

		(!empty($searchArray['radioValue']) && $searchArray['radioValue'] != 'all') ? $this->db->where('product.condition',$searchArray['radioValue']) : '';

		(!empty($searchArray['checkedCat'])) ? $this->db->where_in('product.categoryId', $searchArray['checkedCat']) : '';

		(!empty($searchArray['checkedBrand'])) ? $this->db->where_in('product.brandId', $searchArray['checkedBrand']) : '';
		(!empty($searchArray['title'])) ? $this->db->like('product.title',trim($searchArray['title'])) : '';


		(!empty($wherePrice)) ? $this->db->where($wherePrice) : '';	

		//if($this->session->userdata('userType') == 2){
        	(!empty($this->session->userdata('id'))) ? $this->db->where(array('product.ownerId !='=>$this->session->userdata('id'))) : '';
        //}
        //if($this->session->userdata('userType') == 1){
        	//(!empty($this->session->userdata('id'))) ? $this->db->where(array('product.ownerId'=>$this->session->userdata('id'))) : '';
        //}

		$this->db->where(array('product.status'=>1));
		
		if(!empty($lat) && !empty($long)){
				
			$this->db->having('distance >= ' . $distMin);                     
			$this->db->having('distance <= ' . $distMax);                
			$this->db->order_by('distance'); 
		}
		$getD = $this->db->get()->num_rows();		
		return $getD;
	}

	function getCategoryBrands($catIds){	
		
		$this->db->select('brand.*,catOfBrand.*');
		$this->db->from('brand');
		$this->db->join('catOfBrand','catOfBrand.brandId = brand.id');
		$this->db->where_in('catOfBrand.categoryId', $catIds);
		$this->db->where('brand.status',1);
		$this->db->group_by('brand.id');
		$req = $this->db->get();
		if($req->num_rows()){
			$res = $req->result_array();
			return $res;
		}else{
			return false;
		}
	}

	public function viewProduct($pId){

		$q = $this->db->select('*')->from('product')->where('id',$pId)->get();
		if($q->num_rows()>0){

			$row = $q->row();
			if(!empty($row->productImage)){

				$row->productImage = base_url().'uploads/productImage/'.$row->productImage;
			}else{

				$row->productImage = base_url().FRONT_THEME.'images/defaultProduct.png';
			}

			$my = explode(",", $row->productForRental);
			$row->myPerProduct = $this->productperHour($my[0]);
			$userId = $this->session->userdata('id');

			$row->requestStatus = $this->userRequestStatus(array('productId'=>$row->id,'userId' => $userId, 'payStatus != ' => COMPLETE));
			$row->requestData = $this->getNewRequestView($row->id,$row->ownerId,$userId);
			$row->categoryData = $this->db->get_where('category',array('id'=>$row->categoryId))->row();
			$row->userMYRequestStatus = $this->userMYRequestStatus(array('productId'=>$row->id,'userId' => $userId, 'requestStatus != ' => COMPLETE));
			$row->userMYRequestData = $this->userMYRequestData(array('productId'=>$row->id,'userId' => $userId, 'payStatus != ' => COMPLETE));

			return $row;
		}
	}

	function userMYRequestData($where,$a=''){

		$this->db->where($where);
		$isRented = $this->db->get('renter');
		if($isRented->num_rows()){
			$data = $isRented->row();
			$data->myProductForRental = $this->productperHour($data->productForRental);


			return 	$data;

		}else{

			return false;
		}
	}

	function userMYRequestStatus($where,$a=''){

		$this->db->where($where);
		$isRented = $this->db->get('renter');
		if($isRented->num_rows()){

			return $isRented->row()->requestStatus;	

		}else{

			return false;
		}
	}


	function productCheck($where,$a=''){

		$this->db->where($where);
		if(!empty($a)){

			$this->db->where("(`requestStatus` = 'pending' OR `requestStatus` = 'modify')");
		}
		$isRented = $this->db->get('renter')->num_rows();
		
		return $isRented ? "$isRented" : "0";
	}

	function userRequestStatus($where,$a=''){

		$this->db->where($where);
		$isRented = $this->db->get('renter')->num_rows();


		return $isRented ? "1" : "0";	
	}

	public function getProductImages($pId){

		$q = $this->db->select('*')->from('productImages')->where('productId',$pId)->get();
		if($q->num_rows()>0){

			$result = $q->result();
			foreach ($result as $k =>$row) {

				if(!empty($row->productImage)){

					$result[$k]->productImage = base_url().'uploads/productImage/'.$row->productImage;
				}else{

					$result[$k]->productImage = base_url().FRONT_THEME.'images/defaultProduct.png';
				}				
			}
			return $result;
		}
	}

	public function getRelatedProducts($pId){
        
        $this->db->select('id,categoryId,brandId');
        $this->db->from('product');
        $this->db->where(array('id'=>$pId));

        //if($this->session->userdata('userType') == 2){
        	(!empty($this->session->userdata('id'))) ? $this->db->where(array('ownerId !='=>$this->session->userdata('id'))) : '';
        //}
        //if($this->session->userdata('userType') == 1){
        	//(!empty($this->session->userdata('id'))) ? $this->db->where(array('ownerId'=>$this->session->userdata('id'))) : '';
        //}

        $q = $this->db->get();
        if($q->num_rows() > 0){
	        $cId = $q->row()->categoryId;

			$this->db->select('*');
			$this->db->from('product');
			$this->db->where(array('status'=>1,'categoryId'=>$cId ,'id != '=>$pId));
			(!empty($this->session->userdata('id'))) ? $this->db->where(array('ownerId !='=>$this->session->userdata('id'))) : '';
			$query = $this->db->get();
			if($query->num_rows()>0){

				$result = $query->result();
				
				foreach($result as $value){
					$my = explode(",", $value->productForRental);
                	$value->myPerProduct = $this->productperHour($my[0]);
                	$value->isRented   = $this->productCheck(array('productId'=>$pId, 'requestStatus' => ACCEPT));
	                $imgs = $this->db->select('*')->where(array('productId'=>$value->id))->get('productImages')->row_array();
	                  
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
	}
	
	public function getOwnerdetails($pId){
		$req = $this->db->select('id,ownerId')->from('product')->where('id',$pId)->get()->row_array();
		if(!empty($req)){
			$userDetail = $this->db->select('*')->get_where('users',array('id'=>$req['ownerId']))->row_array();
			if(!empty($userDetail)){
				$rating = $this->db->select_avg('stars')->from('ratings')->where('receiveById',$req['ownerId'])->get()->row_array();				
				$userDetail['stars'] = !empty($rating['stars']) ? $rating['stars'] : '';				
				return $userDetail;
			}
		}
	}

	public function getReviews($pId){

		$q = $this->db->select('id,ownerId')->where('id',$pId)->get('product')->row();
		if(!empty($q)){
			$pId = $q->id;
			//$query = $this->db->select('ratings.*,ratings.id as ratingId,users.id as uId,users.*')->from('ratings')->join('users','ratings.givenById = users.id')->where(array('ratings.receiveById'=>$oId))->order_by('ratings.id','desc')->get();
			$this->db->select('ratings.*,ratings.id as ratingId,users.id as uId,users.*,product.id as pId');
			$this->db->from('ratings');
			$this->db->join('users','users.id = ratings.givenById');
			$this->db->join('product','product.id = ratings.productId');
			$this->db->where('product.id',$pId);
			$this->db->order_by('ratings.id','desc');
			$query = $this->db->get();
			if($query->num_rows()>0){
				$result = $query->result();				
				return $result;
			}
		}
	}

	public function countReviews($pId){

		$q = $this->db->select('id,ownerId')->where('id',$pId)->get('product')->row();
		if(!empty($q)){
			$pId = $q->id;

			//$query = $this->db->select('ratings.*,ratings.id as ratingId,users.id as uId,users.*')->from('ratings')->join('users','ratings.givenById = users.id')->where(array('ratings.receiveById'=>$oId))->order_by('ratings.id','desc')->get();
			$this->db->select('ratings.*,ratings.id as ratingId,users.id as uId,users.*,product.id as pId');
			$this->db->from('ratings');
			$this->db->join('users','users.id = ratings.givenById');
			$this->db->join('product','product.id = ratings.productId');
			$this->db->where('product.id',$pId);
			$this->db->order_by('ratings.id','desc');
			$query = $this->db->get();
			if($query->num_rows()>0){
				$result = $query->num_rows();		
				return $result;
			}
		}
	}
	

	function getRequeststatus($where,$a=''){

		$this->db->where($where);
		if(!empty($a)){

			$this->db->where("(`requestStatus` = 'pending' OR `requestStatus` = 'modify')");
		}
		$isRented = $this->db->get('renter')->num_rows();
		
		return $isRented ? "$isRented" : "0";
	}

    function bookProduct($rentData){
		
		$this->db->where(array('productId' => $rentData['productId'],'userId' => $rentData['userId'],'requestStatus' => REJECT));
    	$this->db->delete('renter');
		
    	$this->db->insert('renter',$rentData);
    	
    	$ownerData = $this->db->select('id,firstName,lastName,deviceToken,deviceType')->get_where('users',array('id'=>$rentData['ownerId']))->row_array();

		if(!empty($ownerData)){
			$userData = $this->db->select('id,firstName,lastName')->get_where('users',array('id'=>$rentData['userId']))->row_array();
			$aName = '';
			if(!empty($userData)){
				$aName = $userData['firstName'].' '.$userData['lastName'];
			}
			if($rentData['requestType'] == 1){
			$msg = $aName." has instantly booked your product.";
			}else{
				$msg = $aName." send you a request to book this product.";
			}
			
			$this->load->model('notification_model');

			$token = array($ownerData['deviceToken']);
			$row = array('notficationType'=>"Product request",'productId' => $rentData['productId'],'userId' => $rentData['userId']);
			if($ownerData['deviceType']==1 && !empty($ownerData['deviceToken'])){

				$this->notification_model->send_ios($token,$msg,$row);

			}elseif($ownerData['deviceType']==2 && !empty($ownerData['deviceToken'])){

			 $row['message'] = $msg;
				
				$this->notification_model->send_android($token,$row,'Product request');
			}
		}
    	return true;
    }

    public function allMyProductListing($limit,$start,$id){
		
		$this->db->select('*'); 	
		$this->db->from('product');
		(!empty($id)) ? $this->db->where(array('ownerId'=>$id)) : '';
		$this->db->where(array('status'=>1));
		$this->db->order_by('id','desc'); 
		$this->db->limit($limit,$start);
		$data = $this->db->get();	
		//echo $this->db->last_query();die;	
		$newData = array();
		if($data->num_rows()){
			
			$detail =  $data->result();
			foreach ($detail as $k => $value) {

				$newData[$k] = array(
					'productId' => $value->id,
					'title' => $value->title,
					'price' => '$ '.$value->price,
					'productAge' => $value->productAge,
					'condition' => $value->condition,
					'availType' => $value->availType,
					'productForRental' => $value->productForRental
				);
				$my = explode(",", $value->productForRental);
				$newData[$k]['myPerProduct'] = $this->productperHour($my[0]);
				$newData[$k]['requestStatus'] = $this->userRequestStatus(array('productId' => $value->id, 'requestStatus != ' => COMPLETE));
				$newData[$k]['isRented'] 	= $this->productCheck(array('productId'=>$value->id, 'requestStatus != ' => "pending",'requestStatus != ' => "reject",'payStatus != ' => COMPLETE));

				
				$imgs = $this->db->select('*')->where(array('productId'=>$value->id))->get('productImages')->row_array();
				
				if(!empty($imgs)){
					if(!empty($imgs['productImage'])){
						$newData[$k]['productImage'] = base_url().'uploads/productImage/'.$imgs['productImage'];
					}else{
					   $newData[$k]['productImage'] = base_url().FRONT_THEME.'images/defaultProduct.png';
					}
				}else{
					$newData[$k]['productImage'] = base_url().FRONT_THEME.'images/defaultProduct.png';
				}				
			}
		}		
		return $newData;				
	}


	function productperHour($value){

		switch ($value) {
		 
		    case 1:
		        return "8 Hour";
		        break;
		    case 2:
		        return "12 Hour";
		        break; 
		    case 3:
		        return "24 Hour";
		        break;
		    case 4:
		        return "1 Week";
		        break; 
		    case 5:
		        return "1 Month";
		        break;
		}
	}

	function countAllMyProduct($id) {
	
		(!empty($id)) ? $this->db->where(array('ownerId'=>$id)) : '';
		return $this->db->count_all_results("product");
	}
	
	function getUserDetail(){

		$sql = $this->db->select('id,zipCode')->where(array('id'=>$this->session->userdata('id')))->get('users')->row_array();
		if(!empty($sql)){
			return $sql['zipCode'];
		}
	}
	
	function addProduct($insertdata,$productImage){

		$query = $this->db->select('*')->where(array('status'=>1,'userType'=>1,'id'=>$this->session->userdata('id')))->get('users')->row_array();	
		
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
			$var = $this->getLatLong($insertdata['address']);

			$insertdata['latitude'] = $var['latitude'];
			$insertdata['longitude'] = $var['longitude'];

			if(!empty($insertdata['latitude']) && !empty($insertdata['longitude'])){

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
							$imgData[$i]['crd'] = $date;
							$imgData[$i]['upd'] = $date;							

							$this->db->insert('productImages',$imgData[$i]);
							
							$i++;
						}
					}
					return 'PA'; // product added
				}else{
					echo "sdf";die;
					return false;
				}	
			}else{
				return 'ED'; // empty latlong
			}				
		}else{
			return 'NA'; // not active
		}
	}
	
	function currentRenter($id,$uId){
		$this->db->select('renter.id as rId,renter.requestType,renter.availType,renter.productForRental,renter.userId,renter.requestStatus,renter.requestType,renter.productId,renter.bookStartDate,renter.bookEndDate,renter.price,renter.extraPay,renter.modifyRequestStatus,renter.crd,renter.finishStatus,users.id as uId,users.firstName,users.lastName,users.rating,users.profileImage')->from('renter')->join('users','users.id = renter.userId')->order_by('renter.crd','desc');
		$this->db->where(array('renter.requestStatus !=' => REJECT));
		$this->db->where("(`renter`.`ownerId` = '$uId' AND `renter`.`productId` = '$id')");
		$this->db->where("(`renter`.`requestStatus` = 'accept' OR `renter`.`requestStatus` = 'complete')");
		$this->db->where("(`renter`.`payStatus` = 'pending')");

		$req = $this->db->get();
	
			if(!empty($req->num_rows())){

				$rs = $req->result();

				foreach ($req->result() as $key => $value) {

					if (!empty($value->profileImage) && file_exists(base_url()."../uploads/profile/".$value->profileImage)) {

						$rs[$key]->profileImage = base_url().'../uploads/profile/'.$value->profileImage;

					}else if (!empty($value->profileImage) && filter_var($value->profileImage, FILTER_VALIDATE_URL) === TRUE) {

						$rs[$key]->profileImage = $value->profileImage;

					}else  if(!empty($value->profileImage)){

						$rs[$key]->profileImage = base_url().'../uploads/profile/'.$value->profileImage;

					}else{
						
						$rs[$key]->profileImage = base_url().FRONT_THEME.'images/defaultUser.jpg';

					}

					$rs[$key]->fullName = $value->firstName.' '.$value->lastName;
					$rs[$key]->myProductForRental = $this->productperHour($value->productForRental);
					$rs[$key]->crd = $this->timeElapsedString($value->crd);
					
				}
			
				return $rs;

			}
			return false;
	}


	function allRequest($id,$uId){

		$this->db->select('renter.id as rId,renter.requestType,renter.availType,renter.productForRental,renter.userId,renter.productId,renter.bookStartDate,renter.bookEndDate,renter.price,renter.requestStatus,renter.crd,renter.modifyPrice,renter.extraPay,renter.modifyBookStartDate,renter.modifyBookEndDate,renter.modifyAvailType,renter.modifyRequestStatus,renter.modifyProductForRental,users.id as uId,users.firstName,users.lastName,users.rating,users.profileImage')->from('renter')->join('users','users.id = renter.userId')->order_by('renter.crd','desc');
			$this->db->where(array('renter.requestStatus !=' => REJECT));
			$this->db->where(array('renter.ownerId'=>$uId,'renter.productId' => $id,'renter.requestStatus' => PENDING));
			$this->db->or_where("(`renter`.`requestStatus` = 'modify' AND `renter`.`modifyRequestStatus` = 'pending' AND `renter`.`ownerId` = '$uId' AND `renter`.`productId` = '$id')");
			$req = $this->db->get();

			if(!empty($req->num_rows())){

				$rs = $req->result();

				foreach ($req->result() as $key => $value) {

					if (!empty($value->profileImage) && file_exists(base_url()."../uploads/profile/".$value->profileImage)) {

						$rs[$key]->profileImage = base_url().'../uploads/profile/'.$value->profileImage;

					}else if (!empty($value->profileImage) && filter_var($value->profileImage, FILTER_VALIDATE_URL) === TRUE) {

						$rs[$key]->profileImage = $value->profileImage;

					}else  if(!empty($value->profileImage)){

						$rs[$key]->profileImage = base_url().'../uploads/profile/'.$value->profileImage;

					}else{
						
						$rs[$key]->profileImage = base_url().FRONT_THEME.'images/defaultUser.jpg';


					}

					$rs[$key]->fullName = $value->firstName.' '.$value->lastName;
					$rs[$key]->myProductForRental = $this->productperHour($value->productForRental);
					$rs[$key]->crd = $this->timeElapsedString($value->crd);
					
				}
				return $rs;

			}
			return false;
	}

	function getNewRequestView($id,$oId,$uId){

		
		$this->db->select('id as rId,requestStatus,crd,modifyPrice,modifyBookStartDate,modifyBookEndDate,modifyAvailType,modifyRequestStatus,modifyProductForRental')->from($this->renter);
		$this->db->where(array('productId' => $id,'userId' => $uId,'ownerId' => $oId,'requestStatus'=>MODIFY,'modifyRequestStatus' => PENDING));	
		$req = $this->db->get();
			
		if(!empty($req->num_rows())){

			$rs = $req->row();

				
			return $rs;

		}

	}

	function previousRequest($id,$uId){

		$this->db->select('renter.id,renter.requestType,renter.availType,renter.productForRental,renter.price,renter.userId,renter.productId,renter.bookStartDate,renter.bookEndDate,renter.extraPay,renter.crd,users.id as uId,users.firstName,users.lastName,users.rating,users.profileImage')->from('renter')->join('users','users.id = renter.userId')->order_by('renter.crd','desc')->where(array('renter.payStatus'=>COMPLETE,'renter.productId' => $id,'renter.ownerId' => $uId));
			$req = $this->db->get();

			if(!empty($req->num_rows())){

				$rs = $req->result();

				foreach ($req->result() as $key => $value) {


					if (!empty($value->profileImage) && file_exists(base_url()."../uploads/profile/".$value->profileImage)) {

					$rs[$key]->profileImage = base_url().'../uploads/profile/'.$value->profileImage;

					}else if (!empty($value->profileImage) && filter_var($value->profileImage, FILTER_VALIDATE_URL)) {

						$rs[$key]->profileImage = $value->profileImage;

					}else  if(!empty($value->profileImage)){

						$rs[$key]->profileImage = base_url().'../uploads/profile/'.$value->profileImage;

					}else{
						
						$rs[$key]->profileImage = base_url().FRONT_THEME.'images/defaultUser.jpg';


					}

					$rs[$key]->myProductForRental = $this->productperHour($value->productForRental);
					$rs[$key]->fullName = $value->firstName.' '.$value->lastName;
					$rs[$key]->crd = $this->timeElapsedString($value->crd);
				}
				
				return $rs;


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
	
	function requestUpdate($productId,$requestId,$requestStatus,$requestDate,$requestEndDate,$availType,$price,$slot,$modifyStatus,$finishstatus,$extrapayment){


	
		$type = "Request Update";

		$checkRequest = $this->db->select('*')->where(array('id'=>$requestId))->get('renter');

		if($checkRequest->num_rows()!=0){

	
			$check = $checkRequest->row_array();

			$ownerData = $this->db->select('id,firstName,lastName,deviceType,deviceToken')->get_where('users',array('id'=>$check['ownerId']))->row_array();

			if(!empty($ownerData)){

				$aName = $ownerData['firstName'].' '.$ownerData['lastName'];

				if($requestStatus=="accept"){

					$this->db->update('renter',array('requestStatus' => 'accept','notificationStatus' => "0"),array('id' => $requestId));
					$msg = $aName." has accepted your request";
					$this->requestAllReject($productId,$requestId,$check['bookStartDate'],$check['bookEndDate']);

				}else if($requestStatus=="reject"){

					$this->db->update('renter',array('requestStatus' => 'reject','notificationStatus' => "0"),array('id' => $requestId));
					$msg = $aName." has rejected your request";

				}else if($requestStatus=="complete"){



					switch ($finishstatus) {
							case ACCEPT:

								$this->db->update('renter',array('requestStatus' => COMPLETE,'finishStatus'=>$finishstatus,'notificationStatus' => "0",'bookEndDate'=>date("Y-m-d"),'bookEndTime'=>date("H:i:s")),array('id' => $requestId));
								$msg = $aName." has accepted your finish request for this product";

							break;

							case REJECT:

								$this->db->update('renter',array('requestStatus' => ACCEPT,'finishStatus'=>'','notificationStatus' => "0"),array('id' => $requestId));
								$msg = $aName." has rejected your finish request for this product";
							
							break;

							case 'sendInvoice':

								$this->db->update('renter',array('requestStatus' => COMPLETE,'finishStatus' => 'sendInvoice','extraPay'=>$extrapayment,'notificationStatus' => "0"),array('id' => $requestId));
								$msg = $aName." has sent you a invoice for this product";

							break;

							default:
								$type = "Product request";
								$this->db->update('renter',array('requestStatus' => COMPLETE,'bookEndDate'=>date("Y-m-d"),'bookEndTime'=>date("H:i:s"),'finishStatus'=>$finishstatus,'notificationStatus' => "0"),array('id' => $requestId));
								$msg = $aName." has finished the rental service for this product";

							break;

					}

					if($requestStatus==COMPLETE && $finishstatus==ACCEPT && $type != "1"){

						$msg = $aName." has finished the rental service for this product";
					}
				}else if($requestStatus=="modify"){




					if($modifyStatus){

						switch ($modifyStatus) {
							case ACCEPT:

								$type = "User modification";
								$my = array();
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

								if(!empty($check['modifyAvailType']))
									$my['availType'] = $check['modifyAvailType'];		

								$my['modifyBookStartDate']  = $my['modifyBookEndDate'] =$my['modifyPrice'] = $data_val['modifyAvailType'] = $my ['modifyProductForRental'] = $my ['modifyBookEndTime'] = $my ['modifyBookStartTime'] = $my ['modifyRequestStatus'] = '';							
								$my ['modifyRequestStatus'] = $my['requestStatus']= 'accept';
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

						$data['requestStatus'] = $requestStatus;
						$data['modifyRequestStatus'] = 'pending';
						$data['modifyBookStartDate'] = $requestDate;
						$data['modifyBookEndDate'] = $requestEndDate;
						$data['modifyAvailType'] = $availType;
						$data['modifyPrice'] = $price;
						$data['modifyProductForRental'] = $slot;
						$data['notificationStatus'] = "0";
						$this->db->update($this->renter,$data,array('id' => $requestId));
						$msg = $aName." has modified your request";
					}	



				}

				$userData = $this->db->select('id,deviceToken,deviceType')->get_where('users',array('id'=>$check['userId']))->row();
							
				
				if(!empty($userData)){		
					
					$this->load->model('notification_model');

					

					if(!empty($finishstatus) && $finishstatus==PENDING){

						$token = array($ownerData['deviceToken']);


					   $row = array('notficationType'=> $type,'productId' => $check['productId'],'userId' => $check['userId']);

					   if($ownerData['deviceType']==1 && !empty($ownerData['deviceToken'])){
						
							$this->notification_model->send_ios($token,$msg,$row);
 
						}elseif($ownerData['deviceType']==2 && !empty($ownerData['deviceToken'])){

							$row['message'] = $msg;					 	
							$this->notification_model->send_android($token,$row,$type);

						}
						
					}else if(($requestStatus=="modify") && ($modifyStatus=="accept" || $modifyStatus=="reject")){

						$token = array($ownerData['deviceToken']);

					   $row = array('notficationType'=> $type,'productId' => $check['productId'],'userId' => $check['userId']);

					   if($ownerData['deviceType']==1 && !empty($ownerData['deviceToken'])){
						
							$this->notification_model->send_ios($token,$msg,$row);
 
						}elseif($ownerData['deviceType']==2 && !empty($ownerData['deviceToken'])){

							$row['message'] = $msg;					 	
							$this->notification_model->send_android($token,$row,$type);

						}
						
					}else{

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
			}
			return true; 
		}else{
			return false; 
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
				}

			}

		}


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

	function paymentComplete($productId,$requestId){


	
		$type = "Product request";

		$checkRequest = $this->db->select('*')->where(array('id'=>$requestId))->get('renter');

		if($checkRequest->num_rows()!=0){

	
			$check = $checkRequest->row_array();

			$ownerData = $this->db->select('id,firstName,lastName')->get_where('users',array('id'=>$check['userId']))->row_array();

			if(!empty($ownerData)){

				$aName = $ownerData['firstName'].' '.$ownerData['lastName'];

				$this->db->update('renter',array('payStatus' => 'complete','notificationStatus' => "0",'transactionId' => (rand(10, 99)).(rand(11, 99)).(rand(21, 99))),array('id' => $requestId));
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

	function adminFees(){

		$adminFees = $this->db->get('admin')->row();
		return $adminFees->percentage;
	}


	function updateProduct($data,$id){

		$this->db->update($this->product,$data,array('id'=>$id));
		return true;
	}

	function postRatingReview($data,$requestId) {

		$data['givenById'] = $this->session->userdata('id');
		$userData = $this->db->select('id,firstName,lastName')->get_where('users',array('id'=>$data['givenById']))->row_array();
			
		$type = "Product request";
		$req = $this->db->select('*')->where(array("productId"=>$data['productId'],"givenById"=>$data['givenById']))->get('ratings');
		 if($req->num_rows()){

	 		$this->db->where(array('id'=>$req->row()->id));
			$this->db->update('ratings', $data);

		}else{

			$this->db->insert('ratings',$data);
		}

		$this->db->update('renter', array('reviewStatus'=>COMPLETE,'notificationStatus' => "0"),array('id'=>$requestId));
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

		$aName = $userData['firstName'].' '.$userData['lastName'];		
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
}
