<?php

	//redirect to routes
	function redirect($route)
	{
		
		switch($route)
		{
			case "root-admin": header("Location: ".ADMIN_PATH."index.php?p=schedules"); break;
			case "login-admin": header("Location: ".ADMIN_PATH); break;
			case "subscribers": header("Location: ".ADMIN_PATH."index.php?p=subscribers"); break;
		}
	}