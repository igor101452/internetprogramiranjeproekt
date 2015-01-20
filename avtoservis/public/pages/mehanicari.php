<?php $mechanics = getMechanics(); ?>
<h1>Механичари</h1>
<hr/>

<?php if($mechanics) { ?>
<table id="mehanicari">
	<?php foreach($mechanics as $m) { ?>
	<tr>
		<td>
			<p>Име и презиме: <?php echo $m['ime']." ".$m['prezime']; ?></p>
			<p>Позиција: <?php echo $m['pozicija']; ?></p>
			<p>Статус: <strong><?php if($m['status']) echo "Активен"; else echo "Неактивен"; ?></strong></p>
		</td>
	</tr>
	<?php } ?>
</table>
<?php } ?>