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

	//zimanje na avtoservisite, samo prviot ke go zememe
	function getAutoservices()
	{
		$db = new Database();

		$db->get("*","avtoservis");

		if($db->getRowsCount()>0)
			$autoservices = $db->resultFromGet();
		else
			$autoservices = 0;

		$db->closeConnection();
		return $autoservices;
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
			$insert_id = $db->getInsertID();
			$aid = getAutoservices()['aid'];
			$db->insert("avtoservis_klienti",['aid' => $aid, 'kid' => $insert_id]);
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

	//zimanje na mehanicar
	function getMechanics()
	{
		$db = new Database();

		$db->get("*","mehanicari");

		if($db->getRowsCount()>0)
			$mechanics = $db->resultFromGet(true);
		else
			$mechanics = 0;

		$db->closeConnection();

		return $mechanics;
	}

	//zemi odreden mehanicar
	function getMechanic($id)
	{
		$db = new Database();

		$db->getWhere("*","mehanicari","mid='$id'");

		if($db->getRowsCount()>0)
			$mechanic = $db->resultFromGet();
		else
			$mechanic = 0;

		$db->closeConnection();

		return $mechanic;
	}

	//dodavanje nov mehanicar
	function addMechanic($mechanic)
	{
		extract($mechanic);

		validateData($fname,'required|alpha');
		validateData($lname,'required|alpha');
		validateData($pozicija,'required');

		if(!empty($GLOBALS['validation_errors']))
		{
			return $GLOBALS['validation_errors'];
		}

		$autoserice_id = getAutoservices()['aid'];
		$active = isset($status) ? 1 : 0;

		$db = new Database();

		$fname 		= $db->cleanData($fname);
		$lname 		= $db->cleanData($lname);
		$pozicija 	= $db->cleanData($pozicija);

		$data = [
			'ime' => $fname,
			'prezime' => $lname,
			'pozicija' => $pozicija,
			'status' => $active,
			'aid'	=> $autoserice_id
		];

		try{
			$db->insert("mehanicari",$data);
			$db->closeConnection();
			return true;
		}
		catch(Exception $e)
		{
			$db->closeConnection();
			return false;
		}
	}

	//azuriranje na mehanicar
	function updateMechanic($mechanic)
	{
		extract($mechanic);

		validateData($fname,'required|alpha');
		validateData($lname,'required|alpha');
		validateData($pozicija,'required');


		if(!empty($GLOBALS['validation_errors']))
		{
			return $GLOBALS['validation_errors'];
		}

		$active = isset($status) ? 1 : 0;

		$db = new Database();

		$fname 		= $db->cleanData($fname);
		$lname 		= $db->cleanData($lname);
		$pozicija	 = $db->cleanData($pozicija);

		$data = [
			'ime' => $fname,
			'prezime' => $lname,
			'pozicija' => $pozicija,
			'status' => $active,
		];

		try{
			$db->update("mehanicari",$data,"mid='$mid'");
			$db->closeConnection();
			return true;
		}
		catch(Exception $e)
		{
			$db->closeConnection();
			return false;
		}
	}

	function mechanicStatusChange($mid)
	{
		$mechanic = getMechanic($mid);

		if($mechanic['status'])
		{
			$status = 0;
		}
		else
		{
			$status = 1;
		}

		$db = new Database();
		try
		{
			$db->update("mehanicari",['status' => $status],"mid='$mid'");
			$db->closeConnection();
			return true;
		}
		catch(Exception $e)
		{
			$db->closeConnection();
			return false;
		}
	}

	//zimanje na stranici
	function getPages()
	{
		$db = new Database();

		$db->get("*","stranici");

		if($db->getRowsCount()>0)
			$pages = $db->resultFromGet(true);
		else
			$pages = 0;

		$db->closeConnection();

		return $pages;
	}

	//zemi odredena strana
	function getPage($id)
	{
		$db = new Database();

		$db->getWhere("*","stranici","sid='$id'");

		if($db->getRowsCount()>0)
			$page = $db->resultFromGet();
		else
			$page = 0;

		$db->closeConnection();

		return $page;
	}

	//dodavanje nova stranica
	function addPage($page)
	{
		extract($page);

		validateData($name,'required');
		validateData($slug,'required');
		validateData($content,'required');

		if(!empty($GLOBALS['validation_errors']))
		{
			return $GLOBALS['validation_errors'];
		}

		$autoserice_id = getAutoservices()['aid'];

		$db = new Database();

		$name 		= $db->cleanData($name);
		$slug 		= $db->cleanData($slug);
		//$content 	= $db->cleanData($content);

		$data = [
			'ime' => $name,
			'slug' => $slug,
			'sodrzina' => $content,
			'aid'	=> $autoserice_id
		];

		try{
			$db->insert("stranici",$data);
			$db->closeConnection();
			return true;
		}
		catch(Exception $e)
		{
			$db->closeConnection();
			return false;
		}
	}

	//azuriranje na stranica
	function updatePage($page)
	{
		extract($page);

		validateData($name,'required');
		validateData($slug,'required');
		validateData($content,'required');

		if(!empty($GLOBALS['validation_errors']))
		{
			return $GLOBALS['validation_errors'];
		}

		$db = new Database();

		$name 		= $db->cleanData($name);
		$slug 		= $db->cleanData($slug);
		//$content 	= $db->cleanData($content);

		$data = [
			'ime' => $name,
			'slug' => $slug,
			'sodrzina' => $content,
		];

		try{
			$db->update("stranici",$data,"sid='$sid'");
			$db->closeConnection();
			return true;
		}
		catch(Exception $e)
		{
			$db->closeConnection();
			return false;
		}
	}
?>