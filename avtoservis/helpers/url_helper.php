<?php
	//momentalno url
	$current_url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	
	//redirect to routes
	function redirect($route,$id="")
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
			case "schedules": header("Location: ".ADMIN_PATH."index.php?p=schedules"); break;
			case "gallery": if($id=="") header("Location: ".ADMIN_PATH."index.php?p=gallery"); 
							else header("Location: ".ADMIN_PATH."index.php?p=gallery&view=".$id);
							break;

			case "root": header("Location: ".BASE_PATH."index.php"); break;
			case "contact": header("Location: ".BASE_PATH."index.php?p=contact"); break;
			case "about-us": header("Location: ".BASE_PATH."index.php?p=about-us"); break;
			case "profile": header("Location: ".BASE_PATH."index.php?p=profile&info"); break;
			case "user-schedules": header("Location: ".BASE_PATH."index.php?p=profile&schedules"); break;
			case "user-gallery": header("Location: ".BASE_PATH."index.php?p=gallery"); break;
			case "mehanicari": header("Location: ".BASE_PATH."index.php?p=mehanicari"); break;
		}
	}