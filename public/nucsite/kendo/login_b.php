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
                                                            <input type="email" class="form-control" placeholder="Email" />
                                                            <i class="icon-envelope"></i>
                                                        </span>
                                                    </label>

                                                    <div class="clearfix">
                                                        <button type="button" class="width-35 pull-right btn btn-sm btn-danger">
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
                                                                                    window.jQuery || document.write("<script src='assets/js/jquery-2.0.3.min.js'>" + "<" + "/script>");
        </script>
        <script type="text/javascript">
            if ("ontouchend" in document)
                document.write("<script src='assets/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
        </script>
        <script type="text/javascript">
            function show_box(id) {
                jQuery('.widget-box.visible').removeClass('visible');
                jQuery('#' + id).addClass('visible');
            }
        </script>
    </body>

</html>
