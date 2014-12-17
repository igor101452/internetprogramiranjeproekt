<?php
	
	if(isset($_GET['p']))
	{	
		$page = $_GET['p'];

		switch($page)
		{
			case "members": 	include_once('pages/members.php'); 		break;
			case "subscribers": include_once('pages/subscribers.php'); 	break;
			
			default: redirect("root"); break;
		}
	}
	else
	{
		include_once('pages/schedules.php');
	}

