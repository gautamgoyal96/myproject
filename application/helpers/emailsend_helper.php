<?php 
/*
 * Send an email. 
 * $info array must have following information :
 * $info = array(
 *      'to_email'      => 
 *      'to_name'       =>
 *      'from_email'    =>
 *      'from_name'     =>
 *      'subject'       =>
 *      'body'          =>
 *      'reply_to'      =>
 * )
 */
if ( ! function_exists('send_email'))
{
    function send_email($email,$message,$subject)
    {
        $CI = & get_instance();

        // ==========================================================================================
        $CI->load->library('email');

        $config['protocol'] = 'sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';

        $CI->email->initialize($config);

        $CI->email->clear();
        $CI->email->set_newline("\r\n");
        // =========================================================================================

      //   $CI->email->from($info['from_email'], $info['from_name']);
      //   $CI->email->to($info['to_email'], $info['to_name']);
      // //  $CI->email->cc('mahbub.kuet@gmail.com', 'MAHBUB');
      //   $CI->email->subject($info['subject']);
      //   $CI->email->message($info['body']);

      //   $CI->email->reply_to($info['reply_to'], "No reply");

        $CI->email->from('deepaks.mindiii@gmail.com', 'AVA');
        $CI->email->to($email);
         //   $CI->email->to('deepaks.mindiii@gmail.com');
      //  $CI->email->cc('mahbub.kuet@gmail.com', 'MAHBUB');
		//echo $message;die;

        $CI->email->subject($subject);
        $CI->email->message($message);

        //$CI->email->reply_to($info['reply_to'], "No reply");

        $a = $CI->email->send();
        // var_dump($a);

        // die();

        if($a){ 
			//print_r($a);die;
			return TRUE;
	}else{
		//print_r(show_error($this->email->print_debugger()));die;
        return FALSE;   
	}
    }  

}
