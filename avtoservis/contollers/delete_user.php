<?php
	
	require_once("../helpers/all.php");

	if(isset($_GET['kid']) && is_numeric($_GET['kid']))
	{
		$id = $_GET['kid'];

		$db = new Database();

		try
		{
			$db->delete("klienti","kid='$id'");
			$db->closeConnection();
			redirect("members");
		}
		catch(Exception $e)
		{
			$db->closeConnection();
			echo "<meta charset='utf-8'/>";
			echo $e->getMessage();
		}

	}

	
?>