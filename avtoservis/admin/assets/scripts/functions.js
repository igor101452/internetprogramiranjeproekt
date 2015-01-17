$(function(){
  var current_url = window.location.href;
  var base_url = window.location.origin+"/internetprogramiranjeproekt/avtoservis/";

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

  $("button[name='mechanic_status']").click(function(){
    var mid = $(this).attr('id');

    $.ajax({
      url: base_url+"contollers/mechanic_status_change.php?mid="+mid,
      type: "get",
      success: function(data){
        console.log(data);
        if(data=="true")
        {
          window.location.reload();
        }
        else
        {
          alert("Грешка. Обидете се повторно!");
        }
      }
    });
  });
});
