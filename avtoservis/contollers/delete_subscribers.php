<?php
	
	require_once("../helpers/all.php");

	if(isset($_GET['pid']) && is_numeric($_GET['pid']))
	{
		$id = $_GET['pid'];

		$db = new Database();

		$db->delete("pretplatnici","pid='$id'");

	}
	
	redirect("subscribers");
?>