<?php
class Transaction_model extends CI_Model {


	public function getRentedRecord($id,$type){
			
		$this->db->select('renter.*,product.id as pId,product.title');
		$this->db->from('renter');
		$this->db->join('product','product.id = renter.productId');
		if($this->session->userdata('userType') == 1){

		   $this->db->where("(renter.ownerId = $id)");

		}else{

			$this->db->where("(renter.userId = $id)");

		}
		if($type=="currentdata"){

			$this->db->where(array('payStatus' => 'complete','reviewStatus' => 'complete'));

		}else{

			$this->db->where("(payStatus !=  'complete' ||  reviewStatus != 'complete')");
			$this->db->where("(finishStatus = 'accept' || finishStatus = 'sendInvoice')");

		}		
		$this->db->order_by('renter.id','desc');
		$query = $this->db->get();
	
		
		if($query->num_rows()>0){
			$result = $query->result();		
			$total = 0;		
			foreach($result as $value){

				$id = $value->ownerId;
				if($this->session->userdata('userType') == 1){

					$id = $value->userId;
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
				$value->rating = $user->rating;
				$value->profileImage = $url;
                $imgs = $this->db->select('*')->where(array('productId'=>$value->pId))->get('productImages')->row_array();
                $value->myProductForRental = $this->productperHour($value->productForRental);
				$value->crd = $this->timeElapsedString($value->crd);
				$t = $value->price+$value->extraPay; 
				$total = $t+$total;
				$adminData = $this->db->get('admin')->row();
			    $adminFess = $total/$adminData->percentage;
			    if($this->session->userdata('userType') == 1){

					$total = $total - $adminFess;
				}
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
      
			return array('data'=>$data,'total'=>$total);
		}
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

	public function transactionInfo($id){
			
		$this->db->select('*');
		$this->db->from('renter');
		$this->db->where(array('id'=>$id));
		$query = $this->db->get();
		
		if($query->num_rows()>0){

			$result = $query->row();
			$result->myProductForRental = $this->productperHour($result->productForRental);	
			$adminData = $this->db->get('admin')->row();
			$result->adminFess = $adminData->percentage;		            
			return $result;
		}
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
	        'd' => 'Day',
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
?>
