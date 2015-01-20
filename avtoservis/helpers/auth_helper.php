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

	//ako e administrator
	function isAdmin()
	{
		@session_start();
		$user = $_SESSION['user'];

		if($user['is_admin']==1)
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
			if(!$admin){
				$db->getWhere("*","klienti","(email='$user' AND privremena_lozinka='$password')");

				if($db->getRowsCount()==1)
				{
					$data['code'] = 2;
					$data['user'] = $db->resultFromGet();
					return $data;
				}
				else
				{
					$db->getWhere("*","klienti","(email='$user' AND lozinka='$password')");
				}
			}
			else
				$db->getWhere("*","klienti","email='$user' AND lozinka='$password' AND is_admin='1'");
			

			if($db->getRowsCount()==1)
			{
				$data = $db->resultFromGet();
				return $data;
			}
			else
			{
				$GLOBALS['errors'][] = "Внесовте погрешни податоци. Обидете се повторно";
				return false;

			}
			
		}
	}

	//logiranje na korisnik
	function login($user,$password,$admin=false)
	{
		$user = check_credentials($user,$password,$admin);
		if(isset($user['code']) && $user['code']===2)
		{

			@session_start();
			$_SESSION['logged']=1;
			$_SESSION['user'] = $user['user'];

			return 2;

		}
		elseif($user!==false)
		{
			//session_start();
			$_SESSION['logged']=1;
			$_SESSION['user'] = $user;
			if($admin)
				redirect('root-admin');
			else
				redirect('profile');
		}
		else
		{
			if(!empty($GLOBALS['validation_errors']))
			{
				$errors = implode("<br>",$GLOBALS['validation_errors']);
				message($errors,"danger");
			}		

			if(!empty($GLOBALS['errors'])){
				$errors = implode("<br>",$GLOBALS['errors']);
				message($errors,"danger");
			}
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


	//promena na lozika pri prvo najavuvanje
	function firstLogin($password,$user)
	{
		try
		{
			$db = new Database();
			$data = [
				'lozinka' => $password,
				'privremena_lozinka' => ""
			];

			$db->update("klienti",$data,"kid='".$user['kid']."'");
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