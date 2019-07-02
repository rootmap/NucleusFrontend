<?php
include('../class/auth.php');
extract($_GET);
if($st==1)
{
	?>
		<input type="text"  name="new_customer" id="fristname" class="span6" placeholder="Please Type Your New Customer name" />
        
		
	<?php
}
elseif($st==301)
{
	?>
        <h4 style="margin-top: -20px;"><i class="icon-user"></i> Please type your new customer info <hr></h4>        
        <label class="control-label"><strong>First Name : </strong></label>	<input style="width: 200px;" type="text"  name="firstname" id="firstname" class="span12" placeholder="Your First Name" /> <br /> <br />
        <label class="control-label"><strong>Last Name : </strong></label>	<input style="width: 200px;" type="text"  name="lastname" id="lastname" class="span12" placeholder="Your Last Name" /> <br /> <br />
        <label class="control-label"><strong>Email Address : </strong></label>	<input style="width: 200px;" type="text"  name="email" id="email" class="span12" placeholder="Your Valid Email" /> <br /> <br />
        <label class="control-label"><strong>Phone Number : </strong></label>	<input style="width: 200px;" type="text"  name="phone" id="phone" class="span12" placeholder="Your Valid Phone Number" /> <br /> 
        
		
	<?php
}
elseif($st==102)
{
	$chk=$obj->exists_multiple("coustomer",array("id"=>$name));
	if($chk!=0)
	{
	?>
    	<input type="hidden" name="cid" value="<?php echo $name; ?>" />
		<div class="control-group">
            <label class="span12"> First Name </label>
                <input class="span6" value="<?php echo $obj->SelectAllByVal("coustomer","id",$name,"firstname"); ?>" placeholder="Your First Name" type="text" name="firstname" />
        </div>
        
        <div class="control-group">
            <label class="span12"> Last Name </label>
               <input class="span6" value="<?php echo $obj->SelectAllByVal("coustomer","id",$name,"lastname"); ?>"  placeholder="Your Last Name" type="text" name="lastname" />
        </div>
        
        <div class="control-group">
            <label class="span12"> Email Address </label>
               <input class="span6" value="<?php echo $obj->SelectAllByVal("coustomer","id",$name,"email"); ?>"  placeholder="Your Valid Email Address" type="text" name="email" />
        </div>
        
        <div class="control-group">
            <label class="span12"> Customer Phone </label>
               <input class="span6" value="<?php echo $obj->SelectAllByVal("coustomer","id",$name,"phone"); ?>"  placeholder="Your Valid Phone Number" type="text" name="phone" />
        </div>
		
	<?php
	}
	else
	{
		?>
        <input type="hidden" name="cid" value="<?php echo $name; ?>" />
        <div class="control-group">
            <label class="span12"> First Name </label>
                <input class="span6" placeholder="Your First Name" type="text" name="firstname" />
        </div>
        
        <div class="control-group">
            <label class="span12"> Last Name </label>
               <input class="span6" placeholder="Your Last Name" type="text" name="lastname" />
        </div>
        
        <div class="control-group">
            <label class="span12"> Email Address </label>
               <input class="span6" placeholder="Your Valid Email Address" type="text" name="email" />
        </div>
        
        <div class="control-group">
            <label class="span12"> Phone </label>
               <input class="span6" placeholder="Your Valid Phone Number" type="text" name="phone" />
        </div>
        <?php
	}
}
elseif($st==101)
{
        $cusinfo=$obj->FlyQuery("SELECT id,firstname,businessname,phone,email FROM coustomer WHERE id='".$name."'");
	$cusname=$cusinfo[0]->firstname;
	$businessname=$cusinfo[0]->businessname;
	$phonenumber=$cusinfo[0]->phone;
        $email=$cusinfo[0]->email;
	$obj->update("invoice",array("invoice_id"=>$cart,"cid"=>$name));
        if($obj->exists_multiple("reccurring_invoice",array("sales_id"=>$cart))!=0)
        {
            $obj->update("reccurring_invoice",array("sales_id"=>$cart,"cid"=>$name,"email"=>$email));
        }
	?>
    <div class="control-group">
        	<label class="control-label">Customer Name :</label>
        <div class="controls">
        	<input class="span6" type="text" value="<?php echo $cusname; ?>" placeholder="Customer Name here..." />
            <input class="span6" name="cuss" type="hidden" value="<?php echo $name; ?>" />
        </div>
    </div>    
    <div class="control-group">
        	<label class="control-label">Business Name :</label>
        <div class="controls">
        	<input class="span6" type="text"  value="<?php echo $businessname; ?>" placeholder="Customer Business here..." />
        </div>
    </div>
    <div class="control-group">
        	<label class="control-label">Phone Number </label>
        <div class="controls">
        	<input class="span6" type="text"  value="<?php echo $phonenumber; ?>" placeholder="Customer Phone here..." />
        </div>
    </div>
	<?php
}
elseif($st==2)
{
	$ex=$obj->exists_multiple("coustomer",array("firstname"=>$name));
	if($ex==0)
	{
		if($obj->insert("coustomer",array("firstname"=>$name,"input_by"=>$input_by))==1)
		{
			$sqlcustomer=$obj->SelectAllByID_Multiple("coustomer",array("firstname"=>$name,"input_by"=>$input_by));
			if(!empty($sqlcustomer))
			?>
            <select name="customername" onChange="new_customer(this.value)" id="customername" data-placeholder="Choose a Customer..." class="select-search select2-offscreen" tabindex="-1">
            <option value=""></option> 
            <?php
			foreach($sqlcustomer as $customer):
				?>
                <option value="<?php  echo $customer->id; ?>"><?php echo $customer->firstname." ".$customer->lastname; ?></option> 
                <?php
			endforeach;
			?>
            <option value="0">Add New Customer</option> 
            </select>
            <?php
		}
		else
		{
			echo "Reload Page";
		}
	}
	else
	{
		echo "Reload Page";	
	}
}
elseif($st==302)
{
	$ex=$obj->exists_multiple("coustomer",array("firstname"=>$firstname,"lastname"=>$lastname,"email"=>$email,"input_by"=>$input_by));
	if($ex==0)
	{
		if($obj->insert("coustomer",array("firstname"=>$firstname,"lastname"=>$lastname,"email"=>$email,"phone"=>$phone,"input_by"=>$input_by))==1)
		{
			$sqlcustomer=$obj->SelectAllByID_Multiple("coustomer",array("firstname"=>$firstname,"lastname"=>$lastname,"email"=>$email,"phone"=>$phone,"input_by"=>$input_by));
			echo $cusid=$sqlcustomer[0]->id;
		}
		else
		{
			$sqlcustomer=$obj->SelectAllByID_Multiple("coustomer",array("firstname"=>$firstname,"lastname"=>$lastname,"email"=>$email,"phone"=>$phone,"input_by"=>$input_by));
			echo $cusid=$sqlcustomer[0]->id;
		}
	}
	else
	{
		$sqlcustomer=$obj->SelectAllByID_Multiple("coustomer",array("firstname"=>$firstname,"lastname"=>$lastname,"email"=>$email,"phone"=>$phone,"input_by"=>$input_by));
                echo $cusid=$sqlcustomer[0]->id;	
	}
}
elseif($st==3)
{
	?>
    <button type="button" onclick="save_customer()" class="btn btn-success"><i class="icon-ok"></i> Save Customer</button> 
    <button type="reset" class="btn btn-danger"><i class="icon-ban-circle"></i> Reset Form</button>
    <?php
}
elseif($st==303)
{
	?>
    <button type="button" onclick="save_customer_from_ticket()" class="btn btn-success"><i class="icon-ok"></i> Save Customer</button> 
    <button type="reset" class="btn btn-danger"><i class="icon-ban-circle"></i> Reset Form</button>
    <?php
}
elseif($st==4)
{ 
	$data=$obj->SelectAllByVal($table,$id,$val,$uf); 
		?>
        <input type="text" style="margin-top:-4px;" id="name" value="<?php echo $data; ?>" class="span6" placeholder="Please Type Your <?php echo $uf; ?>" />
        
	<button type="button" class="label btn-info" onclick="update('<?php echo $table; ?>','<?php echo $id; ?>','<?php echo $val; ?>','<?php echo $uf; ?>')"><i class="icon-check"></i> </button>
	<?php 
}
elseif($st==44)
{ 
	$data=$obj->SelectAllByVal($table,$id,$val,$uf); 
	if($data==0)
	{
		$obj->update($table,array($id=>$val,$uf=>1)); 
		echo $obj->invoice_tax_status(1);	
	}
	elseif($data==1)
	{
		$obj->update($table,array($id=>$val,$uf=>0)); 
		echo $obj->invoice_tax_status(0);	
	}
	?>
    <span onclick="get_data_cus_invoice('<?php echo $table; ?>','<?php echo $id; ?>','<?php echo $val; ?>','<?php echo $pre; ?>','<?php echo $uff; ?>')"><i class="icon-edit"></i> </span>
	<?php 
}
elseif($st==5)
{ 
	if($obj->update($table,array($id=>$val,$uf=>$uv))==1)
	{
		echo $uv;
	}
	else
	{
		echo "Reload Page";
	}
	?>
    <span onclick="update('<?php echo $table; ?>','<?php echo $id; ?>','<?php echo $val; ?>','<?php echo $uf; ?>')"><i class="icon-edit"></i> </span>
    <?php
}
elseif($st==6)
{
?>
<select name="creators" id="creators">
<?php
 $sqlpdata=$obj->SelectAll("store");
 if(!empty($sqlpdata))
 foreach($sqlpdata as $row):
?>
<option value="<?php  echo $row->id; ?>"><?php echo $row->name; ?></option>
<?php endforeach; ?> 
</select>
<span onclick="save_invoice_creator(<?php echo $cart; ?>)"><i class="icon-check"></i> </span>

<?php	
}
elseif($st==7)
{
	$obj->update("invoice",array("invoice_id"=>$invoice_id,"invoice_creator"=>$creator));
	echo $obj->SelectAllByVal("store","id",$creator,"name");
	?>
    <span onclick="invoice_creator('<?php echo $invoice_id; ?>')"><i class="icon-edit"></i> </span>
    <?php 
	
}
elseif($st==8)
{ 
	$data=$obj->SelectAllByVal($table,$id,$val,$uf); 
		?>
        <label>
        <input type="checkbox" name="name" id="name"> Paid
        </label>
        
        <label>
        <input type="checkbox" name="paid" id="paid"> Not Yet
        </label>
        
	<button type="button" class="label btn-info" onclick="update_two('<?php echo $table; ?>','<?php echo $id; ?>','<?php echo $val; ?>','<?php echo $uf; ?>')"><i class="icon-check"></i> </button>
	<?php 
}
elseif($st==9)
{ 
	if($obj->update($table,array($id=>$val,$uf=>$uv))==1)
	{
		echo $obj->invoice_paid_status($uv);
	}
	else
	{
		echo "Reload Page";
	}
	?>
    <span onclick="get_data_cus_two('<?php echo $table; ?>','<?php echo $id; ?>','<?php echo $val; ?>','<?php echo $uf; ?>')"><i class="icon-edit"></i> </span>
    <?php
	
}
elseif($st==9999)
{ 
    $obj->insert("coustomer",array("firstname"=>$f_customer,"businessname"=>$businessname,"email"=>$email,"phone"=>$phonenumber,"input_by"=>$input_by));
    echo $cusid=$obj->SelectAllByVal2("coustomer","email",$email,"input_by",$input_by,"id");
}
else
{
	echo "System Error, Reload Page";	
}
?>