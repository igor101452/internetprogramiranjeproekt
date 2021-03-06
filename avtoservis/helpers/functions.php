<?php
	//prikazi poraka
	function message($string,$type)
	{
		echo "<div class='alert alert-".$type."'><strong>".$string."!</strong></div>";
	}

	//generiraj random string
	// function generateRandomString($length) {
 //    	return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
	// }

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

		if($type=="schedule_request")
		{
			$subject = "Автосервис: Барање за термин";
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
	function addUser($user,$client=false)
	{
		extract($user);

		validateData($fname,'required|alpha');
		validateData($lname,'required|alpha');
		validateData($email,'required|email|unique');
		validateData($password, 'required');
		validateData($r_password, 'required');
		matchPasswords($r_password,$password);


		if(!empty($GLOBALS['validation_errors']))
		{
			return $GLOBALS['validation_errors'];
		}

		$db = new Database();

		$fname = $db->cleanData($fname);
		$lname = $db->cleanData($lname);
		$email = $db->cleanData($email);

		if($client=false)
		{

			$temp_pass = generateRandomString(8);

			if(isset($role) && $role==1) $admin = 1;
			else $admin = 0;

			if(isset($password))
			{
				$data = [
					'ime' => $fname,
					'prezime' => $lname,
					'email' => $email,
					'lozinka' => $password,
					'is_admin' => $admin,
					'uid'	=> 2,
				];
			}
			else
			{
				$data = [
					'ime' => $fname,
					'prezime' => $lname,
					'email' => $email,
					'privremena_lozinka' => $temp_pass,
					'is_admin' => $admin,
					'uid'	=> $role,
				];
			}
		}
		else
		{
			$data = [
					'ime' => $fname,
					'prezime' => $lname,
					'email' => $email,
					'lozinka' => $password,
					'is_admin' => 0,
					'uid'	=> 2,
				];
		}

		try{
			$db->insert("klienti",$data);
			$insert_id = $db->getInsertID();
			$aid = getAutoservices()['aid'];
			$db->insert("avtoservis_klienti",['aid' => $aid, 'kid' => $insert_id]);
			$db->closeConnection();

			if($client==false)
			{
				if(!isset($password))
				{
					$message = $fname." ".$lname."<br><br>
								Добредојдовте во Автосервис<br>
								Вашиот податоци на најава се:<br>

								емаил: ".$email."<br>
								лозинка: ".$temp_pass."<br>
								<br>

								Ве молиме откако ќе се најавите сменета ја вашата лозинка.		
					";

					send_mail($email,$message,"new_user");
				}
			}
			else
			{
				$message = $fname." ".$lname."<br><br>
								Добредојдовте во Автосервис<br>
								Сега можете да ги користите услугите на нашиот сервис.	
				";

				send_mail($email,$message,"new_user");
			}
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

		if(isset($password) && $password!="")
		{
			$password = $db->cleanData($password);
			$admin = 0;
		}
		else
		{
			if(isset($role) && $role==1) $admin = 1;
			else $admin = 0;
		}
		if(isset($password))
		{
			if(strlen($password)==0) {
				$data = [
					'ime' => $fname,
					'prezime' => $lname,
					'email' => $email,
				];
			}else{
				$data = [
					'ime' => $fname,
					'prezime' => $lname,
					'email' => $email,
					'lozinka' => $password,
				];
			}		
		}
		else
		{
			$data = [
				'ime' => $fname,
				'prezime' => $lname,
				'email' => $email,
				'is_admin' => $admin,
				'uid'	=> $role,
			];
		}

		try{
			$db->update("klienti",$data,"kid='$kid'");
			$db->closeConnection();
			if(!isset($password))
			{
				$message = $fname." ".$lname."<br><br>
							Промена на податоци<br>
							Вашите податоци се:<br>

							име: ".$fname."<br>
							презиме: ".$lname."<br>
							емаил: ".$email."<br>
							<br>		
				";

				send_mail($email,$message,"new_user");
			}
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

		$db->getWhere("*","stranici","sid='$id' OR slug='$id'");

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

	//zimanje na terminite
	function getSchedules($user_id=null)
	{
		$db = new Database();

		$autoserice_id = getAutoservices()['aid'];

		if($user_id===null)
			$db->join("termini","avtoservis_termini","termini.tid=avtoservis_termini.tid","aid='$autoserice_id'");
		else
			$db->join("termini","avtoservis_termini","termini.tid=avtoservis_termini.tid","aid='$autoserice_id' AND termini.kid='$user_id'");

		if($db->getRowsCount()>0)
			$schedules = $db->resultFromGet(true);
		else
			$schedules = 0;

		$db->closeConnection();

		return $schedules;
	}

	//zemi odreden termin
	function getSchedule($id)
	{
		$db = new Database();

		$autoserice_id = getAutoservices()['aid'];

		$db->join("termini","avtoservis_termini","termini.tid=avtoservis_termini.tid","aid='$autoserice_id'AND termini.tid='$id'");

		if($db->getRowsCount()>0)
			$schedule = $db->resultFromGet();
		else
			$schedule = 0;

		$db->closeConnection();

		return $schedule;
	}

	//dodavanje nov termin
	function addSchedule($schedule)
	{
		extract($schedule);

		validateData($content,'required');

		if(!empty($GLOBALS['validation_errors']))
		{
			return $GLOBALS['validation_errors'];
		}

		$autoserice_id 	= getAutoservices()['aid'];
		$user_id		= $_SESSION['user']['uid'];

		$db = new Database();

		$data = [
			'sodrzina' => $content,
			'kid'	=> $user_id
		];

		try{
			$db->insert("termini",$data);
			$tid = $db->getInsertID();
			$data2 = [
				'aid' => $autoserice_id,
				'tid' => $tid,
				'vreme' => $time,
				'datum' => $date
			];
			$db->insert("avtoservis_termini",$data2);
			$db->closeConnection();
			return true;
		}
		catch(Exception $e)
		{
			$db->closeConnection();
			return false;
		}
	}

	//azuriranje na termin
	function updateSchedule($schedule)
	{
		extract($schedule);

		validateData($content,'required');

		if(!empty($GLOBALS['validation_errors']))
		{
			return $GLOBALS['validation_errors'];
		}

		$autoserice_id 	= getAutoservices()['aid'];
		$user_id		= $_SESSION['user']['uid'];

		$db = new Database();

		$data = [
			'sodrzina' => $content,
			'kid'	=> $user_id
		];

		try{
			$db->update("termini",$data,"tid='$id'");
			$data2 = [
				'vreme' => $time,
				'datum' => $date
			];
			$db->update("avtoservis_termini",$data2,"aid='$autoserice_id' AND tid='$id'");
			$db->closeConnection();
			return true;
		}
		catch(Exception $e)
		{
			$db->closeConnection();
			return false;
		}
	}

	//promena na status na termin (potvrden/otkazen)
	function changeStatus($status,$id,$member_email)
	{
		try
		{
			$db = new Database();
			$db->update("termini",['status' => $status],"tid='$id'");
			$status ? $status="одобрено" : $status="одбиено";
			$message = "Вашето барање за термин е ".$status;
			send_mail($member_email,$message,"schedule_request");
			$db->closeConnection();
			return true;
		}
		catch(Exception $e)
		{
			$db->closeConnection();
			return false;
		}
	}

	function updateFinishedSchedules($schedules)
	{
		foreach($schedules as $schedule)
		{
			$datum = date('Y-m-d');
			$vreme = date('H:i:s', time());

			$s_datum = date('Y-m-d',strtotime($schedule['datum']));
			$s_vreme = date('H:i:s', strtotime($schedule['vreme']));

			if(($s_datum==$datum && $s_vreme < $vreme) || $s_datum<$datum)
			{
				try
				{
					$db = new Database();
					$db->update("termini",['finished' => '1'],"tid='".$schedule['tid']."'");
					$db->closeConnection();
				}
				catch(Exception $e)
				{
					$db->closeConnection();
				}
			}
		}
	}

	//zimanje na site galerii
	function getGalleries()
	{
		$db = new Database();

		$autoserice_id = getAutoservices()['aid'];

		//$db->join("termini","avtoservis_termini","termini.tid=avtoservis_termini.tid","aid='$autoserice_id'");

		$db->getWhere("*","galerija","aid='$autoserice_id'");

		if($db->getRowsCount()>0)
			$galleries = $db->resultFromGet(true);
		else
			$galleries = 0;

		$db->closeConnection();

		return $galleries;
	}

	//kreiranje na nova galerija
	function addGallery($gallery,$files)
	{

		extract($gallery);	
		extract($files);

		validateData($name,'required');
		validateData($description,'required');

		if(!empty($GLOBALS['validation_errors']))
		{
			return $GLOBALS['validation_errors'];
		}

		$db = new Database();

		$name 				= $db->cleanData($name);
		$description 		= $db->cleanData($description);

		$autoserice_id = getAutoservices()['aid'];

		//$rand = date('Ymd').generateRandomString(6);

		$image_name = uploadImage($cover,$name,"cover");

		if($image_name===false) return "Грешка при прикачување на слика";

		$data = [
			'ime' => $name,
			'opis'=> $description,
			'naslovna_slika' => $image_name,
			'aid' => $autoserice_id
		];

		try
		{
			$db->insert("galerija",$data);
			$db->closeConnection();
			return true;
		}
		catch(Exception $e)
		{
			$db->closeConnection();
			return false;
		}
	}

	//zimanje na odredena galerija
	function getGallery($id,$onlyGallery=false,$active_not_front=false)
	{
		$db = new Database();

		$autoserice_id = getAutoservices()['aid'];

		if($active_not_front)
				$db->joinLeft("galerija","sliki","galerija.gid=sliki.gal_id","aid='$autoserice_id' AND (galerija.status='$id' AND front_gallery='0')");
		elseif($onlyGallery)
			$db->getWhere("*","galerija","gid='$id' AND aid='$autoserice_id'");
		else
			$db->joinLeft("galerija","sliki","galerija.gid=sliki.gal_id","aid='$autoserice_id' AND (galerija.gid='$id' OR front_gallery='$id')");

		if($db->getRowsCount()>0)
			if($onlyGallery)
				$gallery = $db->resultFromGet();
			else
				$gallery = $db->resultFromGet(true);
		else
			$gallery = 0;

		$db->closeConnection();

		return $gallery;
	}

	//dodavanje slika vo galerija
	function addPhoto($gallery,$files)
	{
		extract($gallery[0]);	
		extract($files);

		$db = new Database();

		//$rand = date('Ymd').generateRandomString(6);

		$image_name = uploadImage($photo,$ime,"gallery_photo");

		if($image_name===false) return "Грешка при прикачување на слика";

		$data = [
			'slika_ime' => $image_name,
			'gal_id'	=> $gid
		];

		try
		{
			$db->insert("sliki",$data);
			$db->closeConnection();
			return true;
		}
		catch(Exception $e)
		{
			$db->closeConnection();
			return false;
		}
	}

	//isprakjane baranje za termin
	function sendScheduleRequest($schedule,$id)
	{
		extract($schedule);

		validateData($content,'required');
		validateData($date,'required');
		validateData($time,'required');

		if(!empty($GLOBALS['validation_errors']))
		{
			return $GLOBALS['validation_errors'];
		}

		$db = new Database();

		$data = [
			'sodrzina' => htmlspecialchars($content),
			'kid'	=>	$id
		];

		try
		{

			$db->insert("termini",$data);
			$tid = $db->getInsertID();

			$autoserice_id = getAutoservices()['aid'];

			$data2 = [
				'aid' => $autoserice_id,
				'tid' => $tid,
				'vreme' => $time,
				'datum' => date('Y-m-d',strtotime($date))
			];

			$db->insert("avtoservis_termini",$data2);
			$db->closeConnection();
			return true;
		}
		catch(Exception $e)
		{
			$db->closeConnection();
			return false;
		}

	}

	//snimanje na pretplatnici
	function subscribe($email)
	{
		validateData($email,'required|email');

		if(!empty($GLOBALS['validation_errors']))
		{
			return $GLOBALS['validation_errors'];
		}

		$db = new Database();

		$email = $db->cleanData($email);

		$aid = getAutoservices()['aid'];

		$data = [
			'email' => $email,
		];

		try
		{
			$db->insert("pretplatnici",$data);
			$pid = $db->getInsertID();
			$data2 = [
				'aid' => $aid,
				'pid' => $pid
			];
			$db->insert("avtoservis_pretplatnici",$data2);
			$db->closeConnection();
			return true;
		}
		catch(Exception $e)
		{
			$db->closeConnection();
			return false;
		}
	}

	function changeGalleryStatus($gid)
	{
		$gallery = getGallery($gid,true);

		if($gallery['status'])
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
			$db->update("galerija",['status' => $status],"gid='$gid'");
			$db->closeConnection();
			return true;
		}
		catch(Exception $e)
		{
			$db->closeConnection();
			return false;
		}
	}

	function changeFrontGallery($gid)
	{

		$gallery = getGallery($gid,true);

		if($gallery['front_gallery'])
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
			if($gallery['front_gallery']==0)
				$db->update("galerija",['front_gallery' => '0'],"1");
			$db->update("galerija",['front_gallery' => $status],"gid='$gid'");
			$db->closeConnection();
			return true;
		}
		catch(Exception $e)
		{
			$db->closeConnection();
			return false;
		}
	}

	function getPhoto($slid)
	{
		$db = new Database();

		$db->getWhere("*","sliki","slid='$slid'");

		if($db->getRowsCount()>0)
			$photo = $db->resultFromGet();
		else
			$photo = 0;

		$db->closeConnection();

		return $photo;
	}
?>