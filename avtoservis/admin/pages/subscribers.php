<?php
	if(!isAuthenticated())
	{
		redirect('login-admin');
	}
?>
<h1>Претплатници</h1>

<?php 
	$subscribers = getAllSubscribers();

	if($subscribers)
	{
?>
<div class="form-group">
	<button class="btn btn-primary">Испрати емаил на сите</button>
</div>	
<div class="col-md-6">
		<table class="table table-striped">
			<thead>
				<th>Емаил</th>
				<th>Акција</th>
			</thead>
			<tbody>
				<?php 
					foreach($subscribers as $subscriber)
					{
				?>
						<tr>
							<td><?php echo $subscriber['email']; ?></td>
							<td><a href="<?php echo BASE_URL; ?>contollers/delete_subscribers.php?pid=<?php echo $subscriber['pid']; ?>" class="btn btn-danger btn-xs">избриши</a></td>
						</tr>
				<?php
					}
				?>
			</tbody>
		</table>
</div>
<?php
	}
	else
	{
?>
		<div class="alert alert-info">
			<strong>Немате претплатници!</strong>
		</div>
<?php
	}
?>	

<div class="clear"></div>