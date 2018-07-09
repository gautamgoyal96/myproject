<?php
class Faq_model extends CI_Model {
	
	function addFaq($data){

		$date = date('Y-m-d H:i:s');
		$result = $this->db->select('id')->where(array('question'=>$data['question']))->get('faq');
		
		if($result->num_rows() == 0){

			$catData = array(
				'question' => $data['question'],
				'answer' => $data['answer']
			);
			$this->db->insert('faq', $catData);
			return true;
		}else{
			return false;
		}
	}
	
	function updateFaq($data,$id) {

		$check = $this->db->select('*')->where(array('id !='=> $id,'question'=>$data['question']))->get('faq');		
		
		if($check->num_rows() == 0){
			
			$res = $check->row_array();

			$catData = array(
				'question' => $data['question'],
				'answer'=>$data['answer']
			);			
			
			$this->db->where('id',$id);
			$this->db->update('faq',$catData);
			return true;

		}else{
			return false;
		}	
	}

	function showFaqRecord($id) {

		$this->db->select('*')->from('faq')->where('id',$id);
		$query = $this->db->get();
		$result = $query->row();
		return $result;
	}

	function getAllFaq($limit,$start){

		$this->db->select('*');
		$this->db->from('faq');
		$this->db->limit($limit,$start);
		$this->db->order_by('id','desc');
		$req = $this->db->get();

		$newData = array();
		if($req->num_rows()){

			$res = $req->result_array();	
			return $res;
		}
		return FALSE;
	}

	function countAllFaq() {

		return $this->db->count_all_results("faq");

	}

	function activeFaq($id) {

		$res = $this->db->select('status')->where(array('id'=>$id['id']))->get('faq');
		
		if($res->num_rows()){
			$status=$res->row();
			if($status->status==1){
				$catStatus = "0";				
			} else {
				$catStatus = "1";
			}
			$this->db->where('id',$id['id']);
			$this->db->update('faq',array('status'=>$catStatus));
			return true;
		}
		return false;
	}

	function deleteFaq($id) {

		$this->db->where('id',$id);
		$this->db->delete('faq');
		return true;		
	}


}
?>
