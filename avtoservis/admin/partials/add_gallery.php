<?php
	if(!isAuthenticated() || !isAdmin())
	{
		redirect('login-admin');
	}
	
	if(isset($_POST['add_new_gallery']))
	{
		$status = addGallery($_POST,$_FILES);

		if($status===true)
		{
			message("Успешно внесовте нова галерија","success");
		}
		elseif($status===false)
		{
			message("Грешка при внесување на нова галерија! Обидете се повторно","danger");
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
	<h2>Нова галерија</h2>
	<form action="" method="post" enctype="multipart/form-data">
		<div class="form-group">
			<input type="text" name="name" class="form-control" placeholder="Внесете име">
		</div>
		<div class="form-group">
			<textarea name="description" cols="70" rows="7" class="form-control" placeholder="Внесете опис"></textarea>
		</div>
		<div class="form-group">
			Насловна слика: <input type='file' name='cover' />
		</div>
		<div class="form-group">
			<input type="submit" value="Додади галерија" class="btn btn-primary" name="add_new_gallery" />
		</div>

	</form>	
</div>