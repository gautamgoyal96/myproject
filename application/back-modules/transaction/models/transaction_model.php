<?php
class transaction_model extends CI_Model {
	
    function getAlltranjactionCount(){

    	$this->db->where(array('payStatus' =>'complete'));
		return $this->db->count_all_results("renter");

	}

	function getAlltranjaction($limit,$start) {

		
		$this->db->select('renter.*,product.id as pId,product.title');
		$this->db->from('renter');
		$this->db->join('product','product.id = renter.productId');
    	$this->db->where(array('payStatus' =>'complete'));
		$this->db->order_by('renter.id','desc');
		$this->db->limit($limit,$start);
		$query = $this->db->get();
	
		
		if($query->num_rows()>0){
			$result = $query->result();		
			$total = 0;		
			foreach($result as $value){

				
				$owner = $this->db->get_where('users',array('id'=>$value->ownerId))->row();			    
				$value->ownerName = $owner->firstName." ".$owner->lastName;

				$user = $this->db->get_where('users',array('id'=>$value->userId))->row();			    
				$value->userName = $user->firstName." ".$user->lastName;
                $imgs = $this->db->select('*')->where(array('productId'=>$value->pId))->get('productImages')->row_array();
                $value->myProductForRental = $this->productperHour($value->productForRental);
				$t = $value->price+$value->extraPay; 
				$total = $t+$total;
				$adminData = $this->db->get('admin')->row();
			    $value->adminFess = $total/$adminData->percentage;
			    $value->adminPercentage = $adminData->percentage;
			    $imgs = $this->db->select('*')->where(array('productId'=>$value->pId))->get('productImages')->row_array();

                if(!empty($imgs)){
                    if(!empty($imgs['productImage'])){
                        $value->productImage = base_url().'../uploads/productImage/'.$imgs['productImage'];
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

}
?>
