<?php
	if(!isAuthenticated())
	{
		redirect('login-admin');
	}

	$mechanics = getMechanics();

	$logged_user = $_SESSION['user'];

	$update = false;
	$add 	= false;

	if(isset($_GET['new_mechanic']))
	{
		$add = true;
	}

	if(isset($_GET['mid']))
	{
		if(!is_numeric($_GET['mid'])) redirect("mechanics");

		$mechanic = getMechanic($_GET['mid']);
		$update = true;
	}
?>

<?php if($update) { include_once("/partials/update_mechanic.php"); }
elseif($add){ include_once("/partials/add_mechanic.php"); }
else{
?>
<h1>Механичари</h1>	
<div class="row form-group">
	<a href=<?php echo $current_url."&new_mechanic"; ?> class="btn btn-success">Додади механичар</a>
</div>

<?php if($mechanics) { ?>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-striped">
				<thead>
					<th>Име</th>
					<th>Презиме</th>
					<th>Позиција</th>
					<th>Статус</th>
					<th>Акција</th>
				</thead>
				<tbody>
					<?php foreach($mechanics as $mechanic)	{
						?>
					<tr>
						<td><?php echo $mechanic['ime']; ?></td>
						<td><?php echo $mechanic['prezime']; ?></td>
						<td><?php echo $mechanic['pozicija']; ?></td>
						<?php if($mechanic['status']==1) { $active = true;?>
						<td><label class="label label-success">Активен</label></td>
						<?php }else{ ?>
						<td><label class="label label-danger">Неактивен</label></td>
						<?php } ?>
						<td>
							<a href="<?php echo $current_url; ?>&mid=<?php echo $mechanic['mid']; ?>" class="btn btn-primary btn-xs">промени</a>
							<button name="mechanic_status" id="<?php echo $mechanic['mid']; ?>" class="btn btn-xs <?php if(isset($active)) echo "btn-warning"; else echo "btn-success"; ?>"><?php if(isset($active)) echo "Деактивирај"; else echo "Активирај"; ?></button>
							<a href="<?php echo BASE_URL; ?>contollers/delete_mechanic.php?mid=<?php echo $mechanic['mid']; ?>" class="btn btn-danger btn-xs subscriber_delete">избриши</a>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
<?php }else{
		message("Немате механичари","info");
	}
}
?>

<div class="clear"></div>