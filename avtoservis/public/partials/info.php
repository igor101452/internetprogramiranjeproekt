<h2><?php echo $user['ime']." ".$user['prezime']; ?></h2>
<hr/>
<table>
	<tr>
		<th>Име</th>
		<td><?php echo $user['ime']; ?></td>
	</tr>
	<tr>
		<th>Презиме</th>
		<td><?php echo $user['prezime']; ?></td>
	</tr>
	<tr>
		<th>Емаил</th>
		<td><?php echo $user['email']; ?></td>
	</tr>
</table>