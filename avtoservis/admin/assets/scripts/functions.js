$(function(){
  var current_url = window.location.href;

  $("nav li a").each(function(){
    if($(this).attr('href')==current_url){
          $(".left-nav li").removeClass("active");
      	  $(this).parent().addClass("active"); 
      }
  });
  
});
