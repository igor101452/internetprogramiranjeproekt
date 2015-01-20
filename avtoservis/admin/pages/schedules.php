<?php
	if(!isAuthenticated() || !isAdmin())
	{
		redirect('login-admin');
	}

	$schedules = getSchedules();
	$view = false;

	//ako datumot/vremeto na terminot e pominato, azuriraj
	updateFinishedSchedules($schedules);

	if(isset($_GET['confirm']))
	{
		$member = getUser($_GET['confirm']);
		$result = changeStatus(true,$_GET['confirm'],$member['email']);
		redirect("schedules");
	}

	if(isset($_GET['deny']))
	{
		$member = getUser($_GET['deny']);
		$result = changeStatus(false,$_GET['deny'],$member['email']);
		redirect("schedules");
	}

	if(isset($_GET['view']))
	{
		if(!is_numeric($_GET['view'])) redirect('schedules');
		$schedule = getSchedule($_GET['view']);
		$member = getUser($schedule['kid']);
		$member_name = $member['ime']." ".$member['prezime'];
		$view = true;
	}
?>

<?php if($view){
	require_once('partials/view_schedule.php');
 }else{ ?>
<h1>Термини</h1>	
<?php if($schedules) { ?>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-striped">
				<thead>
					<th>ID</th>
					<th>Содржина</th>
					<th>Датум</th>
					<th>Време</th>
					<th>Клиент</th>
					<th>Статус</th>
					<th>Акција</th>
				</thead>
				<tbody>
					<?php foreach($schedules as $schedule)	{
						$member = getUser($schedule['kid']);
						$member_name = $member['ime']." ".$member['prezime'];
						?>
					<tr>
						<td><?php echo $schedule['tid']; ?></td>
						<td><a href="<?php echo $current_url; ?>&view=<?php echo $schedule['tid']; ?>">
							<?php 
								if(strlen($schedule['sodrzina'])>30) echo substr($schedule['sodrzina'],0,30)."...";
								else echo $schedule['sodrzina'] ;
							?>
						</a></td>
						<td><?php echo date('d-m-Y',strtotime($schedule['datum'])); ?></td>
						<td><?php echo $schedule['vreme']; ?></td>
						<td><?php echo $member_name; ?></td>
						<?php  if($schedule['finished']==1){ ?>
						<td><label class="label label-primary">Завршено</label></td>
						<?php }elseif($schedule['status']==1){ ?>
						<td><label class="label label-success">Потврден</label></td>
						<?php }elseif($schedule['status']!=NULL){ ?>
						<td><label class="label label-danger">Одбиено</label></td>
						<?php }elseif($schedule['status']===null || $schedule['finished']===0){ ?>
						<td><label class="label label-info">Нема статус</label></td>
						<?php } ?>
						<td>
							<a href="<?php echo $current_url; ?>&confirm=<?php echo $schedule['tid']; ?>" class="btn btn-success btn-xs <?php if($schedule['finished']) echo "disabled"; ?>">потврди</a>
							<a href="<?php echo $current_url; ?>&deny=<?php echo $schedule['tid']; ?>" class="btn btn-warning btn-xs <?php if($schedule['finished']) echo "disabled"; ?>">одбиј</a>
							<a href="<?php echo BASE_URL; ?>contollers/delete_schedule.php?tid=<?php echo $schedule['tid']; ?>" class="btn btn-danger btn-xs subscriber_delete">избриши</a>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
<?php }else{
		message("Немате термини","info");
	}
}
?>

<div class="clear"></div>	