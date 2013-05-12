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
    
});