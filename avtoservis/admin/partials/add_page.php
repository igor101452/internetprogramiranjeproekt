<?php
	if(!isAuthenticated() || !isAdmin())
	{
		redirect('login-admin');
	}
	
	if(isset($_POST['add_new_page']))
	{
		$status = addPage($_POST);

		if($status===true)
		{
			message("Успешно внесовте нова страница","success");
		}
		elseif($status===false)
		{
			message("Грешка при внесување на нова страница! Обидете се повторно","danger");
		}
		else
		{
			$errors = implode("<br>",$status);

			message($errors,"danger");
		}
	}
?>

<div class="well col-md-8">
	<h2>Нова страница</h2>
	<form action="" method="post">
		<div class="form-group">
			<input type="text" name="name" class="form-control" placeholder="Внесете име">
		</div>
		<div class="form-group">
			<input type="text" name="slug" class="form-control" placeholder="Внесете слаг">
		</div>
		<div class="form-group">
			<label>Содржина</label>
			<textarea id="editor1" rows="15" cols="70" name="content" class="form-control" placeholder="Внесете соджина"></textarea>
		</div>
		<div class="form-group">
			<input type="submit" value="Додади страница" class="btn btn-primary" name="add_new_page" />
		</div>

	</form>	
</div>

