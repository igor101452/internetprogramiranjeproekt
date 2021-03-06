<?php
	
	function generateRandomString($length) {
    	return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
	}

	function uploadImage($image,$gallery_name_id,$upload_type)
	{
		if($image['error']>0){
			return false;
		}

		$path = "../images/";

		$name = $image['name'];
		$size = $image['size'];
		$type = $image['type'];
			
			
		$tmp_name = $image['tmp_name'];

		if(!file_exists($path.$gallery_name_id))
		{
			mkdir($path.$gallery_name_id,0777);
			mkdir($path.$gallery_name_id."/cover",0777);
			mkdir($path.$gallery_name_id."/photos",0777);
		}

		$ext = explode(".",$name);
		$name = generateRandomString(8).".".$ext[count($ext)-1];

		if($upload_type=="cover")
		{
			if(move_uploaded_file($tmp_name, $path.$gallery_name_id."/cover/".$name)===FALSE)
			{
				return false;
			}

			return $name;
		}

		if($upload_type=="gallery_photo")
		{
			if(move_uploaded_file($tmp_name, $path.$gallery_name_id."/photos/".$name)===FALSE)
			{
				return false;
			}

			return $name;
		}
	}

	function deleteGallery($name)
	{
		$path = "../images/".$name;

		rrmdir($path);
	}

	function rrmdir($dir) {
	   if (is_dir($dir)) {
	     $objects = scandir($dir);
	     foreach ($objects as $object) {
	       if ($object != "." && $object != "..") {
	         if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
	       }
	     }
	     reset($objects);
	     rmdir($dir);
	   }
	} 

	function deletePhoto($gal_name,$photo_name){
		$path = "../images/".$gal_name."/photos/";
		$objects = scandir($path);
		 foreach ($objects as $object) {
	       if ($object != "." && $object != ".." && $object==$photo_name) {
	         unlink($path.$object);
	       }
	     }
	}

?>