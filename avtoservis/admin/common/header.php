<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php require('header-include-styles.php'); ?>
	<title>Автосервис</title>
</head>
<body>
	<div id="wrapper">	
		<?php if(isAuthenticated() && isAdmin()){ ?>
		<div id="header-logo">
			<?php require_once('partials/header-logo.php'); ?>
		</div>

		<div id="navigation">
			<?php require_once('partials/navigation.php'); ?>
		</div>

		<?php } ?>



