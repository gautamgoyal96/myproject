<?php
class SignUp_model extends CI_Model {

    public function verifyNo($data){
        $id=0;
        $sql = $this->db->select('id')->from('users')->where(array('contactNo'=>$data['contactNo']))->get();
       
        if($sql->num_rows()){
            $this->db->where(array('contactNo'=>$data['contactNo']));
            $update =$this->db->update('users',array('OTP'=>$data['OTP'],'id'=>$sql->row()->id,'otpVerified'=>0));
            if($update):
                $id=$sql->row()->id;
            endif;
        }else{
            $data['id'] = $sql->row()->id;
            $this->db->insert('users',$data);
            $id = $this->db->insert_id();
        }
        if($id):
            $this->load->library('twilio');
            $from   = '+7154084595';
            $to     = $data['countryCode'].$data['contactNo'];
            $message = $data['OTP'];
            $response = $this->twilio->sms($from, $to, $message);
            if($response->IsError){
                return  array('status'=>0,'error'=>$response->ErrorMessage);
            }else{
                return  array('status'=>1,'otp'=>$message,'countryCode'=>$data['countryCode'],'contactNo'=>$data['contactNo']);
            }
        endif;
        return  array('status'=>0,'error'=>'Somting going wrong');
    }

    public function step2($data){

        $check = $this->db->select('*')->where(array('countryCode'=>$this->session->userdata('countryCode'),'contactNo'=>$this->session->userdata('contactNo')))->get('users');

        if($check->num_rows()){
            $res = $check->row_array();
            
        }

    }

}
?>
