<?php
        $to = "gautamgoyal.mindiii@gmail.com";
        $subject = "Hii";
        $msg = "Hii";

        $a = mail($to,$subject,$msg);
        if($a){

        	echo "Send mail sucessfully";
        
        }else{

    		echo "Failed.......";
        }
        ?>