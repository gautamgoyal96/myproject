<?php 
class User_model extends CI_Model {

	private $users = "users";
	private $ratings = "ratings";

	function upload_img($profileImage,$folder)
	{ 
		$this->makedirs($folder);

		$allowed_types = "*"; 
		$config = array(
			'upload_path' => './uploads/'.$folder,
			'allowed_types' => $allowed_types,
			'overwrite' => false,
			//'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
			'encrypt_name'=>TRUE ,
			'remove_spaces'=>TRUE
		);

	  	$this->load->library('upload',$config);

	  	if(!$this->upload->do_upload($profileImage)){
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

	function updateProfile($userData){



		if(!empty($userData['email'])){

			$res = $this->db->select('id')->where(array('email'=>$userData['email'],'id !='=>$this->authData->id))->get($this->users);

			if($res->num_rows() != 0){
				return false;
			}	
		}
		$this->db->where('id',$this->authData->id);
			$this->db->update('users',$userData);

				
			return $this->userInfo(array('id' => $this->authData->id));
	}

	function changePassword($data) {

		if($this->encrypt->decode($this->authData->password)==$data['oldPassword']):

			$this->db->where('id',$this->authData->id);
			$this->db->update('users', array('password'=>$this->encrypt->encode($data['newPassword'])));
			return 'SE';

		else:

			return 'AE';
			
		endif;

	}//End Function
	
	function emailVerifyStatus(){
		$check = $this->db->select('id,firstName,lastName,email,countryCode,contactNo,emailVerified,socialType,authToken,profileImage,bankAccountStatus,notifcationstatus')->get_where($this->users,array('id'=>$this->authData->id));
		
		if(!empty($check)){
			$result = $check->row();
			
			if (!empty($result->profileImage) && filter_var($result->profileImage, FILTER_VALIDATE_URL) === false) {
				$result->profileImage = base_url().UPLOAD_FOLDER.'/profile/'.$result->profileImage;
			}	
			
			return $result;
		} else {
			return false;
		}
	}
	
	function updateUserType($userData){
		
		$this->db->where('id',$this->authData->id);
		$this->db->update($this->users,array('usertype'=>$userData['userType']));
		
		$check = $this->db->select('id,firstName,lastName,email,countryCode,contactNo,emailVerified,userType,socialType,authToken,profileImage,rating,notifcationstatus')->get_where($this->users,array('id'=>$this->authData->id));
		
		if(!empty($check)){
			$result = $check->row();
			
			if (!empty($result->profileImage) && filter_var($result->profileImage, FILTER_VALIDATE_URL) === false) {
				$result->profileImage = base_url().UPLOAD_FOLDER.'/profile/'.$result->profileImage;
			}
			
			$result->fullName = '';
			if(!empty($result->firstName) && !empty($result->lastName)){
				$result->fullName = $result->firstName.' '.$result->lastName;
			}

			$result->rating = round($result->rating);	
			
	/*		$userRating = $this->db->select('AVG(stars) as stars')->where(array('receiveById'=>$result->id))->get($this->ratings)->row_array();
			
			if(!empty($userRating['stars'])){
				
				$result->rating = round($userRating['stars'],1);
			}else{
				
				$result->rating = 0;
			}*/
			
			return $result;
		} else {
			return false;
		}
	}

	function userInfo($where){
		$check = $this->db->select('*')->get_where($this->users,$where);
		
		if(!empty($check)){
			$result = $check->row();
			
			if (!empty($result->profileImage) && filter_var($result->profileImage, FILTER_VALIDATE_URL) === false) {
				$result->profileImage = base_url().UPLOAD_FOLDER.'/profile/'.$result->profileImage;
			}
			
				
			

			return $result;
		} else {
			return false;
		}	
	}

	function getRentedRecord($id,$type){
			
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

	function getReviews($id){
			
		$this->db->select('ratings.*,ratings.id as ratingId,users.id as uId,users.firstName,users.lastName,users.profileImage,product.title');
		$this->db->from('ratings');
		$this->db->join('users','users.id = ratings.givenById');			
		$this->db->join('product','product.id = ratings.productId');			
		$this->db->where('ratings.receiveById',$id);
		$this->db->order_by('ratings.id','desc');
		$query = $this->db->get();
		if($query->num_rows()>0){
			$data = $query->result();
			 foreach ($query->result()  as $key => $res) { 

			 	 $imgs = $this->db->select('*')->where(array('productId'=>$res->productId))->get('productImages')->row_array();
                  
                if(!empty($imgs)){

                    if(!empty($imgs['productImage'])){

                       $data[$key]->productImage = base_url().'uploads/productImage/'.$imgs['productImage'];

                    }else{

                       $data[$key]->productImage = base_url().FRONT_THEME.'images/defaultProduct.png';
                    }
                }else{
                    $data[$key]->productImage = base_url().FRONT_THEME.'images/defaultProduct.png';
                }

                if(!empty($res->profileImage)){
                	
                    if(!filter_var($res->profileImage, FILTER_VALIDATE_URL) === false){

                        $data[$key]->profileImage = $res->profileImage;
                    }else{
                        $data[$key]->profileImage = base_url()."../uploads/profile/".$res->profileImage;
                    }
                }else{

                	$data[$key]->profileImage = base_url().FRONT_THEME.'images/defaultUser.jpg';

                }
            }     				
			return $data;
		}
	}

	function getAdminFee(){

		$adminData = $this->db->get('admin')->row();
		return $adminData->percentage;
		
	}

	function message($data){

		$this->db->insert('message',$data);
		$lastId = $this->db->insert_id();
		if($lastId){
			$this->db->update('users',array('helpStatus' => "1"),array('id'=>$this->authData->id));

			return true;

		}

		return false;
	}//End function
	function getMessage($page){
		$limit = 6;
		$page1 = $page*$limit;	
		$userId = $this->authData->id;
		$data= array();
		$this->db->select("*")->from('message');
		$this->db->where("senderId =$userId OR receiverId=$userId");
		$this->db->order_by("id", "desc");
/*		$this->db->limit($limit,$page1);
*/
		$sql=$this->db->get();
		if($sql->num_rows()):
			$data =array_reverse($sql->result());
			foreach ($data as $k => $value) {

				if($value->postType =="1"){

					$data[$k]->message =base_url().'uploads/chat/'.$value->message;

				}


			}
			
		endif;
		return $data;
	}//End function
	
}
