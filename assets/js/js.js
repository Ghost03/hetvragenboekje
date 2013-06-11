$(function()
{
	// Remember me

    $("#switch").on("click", function()
    {
	   if($("#switch").hasClass("switch"))
		  {
			 $(this).removeClass("switch");
			 $(this).addClass("switch-active");
			 $(this).children('input[name="remember"]').val("1")
		  }
		  else
		  {
			 $(this).addClass("switch");
			 $(this).removeClass("switch-active");
			 $(this).children('input[name="remember"]').val("0")
			 
		  }
    });

    // Focus fields
    
    $("input").on("focus",function()
    {
	   $("input").parents(".search-bar, .key-field, .user-field").removeClass("focus");
	   $(this).parents(".search-bar, .key-field, .user-field").addClass("focus");

    });
    
    $("input").placeholder();

    // Header images
   
    var pathArray = window.location.pathname.split( '/' );
    var url = pathArray[0];
    var items = Array(1,2,3,4,5,6,7,8,9,10,11,12);
    var item = items[Math.floor(Math.random()*items.length)];
    $(".search-img").html('<img src="'+url+'assets/img/categories/150x150/'+item+'.png" />');

    // Handleiding

    $('.handleiding a').click(function() {
    	$('#modal').load('private/app/views/scripts/html/modal.phtml');
    	return false;
    });

    //F.A.Q.
    
    $(".faq p").hide();

    $("#info h3").on("click", function(){
	   $(this).next().toggle('slow')
    })

    // Slider

	var slider = {
	    
	    header: function(){
	        
		    var images = 'assets/img/slides/slide*.png';
			var i = 2;
			var delay = 10000;

			setInterval(function() {
			    var path = images.replace('*', i);
			    var slide = $("#slider");
			    slide.fadeOut(function() {
				    $(this).attr("src", path).fadeIn("slow");
				});
			    i = i + 1;
			    if (i == 3) i = 1;
			}, delay);
	        
	    },
	            
	    ads: function() {

	    
		    var images = 'assets/img/prom/slide*.png';
			var i = 2;
			var delay = 5000;
			$("#prom").children().on("click", function()
		 {
			 window.location.href = "mailto:sales@hetvragenboekje.nl";
		 });
			setInterval(function() {
			    var path = images.replace('*', i);
			    var slide = $("#prom").children("img");
			    slide.fadeOut(function() {
				    $(this).attr("src", path).fadeIn("slow");
				});
			    i = i + 1;
			    if (i == 4) i = 1;
			}, delay);
	        
	    }

	}
	slider.header();
	slider.ads();


});