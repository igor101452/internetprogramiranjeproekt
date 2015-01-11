<?php
	
	if(isset($_GET['p']))
	{	
		$page = $_GET['p'];

		switch($page)
		{
			case "members": 	include_once('pages/members.php'); 		break;
			case "subscribers": include_once('pages/subscribers.php'); 	break;
			case "login":		include_once('pages/login.php');		break;
			case "logout":		include_once('pages/logout.php');		break;
			case "schedules":	include_once('pages/schedules.php'); 	break;
			
			default: redirect("root-login"); break;
		}
	}
	else
	{
		include_once('pages/login.php');
	}

