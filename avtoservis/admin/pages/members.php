<?php
	if(!isAuthenticated())
	{
		redirect('login-admin');
	}

	$users = getUsers();

	$logged_user = $_SESSION['user'];

	$update = false;
	$add 	= false;

	if(isset($_GET['new_user']))
	{
		$roles = getRoles();
		$add = true;
	}

	if(isset($_GET['kid']))
	{
		if(!is_numeric($_GET['kid'])) redirect("members");

		$roles = getRoles();
		$user = getUser($_GET['kid']);
		$update = true;
	}
?>

<?php if($update) { include_once("/partials/update_user.php"); }
elseif($add){ include_once("/partials/add_user.php"); }
else{
?>
<h1>Членови</h1>	
<div class="row">
	<a href=<?php echo $current_url."&new_user"; ?> class="btn btn-success">Додади член</a>
</div>

<?php if($users) { ?>
	<div class="row">
		<div class="col-md-6">
			<table class="table table-striped">
				<thead>
					<th>Име</th>
					<th>Презиме</th>
					<th>Емаил</th>
					<th>Улога</th>
					<th>Акција</th>
				</thead>
				<tbody>
					<?php foreach($users as $user)	{
						if($user['kid']==$logged_user['kid']) continue;
							$role = getRole($user['uid'])['ime'];
						?>
					<tr>
						<td><?php echo $user['ime']; ?></td>
						<td><?php echo $user['prezime']; ?></td>
						<td><?php echo $user['email']; ?></td>
						<?php if($role=="admin"){ ?>
						<td style="color:red"><strong><?php echo $role; ?></strong></td>
						<?php }else{ ?>
						<td><?php echo $role; ?></td>
						<?php } ?>
						<td>
							<a href="<?php echo $current_url; ?>&kid=<?php echo $user['kid']; ?>" class="btn btn-primary btn-xs">промени</a>
							<a href="<?php echo BASE_URL; ?>contollers/delete_user.php?kid=<?php echo $user['kid']; ?>" class="btn btn-danger btn-xs subscriber_delete">избриши</a>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
<?php } 
	}
?>

<div class="clear"></div>