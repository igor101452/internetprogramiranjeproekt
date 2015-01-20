<div class="sodrzina">
	<?php if(isset($_GET['p']))
	{	
		$page = $_GET['p'];

		switch($page)
		{
			case "contact": 	include_once('pages/contact.php'); 		break;
			case "about-us":
			case "services": 
			case "special-offers":
			case "location":
								include_once('pages/static.php'); 		break;
			case "home":		include_once('pages/home.php'); 		break;
			case "logout":		include_once('pages/logout.php');		break;
			case "profile":		include_once('pages/profile.php');		break;
			case "user-gallery":include_once('pages/gallery.php');		break;
			case "mehanicari":include_once('pages/mehanicari.php');		break;

			default: redirect("root"); break;
		}
	}else{
		include_once('pages/home.php');
	} ?>
</div>
<div class="clear"></div>