<?php 
if(!isAuthenticated() || isAdmin())
{
	redirect('root');
}	
$current_url = explode("&",$current_url)[0]; 

?>
<div class="profile">
	<div class="sidemeni">
		<nav id="sidemeni">
			<ul>
				<li <?php if(isset($_GET['info'])) echo "class='sidemeni_active'";?>><a href="<?php echo $current_url."&info"; ?>">Информации</a></li>
				<li <?php if(isset($_GET['schedules'])) echo "class='sidemeni_active'";?>><a href="<?php echo $current_url."&schedules"; ?>">Термини</a></li>
				<li <?php if(isset($_GET['update_info'])) echo "class='sidemeni_active'";?>><a href="<?php echo $current_url."&update_info"; ?>">Промена на податоци</a></li>
				<li <?php if(isset($_GET['p']) && $_GET['p'] == 'logout') echo "class='active'";?>><a href="<?php echo BASE_PATH."index.php?p=logout"; ?>">Одјави се</a></li>
			</ul>
		</nav>
	</div>
	<div class="info">
		<?php
			$user = $_SESSION['user'];

			if(isset($_GET['info']))
			{
				require_once("partials/info.php");
			}
			if(isset($_GET['schedules']))
			{
				require_once("partials/schedules.php");
			}
			if(isset($_GET['update_info']))
			{
				require_once("partials/update_info.php");
			}
		?>
	</div>
</div>