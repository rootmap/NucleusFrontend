<?php
include('class/auth.php');
if($_POST)
{
	if($_POST["fetch"]==101)
	{
		?>
        successfully ajax work
        
		</div>
		<?php
		$obj->close($obj->open());
		exit();
	}
	else
	{
		header('HTTP/1.1 500 Are you kiddin me? Empty Not Allowed To Submit');
    	exit();
	}
}
$obj->close($obj->open());