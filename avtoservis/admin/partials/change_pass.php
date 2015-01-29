<?php
	if(!isAuthenticated() || !isAdmin())
	{
		redirect('login-admin');
	}
	
	$user = getUser($_SESSION['user']['kid']);

	if(isset($_POST['update_pass']))
	{
		$status = updateUserPassword($_POST);

		if($status===true)
		{
			message("Успешно ја променивте лозинката","success");
		}
		elseif($status===false)
		{
			message("Грешка при промена на лозинката! Обидете се повторно","danger");
		}
		else
		{
			if(is_array($status))
				$errors = implode("<br>",$status);
			else 
				$errors = $status;

			message($errors,"danger");
		}
	}
?>

<div class="well col-md-6">
	<h2>Промена на лозинка</h2>
	<form action="" method="post">
		<input type="hidden" name="kid" value="<?php echo $user['kid']; ?>" >
		<div class="form-group">
			<input type="password" name="old_pass" class="form-control" placeholder="Внесете стара лозинка">
		</div>
		<div class="form-group">
			<input type="password" name="new_pass" class="form-control" placeholder="Внесете нова лозинка" >
		</div>
		<div class="form-group">
			<input type="password" name="repeat_new_pass" class="form-control" placeholder="Повторете ја новата лозинка">
		</div>
		<div class="form-group">
			<input type="submit" value="Промени лозинка" class="btn btn-primary" name="update_pass" />
		</div>

	</form>	
</div>
<div class="clear"></div>