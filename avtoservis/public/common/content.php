<div class="sodrzina">
	<?php if(isset($_GET['p']))
	{	
		$page = $_GET['p'];

		switch($page)
		{
			case "contact": 	include_once('pages/contact.php'); 		break;
			case "about-us":
			case "services": 	
								include_once('pages/static.php'); 		break;
			case "home":		include_once('pages/home.php'); 		break;

			default: redirect("root"); break;
		}
	}else{
		include_once('pages/home.php');
	} ?>
</div>
<div class="clear"></div>