<?php
	if(!isAuthenticated() || !isAdmin())
	{
		redirect('login-admin');
	}
	
	$roles = getRoles();

	if(isset($_GET['p']) && $_GET['p']=='me_update')
	{
		$user = getUser($_SESSION['user']['kid']);
	}

	else
	{
		$user = getUser($_GET['kid']);
	}

	if(isset($_POST['update_user']))
	{
		$status = updateUser($_POST);

		if($status===true)
		{
			message("Успешно ги ажуриравте податоците","success");
		}
		elseif($status===false)
		{
			message("Грешка при ажурирање на податоците! Обидете се повторно","danger");
		}
		else
		{
			$errors = implode("<br>",$status);

			message($errors,"danger");
		}
	}
?>

<div class="well col-md-6">
	<h2>Промена на податоци</h2>
	<form action="" method="post">
		<input type="hidden" name="kid" value="<?php echo $user['kid']; ?>" >
		<div class="form-group">
			<input type="text" name="fname" class="form-control" placeholder="Внесете име" value="<?php echo $user['ime']; ?>">
		</div>
		<div class="form-group">
			<input type="text" name="lname" class="form-control" placeholder="Внесете презиме" value="<?php echo $user['prezime']; ?>">
		</div>
		<div class="form-group">
			<input type="text" name="email" class="form-control" placeholder="Внесете емаил" value="<?php echo $user['email']; ?>">
		</div>
		<div class="form-group">
			<label>Улога:</label>
			<select name="role" class="form-control">
				<?php foreach($roles as $role){ ?>
				<option value="<?php echo $role['uid']; ?>" <?php if($role['uid']==$user['uid']) echo "selected"; ?> ><?php echo $role['ime']; ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="form-group">
			<input type="submit" value="Промени податоци" class="btn btn-primary" name="update_user" />
		</div>

	</form>	
</div>
<div class="clear"></div>