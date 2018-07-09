<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stripe1_model extends CI_Model {
	
	function addBackAccount($data){
		$chk = $this->db->get_where('stripeDetail',array('userId' => $this->authData->id))->row();
		if(empty($chk)){
			$this->db->insert('stripeDetail',$data);
			$this->db->where(array('id' => $this->authData->id))->update('users',array('bankAccountStatus' => 'yes'));
		}else{
			$this->db->where(array('userId' => $this->authData->id))->update('stripeDetail',$data);
			$this->db->where(array('id' => $this->authData->id))->update('users',array('bankAccountStatus' => 'yes'));
		}
		return true;
	}
	
	
	function getUserIdDetail($userId){
		$data = $this->db->get_where('stripeDetail',array('userId' => $userId))->row_array();
		return $data;
	}

	function gettransactionDetail($id){
		$data = $this->db->get_where('renter',array('id' => $id))->row();
		$adminData = $this->db->get('admin')->row();
		$data->adminFess = $adminData->percentage;
		return $data;
	}

	function updatePayment($requestId,$payment,$tranId,$senderId,$reciverId,$adminPercentage){
		
		$paymentDetail = array(
				'transactionId' => $tranId,
				'senderId' => $senderId,
				'reciverId' => $reciverId,
				'payment' => $payment,
				'requestPostId' => $requestId,
				'adminPercentage' => $adminPercentage,
		);
		$this->db->insert('paymentDetail',$paymentDetail);
		$this->db->update('renter',array('payStatus'=>"complete","transactionId"=>$tranId,'notificationStatus' => "0"),array('id'=>$requestId));

		$type = "Product request";

		$checkRequest = $this->db->select('*')->where(array('id'=>$requestId))->get('renter');

		if($checkRequest->num_rows()!=0){

	
			$check = $checkRequest->row_array();

			$ownerData = $this->db->select('id,firstName,lastName')->get_where('users',array('id'=>$check['userId']))->row_array();

			if(!empty($ownerData)){

				$aName = $ownerData['firstName'].' '.$ownerData['lastName'];

				$msg = $aName." payment has been completed";


				$userData = $this->db->select('id,deviceToken,deviceType')->get_where('users',array('id'=>$check['ownerId']))->row();
							
				
				if(!empty($userData)){		
					
					$this->load->model('notification_model');
					
					$token = array($userData->deviceToken);
				
				   $row = array('notficationType'=> $type,'productId' => $check['productId'],'userId' => $check['ownerId']);

				   if($userData->deviceType==1 && !empty($userData->deviceToken)){
					
						$this->notification_model->send_ios($token,$msg,$row);

					}elseif($userData->deviceType==2 && !empty($userData->deviceToken)){

						$row['message'] = $msg;					 	
						$this->notification_model->send_android($token,$row,$type);
					
					}							
				
					
				}
			}
			return true; 
		}else{
			return false; 
		}
	}

	function adminUpdate($data){

		$this->db->insert('paymentDetail',$data);
		return true;
	}
	
}
