$(function()
    {
	   $("#inloggen").validate({
		  errorElement: "div",
		  errorContainer: $("div.errors"),
		  errorPlacement: function(error, element) {
			 $(".errors").html("");
			 error.appendTo( element.parent("div").parent("form").parent("div").children(".errors") );
		  },
		  rules: {
			 email: {
				required: true,
				email: true
			 },
			 password: "required"
			
		  },
		  messages: {
			 email: "Vul een valide e-mailadres in",
			 password: "Vul een wachtwoord in"
		  }
	   });
   
	   $("#register").validate({
	  
		  errorElement: "div",
		  errorContainer: $("div.errors"),
		  errorPlacement: function(error, element) {
			 $(".errors").html("");
			 error.appendTo( element.parent("div").parent("form").parent("div").children(".errors") );
		  },
		  rules: {
			 email: {
				required: true,
				email: true
			 },
			 name: {
				required: true,
				minlength: 2
			 },
			 rpassword: "required",
			 rpassword2: {
				required: true,
				equalTo: "#rpassword"
			 }
		  },
		  messages: {
			 name: "Vul een naam in",
			 email: "Vul een valide e-mailadres in",
			 rpassword: "Vul een wachtwoord in",
			 rpassword2: "Wachtwoord komt niet overeen"
		  }
	   });
	   var emailError = $("#email-error").text();
	   $("#login").children(".errors").append('<div for="email" class="error" style="">'+emailError+'</div>')
   
	   var checklogin = $(location).attr('pathname');

	   checklogin.indexOf(2);
   
	   checklogin.toLowerCase();
   
	   checklogin = checklogin.split("/")[2];
   
	   if(checklogin == "checklogin")
	   {
		  $("#login").parents(".box").css("height", "280px").effect("shake", 600);
	   }
   
});