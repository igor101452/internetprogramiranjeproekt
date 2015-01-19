<h1>Термин #ID: <?php echo $schedule['tid']; ?></h1>
<hr/>
<div class="form-group">
	<a href="<?php echo ADMIN_PATH.'index.php?p=schedules'; ?>" class="btn btn-default"><i class="fa fa-reply"></i> Назад</a>
</div>
<div class="well">
	<table class="table">
		<tr>
			<th>Клиент</th>
			<td><?php echo $member_name; ?></td>
		</tr>
		<tr>
			<th>Датум</th>
			<td><?php echo date('d-m-Y',strtotime($schedule['datum'])); ?></td>
		</tr>
		<tr>
			<th>Време</th>
			<td><?php echo $schedule['vreme']; ?></td>
		</tr>
		<tr>
			<th>Содржина</th>
			<td><?php echo $schedule['sodrzina']; ?></td>
		</tr>
		</tr>
	</table>
</div>	