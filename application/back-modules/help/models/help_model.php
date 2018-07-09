<?php
class Help_model extends CI_Model {
	function makedirs($folder='', $mode=DIR_WRITE_MODE, $defaultFolder='../uploads/'){

        if(!@is_dir(FCPATH . $defaultFolder)) {

            mkdir(FCPATH . $defaultFolder, $mode);
        }
        if(!empty($folder)) {

            if(!@is_dir(FCPATH . $defaultFolder . '/' . $folder)){
                mkdir(FCPATH . $defaultFolder . '/' . $folder, $mode,true);
            }
        } 
    }
	function countHelpUser(){

		return $this->db->get_where('users',array('helpStatus' =>'1'))->num_rows();

	}//End Function

	function getHelpUserList($limit,$start){

		$this->db->from('users');
		$this->db->limit($limit,$start);		
		$this->db->where(array('helpStatus' =>'1'));
		$req = $this->db->get();
		return $req->result();
	}//End Function

	function getHelpUserDetail($id){
		$res = array();
		$this->db->where(array('id' =>$id));
		$sql = $this->db->select("*")->get('users');

		if($sql->num_rows()):
					
			$res= $sql->row_array();
		endif;
		return $res;
	}//End FUnction	
	function notificationSet($userId,$msg){
		$sql = $this->db->select("*")->where(array('id'=>$userId))->get('users');
		if($sql->num_rows()):
			$user = $sql->row();
			if($user->deviceType==2){
				if(!empty($user->deviceToken)){
				$deviceToken =array($user->deviceToken);
				return $this->notification_model->send_android($deviceToken,$msg);
				}
			}else if($user->deviceType==1){
				if(!empty($user->deviceToken) && $user->deviceToken !='12345'){
					$deviceToken =array($user->deviceToken);
					$r= $this->notification_model->send_ios($deviceToken,$msg['message'],$msg);
					return $r;
				//	print_r($r);die;
				}
				
			}
			
		endif;
		return false;
	}//End Function
	

	function message($data){
		$this->db->insert('message',$data);
		$lastId = $this->db->insert_id();
		$userId = $data['receiverId'];

		if($lastId){
			$msg=array(
				'messageId'=>$lastId,
				'message'=>'Admin: '.$data['message'],
				'title'=>'Message',
				'userId'=>$userId
				); 
			$this->notificationSet($userId,$msg);       
			return true;
		}
		return false;
	}//End function
	function getMessage($userId,$limit=0){
		$data= array();
		$this->db->select("*")->from('message');
		$this->db->where("senderId =$userId OR receiverId=$userId");
		$this->db->order_by("id", "desc");
		($limit==0) ? $this->db->limit('10'):'';
		$sql=$this->db->get();
		if($sql->num_rows()):
			$data =array_reverse($sql->result());
			foreach ($data as $k => $value) {
			$data[$k]->createDate = $this->time_elapsed_string($value->crd);
			}
			
		endif;
		return $data;
	}//End function
	function time_elapsed_string($datetime, $full = false) {
		$now  = new DateTime;
		$ago  = new DateTime($datetime);
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
					's' => 'second'
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
	}//ENd Functrion
	function notifySet(){
		$data= array('status'=>0,'title'=>'','message'=>'','url'=>'');
		$this->db->select("*")->from('message');
		$this->db->where(array('senderType'=>1,'receiverId'=>1));
		$this->db->where('notification',0);
		$this->db->order_by('id','desc');
		$sql=$this->db->get();
		if($sql->num_rows()):
			$note =$sql->row();
			$message = $note->message;
			$fullName = $this->UserName($note->senderId);
			$title = 'Message';
			$url = base_url().'prospect/prospectList/'.$note->senderId.'?section=message';
			$this->db->where('id',$note->id);
			$this->db->update('message',array('notification'=>1));
			$msg = $fullName.": ".$message;
			return json_encode(array('status'=>1,'title'=>$title,'message'=>$msg,'url'=>$url));
		endif;
		return json_encode($data);
	  
	}//ENd FUnction

	function UserName($userId){
		$this->db->select("*")->from('users');
		$this->db->where(array('id'=>$userId));
		$sql=$this->db->get();
		if($sql->num_rows()):
			return $sql->row()->firstName." ".$sql->row()->lastName;
		endif;
		return "";
	}
}//END CLass
