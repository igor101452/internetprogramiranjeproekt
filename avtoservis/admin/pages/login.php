<?php
	if(isAuthenticated())
	{
		redirect('root-admin');
	}
	
	if(isset($_POST['login']))
	{
		extract($_POST);

		login($email,$lozinka);

	}
?>
<h1>Логирај се</h1>
<form action="" method="post">
<input type="text" name="email"/>
<input type="password" name="lozinka"/>
<input type="submit" name="login" value="Логирај се"/>
</form>