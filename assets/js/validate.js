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
		 email: "Please enter a valid email address",
		 password: "Please enter your password"
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
		 name: "Naam",
		 email: "Please enter a valid email address",
		 rpassword: "Please enter your password",
		 rpassword2: "Please enter your password"
	  }
   });
   var emailError = $("#email-error").text();
  $("#inloggen").children(".user-field").append('<label for="email" class="error" style="">'+emailError+'</label>')
   
});