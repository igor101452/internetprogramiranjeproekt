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
	function send_mail($data, $message, $type)
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

	//zimanje na ulogi
	function getRoles()
	{
		$db = new Database();

		$db->get("*","uloga");

		if($db->getRowsCount()>0)
			$roles = $db->resultFromGet(true);
		else
			$roles = 0;

		return $roles;
	}

	//zemi odredena uloga
	function getRole($id)
	{
		$db = new Database();

		$db->getWhere("*","uloga","uid='$id'");

		if($db->getRowsCount()>0)
			$roles = $db->resultFromGet();
		else
			$roles = 0;

		$db->closeConnection();

		return $roles;
	}

	//dodavanje nova uloga
	function addRole($role)
	{
		$db = new Database();

		$role = $db->cleanData($role);

		$data = [
			'ime' => $role
		];

		try{
			$db->insert("uloga",$data);
			$db->closeConnection();
			return true;
		}
		catch(Exception $e)
		{
			$db->closeConnection();
			return false;
		}
	}

	//azuriranje na uloga
	function updateRole($role)
	{
		if(is_array($role)){
			$db = new Database();

			$new_name = $db->cleanData($role['ime']);

			$data = [
				'ime' => $new_name
			];
			
			try{
				$db->update("uloga",$data,"uid='".$role['rid']."'");
				$db->closeConnection();
				return true;
			}
			catch(Exception $e)
			{
				$db->closeConnection();
				return false;
			}
		}
		else
		{
			return "Мора да испратете низа";
		}
	}
?>