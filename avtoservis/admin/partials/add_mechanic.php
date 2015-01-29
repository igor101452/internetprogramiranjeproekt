<?php
	if(!isAuthenticated() || !isAdmin())
	{
		redirect('login-admin');
	}
	
	if(isset($_POST['add_new_mechanic']))
	{
		$status = addMechanic($_POST);

		if($status===true)
		{
			message("Успешно внесовте нов механичар","success");
		}
		elseif($status===false)
		{
			message("Грешка при внесување на нов маханичар! Обидете се повторно","danger");
		}
		else
		{
			$errors = implode("<br>",$status);

			message($errors,"danger");
		}
	}
?>

<div class="well col-md-6">
	<h2>Нов механичар</h2>
	<form action="" method="post">
		<div class="form-group">
			<input type="text" name="fname" class="form-control" placeholder="Внесете име">
		</div>
		<div class="form-group">
			<input type="text" name="lname" class="form-control" placeholder="Внесете презиме">
		</div>
		<div class="form-group">
			<input type="text" name="pozicija" class="form-control" placeholder="Внесете позиција">
		</div>
		<div class="form-group">
			<label>
				<input type="checkbox" name="status" > Активен
			</label>
		</div>
		<div class="form-group">
			<input type="submit" value="Додади механичар" class="btn btn-primary" name="add_new_mechanic" />
		</div>

	</form>	
</div>