<?php
	$new_pass = false;
	
	$gallery = getGallery(1);

	if(isset($_POST['subscribe']))
	{
		extract($_POST);

		$status = subscribe($email);

		if($status===true)
		{
			message("Успешно се претплативте","success");
		}
		elseif($status===false)
		{
			message("Грешка при испраќање! Обидете се повторно","danger");
		}
		else
		{
			$errors = implode("<br>",$status);

			message($errors,"danger");
		}
	}

	if(isset($_POST['login']))
	{
		extract($_POST);

		if(login($email,$lozinka)===2)
		{
			$new_pass = true;
		}
	}

	if(isset($_POST['nova_loz']))
	{
		extract($_POST);
		@session_start();
	
		$user = $_SESSION['user'];
	
		$status = firstLogin($lozinka,$user);

		if($status)
		{
			redirect("profile");
		}
		else
		{
			message("Грешка при промена на лозинка. Обидете се повторно","danger");
		}
	}

	
?>
<?php
	if($new_pass){
		require_once("partials/new_password.php");
	}else{
?>

<h1>Добредојдовте на <strong>Автосервис</strong></h1>

<div class="levo">
	<div id="slideshow">
		<a href="#gal" class="slideshow-prev">&laquo;</a> 
		<ul>
			<?php foreach($gallery as $photo) { ?>
		    <li><img src="../images/<?php echo $photo['ime']; ?>/photos/<?php echo $photo['slika_ime']; ?>" alt="photo1" /></li>
		    <?php } ?>
		</ul>
		<a href="#gal" class="slideshow-next">&raquo;</a> 

	</div>
</div>
<div class="desno">
	<?php @session_start(); if(!isset($_SESSION['logged']) || isAdmin()){ ?>
	<div class="login">
		<h3>Логин форма</h3>
		<form action="" method="post">
	      	<div class="grupa">
	        	<input type="text" name="email" placeholder="Емаил">
	      	</div>
	      	<div class="grupa">
        		<input type="password" name="lozinka" placeholder="Лозинка">
	      	</div>
	      	<div class="grupa">
        		<input type="submit" name="login" value="Најави се" id="logirajse">
        		<a href="" style="float:right; margin-top:15px;">регистрирај се</a>
	      	</div>
		</form>
	</div>

	<div class="subscribe">
		<span>Претплатете се за да добивате новини</span>
		<form action="" method="post">
			<div class="grupa">
				<input type="text" name="email" placeholder="Емаил">
			</div>
			<div class="grupa">
				<input type="submit" name="subscribe" value="Претплати се" class="btn btn-success btn-xs"/>
			</div>
		</form>
	</div>
	<?php } ?>
</div>
<?php } ?>