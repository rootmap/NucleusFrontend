<?php
include('../class/auth.php');
if($_POST)
{
	
	if($_POST["fetch"]==1)
	{
		extract($_POST);
	   ?>
       
       <?php
	}
	elseif($_POST["fetch"]==2)
	{
		include('../class/function.php');
		$ops = new pos();
		function checkin_paid($st) {
			if ($st == 0) {
				return "Unpaid";
			} else {
				return "Paid";
			}
		}
		
		
		extract($_POST);
		
		$device=$obj->SelectAllByVal("checkin_list", "checkin_id", $ticket_id, "device");
		$version=$obj->SelectAllByVal("checkin_list", "checkin_id", $ticket_id, "model");
		$problem=$obj->SelectAllByVal("checkin_list", "checkin_id", $ticket_id, "problem");
	   ?>
       
       <?php
	}
	elseif($_POST["fetch"]==3)
	{
		
		extract($_POST);
	   ?>
            
       <?php
	}
	elseif($_POST["fetch"]==4)
	{
		
		extract($_POST);
	   ?>
            
            
       <?php
	}
	elseif($_POST["fetch"]==5)
	{
		function checkin_paid($st) {
			if ($st == 0) {
				return "Unpaid";
			} else {
				return "Paid";
			}
		}
		extract($_POST);
		
       
       <?php
	}
	else
	{
		header('HTTP/1.1 500 Are you kiddin me? Empty Not Allowed To Submit');
    	exit();
	}
}