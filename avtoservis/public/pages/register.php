<?php

	if(isset($_POST['register_user']))
	{
		$status = addUser($_POST);

		if($status===true)
		{
			message("Успешно се регистриравте","success");
		}
		elseif($status===false)
		{
			message("Грешка при регистрација! Обидете се повторно","danger");
		}
		else
		{
			$error = implode("<br>",$status);

			message($error,"danger");
		}
	}
?>

<h1>Регистрирај се</h1>
<hr/>
<div class="schedule_form">
	<form action="" method="post">
		<div class="grupa">
			<input type="text" name="fname" class="form-control" placeholder="Внесете име" >
		</div>
		<div class="grupa">
			<input type="text" name="lname" class="form-control" placeholder="Внесете презиме" >
		</div>
		<div class="grupa">
			<input type="text" name="email" class="form-control" placeholder="Внесете емаил" >
		</div>
		<div class="grupa">
			<input type="password" name="password" class="form-control" placeholder="Внесете нова лозинка">
		</div>
		<div class="grupa">
			<input type="password" name="r_password" class="form-control" placeholder="Повторете ја лозинката">
		</div>
		<div class="grupa">
			<input type="submit" value="Регистрирај се" class="btn btn-success" name="register_user" />
			<input type="reset" value="Исчисти" class="btn btn" />
		</div>

	</form>	
</div>