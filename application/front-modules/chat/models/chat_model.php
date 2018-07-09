<?php
class Chat_model extends CI_Model {

	public function profile($id){
		
		$userDetail = $this->db->select('*')->get_where('users',array('id'=>$id))->row_array();

		$userDetail['url'] = base_url().FRONT_THEME."images/defaultUser.jpg";
	   if(!filter_var($userDetail['profileImage'], FILTER_VALIDATE_URL) === false) {

	        $userDetail['url'] = $userDetail['profileImage'];

	   }else if(!empty($userDetail['profileImage'])){ 

	      $userDetail['url'] = base_url().'uploads/profile/'.$userDetail['profileImage'];

	   }

	  return $userDetail;
		
	}
}
?>
