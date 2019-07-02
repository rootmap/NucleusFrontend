<?php 
if(isset($_GET['invoice']))
{
	header('location: pos.php?action=pdf&invoice='.$_POST['sidd']);	
}
else
{
	header('location: pos.php');	
}
?>