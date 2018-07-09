<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);

class Stripe{

    public function __construct () {
        $this->ci =& get_instance();
        $this->ci->config->load('stripeconfig');
        $secret_key = $this->ci->config->item('secret_key');
        $publishable_key = $this->ci->config->item('publishable_key');
        
    }
    
    function createBankToken($country,$currency,$accountHolderName,$accountHolderType,$routingNumber,$accountNo){

         try {
                

                $secret_key = $this->ci->config->item('secret_key');
                Stripe\Stripe::setApiKey($secret_key);

                $bankTok = \Stripe\Token::create(array(
                    "bank_account" => array(
                        "country" => $country,
                        "currency" => $currency,
                        "account_holder_name" => $accountHolderName,
                        "account_holder_type" => $accountHolderType,
                        "routing_number" => $routingNumber,
                        "account_number" => $accountNo
                    )
                ));



                if(isset($bankTok->id) && !empty($bankTok->id)){
                    $data['bankId'] = $bankTok->id;
                    $b = $this->createCustomerToVerifyBank($bankTok->id);
                    $data['customerId'] = $b;
                    return $data;
                }else{
                    return false;
                } 

        } catch(Stripe_CardError $e) {

          return $error1 = $e->getMessage();
        } catch (Stripe_InvalidRequestError $e) {
          // Invalid parameters were supplied to Stripe's API
         return $error2 = $e->getMessage();
        } catch (Stripe_AuthenticationError $e) {
          // Authentication with Stripe's API failed
         return $error3 = $e->getMessage();
        } catch (Stripe_ApiConnectionError $e) {
          // Network communication with Stripe failed
         return $error4 = $e->getMessage();
        } catch (Stripe_Error $e) {
          // Display a very generic error to the user, and maybe send
          // yourself an email
         return $error5 = $e->getMessage();
        } catch (Exception $e) {
          // Something else happened, completely unrelated to Stripe
         return $error6 = $e->getMessage();
        }

    }

    function createCustomerToVerifyBank($result){ 

        $customer = \Stripe\Customer::create(array(
                    "description" => "for verification",
                    "source" => $result
                ));

    
            
        if(isset($customer->id) && !empty($customer->id) && isset($customer->default_source) && !empty($customer->default_source)){

            $cus_retrieve = $customer->id;
            $so_retrieve = $customer->default_source;

             // get the existing bank account

            $customer = \Stripe\Customer::retrieve($cus_retrieve);
            $bank_account = $customer->sources->retrieve($so_retrieve);

            // verify the account 30 32
            $res = $bank_account->verify(array('amounts' => array(32, 45)));
            return $customer->id;
        }else{
            return false;
        }
            
    }
    
    function save_bank_account12_id($fName,$lName,$dob,$country,$currency,$routingNumber,$accountNo,$address,$city,$state,$postalCode,$ssnLast,$accountHolderType){
      

        $dob = explode("-", $dob);
        if(!empty($accountHolderType)){

          $accType = $accountHolderType;
        }else{
          $accType = "individual";
        }
        $secret_key = $this->ci->config->item('secret_key');
        Stripe\Stripe::setApiKey($secret_key);
        
        try{

          $acct = Stripe\Account::create(array(

        "country" => $country,
        "type" => 'custom',
        "external_account" => array(
          "object" => "bank_account",
          "country" => $country,
          "currency" => $currency,
          "routing_number" => $routingNumber,
          "account_number" => $accountNo,
        ),
        "tos_acceptance" => array(
          "date" => time(),
          "ip" => $_SERVER['SERVER_ADDR']
        ),
      ));
          $acct_id = $acct->id; 
          $account = Stripe\Account::retrieve($acct_id);
          $account->legal_entity->dob->year = $dob[0];
          $account->legal_entity->dob->month = $dob[1];
          $account->legal_entity->dob->day = $dob[2];
          $account->legal_entity->first_name = $fName;
          $account->legal_entity->last_name = $lName;
          $account->legal_entity->type = $accType;
         /* $account->legal_entity->address->line1 = $address;
          $account->legal_entity->address->postal_code = $postalCode;
          $account->legal_entity->address->city = $city;
          $account->legal_entity->address->state = $state;*/
          $account->legal_entity->ssn_last_4 = $ssnLast;// use 0000 for sandbox.
          $account->save();
         
         if(isset($acct->id) && !empty($acct->id)){

        return $acct->id;
      }
        }catch(Exception $e){

          return false;
        }
    }
    
    function save_bank_account_id($holderName,$dob,$country,$currency,$routingNumber,$accountNo,$address,$postalCode,$city,$state,$ssnLast){
      
          try {
                

                  if(!empty($holderName)){
                        $names = explode(" ", $holderName);
                    }
                    
                    
                    $dob = explode("-", $dob);
                   
                    $secret_key = $this->ci->config->item('secret_key');
                    Stripe\Stripe::setApiKey($secret_key);
                     
                    $acct = Stripe\Account::create(array(

                        "country" => "US",
                        "type" => 'custom',
                        "external_account" => array(
                            "object" => "bank_account",
                            "country" => $country,
                            "currency" => $currency,
                            "routing_number" => $routingNumber,
                            "account_number" => $accountNo,
                        ),
                        "tos_acceptance" => array(
                            "date" => time(),
                            "ip" => $_SERVER['SERVER_ADDR']
                        ),
                    ));
                    $acct_id = $acct->id; 
                    $account = Stripe\Account::retrieve($acct_id);
                    $account->legal_entity->dob->year = $dob[0];
                    $account->legal_entity->dob->month = $dob[1];
                    $account->legal_entity->dob->day = $dob[2];
                    $account->legal_entity->first_name = $names[0];
                    $account->legal_entity->last_name = $names[1];
                    $account->legal_entity->type = "individual";
                    
                    $account->legal_entity->address->line1 = $address;
                    $account->legal_entity->address->postal_code = $postalCode;
                    $account->legal_entity->address->city = $city;
                    $account->legal_entity->address->state = $state;
                    $account->legal_entity->ssn_last_4 = $ssnLast;
                    
                    $account->save();
                 
                   if(isset($acct->id) && !empty($acct->id)){
                        return array('id'=>$acct->id);
                    }else{
                        return false;
                    }
        } catch(Stripe_CardError $e) {

          return $error1 = $e->getMessage();
        } catch (Stripe_InvalidRequestError $e) {
          // Invalid parameters were supplied to Stripe's API
         return $error2 = $e->getMessage();
        } catch (Stripe_AuthenticationError $e) {
          // Authentication with Stripe's API failed
         return $error3 = $e->getMessage();
        } catch (Stripe_ApiConnectionError $e) {
          // Network communication with Stripe failed
         return $error4 = $e->getMessage();
        } catch (Stripe_Error $e) {
          // Display a very generic error to the user, and maybe send
          // yourself an email
         return $error5 = $e->getMessage();
        } catch (Exception $e) {
          // Something else happened, completely unrelated to Stripe
         return $error6 = $e->getMessage();
        }
       
    }



    
    
    function pay_by_bank_id($acctId,$payment){ ////////// bank to stripe
     
        $secret_key = $this->ci->config->item('secret_key');
        Stripe\Stripe::setApiKey($secret_key);

        $transfer = \Stripe\Transfer::create(array( 
            "amount" => $payment, 
            "currency" => "USD", 
            "destination" => $acctId, 

        ));
        return $transfer;
        
    }
    
    function addCardAccount($number,$exp_month,$exp_year,$cvv){


            try {
                

                $secret_key = $this->ci->config->item('secret_key');
                Stripe\Stripe::setApiKey($secret_key);
                
                $result = Stripe\Token::create(
                    array(
                    "card" => array(
                        "number" => $number,
                        "exp_month" => $exp_month,
                        "exp_year" => $exp_year,
                        "cvc" => $cvv
                        ) 
                    )
                ); 

                if(isset($result['id']) && !empty($result['id'])){
                    return array('id' => $result['id']);
                }else{
                    return false;
                } 

        } catch(Stripe_CardError $e) {

          return $error1 = $e->getMessage();
        } catch (Stripe_InvalidRequestError $e) {
          // Invalid parameters were supplied to Stripe's API
         return $error2 = $e->getMessage();
        } catch (Stripe_AuthenticationError $e) {
          // Authentication with Stripe's API failed
         return $error3 = $e->getMessage();
        } catch (Stripe_ApiConnectionError $e) {
          // Network communication with Stripe failed
         return $error4 = $e->getMessage();
        } catch (Stripe_Error $e) {
          // Display a very generic error to the user, and maybe send
          // yourself an email
         return $error5 = $e->getMessage();
        } catch (Exception $e) {
          // Something else happened, completely unrelated to Stripe
         return $error6 = $e->getMessage();
        }

        
            
    }
    
    function save_card_id($email = '',$token = ''){
        
        $secret_key = $this->ci->config->item('secret_key');
        Stripe\Stripe::setApiKey($secret_key);
        
        $customer = Stripe\Customer::create(array(
          "email" => $email, 
          "source" => $token,
        ));
        
        if(isset($customer->id) && !empty($customer->id)){
            return $customer->id;
        }else{
            return false;
        }
    }
    
    function pay_by_card_id($payment,$custId){
      
      try { 

          $secret_key = $this->ci->config->item('secret_key');
          Stripe\Stripe::setApiKey($secret_key);
          
          $charge = Stripe\Charge::create(array(
            "amount" => $payment, 
            "currency" => "usd",
            "customer" => $custId
          ));

          
          return $charge;
          
        } catch(Stripe_CardError $e) {

          return $error1 = $e->getMessage();
        } catch (Stripe_InvalidRequestError $e) {
          // Invalid parameters were supplied to Stripe's API
         return $error2 = $e->getMessage();
        } catch (Stripe_AuthenticationError $e) {
          // Authentication with Stripe's API failed
         return $error3 = $e->getMessage();
        } catch (Stripe_ApiConnectionError $e) {
          // Network communication with Stripe failed
         return $error4 = $e->getMessage();
        } catch (Stripe_Error $e) {
          // Display a very generic error to the user, and maybe send
          // yourself an email
         return $error5 = $e->getMessage();
        } catch (Exception $e) {
          // Something else happened, completely unrelated to Stripe
         return $error6 = $e->getMessage();
        }   
    }

    function pay_byCardId($payment,$custId){
        
        $secret_key = $this->ci->config->item('secret_key');

        Stripe\Stripe::setApiKey($secret_key);
        
        $charge = Stripe\Charge::create(array(
          "amount" => $payment, 
          "currency" => "usd",
          "card" => $custId
        ));
       
        return $charge;
    }

    function pay_by_customer_id($payment,$custId){
        
        $secret_key = $this->ci->config->item('secret_key');
        Stripe\Stripe::setApiKey($secret_key);
        
        $charge = Stripe\Charge::create(array(
          "amount" => $payment, 
          "currency" => "usd",
          "customer" => $custId
        ));
        
        return $charge;
    }

    function owner_pay_byBankId($data){


        $amount = round($data['amount'],2);
        $secret_key = $this->ci->config->item('secret_key');

        Stripe\Stripe::setApiKey($secret_key);


        try{
            $transfer = \Stripe\Transfer::create(array( 
                "amount" => $amount * 100, 
                "currency" => $data['currency'], 
                "destination" => $data['bankAccId'], 
                "description" => "Amount Transfer By Admin",
                "transfer_group" => "Test"

            ));

   
            if(isset($transfer->balance_transaction) && !empty($transfer->balance_transaction)){
                return $transfer;
            }

        } catch(Stripe_CardError $e) {

          return $error1 = $e->getMessage();
        } catch (Stripe_InvalidRequestError $e) {
          // Invalid parameters were supplied to Stripe's API
         return $error2 = $e->getMessage();
        } catch (Stripe_AuthenticationError $e) {
          // Authentication with Stripe's API failed
         return $error3 = $e->getMessage();
        } catch (Stripe_ApiConnectionError $e) {
          // Network communication with Stripe failed
         return $error4 = $e->getMessage();
        } catch (Stripe_Error $e) {
          // Display a very generic error to the user, and maybe send
          // yourself an email
         return $error5 = $e->getMessage();
        } catch (Exception $e) {
          // Something else happened, completely unrelated to Stripe
         return $error6 = $e->getMessage();
        }
   }

    
    

    
}