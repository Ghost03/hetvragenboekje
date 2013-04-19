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
   
  
   
	 $("#inloggen #submit").on("click",function()
	 {
		
	   var loginMail = $("#inloggen #email").val();
		console.log(loginMail);
		  $.ajax({
			 type: "GET",
			 url: "checklogin",
			 data: { email: loginMail}
		    }).success(function( msg ) {
			   console.log("testje");
			   console.log(msg)
		});
	 });
	 
});

