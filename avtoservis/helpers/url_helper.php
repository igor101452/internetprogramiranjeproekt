<?php
	//momentalno url
	$current_url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

	//redirect to routes
	function redirect($route)
	{
		
		switch($route)
		{
			case "root-admin": header("Location: ".ADMIN_PATH."index.php?p=schedules"); break;
			case "login-admin": header("Location: ".ADMIN_PATH); break;
			case "subscribers": header("Location: ".ADMIN_PATH."index.php?p=subscribers"); break;
			case "roles": header("Location: ".ADMIN_PATH."index.php?p=roles"); break;
			case "members": header("Location: ".ADMIN_PATH."index.php?p=members"); break;
			case "mechanics": header("Location: ".ADMIN_PATH."index.php?p=mehanics"); break;
			case "pages": header("Location: ".ADMIN_PATH."index.php?p=pages"); break;

		}
	}