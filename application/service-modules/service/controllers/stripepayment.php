<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
include APPPATH.'third_party/stripe/vendor/autoload.php';

class Stripepayment extends Rest_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model('product_model');
		$this->load->model('stripe1_model');
		$this->load->model('notification_model');
		$this->load->library('stripe');
	}
	
	function addBackAccount_post(){


		
		$admin = 0;

		$holderName        = $this->input->post('holderName');
		$dob               = $this->input->post('dob') ? $this->input->post('dob') : '';
		$country           = $this->input->post('country');
		$currency          = $this->input->post('currency');
		$routingNumber     = $this->input->post('routingNumber');
		$accountNo         = $this->input->post('accountNo');
		$saveDetail        = $this->input->post('saveDetail');
		$accountHolderType = $this->input->post('accountHolderType')? $this->input->post('accountHolderType') : 'individual';
		$address           = !empty($this->input->post('address')) ? $this->input->post('address') : "";
		$postalCode        = !empty($this->input->post('postalCode')) ? $this->input->post('postalCode') : "";
		$city              = !empty($this->input->post('city')) ? $this->input->post('city') : "";
		$state             = !empty($this->input->post('state')) ? $this->input->post('state') : "";
		$ssnLast           = !empty($this->input->post('ssnLast')) ? $this->input->post('ssnLast') : "";
		
		$id = $this->input->post('id');
		
		if(isset($id) && !empty($id)){

				$payStatus = $this->product_model->gettransactionDetail($id);
				$t = $payStatus->price + $payStatus->extraPay;
				$adminFee =  $t/$payStatus->adminFess;	
				$payment = round($t,2);
				$ck = $this->stripe1_model->getUserIdDetail($payStatus->ownerId);

		}


	
	
		if(isset($ck) && isset($ck['customerId']) && empty($ck['customerId'])){
			$customerId = $ck['customerId'];
		}else{
		
		

			if(empty($id)){

			
				$result = $this->stripe->save_bank_account_id($holderName,$dob,$country,$currency,$routingNumber,$accountNo,$address,$postalCode,$city,$state,$ssnLast);
				
				if(!empty($result) && is_string($result)){

					$this->session->set_flashdata('success',$result);
					$response = array('status'=> FAIL ,'message' => $result);
					$this->response($response);

				}

			}

			if($saveDetail == 1){
				$StripToBank['bankAccId'] = $result['id'];
				$StripToBank['userId']    = $this->authData->id;
			
				$res = $this->stripe1_model->addBackAccount($StripToBank);
				$this->session->set_flashdata('success', "Bank information has been added successfully");
				$response = array('status'=> SUCCESS ,'message' => ResponseMessages::getStatusCodeMessage(200));
				$this->response($response);

			}
			
				
			
			$StripToBank = $this->stripe->createBankToken($country,$currency,$holderName,$accountHolderType,$routingNumber,$accountNo);


		}




			if($saveDetail == 1){
				
				$StripToBank['bankAccId'] = $result['id'];
				$StripToBank['userId']    = $this->authData->id;
			
				$res = $this->stripe1_model->addBackAccount($StripToBank);
				$this->session->set_flashdata('success', "Bank information has been added successfully");
				$response = array('status'=> SUCCESS ,'message' => ResponseMessages::getStatusCodeMessage(200));
				$this->response($response);

			}else{
					

				$StripToBank['userId']    = $this->authData->id;			

		
				if(isset($payment) && !empty($payment)){

					/*  User payment */
		
					$StripToBank = $this->stripe->createBankToken($country,$currency,$holderName,$accountHolderType,$routingNumber,$accountNo);
			

					$customerId = $StripToBank['customerId'];

					$resu = $this->stripe->pay_by_card_id($payment*100,$customerId);
						
					if(!empty($resu) && is_string($resu)){

						$this->session->set_flashdata('success',$resu);
						$response = array('status'=> FAIL ,'message' => $resu);
						$this->response($response);

					}
					$tranId = $resu->balance_transaction;
					$updatePayStatus = $this->stripe1_model->updatePayment($id,$payment,$tranId,$payStatus->userId,$payStatus->ownerId,$payStatus->adminFess);

		
					/*  User payment */
					/*   Owner payment */
					$t = $payStatus->price + $payStatus->extraPay;
					$adminFee =  $t/$payStatus->adminFess;	
					$payment = $t-$adminFee;
					$p = round($payment,0);
				

					$userDetial = $this->stripe1_model->getUserIdDetail($payStatus->ownerId);
					$pay = round($payment,0);
					$fRes = $this->stripe->owner_pay_byBankId(array('amount'=>$pay*100,'bankAccId'=>$userDetial['bankAccId'],"currency"=>"usd"));
					

					$d = $this->stripe->pay_by_bank_id($userDetial['bankAccId'],$p);
						
					$updatetable['payment'] = $payment;
					$updatetable['transactionId'] = $d->balance_transaction;
					$updatetable['paymentType'] = "admin";
					$updatetable['requestPostId'] = $id;
					$updatetable['reciverId'] = $payStatus->ownerId;
					$adminUpdate = $this->stripe1_model->adminUpdate($updatetable);	

					/*   Owner payment */	
					$response = array('status'=> SUCCESS ,'message' => ResponseMessages::getStatusCodeMessage(143));
					$this->session->set_flashdata('success', ResponseMessages::getStatusCodeMessage(143));



				}
			}


		$this->response($response);
	}

	function testAccount_post(){
		$holderName = "Ekene Nwobodo";
		$dob = "1993-08-13";
		$country = "US";
		$currency = "USD";
		$routingNumber = "061000227";
		$accountNo = "6581754881";
		$address = "2200 parklake dr ne, apt 1361";
		$city = "Atlanta";
		$state = "Georgia";
		$ssnLast = "4921";
		$accountHolderType = "individual";
		$postalCode = "30345";
		$result = $this->stripe->save_bank_account_id($holderName,$dob,$country,$currency,$routingNumber,$accountNo,$address,$postalCode,$city,$state,$ssnLast);
		$response = array('status'=> FAIL ,'message' => $result);
		$this->response($response);
	}

	function testApplePay_post(){

	  $token = $this->input->post('token');
      $test = $this->stripe->pay_byCardId(0.5*100,$token);
      print_r($test);
      die();

      return $test;

    }


	function addCardAccount12_post(){
		
			
			$fRes = $this->stripe->owner_pay_byBankId(array('amount'=>"0.6",'bankAccId'=>"acct_1BBeYHBMN46punhv","currency"=>"usd"));
			print_r($fRes);

			
	}

	function applePay_post(){
		$admin = 0;
		$requestId = $this->input->post('id');
		$payStatus = $this->stripe1_model->gettransactionDetail($requestId);
		$t = $payStatus->price + $payStatus->extraPay;
		$adminFee =  $t/$payStatus->adminFess;	
		$payment = round($t,2);


		
		$ck = $this->stripe1_model->getUserIdDetail($payStatus->ownerId);
	
		if(!empty($ck) && !empty($ck['bankAccId'])){

			$token = $this->input->post('token');

			$saveDetail = !empty($this->input->post('saveDetail')) ? $this->input->post('saveDetail') : "0";
			if(!empty($token)){
				
				if($saveDetail==1){

					$res = $this->stripe1_model->addBackAccount(array('userId' => $this->authData->userId,'cardId' => $token));

				}

					
			
				/*  User payment */
				$fRes = $this->stripe->pay_byCardId($payment*100,$token);

				$tranId = !empty($fRes->balance_transaction) ? $fRes->balance_transaction : "";
				$updatePayStatus = $this->stripe1_model->updatePayment($requestId,$payment,$tranId,$payStatus->userId,$payStatus->ownerId,$payStatus->adminFess);


				/*  User payment */
				/*   Owner payment */

					$payment = $t-$adminFee;
					$pay = round($payment,2);
					$fRes = $this->stripe->owner_pay_byBankId(array('amount'=>$pay,'bankAccId'=>$ck['bankAccId'],"currency"=>"usd"));
					

					$updatetable['payment'] = $payment;
					$updatetable['transactionId'] = !empty($fRes->balance_transaction) ? $fRes->balance_transaction : "";
					$updatetable['paymentType'] = "admin";
					$updatetable['requestPostId'] = $requestId;
					$updatetable['reciverId'] = $payStatus->ownerId;
					$adminUpdate = $this->stripe1_model->adminUpdate($updatetable);

				/*   Owner payment */
				$response = array('status'=> SUCCESS ,'message' => ResponseMessages::getStatusCodeMessage(143));
				$this->session->set_flashdata('success', ResponseMessages::getStatusCodeMessage(143));
				

			}else{

				$response = array('status'=> FAIL ,'message' => $result);
				$this->session->set_flashdata('success', $result);
			}
		}else{
			
			$response = array('status'=> FAIL ,'message' => "Owner Bank account detail is invalid");

		}
		$this->response($response);

	}

	function addCardAccount_post(){
		
		$admin = 0;
		
		$requestId = $this->input->post('id');
		$payStatus = $this->stripe1_model->gettransactionDetail($requestId);

		
		$t = $payStatus->price + $payStatus->extraPay;
		$adminFee =  $t/$payStatus->adminFess;	
		$payment = round($t,2);


		
		$ck = $this->stripe1_model->getUserIdDetail($payStatus->ownerId);
	
		if(!empty($ck) && !empty($ck['bankAccId'])){

			$number     = $this->input->post('number');
			$exp_month  = $this->input->post('exp_month');
			$exp_year   = $this->input->post('exp_year');
			$cvv        = $this->input->post('cvv');
			$saveDetail = $this->input->post('saveDetail');
			
			$result = $this->stripe->addCardAccount($number,$exp_month,$exp_year,$cvv,$saveDetail);



			if(!empty($result) && is_array($result)){
				if($saveDetail==1){

					$res = $this->stripe1_model->addBackAccount(array('userId' => $this->authData->userId,'cardId' => $result['id']));

				}



				/*  User payment */
				$fRes = $this->stripe->pay_byCardId($payment*100,$result['id']);


					
				$tranId = !empty($fRes->balance_transaction) ? $fRes->balance_transaction : "";
				$updatePayStatus = $this->stripe1_model->updatePayment($requestId,$payment,$tranId,$payStatus->userId,$payStatus->ownerId,$payStatus->adminFess);


				/*  User payment */
				/*   Owner payment */

					$payment = $t-$adminFee;
					$pay = round($payment,2);
					$fRes = $this->stripe->owner_pay_byBankId(array('amount'=>$pay,'bankAccId'=>$ck['bankAccId'],"currency"=>"usd"));
					

					$updatetable['payment'] = $payment;
					$updatetable['transactionId'] = !empty($fRes->balance_transaction) ? $fRes->balance_transaction : "";
					$updatetable['paymentType'] = "admin";
					$updatetable['requestPostId'] = $requestId;
					$updatetable['reciverId'] = $payStatus->ownerId;
					$adminUpdate = $this->stripe1_model->adminUpdate($updatetable);

				/*   Owner payment */
				$response = array('status'=> SUCCESS ,'message' => ResponseMessages::getStatusCodeMessage(143));
				$this->session->set_flashdata('success', ResponseMessages::getStatusCodeMessage(143));
				

			}else{
				$response = array('status'=> FAIL ,'message' => $result);
				$this->session->set_flashdata('success', $result);
			}
		}else{
			
			$response = array('status'=> FAIL ,'message' => "Owner Bank account detail is invalid");

		}
		$this->response($response);
	}
}
