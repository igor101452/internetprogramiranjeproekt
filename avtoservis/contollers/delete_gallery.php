<?php
	
	require_once("../helpers/all.php");

	if(isset($_GET['gid']) && is_numeric($_GET['gid']))
	{
		$id = $_GET['gid'];

		$db = new Database();

		try
		{
			$gallery = getGallery($id,true);
			$gallery_name = $gallery['ime'];
			//die($gallery_name);
			$db->delete("galerija","gid='$id'");
			deleteGallery($gallery_name);

			$db->closeConnection();
			redirect("gallery");
		}
		catch(Exception $e)
		{
			$db->closeConnection();
			echo "<meta charset='utf-8'/>";
			echo $e->getMessage();
		}

	}

	
?>