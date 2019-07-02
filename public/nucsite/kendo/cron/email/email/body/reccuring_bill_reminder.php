<?php
extract($_GET);
    ?>
    <!DOCTYPE HTML>
    <html lang="en">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        </head>
        <body>
            <table cellspacing="0" cellpadding="0" width="100%" border="0">
                <tbody>
                    <tr>
                        <td valign="top" align="center">
                            <table cellspacing="0" cellpadding="10" width="800" border="0" bgcolor="#FFFFFF" style="border:1px solid #689F38;">
                                <tbody>
                                    <tr>
                                        <td valign="top" class="ecxfirst" style="text-align: center;">
                                            <a target="_blank" href="http://www.nucleuspos.com/" style="font-size:20px;color:#383838;text-decoration:none;" class="">
                                                <img border="0" style="width: 100px !important;" alt="" src="http://nucleuspos.com/nucleus/pos_image/nucleusfinal.png">
                                            </a>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top" class="ecxfirst" style="text-align: center;">
                                            <h2 align="center">Your Store Re-Order Product Reminder</h2>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td valign="top">
                                            <p align="justify">
                                            Dear Sir, <br>
                                            You have a upcoming due reccurring invoice bill to pay on <a target="_BLANK" href="http://www.nucleuspos.com">nucleuspos.com</a>, please pay your bill before it expires.<br>
                                            <h4>Your  Bill Short Detail</h4>
                                            <h5>Bill Amount : $<?php echo $bill; ?> </h5>
                                            <h5>Due Date : <?php echo $date; ?> </h5>
                                            Thank You. <br><br>
                                            
                                            <h5>For more query you can directly call or contact with our support team.</h5><br>
                                            Email : <a href="mailto:support@nucleuspos.com">support@nucleuspos.com</a> <br>
                                            Call us : 248-480-7003 <br>
                                            Send a Query : <a href="http://nucleuspos.com/contact.php">Click here</a> <br>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr><td bgcolor="#FFFFFF" align="center" class="ecxlast"><center><p style="font-size:15px;">&copy; <?php echo date("Y"); ?> Nucleuspos.com Ltd. All Rights Reserved</p></center></td></tr>
                </tbody>
            </table>
        </td>
    </tr>

    </tbody>
    </table>
    </body>
    </html>

























