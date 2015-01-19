<?php
	$gallery = getGallery($_GET['view']);
	$add = false;
	if(isset($_GET['new_photo']))
	{
		$add = true;	
	}
?>

<?php if($add) require_once("add_photo.php"); 
else{
?>
<h1><?php echo $gallery[0]['ime']; ?></h1>
<hr/>
<div class="well well-sm col-md-6">
	<p><?php echo $gallery[0]['opis']; ?></p>
</div>
<div class="clear"></div>

<ul id="galerija">
<?php
	if($gallery[0]['slid']==null)
	{
		message("Немате прикачено нови слики. <a href='".$current_url."&new_photo'>прикачете слика</a>","info");
	}
	else
	{
?>
<div class="form-group">
	<a href="<?php echo ADMIN_PATH.'index.php?p=gallery'; ?>" class="btn btn-default"><i class="fa fa-reply"></i> Назад</a>
	<a href=<?php echo $current_url."&new_photo"; ?> class="btn btn-success">Додади слика</a>
</div>
<?php
	foreach($gallery as $g)
	{
		
?>
	
				<li>
					<div class="form-group">
						<img src="<?php echo IMAGE_PATH."/".$g['ime']."/photos/".$g['slika_ime'];?>" alt="галерија">
					</div>
					<div class="form-group">
						<a href="<?php echo BASE_URL; ?>contollers/delete_photo.php?slid=<?php echo $g['slid']; ?>" class="btn btn-danger btn-xs subscriber_delete">избриши</a>
					</div>
				</li>
		<?php } ?>
<?php
		}
?>
</ul>
<?php } ?>