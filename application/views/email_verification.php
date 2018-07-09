<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Email Verification</title>        
    </head>
    <body style="font-family: "Lato", sans-serif; padding:0; margin:0;">
        <table style="max-width: 750px; margin:0px auto; width: 100% ! important; background: #F3F3F3; padding: 0px 30px 30px 30px;" width="100% !important" border="0" cellpadding="0" cellspacing="0">
            <tr>
<!--                 <td style="background:#fff; padding:15px; text-align: center;"><img style="max-width: 125px; width: 100%;padding: 10px;" src="<?php echo base_url().FRONT_THEME.'images/email_logo.png';?>"></td>
 -->            </tr>
            <tr>
                <td style="text-align: center; background: #8e804a;">
                    <table width="100%" border="0" cellpadding="30" cellspacing="0">
                        <tr>
                            <td>
                                <h2 style="color: #fff; margin: 0 0 5px; text-transform: capitalize; font-size: 35px; font-weight: normal;">Hello  <span style="color: #fff;"><?php echo ucfirst($firstName).' '.ucfirst($lastName);?>,</span></h2>
                                <h4 style="color: #fff; margin: 15px 0 5px; font-size: 25px; font-weight: normal;">Welcome to AVA</h4>
                              <!--   <p style="color: #fff; font-size: 16px; line-height: 28px;">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p> -->
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align: center; border-bottom:5px solid #8e804a;">
                    <table width="100%" border="0" cellpadding="30" cellspacing="0" bgcolor="#fff">
                        <tr>
                            <td>
<!--                                 <div><img style="max-width: 100px; width: 100%; margin-bottom:10px;" src="<?php echo base_url().FRONT_THEME.'images/code-icon_jm.png';?>"></div>
 -->                                <h3 style="color: #333; font-size: 28px; font-weight: normal; margin: 0; text-transform: capitalize;">Email Verification</h3>
                                <p style="color: #333; font-size: 16px; line-height: 28px;">Please click to the link below to confirm your email address for ava:</p>
                                <a href="<?php echo $link; ?>" style="background: #8e804a; color: #fff; margin: 15px 0 5px; font-size: 22px; display: inline-block; font-weight: normal; padding: 10px 25px; text-decoration:none;border-radius: 5px;">Verify Now</a>
                            </td>
                        </tr>
                    </table>
                    <table width="100%" border="0" bgcolor="#e8e8e8">
                        <tr>
                            <td >
                                <p style="font-size:16px; margin:10px 0 10px 0;">Sincerely,</p>
                                <p style="font-size:18px; color:#8e804a; margin:0 0 10px 0;">Your ava team.</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>