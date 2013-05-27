$(function()
{
    $("#switch").on("click", function()
    {
	   if($("#switch").hasClass("switch"))
		  {
			 $(this).removeClass("switch");
			 $(this).addClass("switch-active");
		  }
		  else
		  {
			 $(this).addClass("switch");
			 $(this).removeClass("switch-active");
			 
		  }
    });
    
    $("input").on("focus",function()
    {
	   $("input").parents(".search-bar, .key-field, .user-field").removeClass("focus");
	   $(this).parents(".search-bar, .key-field, .user-field").addClass("focus");

    });
    
    $("input").placeholder();
   
    var pathArray = window.location.pathname.split( '/' );
    var url = pathArray[0];
    var items = Array(1,2,3,4,5,6,7,8,9,10,11,12);
    var item = items[Math.floor(Math.random()*items.length)];
    $(".search-img").html('<img src="'+url+'assets/img/categories/150x150/'+item+'.png" />');
    
});