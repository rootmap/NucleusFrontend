<?php 
session_start();
$errmsg_arr[]='';
$error_flag=false;
include('class/db_Class.php');
$obj=new db_class();
include('class/login.php');
$log=new login();
if(isset($_POST['login']))
{
	extract($_POST);
	echo $log->login_user($username,$password);
	exit();	
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>NUCLEUS Login Page - NUCLEUS Admin Panel</title>

    <meta name="description" content="Mcq Test User login page" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="admin/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="admin/assets/css/font-awesome.min.css" />
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />
    <link rel="stylesheet" href="admin/assets/css/ace.min.css" />
    <link rel="stylesheet" href="admin/assets/css/ace-rtl.min.css" />
    <style type="text/css">
        body
        {
            background:url(pos_image/nucleus.png) no-repeat center;	
        }
    </style>
</head>

    <body class="login-layout">
        <div class="main-container" style="margin-top:15%;">
            <div class="main-content">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="login-container">
                            <?php echo $obj->ShowMsg(); ?>
                            <div class="space-6"></div>

                            <div class="position-relative">
                                <div id="login-box" class="login-box visible widget-box no-border">
                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <div class="header blue lighter bigger" style="font-size:16px; line-height:50px;">
                                                <img width="50" src="pos_image/nucleussmall.png"> <strong> NUCLEUS AUTHENTICATION </strong>
                                            </div>

                                            <div class="space-6"></div>

                                            <form method="post" name="login" action="">
                                                <fieldset>
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="text" name="username" id="username" class="form-control" placeholder="Username" />
                                                            <i class="icon-user"></i>
                                                        </span>
                                                    </label>

                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="password" name="password" id="password" class="form-control" placeholder="Password" />
                                                            <i class="icon-lock"></i>
                                                        </span>
                                                    </label>

                                                    <div class="space"></div>

                                                    <div class="clearfix">
                                                        <label class="inline">
                                                            <input type="checkbox" class="ace" />
                                                            <span class="lbl"> Remember Me</span>
                                                        </label>

                                                        <button type="submit" name="login" id="login" class="width-35 pull-right btn btn-sm btn-primary">
                                                            <i class="icon-key"></i>
                                                            Login
                                                        </button>
                                                    </div>

                                                    <div class="space-4"></div>
                                                </fieldset>
                                            </form>

                                            
                                        </div><!-- /widget-main -->

                                        <div class="toolbar clearfix">
                                            <div>
                                                <a href="#forgot-box" onclick="show_box('forgot-box');
                                                                                                        return false;" class="forgot-password-link">
                                                    <i class="icon-arrow-right"></i>
                                                    I forgot my password
                                                </a>
                                            </div>
                                        </div>
                                    </div><!-- /widget-body -->
                                </div><!-- /login-box -->

                                <div id="forgot-box" class="forgot-box widget-box no-border">
                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <h4 class="header red lighter bigger">
                                                <i class="icon-key"></i>
                                                Retrieve Password
                                            </h4>

                                            <div class="space-6"></div>
                                            <p>
                                                Enter your email and to receive instructions
                                            </p>

                                            <form>
                                                <fieldset>
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="email" id="reset_email" class="form-control" placeholder="Email" />
                                                            <i class="icon-envelope"></i>
                                                        </span>
                                                    </label>

                                                    <div class="clearfix">
                                                        <button id="forgetpassword" type="button" class="width-35 pull-right btn btn-sm btn-danger">
                                                            <i class="icon-lightbulb"></i>
                                                            Send Me!
                                                        </button>
                                                    </div>
                                                </fieldset>
                                            </form>
                                        </div><!-- /widget-main -->

                                        <div class="toolbar center">
                                            <a href="#" onclick="show_box('login-box');
                                                                                                return false;" class="back-to-login-link">
                                                Back to login
                                                <i class="icon-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div><!-- /widget-body -->
                                </div><!-- /forgot-box -->
                                
                                <div id="resetcode-box" class="resetcode-box widget-box no-border">
                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <h4 class="header red lighter bigger">
                                                <i class="icon-key"></i>
                                                Password Reset Code 
                                            </h4>

                                            <div class="space-6"></div>
                                            <p>
                                                Enter your reset code from your email.
                                            </p>

                                            <form>
                                                <fieldset>
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="text" id="reset_code" class="form-control" placeholder="Reset Code" />
                                                            <i class="icon-key"></i>
                                                        </span>
                                                    </label>

                                                    <div class="clearfix">
                                                        <button id="verifyresetcodede" type="button" class="width-35 pull-right btn btn-sm btn-danger">
                                                            <i class="icon-lightbulb"></i>
                                                            Verify Code
                                                        </button>
                                                    </div>
                                                </fieldset>
                                            </form>
                                        </div><!-- /widget-main -->

                                        <div class="toolbar center">
                                            <a href="#" onclick="show_box('login-box');
                                                                                                return false;" class="back-to-login-link">
                                                Back to login
                                                <i class="icon-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div><!-- /widget-body -->
                                </div><!-- /Password Reset Code-box -->
                                
                                <div id="password-reset-box" class="password-reset-box widget-box no-border">
                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <div class="header blue lighter bigger" style="font-size:16px; line-height:50px;">
                                                <img width="50" src="pos_image/nucleussmall.png"> <strong> Reset Your Account Password </strong>
                                            </div>

                                            <div class="space-6"></div>

                                            <form method="post" name="login" action="">
                                                <fieldset>
  

                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="password" name="password" id="nresetpassword" class="form-control" placeholder="New Password" />
                                                            <i class="icon-lock"></i>
                                                        </span>
                                                    </label>
                                                    
                                                    <div class="space"></div>
                                                    
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="password" name="password" id="rresetpassword" class="form-control" placeholder="Re-Type Password" />
                                                            <i class="icon-lock"></i>
                                                        </span>
                                                    </label>

                                                    <div class="space"></div>

                                                    <div class="clearfix">
                                                        <button type="button" name="changepass" id="changepass" class="width-45 pull-right btn btn-sm btn-info">
                                                            <i class="icon-key"></i>
                                                            Save Change 
                                                        </button>
                                                    </div>

                                                    <div class="space-4"></div>
                                                </fieldset>
                                            </form>

                                            
                                        </div><!-- /widget-main -->
                                    </div><!-- /widget-body -->
                                </div><!-- /reset Password-box -->
                                
                                
                            </div><!-- /position-relative -->
                        </div>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div>

            <a  href="http://neutrix.systems/" class="span2" style="position:absolute; outline:none; right:0; bottom:0;" target="_blank"><img width="300" style=" clear:both;" style="margin-left:auto; margin-right:auto;" src="images/poweredbyneutrix3.png"></a>
        </div><!-- /.main-container -->

        <!-- basic scripts -->
        <script src="ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
        <script type="text/javascript">
                                                                                    window.jQuery || document.write("<script src='admin/assets/js/jquery-2.0.3.min.js'>" + "<" + "/script>");
        </script>
        <script type="text/javascript">
            if ("ontouchend" in document)
                document.write("<script src='admin/assets/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
        </script>
        <script type="text/javascript">
            function show_box(id) {
                jQuery('.widget-box.visible').removeClass('visible');
                jQuery('#' + id).addClass('visible');
            }
		
		$(document).ready(function () {
		
		 
		 $("#forgetpassword").click(function(){
			 var log_email=$('#reset_email').val();
			 //alert(log_email);
			 load_login = {'st':2,'email':log_email};
			 $.post('class/reset/login.php', load_login,  function(data) {
				if(data==1)
				{
					//alert(data);
					//window.location.replace("./login.php?reset");
					show_box('resetcode-box');
				}
				else if(data==2)
				{
					//alert(data);
					show_box('forgot-box');
				}
				else
				{
					alert("Something Went Wrong Please retry Again");
					//window.location.replace("./login.php");
					show_box('forgot-box');
				}
			 });
		 });
		 
		 
		 
		 $("#changepass").click(function(){
			 var log_npassword=$('#nresetpassword').val();
			 var log_rpassword=$('#rresetpassword').val();
			 //alert(log_email);
			 load_login = {'st':3,'password':log_npassword};
			 if(log_npassword==log_rpassword)
			 {
				 $.post('class/reset/login.php', load_login,  function(data) {
					if(data==1)
					{
						alert("Your Password Changed Successfully, Please Login Using New Password.");
						//window.location.replace("./login.php");
						show_box('login-box');
					}
					else if(data==2)
					{
						show_box('forgot-box');
					}
					else
					{
						alert("Something Went Wrong, Please Provide Your Reset Code Again.");
						show_box('forgot-box');
					}
				 });
			 }
			 else
			 {
				 alert("Password Mismatch.");
			 }
		 });
		 
		 $("#verifyresetcodede").click(function(){
			 var reset_code=$('#reset_code').val();
			 //alert(log_email);
			 load_login = {'st':4,'reset_code':reset_code};
				 $.post('class/reset/login.php', load_login,  function(data) {
					if(data==1)
					{
						show_box('password-reset-box');
					}
					else if(data==0)
					{
						alert("Empty Reset Code Not Allowed.");
						$("#reset_code").css("border-color","#f00");
					}
					else if(data==2)
					{
						alert("Invalid Reset Code. Please Check Your Email &amp; Re-Type Your Reset.");
						show_box('resetcode-box');
					}
					else
					{
						alert("Something Went Wrong Please retry Again");
						show_box('resetcode-box');
					}
				 });
		 });
		
    });
        </script>
    </body>

</html>
