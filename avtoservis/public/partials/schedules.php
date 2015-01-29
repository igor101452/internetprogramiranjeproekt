<?php 

	$schedules = getSchedules($user['kid']); 
	
	$add = false;

	if(isset($_GET['new_schedule']))
	{
		$add = true;
	}

	if(isset($_GET['view']))
	{
		if(!is_numeric($_GET['view'])) redirect('user-schedule');
		$schedule = getSchedule($_GET['view']);
		$member = getUser($schedule['kid']);
		$member_name = $member['ime']." ".$member['prezime'];
		$view = true;
	}
?>


<div class="row">
	<a href=<?php echo $current_url."&schedules&new_schedule"; ?> class="btn btn-success">Закажи термин</a>
</div>
<?php if($add) {
	require_once("partials/add_schedule.php");
}elseif($view){
	require_once('partials/view_schedule.php');
 }else{ ?>

<?php if($schedules){ ?>
<h2>Термини</h2>
<hr/>

<table id="schedules">
	<thead>
		<th>ID</th>
		<th>Опис</th>
		<th>Датум</th>
		<th>Време</th>
		<th>Статус</th>
		<th>Акција</th>
	</thead>
	<tbody>
		<?php
			foreach($schedules as $schedule)
			{
		?>
			<tr>
				<td><?php echo $schedule['tid']; ?></td>
				<td><?php if(strlen($schedule['sodrzina'])>30) echo "<a href='".$current_url."&schedules&view=".$schedule['tid']."'>".substr($schedule['sodrzina'],0,30)."...</a>"; else echo $schedule['sodrzina']; ?></td>
				<td><?php echo date('d-m-Y',strtotime($schedule['datum'])); ?></td>
				<td><?php echo $schedule['vreme']; ?></td>
				<?php  if($schedule['finished']==1){ ?>
				<td><label class="label label-primary">Завршено</label></td>
				<?php }elseif($schedule['status']==1){ ?>
				<td><label class="label label-success">Потврден</label></td>
				<?php }elseif($schedule['status']!=NULL){ ?>
				<td><label class="label label-danger">Одбиено</label></td>
				<?php }elseif($schedule['status']===null || $schedule['finished']===0){ ?>
				<td><label class="label label-info">Се чека</label></td>
				<?php } ?>
				<td>
					<a href="<?php echo BASE_URL; ?>contollers/delete_schedule.php?tid=<?php echo $schedule['tid']; ?>&user" class="btn btn-danger btn-xs subscriber_delete">избриши</a>
				</td>
			</tr>
		<?php
			}
		?>
	</tbody>
</table>

<?php }
else{
?>

<br/>
<?php
	message("Немате закажено термини","info"); 
	}
}
 ?>