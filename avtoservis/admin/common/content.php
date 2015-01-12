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
			case "mehanics":	include_once('pages/mechanics.php'); 	break;
			case "roles":		include_once('pages/roles.php'); 		break;
			case "gallery":		include_once('pages/gallery.php'); 		break;
			case "pages":		include_once('pages/pages.php'); 		break;

			default: redirect("root-login"); break;
		}
	}
	else
	{
		include_once('pages/login.php');
	}

