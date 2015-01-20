<?php $gallery = getGallery(1,false,true); ?>

<h1>Галерија</h1>
<hr/>

<ul id="galerija">
<?php foreach($gallery as $g){	?>
<li>
	<img src="<?php echo IMAGE_PATH.$g['ime']."/photos/".$g['slika_ime'];?>" alt="галерија">
</li>
<?php } ?>
</ul>