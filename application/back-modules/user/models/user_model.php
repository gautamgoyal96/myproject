<?php
class User_model extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->model('common_model');
	}
	private $renter = "renter";

	function upload_img($image,$folder) {

		$this->makedirs($folder);

		$config = array(
			'upload_path' => '../uploads/'.$folder,
			'allowed_types' => "gif|jpg|png|jpeg",
			'overwrite' => false,
			'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
			'encrypt_name'=>TRUE ,
			'remove_spaces'=>TRUE
		);

	  	$this->load->library('upload',$config);

	  	if(!$this->upload->do_upload($image)){
   			$error = array('error' => $this->upload->display_errors());
			return $error;

		} else {

			$this->load->library('image_lib');
			$folder_thumb = $folder.'/thumb/';
			$this->makedirs($folder_thumb);

			$width = 600;
			$height = 600;

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
			
			$folder_thumb = $folder.'/thumb300/';
			$this->makedirs($folder_thumb);

			$width = 300;
			$height = 300;

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
	function makedirs($folder='', $mode=DIR_WRITE_MODE, $defaultFolder='../uploads')
	{
		if(!@is_dir(FCPATH . $defaultFolder)){
			mkdir(FCPATH . $defaultFolder, $mode);
		}
		
		if(!empty($folder)){
			if(!@is_dir(FCPATH . $defaultFolder . '/' . $folder)){
				mkdir(FCPATH . $defaultFolder . '/' . $folder, $mode);
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

	function getAllOwners($limit,$start,$searchText){

		$this->db->select('*');
		$this->db->from('users');
		$this->db->limit($limit,$start);
		(!empty( $searchText)) ? $this->db->like('firstName', trim($searchText)) : '';
		$this->db->where(array('userType'=>1,'OTP'=>'checked'));
		$this->db->order_by('id','desc');
		$req = $this->db->get();
		
		if($req->num_rows()){
			$res = $req->result();
			return $res;
		}
		return FALSE;
	}

	function getAllCustomers($limit,$start,$searchText){

		$this->db->select('*');
		$this->db->from('users');
		$this->db->limit($limit,$start);
		(!empty( $searchText)) ? $this->db->like('firstName', trim($searchText)) : '';
		$this->db->where(array('userType'=>2,'OTP'=>'checked'));
		$this->db->order_by('id','desc');
		$req = $this->db->get();
		
		if($req->num_rows()){
			$res = $req->result();
			return $res;
		}
		return FALSE;
	}

	function countAllCustomers($searchText) {
		$this->db->where(array('userType'=>2,'OTP'=>'checked'));
		(!empty($searchText)) ? $this->db->like('firstName', trim($searchText)) : '';
		return $this->db->count_all_results("users");
	}
	
	function countAllOwners($searchText) {
		$this->db->where(array('userType'=>1,'OTP'=>'checked'));
		(!empty($searchText)) ? $this->db->like('firstName', trim($searchText)) : '';
		return $this->db->count_all_results("users");
	}

	function activeUsers($id) {

		$res = $this->db->select('status')->where(array('id'=>$id['id']))->get('users');
		
		if($res->num_rows()){
			$status=$res->row();
			if($status->status==1){
				$this->db->where('ownerId',$id['id']);
				$this->db->update('product',array('status'=>0));
				$this->db->where('id',$id['id']);
				$this->db->update('users',array('status'=>0));
				return true;
			} else {
				$this->db->where('ownerId',$id['id']);
				$this->db->update('product',array('status'=>1));
				$this->db->where('id',$id['id']);
				$this->db->update('users',array('status'=>1));
				return true;
			}
		}
		return false;
	}

	function deleteUsers($id) {

		$this->db->where('id',$id);
		$this->db->delete('users');
		$this->db->where('ownerId',$id);
		$this->db->delete('product');
		$this->db->where('ownerId',$id);
		$this->db->delete('renter');
		$this->db->where('userId',$id);
		$this->db->delete('renter');
		$this->db->where('givenById',$id);
		$this->db->delete('ratings');
		$this->db->where('receiveById',$id);
		$this->db->delete('ratings');
		return true;
	}

	function record_countt($table,$where = null, $orwhere = null) {
		
		if(!empty($where)){
			$this->db->where($where);
		}
		if(!empty($orwhere)){
			$this->db->or_where($orwhere);
		}
		return $this->db->count_all_results($table);
	}


	function allBrandName() {

		$res = $this->db->select('*')->where(array('status'=>1))->order_by("brandName", "asc")->get('brand');
		$result = $res->result();
		return $result;
	}

	function allProBrandName($id) {

		$this->db->select('brand.*,product.brandId');
		$this->db->from('brand');
		$this->db->join('product','product.brandId = brand.id');
		$this->db->where('product.categoryId',$id);
		$this->db->group_by('product.brandId');
		$req = $this->db->get()->result_array();

		if(!empty($req)){
			$prvBrand = array_column($req,'brandId');
			$res = $this->db->select('*')->where('status',1)->where_not_in('id', $prvBrand)->order_by("brandName", "asc")->get('brand')->result();			
		}else{
			$prvBrand =0;
			$res = $this->db->select('*')->where(array('status'=>1))->order_by("brandName", "asc")->get('brand')->result();
		}
		return $res;
	}

	function addCategory($data){

		$date = date('Y-m-d H:i:s');
		$result = $this->db->select('id')->where(array('categoryName'=>$data['categoryName']))->get('category');
		
		if($result->num_rows() == 0){

			$catData = array(
				'categoryName'=>$data['categoryName'],
				'crd' => $date,
				'upd'=> $date
			);
			$this->db->insert('category', $catData);
			$lastId = $this->db->insert_id();
			$newdata = array();

			return true;
		}else{
			return false;
		}
	}

	function showCategoryRecord($id) {

		$this->db->select('*')->from('category')->where('id',$id);
		$query = $this->db->get();
		$result = $query->row();
		/*$brandId = $result->brandId;
		if(!empty($brandId)){
			$varr = explode(',', $brandId);
			foreach ($varr as $value) {
				$name = $this->db->select('brandName')->get_where('brand',array('id'=>$value))->row();
				if(!empty($name))
					$sql[] = $name->brandName;
			}
			$result->brandName = implode(',', $sql);
		}*/
		return $result;
	}

	function productBrandData($id){
		//$checkProduct = $this->db->select('brandId')->get_where('product',array('categoryId'=>$id))->result_array();
		$checkProduct = $this->db->select('brandId')->where(array('categoryId'=>$id))->group_by('brandId')->get('product')->result_array();		

		if(!empty($checkProduct)){
			
			$last_names = array_column($checkProduct, 'brandId');

			return $last_names;
		}
	}

	function catOfBrandData($id){
		//$checkProduct = $this->db->select('brandId')->get_where('product',array('categoryId'=>$id))->result_array();
		$checkProduct = $this->db->select('brandId')->where(array('categoryId'=>$id))->get('catOfBrand')->result_array();		

		if(!empty($checkProduct)){
			
			$last_names = array_column($checkProduct, 'brandId');

			return $last_names;
		}else{
			return 0;
		}
	}
	
	function updateCategory($data,$id) {

		$check = $this->db->select('*')->where(array('id !='=> $id,'categoryName'=>$data['categoryName']))->get('category');		
		
		if($check->num_rows() == 0){
			
			$res = $check->row_array();
			$date = date('Y-m-d H:i:s');

			$catData = array(
				'categoryName'=>$data['categoryName'],
				'upd'=> $date
			);			
			
			$this->db->where('id',$id);
			$this->db->update('category',$catData);
			return true;

		}else{
			return false;
		}	
	}

	/*function updateCategory($data,$id) {

		$checkProduct = $this->db->select('brandId')->get_where('product',array('categoryId'=>$id))->result_array();

		$this->db->select('product.id as pId,product.categoryId,product.brandId,category.id as cId,brand.id as bId');
		$this->db->from('product');
		$this->db->join('category','category.id = product.categoryId');
		$this->db->join('brand','brand.id = product.brandId');
		$this->db->where(array('product.categoryId'=>$id));
		$req = $this->db->get();

		echo $this->db->last_query();die;

		if(!empty($checkProduct)){
			foreach ($checkProduct as $value) {
				print_r(explode(',', $value['brandId']));
			}die;
			$check = $this->db->select('*')->where(array('id !='=> $id,'categoryName'=>$data['categoryName']))->get('category');
			if($check->num_rows() == 0){

				$res = $check->row_array();
				$date = date('Y-m-d H:i:s');

				$catData = array(
					'categoryName'=>$data['categoryName'],
					'upd'=> $date
				);
				$this->db->where('id',$id);
				$this->db->update('category',$catData);

				$req = $this->db->select('*')->get_where('catOfBrand',array('categoryId'=>$id))->result_array();
				if(!empty($req)){
					foreach ($req as $value) {
						$this->db->where('categoryId',$value['categoryId']);
						$this->db->delete('catOfBrand');
					}
				}

				$newdata = array();
				$i = 0;
				foreach (explode(',', $data['brandId']) as $value) {
					$newdata[$i] = array(
						'categoryId'=>$id,
						'brandId'=>$value,
						'crd'=>$date,
						'upd'=>$date
					);
					$i++;
				}
				$this->db->insert_batch('catOfBrand',$newdata); 
				
				return true;
			}else{
				return false;
			}	
		}
	}*/

	function getAllCategory($limit,$start,$searchText){

		$this->db->select('*');
		$this->db->from('category');
		$this->db->limit($limit,$start);
		(!empty( $searchText)) ? $this->db->like('categoryName', trim($searchText)) : '';
		$this->db->order_by('id','desc');
		$req = $this->db->get();

		$newData = array();
		if($req->num_rows()){

			$res = $req->result_array();

			foreach ($res as $key => $value) {
				$this->db->select('brand.*,catOfBrand.*');
				$this->db->from('brand');
				$this->db->join('catOfBrand','brand.id = catOfBrand.brandId','left');
				$this->db->where(array('catOfBrand.categoryId'=>$value['id'],'brand.status'=>1));
				$brandDetail = $this->db->get()->result_array();
				
				$brandName = '';
				foreach ($brandDetail as $value) {
					$brandName .= $value['brandName'].", ";
				}
				
				$bName = substr(trim($brandName), 0, -1);			   
			    $res[$key]['brandName'] = $bName;
			}			
			return $res;
		}
		return FALSE;
	}

	function countAllCategory($searchText) {
		(!empty($searchText)) ? $this->db->like('categoryName', trim($searchText)) : '';
		return $this->db->count_all_results("category");
	}

	function activeCategory($id) {

		$res = $this->db->select('status')->where(array('id'=>$id['id']))->get('category');
		
		if($res->num_rows()){
			$status=$res->row();
			if($status->status==1){
				$catStatus = "0";				
			} else {
				$catStatus = "1";
			}
			$this->db->where('id',$id['id']);
			$this->db->update('category',array('status'=>$catStatus));
			$this->db->update('product',array('status'=>$catStatus),array('categoryId'=>$id['id']));

			$upStatus = $this->db->select('categoryId')->get_where('catOfBrand',array('categoryId'=>$id['id']))->result_array();

			if(!empty($upStatus)){				
				foreach ($upStatus as $value) {
					$this->db->update('catOfBrand',array('status'=>$catStatus),array('categoryId'=>$value['categoryId']));
				}
			}
			return $catStatus;
		}
		return false;
	}

	function deleteCategory($id) {

		$checkProduct = $this->db->select('categoryId')->get_where('product',array('categoryId' => $id))->row_array();

		if(empty($checkProduct)){
			$check = $this->db->select('categoryId')->get_where('catOfBrand',array('categoryId'=>$id))->result_array();
			if(!empty($check)){
				foreach ($check as $value) {
					$this->db->where('categoryId',$value['categoryId']);
					$this->db->delete('catOfBrand');
				}
			}
			$this->db->where('id',$id);
			$this->db->delete('category');
			return true;
		}else{
			return false;
		}		
	}

	function addBrand($data){

		$result = $this->db->select('id')->where(array('brandName'=>$data['brandName']))->get('brand');
		
		if($result->num_rows() == 0){
			$this->db->insert('brand', $data);
			return true;
		}else{
			return false;
		}
	}

	function showBrandRecord($id) {

		$this->db->select('*')->from('brand')->where('id',$id);
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}

	function updateBrand($data,$id) {

		$check = $this->db->select('*')->where(array('id !='=> $id,'brandName'=>$data['brandName']))->get('brand');
		if($check->num_rows() == 0){
			$this->db->where('id',$id);
			$this->db->update('brand',$data);
			return true;
		}else{
			return false;
		}
	}

	function getAllBrand($limit,$start,$searchText){

		$this->db->select('*');
		$this->db->from('brand');
		$this->db->limit($limit,$start);
		(!empty( $searchText)) ? $this->db->like('brandName', trim($searchText)) : '';
		$this->db->order_by('id','desc');
		$req = $this->db->get();
		if($req->num_rows()){
			$res = $req->result();
			return $res;
		}
		return FALSE;
	}

	function countAllBrand($searchText) {
		(!empty($searchText)) ? $this->db->like('brandName', trim($searchText)) : '';
		return $this->db->count_all_results("brand");
	}

	function activeBrand($id) {

		$res = $this->db->select('status')->where(array('id'=>$id['id']))->get('brand');
		
		if($res->num_rows()){
			$status=$res->row();
			if($status->status==1){
				$brandStatus = "0";				
			} else {
				$brandStatus = "1";
			}
			$this->db->where('id',$id['id']);
			$this->db->update('brand',array('status'=>$brandStatus));

			$check = $this->db->select('brandId')->get_where('catOfBrand',array('brandId'=>$id['id']))->result_array();
			if(!empty($check)){
				foreach ($check as $value) {
					$this->db->where('brandId',$value['brandId']);
					$this->db->update('catOfBrand',array('status'=>$brandStatus));
				}			
			}
			return $brandStatus;
		}
		return false;
	}

	function deleteBrand($id) {

		$checkProduct = $this->db->select('brandId')->get_where('product',array('brandId' => $id))->row_array();

		if(empty($checkProduct)){
			$check = $this->db->select('brandId')->get_where('catOfBrand',array('brandId'=>$id))->result_array();
			if(!empty($check)){
				foreach ($check as $value) {
					$this->db->where('brandId',$value['brandId']);
					$this->db->update('catOfBrand',array('status'=>0));
				}			
			}
			$this->db->where('id',$id);
			$this->db->delete('brand');
			return true;
		}else{
			return false;
		}
	}

	function allCategoryName() {

		$res = $this->db->select('*')->where(array('status'=>1))->order_by("categoryName", "asc")->get('category');
		$result = $res->result();
		return $result;
	}

	function getAllProduct($limit,$start,$searchText,$bId,$cId,$where,$price,$fromDate,$toDate,$userId=""){

		$var = explode('-', $price);
		if(isset($var[0]) && isset($var[1])){
			$min = $var[0];
			$max = $var[1];
			if($max == 'more'){
				$wherePrice = "totalPrice > ".$min."";	
			}else{
				$wherePrice = "totalPrice BETWEEN ".$min." AND ".$max."";	
			}
			
		} else{
			$min = $max = $wherePrice = '';
		}

		$whereDate = "availStartDate BETWEEN '".$fromDate."' AND '".$toDate."'";

		$this->db->select('product.*,product.status as pStatus,product.id as pId,category.id,category.categoryName,brand.id,brand.brandName');
		$this->db->from('product');
		$this->db->join('category','category.id = product.categoryId');
		$this->db->join('brand','brand.id = product.brandId');
		if($where==1){
			$this->db->join('renter','product.id = renter.productId');
		}
		$this->db->limit($limit,$start);
		(!empty($searchText)) ? $this->db->like('product.title', trim($searchText)) : '';
		if($where==1){
			$this->db->where('renter.requestStatus = 1');
		}
		!empty($bId) ? $this->db->where('product.brandId',$bId) : '';
		!empty($cId) ? $this->db->where('product.categoryId',$cId) : '';
		(!empty($wherePrice)) ? $this->db->where($wherePrice) : '';
		!empty($userId) ? $this->db->where(array('product.ownerId' => $userId)) : '';
		(!empty($fromDate) && !empty($toDate))? $this->db->where($whereDate) : '';
		$this->db->order_by('product.id','desc');
		$req = $this->db->get();
		
		
		if($req->num_rows()){
            $res = $req->result();          
            foreach($res as $value){
                $imgs = $this->db->select('*')->where(array('productId'=>$value->pId))->get('productImages')->row_array();
                  
                if(!empty($imgs)){
                    if(!empty($imgs['productImage'])){
                        $value->productImage = base_url().'../uploads/productImage/'.$imgs['productImage'];
                    }else{
                       $value->productImage = 'http://mindiii.com/ava/themes/admin/assets/images/mob.jpeg';
                    }
                }else{
                    $value->productImage = 'http://mindiii.com/ava/themes/admin/assets/images/mob.jpeg';
                }
                $data[] = $value;
            }              
            return $data;
        }    
		return FALSE;
	}

	function countAllProduct($searchText,$bId,$cId,$where,$price,$fromDate,$toDate,$userId="") {

		$var = explode('-', $price);
		if(isset($var[0]) && isset($var[1])){
			$min = $var[0];
			$max = $var[1];
			if($max == 'more'){
				$wherePrice = "totalPrice > ".$min."";	
			}else{
				$wherePrice = "totalPrice BETWEEN ".$min." AND ".$max."";	
			}
		} else{
			$min = $max = $wherePric = '';
		}

		$whereDate = "availStartDate BETWEEN '".$fromDate."' AND '".$toDate."'";
		if($where==1){
			$this->db->join('renter','product.id = renter.productId');
			$this->db->where('renter.requestStatus = 1');
		}
		!empty($bId) ? $this->db->where('brandId',$bId) : '';
		!empty($cId) ? $this->db->where('categoryId',$cId) : '';
		(!empty($wherePrice)) ? $this->db->where($wherePrice) : '';
		(!empty($fromDate) && !empty($toDate))? $this->db->where($whereDate) : '';
		!empty($userId) ? $this->db->where(array('ownerId' => $userId)) : '';
		(!empty($searchText)) ? $this->db->like('title', trim($searchText)) : '';

		return $this->db->count_all_results("product");
	}

	function activeProduct($id) {
		$res = $this->db->select('status')->where(array('id'=>$id['id']))->get('product');		
		if($res->num_rows()){
			$status=$res->row();
			if($status->status==1){
				$this->db->where('id',$id['id']);
				$this->db->update('product',array('status'=>0));
				return true;
			} else {
				$this->db->where('id',$id['id']);
				$this->db->update('product',array('status'=>1));
				return true;
			}
		}
		return false;
	}

	function deleteProduct($id) {

		$this->db->where('id',$id);
		$this->db->delete('product');
		return true;
	}

	function productDetail($id){

		$this->db->select('product.*,users.id,users.firstName,users.lastName,users.email,users.profileImage,users.rating,users.about,category.id,category.categoryName');
		$this->db->from('product');
		$this->db->join('category','category.id = product.categoryId');
		$this->db->join('users','users.id = product.ownerId');
		$this->db->where('product.id',$id);
		$req = $this->db->get();
		
		if($req->num_rows()){
			$res = $req->row_array();
			$res['isRented'] = $this->db->get_where($this->renter,array('productId'=>$id,'requestStatus' => '1'))->num_rows();

			return $res;
		}
	}

	function getProductImg($id){
		$img = $this->db->select('*')->get_where('productImages',array('productId'=>$id))->result_array();
		if(!empty($img)){
			return $img;
		}
	}

	function getNewRequestList($id){

		$this->db->select('renter.id,renter.userId,renter.productId,renter.bookStartDate,renter.bookEndDate,renter.crd,users.id as uId,users.firstName,users.lastName,users.rating,users.profileImage')->from($this->renter)->join('users','users.id = renter.userId')->order_by('renter.crd','desc')->where(array('renter.requestStatus'=>PENDING,'renter.productId' => $id));
			$req = $this->db->get();

			if(!empty($req->num_rows())){

				$rs = $req->result();

				foreach ($req->result() as $key => $value) {

					//$rs[$key]->profileImage = base_url()."../uploads/profile/54055ffa7b78c33c1a4310f7914e034c.png";

					if (!empty($value->profileImage) && file_exists(base_url()."../uploads/profile/".$value->profileImage)) {

						$rs[$key]->profileImage = base_url().'../uploads/profile/'.$value->profileImage;

					}else if (!empty($value->profileImage) && filter_var($value->profileImage, FILTER_VALIDATE_URL) === TRUE) {

						$rs[$key]->profileImage = $value->profileImage;

					}else  if(!empty($rs->profileImage)){

						$rs[$key]->profileImage = base_url().'../uploads/profile/'.$rs->profileImage;

					}else{
						
						$rs[$key]->profileImage = base_url()."../uploads/profile/54055ffa7b78c33c1a4310f7914e034c.png";

					}

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

	function productRenter($id){

		$this->db->select('renter.id,renter.userId,renter.requestStatus,renter.productId,renter.bookStartDate,renter.bookEndDate,renter.crd,users.id as uId,users.firstName,users.lastName,users.rating,users.profileImage')->from($this->renter)->join('users','users.id = renter.userId')->order_by('renter.crd','desc')->where(array('renter.requestStatus != '=>PENDING,'renter.requestStatus != '=>'reject'))->where(array('renter.requestStatus != '=>REJECT))->where(array('renter.requestStatus != '=>COMPLETE,'renter.productId' => $id));

			$req = $this->db->get();

			if(!empty($req->num_rows())){

				$rs = $req->result();

				foreach ($req->result() as $key => $value) {

					//$rs[$key]->profileImage = base_url()."../uploads/profile/54055ffa7b78c33c1a4310f7914e034c.png";

					if (!empty($value->profileImage) && file_exists(base_url()."../uploads/profile/".$value->profileImage)) {

						$rs[$key]->profileImage = base_url().'../uploads/profile/'.$value->profileImage;

					}else if (!empty($value->profileImage) && filter_var($value->profileImage, FILTER_VALIDATE_URL) === TRUE) {

						$rs[$key]->profileImage = $value->profileImage;

					}else  if(!empty($value->profileImage)){

						$rs[$key]->profileImage = base_url().'../uploads/profile/'.$value->profileImage;

					}else{
						
						$rs[$key]->profileImage = base_url()."../uploads/profile/54055ffa7b78c33c1a4310f7914e034c.png";

					}

					$rs[$key]->fullName = $value->firstName.' '.$value->lastName;
					$rs[$key]->crd = $this->timeElapsedString($value->crd);
					
				}
			
				return $rs;

			}
			return false;
	}

	
}
?>
