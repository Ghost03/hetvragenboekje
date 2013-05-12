$(function()
{
   $("#inloggen").validate({
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
		 rpassword2: "Please enter your password"
	  }
   });
   var emailError = $("#email-error").text();
  $("#inloggen").children(".user-field").append('<label for="email" class="error" style="">'+emailError+'</label>')
   
});