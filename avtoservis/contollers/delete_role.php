<?php
	
	require_once("../helpers/all.php");

	if(isset($_GET['rid']) && is_numeric($_GET['rid']))
	{
		$id = $_GET['rid'];

		$db = new Database();

		$db->delete("uloga","uid='$id'");

	}

	redirect("roles");
?>