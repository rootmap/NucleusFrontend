<?php
include('../class/auth.php');
extract($_GET);
if($pid!='')
{
	?>
    <input type="text" name="new_problem" class="span8" placeholder="Please Type Your Problem  Type Here" />
    <input type="hidden" name="problem_type" value="0" />
    <?php
}
else
{
	echo "System Error, Reload Page";	
}
?>