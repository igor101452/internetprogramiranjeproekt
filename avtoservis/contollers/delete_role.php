<?php
	
	require_once("../helpers/all.php");

	if(isset($_GET['rid']) && is_numeric($_GET['rid']))
	{
		$id = $_GET['rid'];

		$db = new Database();

		try
		{
			$db->delete("uloga","uid='$id'");
			$db->closeConnection();
			redirect("roles");
		}
		catch(Exception $e)
		{
			$db->closeConnection();
			echo "<meta charset='utf-8'/>";
			echo $e->getMessage();
		}

	}

	
?>