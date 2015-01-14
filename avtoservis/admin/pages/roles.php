<?php
	if(!isAuthenticated())
	{
		redirect('login-admin');
	}

	$roles = getRoles();

	$current_url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

	if(isset($_POST['add_role']))
	{
		extract($_POST);

		if(addRole($role))
		{
			message("Додадена е нова улога","success");
		}
		else
		{
			message("Грешка при додавање нова улога. Обидете се пак","danger");
		}
	}

	if(isset($_POST['update_role']))
	{
		extract($_POST);
		
		$role = ['ime' => $role, 'rid' => $uid];
		$status = updateRole($role);

		if($status===true)
		{
			message("Улогата е успешно ажурирана","success");
		}
		elseif($status!==false)
		{
			message($status,"danger");
		}
		else
		{
			message("Грешка при ажурирање на улогата. Обидете се пак","danger");
		}
	}

?>

<?php if(isset($_GET['new_role']) || isset($_GET['rid']))
	{
	$update = false;
	if(isset($_GET['rid']) && is_numeric($_GET['rid'])){ $update = true; $role = getRole($_GET['rid']); }
?>
<div class="well col-md-6">
<h2><?php if($update) echo "Промени податоци"; else echo "Додади улога";?></h2>
	<form action="" method="post">
		<?php if($update){ ?>
		<input type="hidden" name="uid" value="<?php echo $role['uid']; ?>"/>
		<?php } ?>
		<div class="form-group">
			<?php if($update){ ?>
			<label>Име на улога</label>
			<?php } ?>
			<input type="text" name="role" class="form-control" placeholder="Име на улога" <?php if($update) echo "value='".$role['ime']."'"; ?> >
		</div>
		<div class="form-group">
			<input type="submit" name="<?php if($update) echo 'update_role'; else echo 'add_role'; ?>" class="btn btn-primary" value="<?php if($update)  echo "Промени"; else echo "Додади"; ?>" />
		</div>
	</form>
</div>
<?php
	}
?>

<?php if(!isset($_GET['new_role']) && !isset($_GET['rid'])) { ?> 
<h1>Улоги</h1>	

<div class="row">
	<a href=<?php echo $current_url."&new_role"; ?> class="btn btn-success">Додади улога</a>
</div>

<?php if($roles) { ?>
	<div class="row">
		<div class="col-md-6">
			<table class="table table-striped">
				<thead>
					<th>Улога</th>
					<th>Акција</th>
				</thead>
				<tbody>
					<?php foreach($roles as $role)	{?>
					<tr>
						<td><?php echo $role['ime']; ?></td>
						<td>
							<a href="<?php echo $current_url; ?>&rid=<?php echo $role['uid']; ?>" class="btn btn-primary btn-xs">промени</a>
							<a href="<?php echo BASE_URL; ?>contollers/delete_role.php?rid=<?php echo $role['uid']; ?>" class="btn btn-danger btn-xs subscriber_delete">избриши</a>
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