<?php
	
	require_once("../helpers/all.php");

	if(isset($_GET['tid']) && is_numeric($_GET['tid']))
	{
		$id = $_GET['tid'];

		$db = new Database();

		try
		{
			$db->delete("termini","tid='$id'");
			$db->closeConnection();
			if(isset($_GET['user']))
				redirect("user-schedules");
			else
				redirect("schedules");
		}
		catch(Exception $e)
		{
			$db->closeConnection();
			echo "<meta charset='utf-8'/>";
			echo $e->getMessage();
		}

	}

	
?>