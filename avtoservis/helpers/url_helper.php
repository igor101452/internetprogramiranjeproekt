<?php

	//redirect to routes
	function redirect($route)
	{
		switch($route)
		{
			case "root": header("Location: ".BASE_PATH."admin/"); break;
		}
	}