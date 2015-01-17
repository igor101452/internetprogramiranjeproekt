<?php

	$mechanic = getMechanic($_GET['mid']);

	if(isset($_POST['update_mechanic']))
	{
		$status = updateMechanic($_POST);

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
		<input type="hidden" name="mid" value="<?php echo $mechanic['mid']; ?>" >
		<div class="form-group">
			<input type="text" name="fname" class="form-control" placeholder="Внесете име" value="<?php echo $mechanic['ime']; ?>">
		</div>
		<div class="form-group">
			<input type="text" name="lname" class="form-control" placeholder="Внесете презиме" value="<?php echo $mechanic['prezime']; ?>">
		</div>
		<div class="form-group">
			<input type="text" name="pozicija" class="form-control" placeholder="Внесете позиција" value="<?php echo $mechanic['pozicija']; ?>">
		</div>
		<div class="form-group">
			<div class="form-group">
			<label>
				<input type="checkbox" name="status" <?php if($mechanic['status']==1) echo "checked"; ?>> Активен
			</label>
		</div>
		</div>
		<div class="form-group">
			<input type="submit" value="Промени податоци" class="btn btn-primary" name="update_mechanic" />
		</div>

	</form>	
</div>