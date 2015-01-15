<?php
	require_once('validation_helper.php');	

	//proverka dali korsinikot e najaven
	function isAuthenticated(){

		@session_start();
		if(isset($_SESSION['logged']) && $_SESSION['logged']===1)
		{
			return true;
		}

		return false;
	}

	//proverka dali korisnikot postoi vo bazata
	function check_credentials($user,$password,$admin)
	{
		$db = new Database();
		
		$user 		= $db->cleanData($user);
		$password 	= $db->cleanData($password);

		validateData($user,'required|email');
		validateData($password,'required');

		if(!empty($GLOBALS['validation_errors']))
		{
			return false;
		}
		else
		{
			if(!$admin)
				$db->getWhere("*","klienti","email='$user' AND lozinka='$password'");
			else
				$db->getWhere("*","klienti","email='$user' AND lozinka='$password' AND is_admin='1'");
			

			if($db->getRowsCount()==1)
			{
				$data = $db->resultFromGet();
				return $data;
			}
			else
			{
				$GLOBALS['errors'][] = "Внесовте погрешни податоци. Обидете се повторно!";
				return false;

			}
			
		}
	}

	//logiranje na korisnik
	function login($user,$password,$admin=false)
	{
		if(($user = check_credentials($user,$password,$admin))!==false)
		{
			//session_start();
			$_SESSION['logged']=1;
			$_SESSION['user'] = $user;
			if($admin)
				redirect('root-admin');
		}
		else
		{
			if(!empty($GLOBALS['validation_errors']))
			{
				foreach($GLOBALS['validation_errors'] as $err)
				{
					echo $err."<br/>";
				}
			}		

			if(!empty($GLOBALS['errors'])){
				foreach($GLOBALS['errors'] as $err)
				{
					echo $err."<br/>";
				}
			}
			//redirect('login-admin');
		}

	}

	//odjavuvanje na korisnik
	function logout()
	{
		@session_start();
		session_destroy();
	}

	//registriranje na nov korisnik
	function register()
	{
		extract($_POST);
	}

	
?>