<?php
class Verification_model extends CI_Model {

	public function __construct(){
		parent::__construct();
	}

	public function mailverify($id){

		$check = $this->db->select('id')->get_where('users',array('id'=>$id))->row_array();
		if(!empty($check)){
			$uData = array('emailVerified'=>1);
			$this->db->where(array('id'=>$check['id']));
			$this->db->update('users',$uData);
			return true;
		}else{
			return false;
		}
	}
}
?>
