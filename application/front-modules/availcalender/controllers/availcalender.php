<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Availcalender extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('availcalender_model');
    }
    
	function index(){

        $this->session->unset_userdata('slot');
        $this->session->unset_userdata('requestDate');
        $this->session->unset_userdata('calType');
        $this->session->unset_userdata('pId');
        $this->session->unset_userdata('slot');

        $id = $this->input->post('id');

        if(!empty($id)){

            $this->session->set_userdata('pId',$id);
        }

         if(!empty($_GET['pId'])){

            $this->session->set_userdata('pId',$_GET['pId']);
        }

        $slot = $this->input->post('slot');

        if(!empty($slot)){


            $this->session->set_userdata('slot',$slot);
        }

        if(!empty($_GET['slot'])){

            $this->session->set_userdata('slot',$_GET['slot']);
        }

        $requestDate = $this->input->post('requestDate');

        if(!empty($requestDate)){

            $this->session->set_userdata('requestDate',$requestDate);
        }

        if(!empty($_GET['requestDate'])){

            $this->session->set_userdata('requestDate',$_GET['requestDate']);
        }

        $calType = $this->input->post('calType');

        if(!empty($calType)){

            $this->session->set_userdata('calType',$calType);
        }

        if(!empty($_GET['calType'])){

            $this->session->set_userdata('calType',$_GET['calType']);
        }



        $this->load->view('request_calendar');

    }//ENd Function	

    function checkDate(){

        $data = $this->availcalender_model->checkDate($this->input->post('date'));

    }
}

/* End of file callender.php */
/* Location: ./application/controllers/callender.php */
