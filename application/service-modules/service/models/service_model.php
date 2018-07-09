<?php 
class Service_model extends CI_Model {

	//Generate token for user
	public function _generate_token()
	{
		$this->load->helper('security');
		$salt = do_hash(time().mt_rand());
		$new_key = substr($salt, 0, 20);
		return $new_key;
	}
	
	//Function for check provided token is valid or not
	public function isValidToken($authToken)
	{
		$this->db->select('*');
		$this->db->where('authToken',$authToken);
		if($query = $this->db->get('users')){
			if($query->num_rows() > 0){
				return $query->row();
			}
		}
		
		return FALSE;
	}

	public function upload_img($profileImage,$folder)
	{ 
		$this->makedirs($folder);

		if($profileImage == 'profileImage'){
			$allowed_types = "gif|jpg|png|jpeg|pdf"; 
		} 

		$config = array(
			'upload_path' => 'uploads/'.$folder,
			'allowed_types' => $allowed_types,
			'overwrite' => false,
			'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
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

			$width = 300;
			$height = 300;

			$image_data = $this->upload->data(); //upload the image

			$resize['source_image'] = $image_data['full_path'];
			$resize['new_image'] = realpath(APPPATH . './uploads/thumb/' . $folder_thumb);
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

	//Creates directory 
	public function makedirs($folder='', $mode=DIR_WRITE_MODE, $defaultFolder='/uploads/'){

		if(!@is_dir(FCPATH . $defaultFolder)) {

			mkdir(FCPATH . $defaultFolder, $mode);
		}
		if(!empty($folder)) {

			if(!@is_dir(FCPATH . $defaultFolder . '/' . $folder)){
				mkdir(FCPATH . $defaultFolder . '/' . $folder, $mode,true);
			}
		} 
	}
	
	function time_elapsed_string($datetime, $full = false) {
		$today = time();    
		$createdday= strtotime($datetime); 
		$datediff = abs($today - $createdday);  
		$difftext="";  
		$years = floor($datediff / (365*60*60*24));  
		$months = floor(($datediff - $years * 365*60*60*24) / (30*60*60*24));  
		$days = floor(($datediff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));  
		$hours= floor($datediff/3600);  
		$minutes= floor($datediff/60);  
		$seconds= floor($datediff);  
		//year checker  
		if($difftext=="")  
		{  
			if($years>1)  
				$difftext=$years." years ago";  
			elseif($years==1)  
				$difftext=$years." year ago";  
		}  
		//month checker  
		if($difftext=="")  
		{  
			if($months>1)  
				$difftext=$months." months ago";  
			elseif($months==1)  
				$difftext=$months." month ago";  
		}  
		//month checker  
		if($difftext=="")  
		{  
			if($days>1)  
				$difftext=$days." days ago";  
			elseif($days==1)  
				$difftext=$days." day ago";  
		}  
		//hour checker  
		if($difftext=="")  
		{  
			if($hours>1)  
				$difftext=$hours." hours ago";  
			elseif($hours==1)  
				$difftext=$hours." hour ago";  
		}  
		//minutes checker  
		if($difftext=="")  
		{  
			if($minutes>1)  
				$difftext=$minutes." minutes ago";  
			elseif($minutes==1)  
				$difftext=$minutes." minute ago";  
		}  
		//seconds checker  
		if($difftext=="")  
		{  
			if($seconds>1)  
				$difftext=$seconds." seconds ago";  
			elseif($seconds==1)  
				$difftext=$seconds." second ago";  
		}  
		return $difftext;  
	}

	public function getAddress($lat,$lng){            //using curl
		//$lat = '22.7533';
		//$lng = '75.8937';
		if(!empty($lat) && !empty($lng)){
			$url = 'http://maps.google.com/maps/api/geocode/json?latlng=' . $lat . "," . $lng .'&sensor=false';
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			$response = curl_exec($ch);
			curl_close($ch);
			$output = json_decode($response);
			if (isset($output->results[0]->formatted_address)) {
				$street = $output->results[0]->formatted_address;
				if(!empty($street)){
					return $street;
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

	function getAddress1($latitude,$longitude){             // using file get content
	    if(!empty($latitude) && !empty($longitude)){
	        //Send request and receive json data by address
	        $geocodeFromLatLong = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=false'); 
	        $output = json_decode($geocodeFromLatLong);
	        $status = $output->status;
	        //Get address from json data
	        $address = ($status=="OK")?$output->results[0]->formatted_address:'';
	        //Return address of the given latitude and longitude
	        if(!empty($address)){				
	            return $address;
	        }else{
	            return false;
	        }
	    }else{
	        return false;   
	    }
	}
	
	public function userInfo($id){

		$res = $this->db->select('id,firstName,lastName,email,countryCode,contactNo,emailVerified,userType,socialType,authToken,profileImage,address,latitude,longitude,about,bankAccountStatus,rating,notifcationstatus,zipCode')->where($id)->get('users');

		if($res->num_rows()){
			$result = $res->row();

/*			$result->rating = rand($result->rating);
*/			
			if (!empty($result->profileImage) && filter_var($result->profileImage, FILTER_VALIDATE_URL) === false) {
				//$result->profileImage = base_url().UPLOAD_FOLDER.'/profile/thumb/'.$result->profileImage;
				$result->profileImage = base_url().UPLOAD_FOLDER.'/profile/'.$result->profileImage;
			}
			/*$result->fullName = '';
			if(!empty($result->firstName) && !empty($result->lastName)){
				$result->fullName = $result->firstName.' '.$result->lastName;
			}*/
			
			
			
			return $result;
		} else {
			return false;
		}
	}

	public function userStatus($where){

		$res = $this->db->select('status')->where($where)->get('users');
		if($res->num_rows()){
			return $res->row()->status;
		}
		return "";
	}


	public function userRegistration($data) {

		$res = $this->db->select('id')->where(array('email'=>$data['email'],'email !='=>''))->get('users');
		if($res->num_rows() == 0) {
			if(!empty($data['socialId']) && !empty($data['socialType'])) {

				$check = $this->db->select('id')->where(array('socialId'=>$data['socialId'],'socialType'=>$data['socialType']))->get('users');
				if($check->num_rows() == 1) {

					$id=$check->row();
					$this->db->update('users',array('deviceToken' => ''),array('deviceToken'=>$data['deviceToken']));
					$this->db->where(array('id'=>$id->id));
					$this->db->update('users',array('authToken'=>$data['authToken'],'deviceToken'=>$data['deviceToken'],'deviceType'=>$data['deviceType']));
					$userDetail['data'] = $this->userInfo(array('id'=>$id->id));					
					$userDetail['regType'] = 'SL';
					return $userDetail;
				} else{
					
					//$data['address'] = $this->getAddress($data['latitude'],$data['longitude']);
					if(empty($data['contactNo'])){
						return "FT";
					}
					
					$getdata = $this->db->select('id')->get_where('users',array('otpVerified'=>0,'countryCode'=>$data['countryCode'],'contactNo'=>$data['contactNo']))->row_array();
					if(!empty($getdata)){
						$this->db->where(array('id'=>$getdata['id']));
						$this->db->update('users',$data);
						$userDetail['data'] = $this->userInfo(array('id'=>$getdata['id']));
						$userDetail['regType'] = 'SR';
						return $userDetail;	
					}else{
						return "CNAE"; 
					}				
				}
			}else{
				$check = $this->db->select('id')->get_where('users',array('countryCode'=>$data['countryCode'],'contactNo'=>$data['contactNo']))->row_array();
				
				if(!empty($check)){
				//	$data['address'] = $this->getAddress($data['latitude'],$data['longitude']);
					$this->db->where(array('id'=>$check['id']));
					$this->db->update('users',$data);
					$userDetail['data'] = $this->userInfo(array('id'=>$check['id']));

					$data_set['link']   = base_url()."verification/mailverify/".base64_encode(base64_encode($check['id']));
					
					$userData['firstName'] = $userDetail['data']->firstName;
		            $userData['lastName'] = $userDetail['data']->lastName;
		            $userData['link'] = $data_set['link'];
		            
		            $message  = $this->load->view('email_verification',$userData,TRUE);
		            
		            $subject = "Email verification";

		           /* $this->smtp_email->send_mail($userDetail['data']->email,$subject,$message);*/
		            $headers = "MIME-Version: 1.0" . "\r\n";
		            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		            $headers .= 'From: AvaRents<avaco@ava.avarents.co>' . "\r\n";
		            $headers .= 'Reply-To: avaco@ava.avarents.co' . "\r\n";
		            $headers .= "X-Mailer: PHP/" . phpversion();
		            mail($userDetail['data']->email,$subject,$message,$headers);

							
					$userDetail['regType'] = 'NR';
					return $userDetail;
				}else{
					return "SGW"; //something going wrong
				}
			}
		} else {
			if(!empty($data['socialId']) && !empty($data['socialType'])) {

				$check = $this->db->select('id')->where(array('socialId'=>$data['socialId'],'socialType'=>$data['socialType']))->get('users');
				if($check->num_rows() == 1)	{

					$id=$check->row();
					$this->db->update('users',array('deviceToken' => ''),array('deviceToken'=>$data['deviceToken']));
					$this->db->where(array('id'=>$id->id));
					$this->db->update('users',array('authToken'=>$data['authToken'],'deviceToken'=>$data['deviceToken'],'deviceType'=>$data['deviceType']));
					$userDetail['data'] = $this->userInfo(array('id'=>$id->id));
					$userDetail['regType'] = 'SL';
					return $userDetail;
				} else{
					return 'AE';
				}
			} else{
				return 'AE';
			}
		}
		return false;
	}

	function userLogin($data,$authToken){

		$res = $this->db->select('*')->where(array('email'=>$data['email']))->get('users');

		if($res->num_rows() > 0){

			$result = $res->row();
			$password = $this->encrypt->decode($result->password);
			if($password == $data['password']){
				if($result->status == 1){//if user is active

					$update_data = array();
						$update_data['deviceToken'] = $data['deviceToken'];
						$update_data['deviceType'] = $data['deviceType'];
						$update_data['authToken'] = $authToken;

					if(!empty($update_data['deviceToken'])){

						$this->db->update('users',array('deviceToken' => ''),array('deviceToken'=>$update_data['deviceToken']));
						$this->db->update('users',$update_data,array('id'=>$result->id));
						$userDetail = $this->userInfo(array('id'=>$result->id));
						return array('type'=>'LS','userDetail'=>$userDetail); //login successfull
					} else{
						$this->db->update('users',array('authToken'=>$data['authToken']),array('id'=>$result->id));
						$userDetail = $this->userInfo(array('id'=>$result->id));
						return array('type'=>'LS','userDetail'=>$userDetail); //login successfull
					}
				}else {
					return array('type'=>'NA','userDetail'=>array()); // not active
				}
			} else {
				return array('type'=>'WP','userDetail'=>array()); //wrong password
			}
		} 
		return false;
	}
	
	public function generateAuthToken(){

    	$authToken = $this->_generate_token();

    	$existToken = $this->common_model->get_records_by_id("users",true,array('authToken'=>$authToken),"*","","");

    	if(!empty($existToken)){
    	 	$this->_generate_token(); 	
    	}else{
    	 	$authToken = $authToken;
    	}
    	return $authToken;
    }

	public function verifyNo($data){
		$id=0;
		$sql = $this->db->select('id')->from('users')->where(array('contactNo'=>$data['contactNo']))->get();
		$authToken = $this->generateAuthToken();
		if($sql->num_rows()){
			$this->db->where(array('contactNo'=>$data['contactNo']));
			$update =$this->db->update('users',array('OTP'=>$data['OTP'],'authToken'=>$authToken,'otpVerified'=>0,'countryCode' => $data['countryCode']));
			if($update):
				$id=$sql->row()->id;
			endif;
		}else{
			$data['authToken'] = $authToken ;
			$this->db->insert('users',$data);
			$id = $this->db->insert_id();
		}
		if($id):
			$this->load->library('twilio');
			$from 	= '+14159972821';
			$to 	= $data['countryCode'].$data['contactNo'];
			$message = "Your AVA Rents verification code is ".$data['OTP'].". Thanks for joining";

			$response = $this->twilio->sms($from, $to, $message);
			if($response->IsError){
				return  array('status'=>0,'error'=>$response->ErrorMessage);
			}else{
				return  array('status'=>1,'otp'=>$data['OTP'],'countryCode'=>$data['countryCode'],'contactNo'=>$data['contactNo']);
			}
		endif;
		return  array('status'=>0,'error'=>'Somting going wrong');
	}

	public function forgotPassword($email){
		$req = $this->db->select('id,firstName,lastName,email,password,socialId,socialType')->where(array('email'=>$email))->get('users');
		if($req->num_rows()){


			$this->load->library('encrypt');
			$res = $req->row();
			
			if($res->socialId!='' && $res->socialType!=''){

				return array('emailType'=>'ES','email'=>'Not able to send a password in your entered email address' ); //ES emailSend

			}
			$useremail= $res->email;
			$password="Forgot Password is :-".$this->encrypt->decode( $res->password) ;
			
			$userData['firstName'] = $res->firstName;
            $userData['lastName'] = $res->lastName;
            $userData['password'] = $password;
            
            $message  = $this->load->view('forgot_password',$userData,TRUE);		            
			$subject = "Ava Forgot Password";
   /*         $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From: AvaRents<avaco@ava.avarents.co>' . "\r\n";
            $headers .= 'Reply-To: avaco@ava.avarents.co' . "\r\n";
            $headers .= "X-Mailer: PHP/" . phpversion();
            mail($useremail,$subject,$message,$headers);*/
			$this->smtp_email->send_mail($useremail,$subject,$message);
			
			return array('emailType'=>'ES','email'=>'Your password has been successfully sent to your email address!!' ); //ES emailSend
		}else{
			return false;
		}
	}//end funtion

	public function emailSent($useremail,$message,$subject){

		$this->load->library('email');

		$config = array();
		$config['useragent']  = "CodeIgniter";
		$config['mailpath']  = "/usr/sbin/sendmail"; // or "/usr/sbin/sendmail"
		$config['protocol'] = "sendmail";
		$config['smtp_host']= "avarents.co";
		$config['smtp_port'] = "25";
		$config['mailtype'] = 'html';
		$config['charset']  = 'utf-8';
		$config['newline']  = "\r\n";
		$config['wordwrap'] = TRUE;

		$this->email->initialize($config);

		$this->email->from('admin@admin.com', 'Ava');
		$this->email->to($useremail);

		$this->email->subject($subject);
		$this->email->message($message);

		if ($this->email->send()) {			
			return  array('emailType'=>'ES','email'=>'Your password has been successfully sent to your email address!!' ); //ES emailSend
		}else{					
			return  array('emailType'=>'NS','email'=> show_error($this->email->print_debugger())) ; //NS NOSend
		}
	}//end function
	
	function getAllCategory(){

		$this->db->select('*');
		$this->db->from('category');
		$this->db->where('status',1);
		$result = $this->db->get();
		$newData = array();
		if($result->num_rows()){
			$catLis = $result->result();
			foreach ($catLis as $k => $value) {
				$newData[$k] = array(
					'id' => $value->id,
					'categoryName' => $value->categoryName
				);
			}
		}
		return $newData;
	}
	
	function getAllBrands(){

		$check = $this->db->select('id,brandName')->order_by('brandName','ASC')->get('brand');
		if($check->num_rows()){

			return $check->result();
		}
		return false;	
	}

	function searchProduct($data){

		$miles = $data['distance'];
		if(!empty($data['latitude']) && !empty($data['longitude'])){
			$this->db->select("product.id as productId,product.title,product.price,product.productForRental,product.availType,product.condition,product.ownerId, ( 6371 * acos( cos( radians( ".$data['latitude']."  ) ) * cos( radians( product.latitude ) ) * cos( radians( product.longitude ) - radians(".$data['longitude'].") ) + sin( radians(".$data['latitude'].") ) * sin( radians( product.latitude ) ) ) ) AS distance");
			$this->db->having('distance <= ' . $miles);                     
			$this->db->order_by('distance'); 

		}else{
			$this->db->select('product.id as productId,product.title,product.price,product.productForRental,product.availType,product.condition,product.ownerId'); 
			$this->db->order_by('product.id','desc'); 
		}
		$this->db->from('product');
		!empty($data['categoryId']) ? $this->db->where(array('product.categoryId'=>$data['categoryId'])) : '';
		!empty($data['userId']) ? $this->db->where(array('product.ownerId !='=>$data['userId'])) : '';
		!empty($data['ownerId']) ? $this->db->where(array('product.ownerId'=>$data['ownerId'])) : '';
		!empty($data['condition']) ? $this->db->where(array('product.condition'=>$data['condition'])) : '';
		if(!empty($data['startPrice'])) {

			if($data['endPrice']>100){

				$this->db->where(array("price > " => $data['endPrice']));


			}else{

				$this->db->where("price BETWEEN ".$data['startPrice']." AND ".$data['endPrice']."");

			}
		 }
		!empty($data['brand']) ? $this->db->where_in('brandId', explode(",",$data['brand'])) : '';
		
		$this->db->where(array('product.status'=>1));
		$row = $this->db->get();
		/*echo $this->db->last_query();
		die();*/

		if($row->num_rows()){
			$detail =  $row->result();

			foreach ($row->result() as $key => $value) {
				$value->distance = "0";
				if(!empty($value->distance))
				$detail[$key]->distance 	= round($value->distance,2);

				$detail[$key]->productImage = $this->productImage($value->productId);
				$detail[$key]->isRented 	= $this->isRented($value->productId);
				$detail[$key]->requestTotal = $this->productCheck(array('productId'=>$value->productId ,'requestType' => RequestToBook),'1');

			}

			return $detail;
			
		}
		return false;
	}

	function productCheck($where,$a=''){

		$this->db->where($where);
		if(!empty($a)){

			$this->db->where("(`requestStatus` = 'pending' OR `requestStatus` = 'modify')");
		}
		$isRented = $this->db->get('renter')->num_rows();
		
		return $isRented ? "$isRented" : "0";
	}

	function isRented($productId){
		
		$this->db->where(array('requestStatus != ' => "pending"));
		$this->db->where(array('productId'=>$productId,'requestStatus != ' => "reject",'payStatus != ' => COMPLETE));
		$isRented = $this->db->get('renter')->num_rows();
	
		return $isRented ? "$isRented" : "0";
	}

	function getProductInfo($data){

		$this->db->select('product.id as productId,product.title,product.price,product.productForRental,product.availType,product.condition,product.availStartDate,product.availEndDate,product.address,product.totalPrice,product.ownerId,product.description,product.instantBooking,product.productAge,product.crd as postedTime,category.categoryName,category.categoryName,category.id')->join('category','product.categoryId = category.id'); 
		$this->db->from('product')->where(array('product.id'=>$data['productId'],'product.ownerId'=>$data['ownerId'],'product.status'=>"1"));
		$row = $this->db->get();
		$value =  $row->row();

		$value->productImage = $this->productImage($value->productId);
		$value->isRented 		= $this->isRented($value->productId);
		$value->requestTotal 		= $this->productCheck(array('productId'=>$value->productId ,'requestType' => RequestToBook),'1');
		$value->ownerDetail = $this->userDetail(array('id'=>$value->ownerId));
		$value->renterData = $this->renterData($value->productId);
		$value->postedTime = $this->time_elapsed_string($value->postedTime);

		$value->requestToBook = $value->bookNow = $value->requestStatus = "";
		$value->instantBooking = !empty($value->instantBooking) ? "ON" : "OFF";
		$value->bookingDate = $this->productBookingDate($value->productId);
		$value->isBookOrRequest ="";
		if(!empty($data['userId'])){
			$value->requestToBook = $this->productCheck(array('productId'=>$value->productId, 'requestType' => RequestToBook,'userId' => $data['userId'], 'requestStatus != ' => COMPLETE));
			$value->bookNow = $this->productCheck(array('productId'=>$value->productId, 'requestType' => BookNow,'userId' => $data['userId'], 'requestStatus != ' => COMPLETE));
			$value->requestStatus = $this->userRequestStatus(array('productId'=>$value->productId,'userId' => $data['userId'], 'reviewStatus != ' => COMPLETE));
			$value->isBookOrRequest 		= $this->productCheck1(array('productId'=>$value->productId,'userId' => $data['userId'], 'requestStatus != ' => COMPLETE));


		}
		

		return $value;

	}

	function productCheck1($where,$a=''){

		$this->db->where($where);
		if(!empty($a)){

			$this->db->where("(`requestStatus` = 'pending' OR `requestStatus` = 'modify')");
		}
		$isRented = $this->db->get('renter')->num_rows();

		return $isRented ? "1" : "0";
	}


	function productBookingDate($id){

		$this->db->select("bookStartDate,bookEndDate,availType");
		$this->db->where(array('requestStatus' => ACCEPT,"productId" => $id));
		$data = $this->db->get('renter');
		$row = array();
		if($data->num_rows()){

			$row = $data->result();

			foreach ($row as $key => $value) {
				$my[$key] = $value->bookStartDate;
				$my[$key] = $value->bookEndDate;
				$my[$key] = $value->availType;
			}
		}
		return $row;
	}

	function userRequestStatus($where,$a=''){

		$this->db->where($where);
		$isRented = $this->db->get('renter');
		
		if($isRented->num_rows()){

			return $isRented->row()->requestStatus;			
		}
		return "";
	}


	function renterData($id){
		$this->db->select("id as requestId,requestType,userId,bookStartDate,bookEndDate");
		$this->db->where(array('requestStatus' => ACCEPT,"productId" => $id));
		$data = $this->db->get('renter');
		if($data->num_rows()){

			$row = $data->row();
				$user = $this->userDetail(array('id'=>$row->userId));
				$row->firstName 	 = $user->firstName;
				$row->lastName 	 = $user->lastName;
				$row->profileImage = $user->profileImage;
				$row->firebaseToken 	 = $user->firebaseToken;
				$row->firebaseId = $user->firebaseId;
				$row->rating 		 = $user->rating;



			return $row;
		}

		return new stdClass;

	}


	function userDetail($id){

		$res = $this->db->select('id as ownerId,firstName,lastName,profileImage,rating,firebaseToken,firebaseId,email,countryCode,contactNo,address,about,bankAccountStatus')->where($id)->get('users');

		if($res->num_rows()){

			$result = $res->row();

			$result->rating = round($result->rating);
			
			if (!empty($result->profileImage) && filter_var($result->profileImage, FILTER_VALIDATE_URL) === false) {

				$result->profileImage = base_url().UPLOAD_FOLDER.'/profile/'.$result->profileImage;

			}
			
			return $result;
		} else {
			return false;
		}
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

	function getProductStatus($id){

		$value = array();
		$value['requestTotal'] 		= $this->productCheck(array('productId'=>$id,'requestType' => RequestToBook),'1');
		
		$value['requestStatus'] = $this->userRequestStatus(array('productId'=>$id, 'reviewStatus != ' => COMPLETE));

		$value['isRented']	= $this->productCheck(array('productId'=>$id, 'requestStatus != ' => "pending",'requestStatus != ' => "reject",'payStatus != ' => COMPLETE));


		return $value;

	}

	function getFaq(){

		$data = $this->db->select('id,question,answer')->get_where('faq',array('status'=>'1'))->result();
		return $data;
		
	}
	
}

