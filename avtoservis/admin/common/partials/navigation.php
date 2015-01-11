<nav  class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container-fluid menu-margin">

	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" href="#">Автосервис</a>
	    </div>

	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav left-nav">
	        <li class="active"><a href="<?php echo ADMIN_PATH; ?>index.php">Термини <span class="sr-only">(current)</span></a></li>
	        <li><a href="<?php echo ADMIN_PATH; ?>index.php?p=members">Членови</a></li>
	        <li><a href="<?php echo ADMIN_PATH; ?>index.php?p=subscribers">Претплатници</a></li>
	      </ul>
	      <ul class="nav navbar-nav navbar-right">
	        <li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Администратор <span class="caret"></span></a>
	          <ul class="dropdown-menu" role="menu">
	            <li><a href="#"><i class="fa fa-gear"></i> Промени лозинка</a></li>
	            <li class="divider"></li>
	            <li><a href="<?php echo ADMIN_PATH; ?>index.php?p=logout"><i class="fa fa-sign-out"></i> Одјави се</a></li>
	          </ul>
	        </li>
	      </ul>
	    </div>

  	</div>
</nav>

