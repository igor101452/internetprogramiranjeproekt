<?php
	
	require_once("../helpers/all.php");

	if(isset($_GET['mid']) && is_numeric($_GET['mid']))
	{
		$id = $_GET['mid'];

		$db = new Database();

		try
		{
			$db->delete("mehanicari","mid='$id'");
			$db->closeConnection();
			redirect("mechanics");
		}
		catch(Exception $e)
		{
			$db->closeConnection();
			echo "<meta charset='utf-8'/>";
			echo $e->getMessage();
		}

	}

	
?>