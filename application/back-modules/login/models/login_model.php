<?php
class Login_model extends CI_Model {
	
    
	function login($data)
	{
		$res = $this->db->select('*')->where(array('email'=>$data['email'],'password'=>$data['password']))->get('admin');
		if($res->num_rows() > 0){
			$result = $res->row();

			$sessionData = array(
				'email'=> $result->email,
				'id' => $result->id,
				'back_login'   => true
				);
			
			$this->session->set_userdata($sessionData);

			return $result;
		} else{
			return FALSE;
		}
	}	
}
?>