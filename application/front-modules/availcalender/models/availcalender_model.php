<?php
class Availcalender_model extends CI_Model {

    private $product = "product";
    private $renter = "renter";
    
	function requestCallendar($class_day,$myDate,$cellContent,$m){
       $array = $currentDate = $DDate = array();

        $a = "";
       $pId =  $this->session->userdata('pId');
       if(!empty($pId)){
       $product = $this->db->get_where($this->product,array('id'=>$pId))->row();
       $bookDate = $this->bookedDate();
       $currentDate = $this->currentDate();

       $availableDate = explode(",",$product->availStartDate);
       $array = array_unique (array_merge ($bookDate, $availableDate));
       }else if(empty($pId) && !empty($this->session->userdata('requestDate'))){

          $DDate = explode(",", $this->session->userdata('requestDate'));
    

       }
        if($this->session->userdata('userType') == 2 || $this->session->userdata('calType')==1){
        $a = 'onclick="my('.$cellContent.$m.');"';
       }

       if(!empty($myDate) &&in_array($myDate,$array)){

        return '<li class="calendar_days calendar_active cal" '.$a.' id="cal' . $cellContent .$m. '" data-id="'.$myDate.'">' . $cellContent . '</li>' . "\r\n";

       }else if(!empty($myDate) &&in_array($myDate,$currentDate)){

             return '<li class="calendar_days calendar_active_av cal" '.$a.' id="cal' . $cellContent  .$m.  '" data-id="'.$myDate.'">' . $cellContent . '</li>' . "\r\n";

       }else if(!empty($DDate) &&in_array($myDate,$DDate)){

             return '<li class="calendar_days calendar_active cal" '.$a.' id="cal' . $cellContent  .$m.  '" data-id="'.$myDate.'">' . $cellContent . '</li>' . "\r\n";

       }

        return '<li class="' . $class_day . ' cal" '.$a.' id="cal' . $cellContent .$m. '" data-id="'.$myDate.'">' . $cellContent . '</li>' . "\r\n";
        
    }//End Function

    function currentDate(){

        $slot =  $this->session->userdata('slot');
        $requestDate =  $this->session->userdata('requestDate');
        if(!empty($slot) && !empty($requestDate)){

            if($slot ==1 || $slot ==2 || $slot ==3){

                    $my[] = $requestDate;
     
            }else if($slot==4){

                for($i=0;$i<7;$i++){

                   $dt = $requestDate;

                   $my[] = date( "Y-m-d", strtotime( "$dt +".$i." day" ) ); // PHP:  2009-03-04
                }


            }else if($slot==5){

                for($i=0;$i<30;$i++){

                   $dt = $requestDate;

                   $my[] = date( "Y-m-d", strtotime( "$dt +".$i." day" ) ); // PHP:  2009-03-04
                }

            }

            return $my;
        }else{

            return array();
        }    
    }

    function bookedDate(){

       $pId =  $this->session->userdata('pId');
       $this->db->select("bookStartDate,bookEndDate,availType");
        $this->db->where(array('requestStatus' => ACCEPT,"productId" => $pId));
        $data = $this->db->get($this->renter);
        $row = array();
        if($data->num_rows()){

            $row = $data->result();

            foreach ($row as $key => $value) {

         
                if($value->availType==1){

                   $my[] = $value->bookStartDate;
 
                }else if($value->availType==2){

                    for($i=0;$i<7;$i++){

                       $dt = $value->bookStartDate;

                       $my[] = date( "Y-m-d", strtotime( "$dt +".$i." day" ) ); // PHP:  2009-03-04
                    }

 
                }else if($value->availType==3){

                    for($i=0;$i<30;$i++){

                       $dt = $value->bookStartDate;

                       $my[] = date( "Y-m-d", strtotime( "$dt +".$i." day" ) ); // PHP:  2009-03-04
                    }
 
                }
            }

            return $my;
 
        }

        return array();

    }

    function checkDate($mDate){

       $pId =  $this->session->userdata('pId');
       $product = $this->db->get_where($this->product,array('id'=>$pId))->row();
       $bookDate = $this->bookedDate();
       $availableDate = explode(",",$product->availStartDate);
       $array = array_unique (array_merge ($bookDate, $availableDate));     
       if(!empty($mDate) &&in_array($mDate,$array)){

          echo "1";

       }else{

          echo "0";

       }
    }
    
}
