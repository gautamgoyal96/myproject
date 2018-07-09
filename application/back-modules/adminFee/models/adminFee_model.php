<?php
class AdminFee_model extends CI_Model {
	
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

}
?>
