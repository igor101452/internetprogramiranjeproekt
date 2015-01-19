<?php
	if(isset($_POST['add_new_photo']))
	{
		$status = addPhoto($gallery,$_FILES);

		if($status===true)
		{
			redirect("gallery",$gallery[0]['gid']);
		}
		elseif($status===false)
		{
			message("Грешка при внесување на нова страница! Обидете се повторно","danger");
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
<div class="form-group">
	<a href="<?php echo ADMIN_PATH.'index.php?p=gallery&view='.$_GET['view']; ?>" class="btn btn-default"><i class="fa fa-reply"></i> Назад</a>
</div>
<div class="well col-md-6">
	<h2>Прикачи слика</h2>
	<form action="" method="post" enctype="multipart/form-data">
		<div class="form-group">
			<input type='file' name='photo' />
		</div>
		<div class="form-group">
			<input type="submit" value="Прикачи слика" class="btn btn-primary" name="add_new_photo" />
		</div>

	</form>	
</div>