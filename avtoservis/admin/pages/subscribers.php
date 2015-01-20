<?php
	if(!isAuthenticated() || !isAdmin())
	{
		redirect('login-admin');
	}

	$subscribers = getAllSubscribers();

	if(isset($_POST['send_newsletter']))
	{
		extract($_POST);

		if($newsletter!="")
		{
			if(send_mail($subscribers,$newsletter,"subscribers"))
			{
				$total = count($subscribers);
				message("Емаилот е пратен на $total претплатници","success");
			}
		}
		else
		{
			message("Внесете содржина","danger");
		}
	}
?>
<h1>Претплатници</h1>

<?php 

	if($subscribers)
	{
?>
<div class="row">
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
							<td><a href="<?php echo BASE_URL; ?>contollers/delete_subscribers.php?pid=<?php echo $subscriber['pid']; ?>" class="btn btn-danger btn-xs subscriber_delete">избриши</a></td>
						</tr>
				<?php
					}
				?>
			</tbody>
		</table>
</div>
<div class="col-md-6 well">
	<p><strong>Newsletter</strong></p>
	<form action="" method="post">
		<div class="form-group">
			<textarea cols="80" rows="10" name="newsletter" placeholder="Внеси соджина"></textarea>
		</div>
		<div class="form-group">
			<input type="submit" class="btn btn-primary" name="send_newsletter" value="Испрати емаил на сите"/>
		</div>
	</form>
</div>
</div>
<?php
	}
	else
	{
		message("Немате претплатници","info");
	}
?>	

<div class="clear"></div>