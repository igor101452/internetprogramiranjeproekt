<?php if(isset($_POST['send_request']))
{
	$status = sendScheduleRequest($_POST,$user['kid']);

	if($status===true)
	{
		message("Успешно го испративте барањето","success");
	}
	elseif($status===false)
	{
		message("Грешка при испраќање на барањето! Обидете се повторно","danger");
	}
	else
	{
		$errors = implode("<br>",$status);

		message($errors,"danger");
	}
}
?>

<h2>Испрати барање за термин</h2>

<div class="schedule_form">
	<form action="" method="post">
		<div class="grupa">
			<textarea name="content" cols="70" rows="10" placeholder="Внесете опис на проблемот"></textarea>
		</div>
		<div class="grupa">
			<input type="text" id="datepicker" name="date" placeholder="Изберете датум" readonly="readonly">
		</div>
		<div class="grupa">
			<input type="text" id="timepicker" name="time" placeholder="Изберете време" readonly="readonly">
		</div>
		<div class="grupa">
			<input type="submit" name="send_request" value="Испрати барање" class="btn btn-success">
		</div>
	</form>
</div>