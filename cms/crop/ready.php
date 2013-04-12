<?php
$link = $_GET['link'];
?><html>
	<head>

		<script src="js/jquery.min.js"></script>
		<script src="js/jquery.Jcrop.js"></script>
		<link rel="stylesheet" href="css/jquery.Jcrop.css" type="text/css" />
		<link rel="stylesheet" href="demo_files/demos.css" type="text/css" />

		<style>
		#cropbox {
			padding: 5px;
			border: 1px solid #000;
		}
		</style>

	</head>

	<body>

	<div id="outer">
		<div class="jcExample">
			<div class="article">
				
				<h1>Complete</h1>
				<p>The image was successfully converted to the new format.</p>
		
				<!-- This is the image we're attaching Jcrop to -->
				<img src="<?php echo $link ?>" id="cropbox" />
				
				<h1 style="margin-top: 20px;">What to do?</h1>
				<p>
					Copy the link below and paste it into the field where you want this image.
					<input type="text" style="padding: 10px; font-size: 15px; font-weight: bold; width: 450px; margin-top: 15px;" value="<?php echo $link; ?>" />
				</p>
				
				<input type="button" value="Close Window" onClick="window.close()">

			</div>
		</div>
	</div>
	
	</body>
</html>