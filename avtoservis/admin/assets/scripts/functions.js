$(function(){
  var current_url = window.location.href;

  $("nav li a").each(function(){
    if($(this).attr('href')==current_url){
          $(".left-nav li").removeClass("active");
      	  $(this).parent().addClass("active"); 
      }
  });

  if(window.location.href.indexOf("&")>=0)
  {
    var url = current_url.split("&");

    $("nav li a").each(function(){
      if($(this).attr('href')==url[0])
      {
        $(".left-nav li").removeClass("active");
        $(this).parent().addClass("active"); 
      }
    });
  }
  

  $(".subscriber_delete").click(function(e){
  		e.preventDefault();
  		if(window.confirm("Дали сте сигурни?"))
  		{
  			window.location = $(this).attr('href');
  		}
  		return false;
  });
});
