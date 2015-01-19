<!DOCTYPE html>
<html lang="mk">
<head>
	<meta charset="UTF-8">
	<title>Почетна</title>
	<link href="assets/style.css" type="text/css" rel="stylesheet" />
</head>
<body>
	<div class="header">
		<img src="../images/banner.png" alt="baner" width="100%" height="300px;">
		<nav>
	      <ul>
	        <li <?php if(!isset($_GET['p'])) echo "class='active'";?>><a href="<?php echo BASE_PATH; ?>">Почетна</a></li>
	        <li <?php if(isset($_GET['p']) && $_GET['p'] == 'about-us') echo "class='active'";?> ><a href="<?php echo BASE_PATH."index.php?p=about-us"; ?>">За нас</a></li>
	        <li <?php if(isset($_GET['p']) && $_GET['p'] == 'services') echo "class='active'";?>><a href="<?php echo BASE_PATH."index.php?p=services"; ?>">Сервиси</a></li>
	        <li><a href="#">Страница 3</a></li>
	        <li id="meni"><a href="#">Страница 4</a>
	          <ul class="podmeni">
	            <li><a href="#">Потстраница 1</a></li>
	            <li><a href="#">Потстраница 2</a></li>
	          </ul>
	        </li>
	        <li><a href="#" class="koscnicka">Страница 5</a></li>
	        <li <?php if(isset($_GET['p']) && $_GET['p'] == 'contact') echo "class='active'";?>><a href="<?php echo BASE_PATH."index.php?p=contact"; ?>">Контакт</a></li>
	      </ul>
	    </nav>
	</div>
	<div class="clear"></div>