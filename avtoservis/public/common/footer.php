<div class="footer">
		<p>Интернет програмирање, &copy; <?php echo date('Y'); ?></p>
	</div>
	<script src="assets/scripts/jquery-1.11.1.min.js"></script>
	<script src="assets/libraries/jquery-ui/jquery-ui.js"></script>
	<script src="assets/scripts/timepicker/jquery.timepicker.min.js"></script>
	<script src="assets/scripts/functions.js"></script>
	<script type="text/javascript">
		$(function(){
			var div_top = $('nav').offset().top;
			var window_top = $(window).scrollTop();

			if (window_top > div_top) {
		      $('nav').addClass('stick');
			 }

			$(window).scroll(function(){
			  window_top = $(window).scrollTop();
			  	
			  if(window_top<=div_top){
			      $('nav').removeClass('stick');
			  }
			  if (window_top > div_top) {
			      $('nav').addClass('stick');
			  }
			});
		});
	</script>
</body>
</html>