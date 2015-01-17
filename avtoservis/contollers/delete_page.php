<?php
	
	require_once("../helpers/all.php");

	if(isset($_GET['sid']) && is_numeric($_GET['sid']))
	{
		$id = $_GET['sid'];

		$db = new Database();

		try
		{
			$db->delete("stranici","sid='$id'");
			$db->closeConnection();
			redirect("pages");
		}
		catch(Exception $e)
		{
			$db->closeConnection();
			echo "<meta charset='utf-8'/>";
			echo $e->getMessage();
		}

	}

	
?>