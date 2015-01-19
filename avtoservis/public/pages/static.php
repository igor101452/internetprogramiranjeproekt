<?php 
	if(isset($_GET['p']))
	{
		$slug = $_GET['p'];

		$page = getPage($slug);
	}
?>

<?php if($page) { ?>
<h1><?php echo $page['ime']; ?></h1>
<hr/>
<div>
	<?php echo $page['sodrzina']; ?>
</div>
<?php } ?>

<div class="clear"></div>