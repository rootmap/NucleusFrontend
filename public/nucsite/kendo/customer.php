<?php
include('class/auth.php');
$table = "coustomer";
if (isset($_POST['create'])) {
    extract($_POST);
    if (!empty($firstname)) {

        $checkemail = $obj->SelectAllByVal("setting_customer", "store_id", $input_by, "no_email");
        if ($checkemail != 0) {
            if (empty($email)) {
                $obj->Error("Email, Not Empty", $obj->filename());
            }
        }

        if ($sendemail == 1) {
            $stss = 1;
        } else {
            $stss = 0;
        }

        if ($obj->insert($table, array("firstname" => $firstname,
                    "lastname" => $lastname,
                    "phone" => $phone,
                    "phonesms" => $mobilesms,
                    "email" => $email,
                    "reffered" => $reffered,
                    "businessname" => $businessname,
                    "address1" => $address1,
                    "address2" => $address2,
                    "city" => $city,
                    "country" => $country,
                    "input_by" => $input_by,
                    "postalcode" => $postalcoad,
                    "access_id" => $access_id,
                    "date" => date('Y-m-d'),
                    "status" => $stss)) == 1) {

            /* if($sendemail==1)
              {

              $report_cpmpany_name=$obj->SelectAllByVal("setting_report","store_id",$input_by,"name");
              $report_cpmpany_address=$obj->SelectAllByVal("setting_report","store_id",$input_by,"address");
              $report_cpmpany_phone=$obj->SelectAllByVal("setting_report","store_id",$input_by,"phone");
              $report_cpmpany_email=$obj->SelectAllByVal("setting_report","store_id",$input_by,"email");

              $to=$report_cpmpany_email;
              $sender =$report_cpmpany_name;
              $user_email=$email;
              $message = '<!DOCTYPE HTML><head><meta http-equiv="content-type" content="text/html">
              <title>Email notification From NucleusPos</title>';
              $message .= "</head>";
              $message .= "<body>";
              $message .="Your Account is Succesfully Created On Nucleuspos.com<br>";
              $message .= "</body>";
              $message .= "</html>";

              $headers  = "From: " . $sender . "\r\n";
              $headers .= "Reply-To: ". $user_email . "\r\n";
              //$headers .= "CC: \r\n";
              $headers .= "MIME-Version: 1.0\r\n";
              $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

              @mail($to,$subject,$message, $headers);

              } */


            $obj->Success("Customer Account Successfully Stored in System.", $obj->filename());
        } else {
            $obj->Error("Something is wrong, Try again", $obj->filename());
        }
    } else {
        $obj->Error("Failed, Fill up the required field", $obj->filename());
    }
} elseif (isset($_POST['update'])) {
    extract($_POST);
    if (!empty($firstname)) {
        if ($obj->update($table, array("id" => $edit, "firstname" => $firstname, "lastname" => $lastname, "phone" => $phone, "phonesms" => $mobilesms, "email" => $email,
                    "reffered" => $reffered, "businessname" => $businessname, "address1" => $address1, "address2" => $address2, "city" => $city, "country" => $country,
                    "postalcode" => $postalcoad, "access_id" => $access_id, "date" => date('Y-m-d'), "status" => 1)) == 1) {
            $obj->Success("Successfully Updated", $obj->filename() . "?edit=" . $edit);
        } else {
            $obj->Error("Something is wrong, Try again", $obj->filename() . "?edit=" . $edit);
        }
    } else {
        $obj->Error("Failed, Fill up the required field", $obj->filename() . "?edit=" . $edit);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
        include './plugin/plugin.php';
        $cms = new CmsRootPlugin();
        echo $cms->GeneralCss(array("kendo"));
        ?>
    </head>

    <body>
        <?php include('include/header.php'); ?>
        <!-- Main wrapper -->
        <div class="wrapper three-columns">

            <!-- Left sidebar -->
            <?php include('include/sidebar_left.php'); ?>
            <!-- /left sidebar -->


            <!-- Main content -->
            <div class="content">

                <!-- Info notice -->
                <?php echo $obj->ShowMsg(); ?>
                <!-- /info notice -->

                <div class="outer">
                    <div class="inner">
                        <div class="page-header"><!-- Page header -->
                            <h5><i class="font-user"></i> New Customer Detail </h5>
                            <ul class="icons">
                                <li><a href="<?php echo $obj->filename(); ?>" class="hovertip" title="Reload"><i class="font-refresh"></i></a></li>
                            </ul>
                        </div><!-- /page header -->

                        <div class="body">

                            <!-- Middle navigation standard -->
                            <?php //include('include/quicklink.php');  ?>
                            <!-- /middle navigation standard -->

                            <!-- Content container -->
                            <div class="container">




                                <!-- Content Start from here customized -->

                                <?php if (@$_GET['edit']) { ?>    
                                    <form class="form-horizontal" method="post" action="">
                                        <fieldset>

                                            <!-- General form elements -->
                                            <div class="well row-fluid block">
                                                <div class="navbar">
                                                    <div class="navbar-inner">
                                                        <h5><i class="icon-edit"></i>Edit Customer</h5>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="edit" value="<?php echo $_GET['edit']; ?>">
                                                <div class="control-group">
                                                    <label class="control-label">First Name:</label>
                                                    <div class="controls"><input class="span8 k-textbox" value="<?php echo $obj->SelectAllByVal($table, "id", $_GET['edit'], "firstname"); ?>" type="text" name="firstname" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">Last Name:</label>
                                                    <div class="controls"><input value="<?php echo $obj->SelectAllByVal($table, "id", $_GET['edit'], "lastname"); ?>" class="span8 k-textbox" type="text" name="lastname" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">Phone:</label>
                                                    <div class="controls"><input value="<?php echo $obj->SelectAllByVal($table, "id", $_GET['edit'], "phone"); ?>" class="span8 k-textbox" type="text" name="phone" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">Mobile: Required for SMS</label>
                                                    <div class="controls"><input value="<?php echo $obj->SelectAllByVal($table, "id", $_GET['edit'], "phonesms"); ?>" class="span8 k-textbox" type="text" name="mobilesms" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">Email</label>
                                                    <div class="controls"><input value="<?php echo $obj->SelectAllByVal($table, "id", $_GET['edit'], "email"); ?>" class="span8 k-textbox" type="text" name="email" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">Reffered By</label>
                                                    <div class="controls"><input value="<?php echo $obj->SelectAllByVal($table, "id", $_GET['edit'], "reffered"); ?>" class="span8 k-textbox" type="text" name="reffered" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">Business Name</label>
                                                    <div class="controls"><input value="<?php echo $obj->SelectAllByVal($table, "id", $_GET['edit'], "businessname"); ?>"  class="span8 k-textbox" type="text" name="businessname" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">Address</label>
                                                    <div class="controls"><input value="<?php echo $obj->SelectAllByVal($table, "id", $_GET['edit'], "address1"); ?>" class="span8 k-textbox" type="text" name="address1" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">Address 2</label>
                                                    <div class="controls"><input value="<?php echo $obj->SelectAllByVal($table, "id", $_GET['edit'], "address2"); ?>" class="span8 k-textbox" type="text" name="address2" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">City</label>
                                                    <div class="controls"><input  value="<?php echo $obj->SelectAllByVal($table, "id", $_GET['edit'], "city"); ?>" class="span8 k-textbox" type="text" name="city" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">State / Country</label>
                                                    <div class="controls">
                                                        <select name="country" id="country" style="width: 180px;">
                                                            <?php
                                                            $cc = $obj->SelectAllByVal($table, "id", $_GET['edit'], "country");
                                                            $sqlcountry = $obj->SelectAll("country");
                                                            if (!empty($sqlcountry))
                                                                foreach ($sqlcountry as $country):
                                                                    ?>
                                                                    <option  <?php if ($cc == $country->id) { ?> selected <?php } ?> value="<?php echo $country->id; ?>"><?php echo $country->name; ?></option> 
                                                                <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">Zip / Postal Code</label>
                                                    <div class="controls"><input value="<?php echo $obj->SelectAllByVal($table, "id", $_GET['edit'], "postalcode"); ?>" class="span8" type="text" name="postalcoad" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">&nbsp;</label>
                                                    <div class="controls">
                                                        <button type="submit" name="update" class="k-button"><i class="icon-ok"></i> Create Account</button> 
                                                        <button type="reset" name="reset" class="k-button"><i class="icon-ban-circle"></i> Reset Form</button>
                                                    </div>
                                                </div>


                                            </div>
                                            <!-- /general form elements -->
                                        </fieldset>                     

                                    </form>
                                <?php } else { ?>
                                    <form class="form-horizontal" method="post" action="">
                                        <fieldset>

                                            <!-- General form elements -->
                                            <div class="well row-fluid block">                                    
                                                <div class="control-group">
                                                    <label class="control-label">First Name:</label>
                                                    <div class="controls"><input class="span8 k-textbox" type="text" name="firstname" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">Last Name:</label>
                                                    <div class="controls"><input class="span8 k-textbox" type="text" name="lastname" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">Phone:</label>
                                                    <div class="controls"><input class="span8 k-textbox" type="text" name="phone" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">Mobile: Required for SMS</label>
                                                    <div class="controls"><input class="span8 k-textbox" type="text" name="mobilesms" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">Email</label>
                                                    <div class="controls"><input class="span8 k-textbox" type="text" name="email" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">Reffered By</label>
                                                    <div class="controls"><input class="span8 k-textbox" type="text" name="reffered" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">Business Name</label>
                                                    <div class="controls"><input class="span8 k-textbox" type="text" name="businessname" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">Address</label>
                                                    <div class="controls"><input class="span8 k-textbox" type="text" name="address1" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">Address 2</label>
                                                    <div class="controls"><input class="span8 k-textbox" type="text" name="address2" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">City</label>
                                                    <div class="controls"><input class="span8 k-textbox" type="text" name="city" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">State / Country</label>
                                                    <div class="controls">
                                                        <select name="country" id="country" style="width: 200px;">
                                                            <?php
                                                            $sqlcountry = $obj->SelectAll("country");
                                                            if (!empty($sqlcountry))
                                                                foreach ($sqlcountry as $country):
                                                                    ?>
                                                                    <option  value="<?php echo $country->id; ?>"><?php echo $country->name; ?></option> 
                                                                <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">Zip / Postal Code</label>
                                                    <div class="controls"><input class="span8 k-textbox" type="text" name="postalcoad" /></div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">Send Email </label>
                                                    <div class="controls">
                                                        <select name="sendemail"  id="sendemail" data-placeholder="Send Email After Complete Account Creation" style="width: 290px;">
                                                            <option  value="1">Yes </option>
                                                            <option  value="0">No </option> 
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label">&nbsp;</label>
                                                    <div class="controls">
                                                        <button type="submit" name="create" class="k-button"><i class="icon-ok"></i> Create Account</button> 
                                                        <button type="reset" name="reset" class="k-button"><i class="icon-ban-circle"></i> Reset Form</button>
                                                    </div>
                                                </div>


                                            </div>
                                            <!-- /general form elements -->
                                        </fieldset>                     

                                    </form>
                                <?php } ?>        

                                <!-- Content End from here customized -->




                                <div class="separator-doubled"></div> 



                            </div>
                            <!-- /content container -->

                        </div>
                    </div>
                </div>
            </div>
            <!-- /main content -->
               
            <?php 
                include('include/footer.php'); 
                echo $cms->KendoFotter();
            ?>
            <script>
                nucleus("#country").kendoDropDownList({
                    optionLabel: " -- Select State / Country-- "
                }).data("kendoDropDownList");
                
                nucleus("#sendemail").kendoDropDownList({
                    optionLabel: "Send Email After Complete Account Creation"
                }).data("kendoDropDownList").select(2);
            </script> 
            <!-- Right sidebar -->
            <?php //include('include/sidebar_right.php');  ?>
            <!-- /right sidebar -->

        </div>
        <!-- /main wrapper -->

    </body>
</html>
