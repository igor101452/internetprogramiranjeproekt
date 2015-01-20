<!DOCTYPE html>
<html lang="mk">
<head>
	<meta charset="UTF-8">
	<title>Почетна</title>
	<link href="assets/styles/style.css" type="text/css" rel="stylesheet" />
	<link rel="stylesheet" href="assets/libraries/jquery-ui/jquery-ui.min.css" >
	<link rel="stylesheet" href="assets/libraries/jquery-ui/jquery-ui.theme.min.css" >
	<link rel="stylesheet" href="assets/scripts/timepicker/jquery.timepicker.min.css" >
</head>
<body>
	<div id = "overlay"></div>
		
		<div id = "frame">
			<table id="frame-table">
				<tr>
					<td>
						<div id="left"></div>	
					</td>
					<td>
						<div id="right"></div>	
					</td>
				</tr>
			</table>
			<img id="main" src="" alt=""/>
		</div>
	<div class="header">
		<img src="../images/banner.png" alt="baner" width="100%" height="300px;">
		<nav>
	      <ul>
	        <li <?php if(!isset($_GET['p'])) echo "class='active'";?>><a href="<?php echo BASE_PATH; ?>">Почетна</a></li>
	        <li id="meni" <?php if(isset($_GET['p']) && $_GET['p'] == 'about-us') echo "class='active'";?> ><a href="<?php echo BASE_PATH."index.php?p=about-us"; ?>">За нас</a>
			<ul class="podmeni">
	            <li><a href="<?php echo BASE_PATH."index.php?p=user-gallery"; ?>">Галерија</a></li>
	            <li><a href="<?php echo BASE_PATH."index.php?p=mehanicari"; ?>">Механичари</a></li>
	          </ul>
	        </li>
	        <li <?php if(isset($_GET['p']) && $_GET['p'] == 'services') echo "class='active'";?>><a href="<?php echo BASE_PATH."index.php?p=services"; ?>">Сервиси</a></li>
	        <li <?php if(isset($_GET['p']) && $_GET['p'] == 'special-offers') echo "class='active'";?>><a href="<?php echo BASE_PATH."index.php?p=special-offers"; ?>">Специјални понуди</a></li>
	        <li <?php if(isset($_GET['p']) && $_GET['p'] == 'location') echo "class='active'";?>><a href="<?php echo BASE_PATH."index.php?p=location"; ?>" >Локација</a></li>
	        <li <?php if(isset($_GET['p']) && $_GET['p'] == 'contact') echo "class='active'";?>><a href="<?php echo BASE_PATH."index.php?p=contact"; ?>">Контакт</a></li>
	        <?php session_start(); if(isset($_SESSION['logged']) && !isAdmin()){ ?>
		        <li <?php if(isset($_GET['p']) && $_GET['p'] == 'profile') echo "class='active'";?>><a href="<?php echo BASE_PATH."index.php?p=profile&info"; ?>">Профил</a></li>
	        <?php } ?>
	      </ul>
	    </nav>
	</div>
	<a id="gal"></a>
	<div class="clear"></div>