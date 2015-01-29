<?php
	if(!isAuthenticated() || !isAdmin())
	{
		redirect('login-admin');
	}
	
	if(isset($_POST['add_new_user']))
	{
		$status = addUser($_POST);

		if($status===true)
		{
			message("Успешно внесовте нов член","success");
		}
		elseif($status===false)
		{
			message("Грешка при внесување на нов член! Обидете се повторно","danger");
		}
		else
		{
			$errors = implode("<br>",$status);

			message($errors,"danger");
		}
	}
?>

<div class="well col-md-6">
	<h2>Нов корисник</h2>
	<form action="" method="post">
		<div class="form-group">
			<input type="text" name="fname" class="form-control" placeholder="Внесете име">
		</div>
		<div class="form-group">
			<input type="text" name="lname" class="form-control" placeholder="Внесете презиме">
		</div>
		<div class="form-group">
			<input type="text" name="email" class="form-control" placeholder="Внесете емаил">
		</div>
		<div class="form-group">
			<label>Улога:</label>
			<select name="role" class="form-control">
				<?php foreach($roles as $role){ ?>
				<option value="<?php echo $role['uid']; ?>"><?php echo $role['ime']; ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="form-group">
			<input type="submit" value="Додади член" class="btn btn-primary" name="add_new_user" />
		</div>

	</form>	
</div>