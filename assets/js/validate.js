$(function()
{
   $("#inloggen").validate({
	  errorElement: "div",
	  errorContainer: $(".error"),
	  errorPlacement: function(error, element){
		 error.appendTo(element.parents("error"));
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
	  errorContainer: $(".error"),
	  errorPlacement: function(error, element){
		 error.appendTo(element.parents("error"));
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
  $("#inloggen").children(".user-field").append('<label for="email" class="error" style="">'+emailError+'</label>')
   
});