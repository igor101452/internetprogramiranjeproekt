<?php
	if(isAuthenticated() && isAdmin())
	{
		redirect('root-admin');
	}
	
	if(isset($_POST['login']))
	{
		extract($_POST);

		login($email,$lozinka,true);

	}
?>

<div class="well col-md-5" style="margin-left:25%;">
<h1><a href="<?php echo BASE_URL; ?>">Автосервис</a></h1>
	<h1>Форма за најавување</h1>
	<form action="" method="post" >
		<div class="form-group">
			<input type="text" name="email" class="form-control" placeholder="Емаил"/>
		</div>
		<div class="form-group">
			<input type="password" name="lozinka" class="form-control" placeholder="Лозинка"/>
		</div>
		<div class="form-group">
			<input type="submit" name="login" value="Логирај се" class="btn btn-primary"/>
		</div>
	</form>
</div>

<div class="clear"></div>