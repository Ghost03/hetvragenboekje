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
	   
	   $("#steleenvraag").validate({
		  errorElement: "div",
		  errorContainer: $("div.errors"),
		  errorPlacement: function(error, element) {
			 $(".errors").html("");
		
			 error.appendTo(element.parent("fieldset").parent("form").parent("div").children(".errors"));
		  },
		  rules: {
			 categorie_id:{
				required: true
			 },
			 name: {
				required: true,
				minlength: 2,
				maxlength: 182
			 }
		  },
		  messages: {
			 categorie_id: "Selecteer een categorie",
			 name: "Stel uw vraag met minimaal 2 karakters en maximaal 182."
		  }
	   });
	   
	   var l_emailError = $("#l-email-error").text();
	   $("#login").children(".errors").append('<div for="email" class="error" style="">'+l_emailError+'</div>')
	   var r_emailError = $("#r-email-error").text();
	   $("#registreren").children(".errors").append('<div for="email" class="error" style="">'+r_emailError+'</div>')
   
	   var checklogin = $(location).attr('pathname');

	   checklogin.indexOf(2);
   
	   checklogin.toLowerCase();
   
	   checklogin = checklogin.split("/")[2];
   
	   if(checklogin == "checklogin")
	   {
		  $("#login").parents(".box").css("height", "280px").effect("shake", 600);
	   }
	   if(checklogin == "registreren")
	   {
		  $("#registreren").parents(".box").css("height", "280px").effect("shake", 600);
	   }
   
});