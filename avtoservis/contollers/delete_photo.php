<?php
	
	require_once("../helpers/all.php");

	if(isset($_GET['slid']) && is_numeric($_GET['slid']) && isset($_GET['gid']) && is_numeric($_GET['gid']))
	{
		$id = $_GET['slid'];
		$gid = $_GET['gid'];

		$db = new Database();
		$back  = $_SERVER['HTTP_REFERER'];
		try
		{
			$gallery = getGallery($gid,true);
			$photo = getPhoto($id);
			if($photo && $gallery)
			{
				$gallery_name = $gallery['ime'];
				$photo_name = $photo['slika_ime'];

				$db->delete("sliki","slid='$id'");
				deletePhoto($gallery_name,$photo_name);

				$db->closeConnection();
				
			}
			redirect("view_gallery",$gallery['gid']);
		}
		catch(Exception $e)
		{
			$db->closeConnection();
			echo "<meta charset='utf-8'/>";
			echo $e->getMessage();
		}

	}

	
?>