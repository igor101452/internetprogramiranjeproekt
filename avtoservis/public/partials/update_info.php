<?php
	$user = getUser($user['kid']);

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
<h2>Промена на податоци</h2>
<hr/>
<div class="schedule_form">
	<form action="" method="post">
		<input type="hidden" name="kid" value="<?php echo $user['kid']; ?>" >
		<div class="grupa">
			<input type="text" name="fname" class="form-control" placeholder="Внесете име" value="<?php echo $user['ime']; ?>">
		</div>
		<div class="grupa">
			<input type="text" name="lname" class="form-control" placeholder="Внесете презиме" value="<?php echo $user['prezime']; ?>">
		</div>
		<div class="grupa">
			<input type="text" name="email" class="form-control" placeholder="Внесете емаил" value="<?php echo $user['email']; ?>">
		</div>
		<div class="grupa">
			<input type="password" name="password" class="form-control" placeholder="Внесете нова лозинка">
		</div>
		<div class="grupa">
			<input type="submit" value="Промени податоци" class="btn btn-success" name="update_user" />
		</div>

	</form>	
</div>