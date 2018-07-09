<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('home_model');
    }
    
	public function index() {

	    $data['category'] = $this->home_model->getAllCategory();
	    $data['products'] = $this->home_model->getAllProducts();


	    $this->session->set_userdata('categoryId','');
	    $this->session->set_userdata('latitude','');
		$this->session->set_userdata('longitude', '');

	    $ip = $_SERVER['REMOTE_ADDR'];

		$city_name = $this->home_model->getCityNameByIpAddress($ip);

		if(!empty($city_name['city'])){
			$data['city_name'] = $city_name['city'];
		}else{
			$data['city_name'] = "";
		}
        $data['addCss'] = array("css/calendar.css","css/owl.carousel.min.css");
        $data['addJs'] = array("js/wow.min.js","js/additional-methods.js","js/owl.carousel.js","js/element.js","js/jquery.fancybox.js");	    
		$this->template->build('home',$data);
	}

	 function latandLong(){

      /*  $address = "Indore, Madhya Pradesh, India";
        $url = "http://maps.googleapis.com/maps/api/geocode/xml?address=".$address."&sensor=false";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_TIMEOUT, 5000);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $ipdata = curl_exec($ch);
        $output = json_decode($ipdata,true);       
        print_r($output);
            die();
*/
            $address = "Indore+MadhyaPradesh+India";
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
        echo $lat = $response_a->results[0]->geometry->location->lat;
        echo "<br />";
        echo $long = $response_a->results[0]->geometry->location->lng;
        die();
        
 
       /* $latitude   =  isset($output['results'][0]['geometry']['location']['lat'])?$output['results'][0]['geometry']['location']['lat']:'';

        $longitude  = isset($output['results'][0]['geometry']['location']['lng'])?$output['results'][0]['geometry']['location']['lng']:'';
        $a = array('lat' =>$latitude ,'long'=>$longitude );
        return array('lat' =>$latitude ,'long'=>$longitude );*/
    }//End Function 


    public function test(){

            echo "Local :".date_default_timezone_get() . ' => ' . date('e') . ' => ' . date('T')."<br>";
    echo date_default_timezone_get()."<br>";
    echo date('Y-m-d h:i A');
    
    die();            $this->load->library('Smtp_email');         

                $userData['firstName'] = 'Gautam';
                $userData['lastName'] = 'Goyal';
                $userData['link'] =  base_url();
                        
                $message  = $this->load->view('email_verification',$userData,TRUE); 
                $email = "andyarshad@me.com";
                $subject = "Email verification";
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $headers .= 'From: AvaRents<noreplay@avarents.co>' . "\r\n";
                $headers .= 'Reply-To: noreplay@avarents.co' . "\r\n";
                $headers .= "X-Mailer: PHP/" . phpversion();
                $a = mail($email,$subject,$message,$headers);
                if($a){

                    echo 'sucessFull';
                }else{

                    echo 'test';
                }
            /*  echo  $a = $this->smtp_email->send_mail($email,$subject,$message);*/
    }
}



/* End of file welcome.php */
/* Location: ./application/controllers/home.php */
