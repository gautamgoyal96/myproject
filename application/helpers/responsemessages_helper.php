<?php

class ResponseMessages{

    public static function getStatusCodeMessage($status)
    {

        $codes = Array(
            100 => "Invalid API key",
            101 => "Invalid Auth Token",
            102 => "Invalid Username",
            103 => "Invalid Input Parameters",
            104 => "An Error Occurred in User Registration",
            105 => "Invalid login/password",
            106 => "User authentication successfully done!",
            107 => "User Not Found",
            108 => "You've updated your profile",
            109 => "An error occurred please try again",
    		110 => "User registration successfully done",
    		112 => "Please select image",
    		113 => "Please select video",
    		114 => "No results found right now",
    		115 => "You're temporarily blocked from posting",
    		116 => "Email already exist",
    		117 => "Email is already registered",
    		118 => "Something going wrong",
    		119 => "All fields are required",
    		120 => "A new password has been sent on your registered email",
            121 => "Currently you are inactivate user", 
            122 => "Contact number already exist",
            123 => "You have already join",
            124 => "Registration successfully, Verification code has been sent",
			125 => "Product added successfully",
			126 => "Currently you are not active",
            127 => "Your request has been sent successfully",
            128 => "Currently product not available",
            129 => "Product updated successfully",
            130 => "Product can't updated",
            131 => "Product not available",
            132 => "Request accepted successfully",
            133 => "Request reject successfully",
            134 => "Request modify successfully",
            135 => "Request modification accepted successfully",
            136 => "Request modification rejected successfully",
            137 => "Old Password does not match",
            138 => "Password change successfully",
            139 => "Request finished successfully",
            140 => "Request accepted successfully",
            141 => "Request rejected successfully",
            142 => "Invoice sent successfully",
            143 => "Payment complete successfully",
            144 => "Review sent successfully",
            
            
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => '(Unused)',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported'
        );

        
        
        return (isset($codes[$status])) ? $codes[$status] : '';
    }
}

?>
