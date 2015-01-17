<?php
	//AJAX povik
	if(isset($_GET['mid']) && is_numeric($_GET['mid']))
	{

		require_once("../helpers/all.php");

		$status = mechanicStatusChange($_GET['mid']);

		if($status)
		{
			echo "true";
		}
		else
		{
			echo "false";
		}
	}
?>