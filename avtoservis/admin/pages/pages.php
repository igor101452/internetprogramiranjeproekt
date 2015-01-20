<?php
	if(!isAuthenticated() || !isAdmin())
	{
		redirect('login-admin');
	}

	$pages = getPages();

	$logged_user = $_SESSION['user'];

	$update = false;
	$add 	= false;

	if(isset($_GET['new_page']))
	{
		$add = true;
	}

	if(isset($_GET['sid']))
	{
		if(!is_numeric($_GET['sid'])) redirect("pages");

		$page = getPage($_GET['sid']);
		$update = true;
	}
?>

<?php if($update) { include_once("partials/update_page.php"); }
elseif($add){ include_once("/partials/add_page.php"); }
else{
?>
<h1>Страници</h1>	
<div class="row form-group">
	<a href=<?php echo $current_url."&new_page"; ?> class="btn btn-success">Додади страница</a>
</div>

<?php if($pages) { ?>
	<div class="row">
		<div class="col-md-6">
			<table class="table table-striped">
				<thead>
					<th>Име</th>
					<th>Слаг</th>
					<th>Акција</th>
				</thead>
				<tbody>
					<?php foreach($pages as $page)	{
						?>
					<tr>
						<td><?php echo $page['ime']; ?></td>
						<td><?php echo $page['slug']; ?></td>
						<td>
							<a href="<?php echo $current_url; ?>&sid=<?php echo $page['sid']; ?>" class="btn btn-primary btn-xs">промени</a>
							<a href="<?php echo BASE_URL; ?>contollers/delete_page.php?sid=<?php echo $page['sid']; ?>" class="btn btn-danger btn-xs subscriber_delete">избриши</a>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
<?php }else{
		message("Немате страници","info");
	}
}
?>

<div class="clear"></div>