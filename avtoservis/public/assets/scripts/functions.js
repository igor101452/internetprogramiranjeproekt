var imageWidth = 640;

$(window).ready(function() {
    //Slideshow na pocetna stranica
    var currentImage = 0;

    var allImages = $('#slideshow li img').length;

    $('#slideshow ul').width(allImages*imageWidth);

    $('.slideshow-next').click(function(){
        
        currentImage++;

        if(currentImage>=allImages) currentImage = 0;

        setFramePosition(currentImage);

    });

    $('.slideshow-prev').click(function(){

        currentImage--;

        if(currentImage<0) currentImage = allImages-1;

        setFramePosition(currentImage);

    });

    setInterval(function(){

        currentImage++;

        if(currentImage>=allImages) currentImage = 0;

        setFramePosition(currentImage);
    },4000);

    //kraj za slideshow na pocetna stranica

    $(".subscriber_delete").click(function(e){
      e.preventDefault();
      if(window.confirm("Дали сте сигурни?"))
      {
        window.location = $(this).attr('href');
      }
      return false;
  });

  $("#datepicker").datepicker();
   $('#timepicker').timepicker({
        timeFormat: 'HH:mm',

        minTime: new Date(0, 0, 0, 8, 0, 0),
        maxTime: new Date(0, 0, 0, 16, 0, 0),

        startHour: 6,
 
        startTime: new Date(0, 0, 0, 9, 00, 0),

        interval: 60
    });

   //Galerija
    var current_li;

    $("#galerija img").click(function(){
        var src = $(this).attr("src");
        current_li = $(this).parent();
        $("#main").attr("src",src);
        $("#frame").fadeIn();
        $("#overlay").fadeIn();
    });



    $("#overlay").click(function(){
        $("#overlay").fadeOut();
        $("#frame").fadeOut();
    });

    $("#right").click(function(){

        if(current_li.is(":last-child")){
            var next_li = $("#galerija li").first();
        }else{
            var next_li = current_li.next();
        }
        
        var next_src = next_li.children("img").attr("src");
        $("#main").attr("src",next_src);
        console.log($("#main").attr("src"));
        current_li = next_li;
    });

    $("#left").click(function(){
        if(current_li.is(":first-child")){
            var prev_li = $("#galerija li").last();
        }else{
            var prev_li = current_li.prev();
        }
        
        var prev_src = prev_li.children("img").attr("src");
        $("#main").attr("src",prev_src);
        current_li = prev_li;
    });

   //Kraj galerija
   
});

function setFramePosition(pos){
    
    var px = imageWidth*pos*-1;

    $('#slideshow ul').animate({
        left: px
    }, 300);
}