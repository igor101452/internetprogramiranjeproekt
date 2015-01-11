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
	function check_credentials($user,$password)
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
			$data = $db->getWhere("*","klienti","email='$user' AND lozinka='$password'");

			if($db->getRowsCount()==1)
			{
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
	function login($user,$password)
	{
		if(($user = check_credentials($user,$password))!==false)
		{
			//session_start();
			$_SESSION['logged']=1;
			$_SESSION['user'] = $user;
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
		session_start();
		session_destroy();
	}

	
?>