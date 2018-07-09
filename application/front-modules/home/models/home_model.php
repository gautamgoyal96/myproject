<?php
class Home_model extends CI_Model {
    
    private $users = "users";


	public function getCityNameByIpAddress($ipaddress){
	       
        $url = "http://freegeoip.net/json/".$ipaddress;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_TIMEOUT, 5000);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $ipdata = curl_exec($ch);
        $result = json_decode($ipdata,true);       
        if(!empty($result)){           
            return $result;
        }else{
            return 0;
        }
    }  

	public function getAllCategory(){

		$q = $this->db->select('*')->where('status',1)->get('category');
		if($q->num_rows()>0){
			return $q->result();
		}
	}

	public function getAllProducts(){

		$this->db->select('*');
        $this->db->where(array('status'=>1));


        //if($this->session->userdata('userType') == 2){
        (!empty($this->session->userdata('id'))) ? $this->db->where(array('ownerId !='=>$this->session->userdata('id'))) : '';
        //}
        //if($this->session->userdata('userType') == 1){
            //(!empty($this->session->userdata('id'))) ? $this->db->where(array('ownerId'=>$this->session->userdata('id'))) : '';
        //}
        
        $req = $this->db->get('product');
		if($req->num_rows()){
            $res = $req->result();          
            foreach($res as $value){

                $my = explode(",", $value->productForRental);
                $value->myPerProduct = $this->productperHour($my[0]);
                $imgs = $this->db->select('*')->where(array('productId'=>$value->id))->get('productImages')->row_array();
                $this->load->model('products/products_model');
                $value->isRented   = $this->products_model->productCheck(array('productId'=>$value->id, 'requestStatus' => ACCEPT));

                if(!empty($imgs)){
                    if(!empty($imgs['productImage'])){
                        $value->productImage = base_url().'uploads/productImage/thumb/'.$imgs['productImage'];
                    }else{
                       $value->productImage = base_url().FRONT_THEME.'images/defaultProduct.png';
                    }
                }else{
                    $value->productImage = base_url().FRONT_THEME.'images/defaultProduct.png';
                }
                $data[] = $value;
            }   
                    
            return $data;
        }   
	}

    function productperHour($value){

        switch ($value) {
         
            case 1:
                return "8 Hour";
                break;
            case 2:
                return "12 Hour";
                break; 
            case 3:
                return "24 Hour";
                break;
            case 4:
                return "1 Week";
                break; 
            case 5:
                return "1 Month";
                break;
        }
    }


    function Register($row){
        
        $res = $this->db->select('id')->where(array('email'=>$row['email'],'email !='=>''))->get($this->users);

            if($res->num_rows() == 0) {

                $users = $this->db->get_where($this->users,array('socialId'=>$row['socialId'],'socialType' => $row['socialType'],'OTP' => 'checked'))->row();
            
                if($users){
                   
                    $this->session_create($users->id); 
                     return array('return' =>false,"type"=>"SL");

                }else{ 
                 
                    $data = $this->db->get_where($this->users,array('socialId'=>$row['socialId'],'socialType' => $row['socialType'],'OTP != ' => 'checked'))->row();
                    if($data){

                        return array('type'=>'SR', 'userData'=>$data->id);

                    }else{

                       
                        return array('type'=>'SR', 'userData'=>'');
                    }
                }
            }else{
                

                if(!empty($row['socialId']) && !empty($row['socialType'])) {


                    $check = $this->db->select('id')->where(array('socialId'=>$row['socialId'],'socialType'=>$row['socialType'],'OTP' => 'checked'))->get($this->users);
                     
                    if($check->num_rows() == 1) {
                        
                        $id=$check->row()->id;
                    
                        $this->session_create($id);  
                        return array('type'=>'SL', 'userData'=>$id);

                    } else{

                        $data = $this->db->get_where($this->users,array('socialId'=>$row['socialId'],'socialType' => $row['socialType'],'OTP != ' => 'checked'))->row();

                        if($data){

                            return array('type'=>'SR', 'userData'=>$data->id);

                        }else{

                            if(empty($row['email'])){

                                 return array('type'=>'SR', 'userData'=>'');
                            }
                            return array('type'=>'AE', 'msg' => "Email is already registered");

                        }

                    }
                } else{
                    return array('type'=>'AE', 'msg'=>"Email is already registered");;
                }
            }


    } //End Function

    function verifyNo($data){

        $id=0;
        $sql = $this->db->select('id,otpVerified as isVerified,firstName as fullName')->from($this->users)->where(array('contactNo'=>$data['contactNo']))->get();
     
        if($sql->num_rows()){

            $my = $sql->row();
  
            if($my->isVerified==1 && !empty($my->fullName)){
                
                return array('status'=>2,'error'=>'');
        
            }elseif (($my->isVerified==0 || $my->isVerified==1) && empty($my->fullName)) {
         
                $this->db->where(array('contactNo'=>$data['contactNo']));
                $update =$this->db->update($this->users,array('OTP'=>$data['OTP'],'contactNo'=>$data['contactNo'],'otpVerified'=>0));
                 $id=$sql->row()->id;
                if($update):
                    $id=$sql->row()->id;
                endif;
            }else{

                $id ='';
            }
        }else{

            if(!empty($data['userId'])){

                $this->db->where(array('id'=>$data['userId']));
                $update =$this->db->update($this->users,array('OTP'=>$data['OTP'],'contactNo'=>$data['contactNo'],'otpVerified'=>0));

                $id = $data['userId'];
            }else{    

                $data['crd'] = date('Y-m-d H:i:s');
                $this->db->insert($this->users,array('OTP'=>$data['OTP'],'contactNo'=>$data['contactNo'],'otpVerified'=>0));
                $id = $this->db->insert_id();
            }    
        }

        if($id):

        $message = "Your AVA Rents verification code is ".$data['OTP'].". Thanks for joining";
        //return  array('status'=>1,'otp'=>$message,'id' => $id); 

        $this->load->library('twilio');
        $from   = '+14159972821';
        $to     = $data['countryCode'].$data['contactNo'];
        
        $response = $this->twilio->sms($from, $to, $message);
        if($response->IsError){
            $this->db->delete($this->users,array('id'=>$id));
            return  array('status'=>0,'error'=>$response->ErrorMessage);
        }else{
            return  array('status'=>1,'otp'=>$data['OTP'],'id' => $id); 
        }
        endif;
        //endif;
        return  array('status'=>0,'error'=>'Somting going wrong');

    }   //Enf Function

    function signupSecondStep($data,$id){

       $row = $this->latandLong(str_replace(' ','+',$data['address']));
       $data['latitude'] = $row['lat'];
       $data['longitude'] = $row['long'];
       if(!empty($data['socialType']) && !empty($data['socialId'])){
			$data['emailVerified'] = '1';
	   }
        $data['deviceToken'] = "";
        $data['deviceType'] = "3";
        $data['authToken'] = $this->_generate_token();
       $this->db->update($this->users,$data,array('id' => $id));
       $this->session_create($id);
       
       if(empty($data['socialType']) && empty($data['socialId'])){
			$data_set['link']   = base_url()."verification/mailverify/".base64_encode(base64_encode($id));
			
			$userData['firstName'] = $data['firstName'];
            $userData['lastName'] = $data['lastName'];
            $userData['link'] = $data_set['link'];
                    
			$message  = $this->load->view('email_verification',$userData,TRUE);	
/*
            print_r($message);
            die();	*/	
			$subject = "Email verification";
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From: AvaRents<avaco@ava.avarents.co>' . "\r\n";
            $headers .= 'Reply-To: avaco@ava.avarents.co' . "\r\n";
            $headers .= "X-Mailer: PHP/" . phpversion();
            mail($data['email'],$subject,$message,$headers);
           // $this->smtp_email->send_mail($data['email'],$subject,$message);
		//	$r = send_email($data['email'],$message,$subject); 
       }
       return true;
    }

    function latandLong($address){
        
        $url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response);
        if($response_a->results){
            
            $lat = $response_a->results[0]->geometry->location->lat;
            $long = $response_a->results[0]->geometry->location->lng;
            return array('lat' =>$lat ,'long'=>$long);
        
        }else{

            return array('lat' =>'22.7196' ,'long'=>'75.8577');

        }
        
    }//End Function 


    function login($data_val) {

        $update_data = array();
        $update_data['deviceToken'] = "";
        $update_data['deviceType'] = "3";
        $update_data['authToken'] = $this->_generate_token();

        $this->load->library('encrypt');
        $row = $this->db->select('id,password')->where(array('email' =>$data_val['email'],'status' => 0))->get($this->users);
        if($row->num_rows()){

            return "IA";
        }
        $sql = $this->db->select('id,password')->where(array('email' =>$data_val['email'],'status' => 1))->get($this->users);
        if($sql->num_rows() > 0){
            $user = $sql->row();    
               
            if($this->encrypt->decode($user->password) == $data_val['password']){

                $this->db->update('users',$update_data,array('id'=>$user->id));
                
                return $this->session_create($user->id);    
            }
        } else{
            return FALSE;
        }
    } //End Function

    function emailCheck($data_val) {

        $row = $this->db->select('id,password')->where(array('email' =>$data_val['email']))->get($this->users);
        if($row->num_rows()){

            return true;
        }
       
            return FALSE;
    } //End Function

    function session_create($lastId){

        $sql = $this->db->select('*')->where(array('id'=>$lastId))->get($this->users);
        if($sql->num_rows()):
            $user= $sql->row();
            $sessionData = array(
                'email'         => $user->email,
                'userType'      => $user->userType,
                'status'        => $user->status,
                'id'            => $user->id,
                'authToken'     => $user->authToken,
                'front_login'   => true

            );
            $this->session->set_userdata($sessionData);
            return true;
        endif;
        return false; 

    }//ENdFunction

    public function _generate_token(){

        $this->load->helper('security');
        $salt = do_hash(time().mt_rand());
        $new_key = substr($salt, 0, 20);
        return $new_key;
    }
    
    public function forgotPassword($email){
        $req = $this->db->select('id,firstName,lastName,email,password,socialId,socialType')->where(array('email'=>$email))->get('users');
        if($req->num_rows()){
            $this->load->library('encrypt');
            $res = $req->row();

            
            if(!empty($res->socialId) && !empty($res->socialType)){


                return '2'; //ES emailSend

            }
            
            $useremail= $res->email;
            $password="Forgot Password is :-".$this->encrypt->decode( $res->password) ;
            
            $userData['firstName'] = $res->firstName;
            $userData['lastName'] = $res->lastName;
            $userData['password'] = $password;
            
            $message  = $this->load->view('forgot_password',$userData,TRUE);
                    
			$subject = "Ava Forgot Password";
          /*  $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From: AvaRents<avaco@ava.avarents.co>' . "\r\n";
            $headers .= 'Reply-To: avaco@ava.avarents.co' . "\r\n";
            $headers .= "X-Mailer: PHP/" . phpversion();
            mail($useremail,$subject,$message,$headers);  */ 
            $this->smtp_email->send_mail($useremail,$subject,$message);
            return true;
        }else{
            return false;
        }
    }//end funtion

    public function emailSent($useremail,$message,$subject){

        $this->load->library('email');

        $config = array();
        $config['useragent']  = "CodeIgniter";
        $config['mailpath']  = "/usr/sbin/sendmail"; // or "/usr/sbin/sendmail"
        $config['protocol'] = "sendmail";
        $config['smtp_host']= "admin.com";
        $config['smtp_port'] = "25";
        $config['mailtype'] = 'html';
        $config['charset']  = 'utf-8';
        $config['newline']  = "\r\n";
        $config['wordwrap'] = TRUE;

        $this->email->initialize($config);

        $this->email->from('admin@admin.com', 'Ava');
        $this->email->to($useremail);

        $this->email->subject($subject);
        $this->email->message($message);

        if ($this->email->send()) {         
            return  array('emailType'=>'ES','email'=>'Your password has been successfully sent to your email address!!' ); //ES emailSend
        }else{                  
            return  array('emailType'=>'NS','email'=> show_error($this->email->print_debugger())) ; //NS NOSend
        }
    }//end function 
}
