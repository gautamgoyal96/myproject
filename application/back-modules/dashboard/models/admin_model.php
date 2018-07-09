<?php
class Admin_model extends CI_Model {
	
    function admin_profile($id) {

		$this->db->select('*')->from('admin')->where('id',$id);
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}

	function update_profile($data,$id) {

		$this->db->where(array('id' =>$id));
		$this->db->update('admin',$data);
		return true;
	}

	function countOwners(){
        $res = $this->db->select('id')->where(array('status'=>1,'userType'=>1,'otpVerified !=' => 0))->get('users');
		return $res->num_rows();
	} 

	function countCustomers(){

		$res = $this->db->select('id')->where(array('status'=>1,'userType'=>2,'otpVerified !=' => 0))->get('users');
		return $res->num_rows();
	} 

	function countCategory(){
		
        $res=$this->db->select('id')->where(array('status'=>1))->get('category');
      	return $res->num_rows();
	}

	function countProduct(){
		
        $res=$this->db->select('id')->where(array('status'=>1))->get('product');
      	return $res->num_rows();
	}
}
?>
