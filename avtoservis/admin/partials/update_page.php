<?php
	if(!isAuthenticated() || !isAdmin())
	{
		redirect('login-admin');
	}
	
	$page = getPage($_GET['sid']);

	if(isset($_POST['update_page']))
	{
		$status = updatePage($_POST);

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

<div class="well col-md-8">
	<h2>Промена на податоци</h2>
	<form action="" method="post">
		<input type="hidden" name="sid" value="<?php echo $page['sid']; ?>" >
		<div class="form-group">
			<label>Име</label>
			<input type="text" name="name" class="form-control" placeholder="Внесете име" value="<?php echo $page['ime']; ?>">
		</div>
		<div class="form-group">
			<label>Слаг</label>
			<input type="text" name="slug" class="form-control" placeholder="Внесете презиме" value="<?php echo $page['slug']; ?>">
		</div>
		<div class="form-group">
			<label>Содржина</label>
			<textarea id="editor1" rows="15" cols="70" name="content" class="form-control" placeholder="Внесете соджина"><?php echo $page['sodrzina']; ?></textarea>
		</div>
		<div class="form-group">
			<input type="submit" value="Промени податоци" class="btn btn-primary" name="update_page" />
		</div>

	</form>	
</div>