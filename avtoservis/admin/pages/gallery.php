<?php
	if(!isAuthenticated())
	{
		redirect('login-admin');
	}

	$galleries = getGalleries();

	$add = false;
	$update = false;
	$view = false;

	if(isset($_GET['new_gallery']))
	{
		$add = true;
	}

	if(isset($_GET['gid']))
	{
		if(!is_numeric($_GET['gid'])) redirect("gallery");
		$update = true;
	}

	if(isset($_GET['status']))
	{
		if(!is_numeric($_GET['status'])) redirect("gallery");

		redirect("gallery");
	}

	if(isset($_GET['view']))
	{
		if(!is_numeric($_GET['view'])) redirect("gallery");
		$view = true;
	}

?>

<?php if($add) { 
	require_once("/partials/add_gallery.php");
}elseif($view) {
	require_once("/partials/view_gallery.php");
}else{ ?>
<h1>Галерија</h1>
<hr/>	
<div class="form-group">
	<a href=<?php echo $current_url."&new_gallery"; ?> class="btn btn-success">Додади галерија</a>
</div>

<?php if($galleries){ ?>
<div class="well">
	<ul id="galerija">
		<?php foreach($galleries as $gallery) {?>
				<li>
					<p><strong><?php echo $gallery['ime']; ?></strong></p>
					<div class="form-group">
						<a href="<?php echo $current_url; ?>&view=<?php echo $gallery['gid']; ?>">
							<img src="<?php echo IMAGE_PATH."/".$gallery['ime']."/cover/".$gallery['naslovna_slika'];?>" alt="галерија">
						</a>
					</div>
					<div class="form-group">
						<a href="<?php echo $current_url; ?>&status=<?php echo $gallery['gid']; ?>" class="btn btn-xs <?php if($gallery['status']==0) echo "btn-success"; else echo "btn-warning"; ?>"><?php if($gallery['status']==0) echo "активирај"; else echo "деактивирај"; ?></a>  
						<a href="<?php echo $current_url; ?>&gid=<?php echo $gallery['gid']; ?>" class="btn btn-primary btn-xs">промени</a>  
						<a href="<?php echo BASE_URL; ?>contollers/delete_gallery.php?gid=<?php echo $gallery['gid']; ?>" class="btn btn-danger btn-xs subscriber_delete">избриши</a>
					</div>
				</li>
		<?php } ?>
	</ul>
</div>
<?php } 
}?>

<div class="clear"></div>