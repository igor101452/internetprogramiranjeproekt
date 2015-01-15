<?php
	//prikazi poraka
	function message($string,$type)
	{
		echo "<div class='alert alert-".$type."'><strong>".$string."!</strong></div>";
	}

	//generiraj random string
	function generateRandomString($length) {
    	return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
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

		$db->closeConnection();
		return $subscribers;

	}

	//za isprakanje na newsletter na pretplatnicite
	function send_mail($data, $message, $type)
	{
		if($type=="subscribers")
		{
			$subject = "Автосервис: Newsletter";
			$headers = "From: igor@yahoo.com";

		}

		if($type=="new_user")
		{
			$subject = "Автосервис: Нов корисник";
			$headers = "From: igor@yahoo.com";
		}

		if(is_array($data))
		{
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
		}
		else
		{
			try
			{
				//mail($data,$subject,$message,$headers);
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

		$db->closeConnection();
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

		validateData($role,'required');

		if(!empty($GLOBALS['validation_errors']))
		{
			return "Внесете име на улогата";
		}

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

			validateData($role['ime'],'required');

			if(!empty($GLOBALS['validation_errors']))
			{
				return "Внесете име на улогата";
			}

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
			$db->closeConnection();
			return "Мора да испратете низа";
		}
	}

	//zimanje na klienti/korisnici
	function getUsers()
	{
		$db = new Database();

		$db->get("*","klienti");

		if($db->getRowsCount()>0)
			$users = $db->resultFromGet(true);
		else
			$users = 0;

		$db->closeConnection();

		return $users;
	}

	//zemi odreden clen
	function getUser($id)
	{
		$db = new Database();

		$db->getWhere("*","klienti","kid='$id'");

		if($db->getRowsCount()>0)
			$user = $db->resultFromGet();
		else
			$user = 0;

		$db->closeConnection();

		return $user;
	}

	//dodavanje nov clen
	function addUser($user)
	{
		extract($user);

		validateData($fname,'required|alpha');
		validateData($lname,'required|alpha');
		validateData($email,'required|email');


		if(!empty($GLOBALS['validation_errors']))
		{
			return $GLOBALS['validation_errors'];
		}

		$db = new Database();

		$fname = $db->cleanData($fname);
		$lname = $db->cleanData($lname);
		$email = $db->cleanData($email);

		$temp_pass = generateRandomString(8);

		if($role==1) $admin = 1;
		else $admin = 0;

		$data = [
			'ime' => $fname,
			'prezime' => $lname,
			'email' => $email,
			'privremena_lozinka' => $temp_pass,
			'is_admin' => $admin,
			'uid'	=> $role,
		];

		try{
			$db->insert("klienti",$data);
			$db->closeConnection();

			$message = $fname." ".$lname."<br><br>
						Добредојдовте во Автосервис<br>
						Вашиот податоци на најава се:<br>

						емаил: ".$email."<br>
						лозинка: ".$temp_pass."<br>
						<br>

						Ве молиме откако ќе се најавите сменета ја вашата лозинка.		
			";

			send_mail($email,$message,"new_user");

			return true;
		}
		catch(Exception $e)
		{
			$db->closeConnection();
			return false;
		}
	}

	//dodavanje nov clen
	function updateUser($user)
	{
		extract($user);

		validateData($fname,'required|alpha');
		validateData($lname,'required|alpha');
		validateData($email,'required|email');


		if(!empty($GLOBALS['validation_errors']))
		{
			return $GLOBALS['validation_errors'];
		}

		$db = new Database();

		$fname = $db->cleanData($fname);
		$lname = $db->cleanData($lname);
		$email = $db->cleanData($email);

		if($role==1) $admin = 1;
		else $admin = 0;

		$data = [
			'ime' => $fname,
			'prezime' => $lname,
			'email' => $email,
			'is_admin' => $admin,
			'uid'	=> $role,
		];

		try{
			$db->update("klienti",$data,"kid='$kid'");
			$db->closeConnection();

			$message = $fname." ".$lname."<br><br>
						Промена на податоци<br>
						Вашите податоци се:<br>

						име: ".$fname."<br>
						презиме: ".$lname."<br>
						емаил: ".$email."<br>
						<br>		
			";

			send_mail($email,$message,"new_user");

			return true;
		}
		catch(Exception $e)
		{
			$db->closeConnection();
			return false;
		}
	}
?>