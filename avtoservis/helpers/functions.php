<?php
	//prikazi poraka
	function message($string,$type)
	{
		echo "<div class='alert alert-".$type."'><strong>".$string."!</strong></div>";
	}

	//zimanje na site pretplatnici
	function getAllSubscribers()
	{
		$db = new Database();

		$db->get("*","pretplatnici");

		if($db->getRowsCount()>0)
			$subscribers = $db->resultFromGet(true);
		else
			$subscribers = 0;

		return $subscribers;

	}

	//za isprakanje na newsletter na pretplatnicite
	function send_mail($data, $mesaage, $type)
	{
		if($type=="subscribers")
		{
			 //mail ( string $to , string $subject , string $message [, string $additional_headers [, string $additional_parameters ]] )
			$subject = "Автосервис: Newsletter";
			$headers = "From: igor@yahoo.com";

		}

		foreach($data as $d)
		{
			try
			{
				//mail($d['email'],$subject,$message,$headers);
			}
			catch(Exception $e)
			{
				return false;
			}
		}

		return true;
	}
?>