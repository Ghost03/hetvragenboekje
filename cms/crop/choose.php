<?php
// Set the path to the CMS.
$path = 'http://www.amsterdamstandard.es/projects/iventions/';

$_GET['picture'] = str_replace("_cropped.jpg", ".jpg", $_GET['picture']);

if( isset($_GET['ratio']) )
{
	$ratio = $_GET['ratio'];
}
else
{
	$ratio = 1;
}
if( isset($_GET['picture']) )
{
	$picture = str_replace("_cropped.jpg", ".jpg", $_GET['picture']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$targ_w = $_GET['result_width'];
	$targ_h = $_GET['result_height'];
	$jpeg_quality = 100;

	$src = $_GET['picture'];
	$img_r = imagecreatefromjpeg($src);
	$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

	imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],
	$targ_w,$targ_h,$_POST['w'],$_POST['h']);

	//header('Content-type: image/jpeg');
	
	$picture = str_replace($path, "../../", $_GET['picture']);
	$picture = str_replace(".jpg", "_cropped.jpg", $picture);
	
	imagejpeg($dst_r, $picture, $jpeg_quality);

	$newlink = str_replace("../../", $path, $picture);
	header('Location: ready.php?link='. $newlink .'');
	exit();
}

// If not a POST request, display page below:

?><html>
	<head>

		<script src="js/jquery.min.js"></script>
		<script src="js/jquery.Jcrop.js"></script>
		<link rel="stylesheet" href="css/jquery.Jcrop.css" type="text/css" />
		<link rel="stylesheet" href="demo_files/demos.css" type="text/css" />

		<script language="Javascript">

			$(function(){

				$('#cropbox').Jcrop({
					aspectRatio: <?php echo $ratio ?>,
					onSelect: updateCoords,
					onChange: showPreview,
				});

			});

			function updateCoords(c)
			{
				$('#x').val(c.x);
				$('#y').val(c.y);
				$('#w').val(c.w);
				$('#h').val(c.h);
			};

			function checkCoords()
			{
				if (parseInt($('#w').val())) return true;
				alert('Please select a crop region then press submit.');
				return false;
			};
			
			function showPreview(coords)
			{
				var rx = <?php echo $_GET['result_width'] ?> / coords.w;
				var ry = <?php echo $_GET['result_height'] ?> / coords.h;
			
				$('#preview').css({
					width: Math.round(rx * 500) + 'px',
					height: Math.round(ry * 370) + 'px',
					marginLeft: '-' + Math.round(rx * coords.x) + 'px',
					marginTop: '-' + Math.round(ry * coords.y) + 'px'
				});
				
			var $preview = $('#preview');

		  function showPreview(coords)
		  {
		    if (parseInt(coords.w) > 0)
		    {
		      var rx = 100 / coords.w;
		      var ry = 100 / coords.h;
		
		      $preview.css({
		        width: Math.round(rx *  <?php echo $_GET['result_width'] ?>) + 'px',
		        height: Math.round(ry *  <?php echo $_GET['result_height'] ?>) + 'px',
		        marginLeft: '-' + Math.round(rx * coords.x) + 'px',
		        marginTop: '-' + Math.round(ry * coords.y) + 'px'
		      }).show();
		    }
		  }
		
		  function hidePreview()
		  {
		    $preview.stop().fadeOut('fast');
		  }
				
			};

		</script>
		
		<style>
		#preview {
			width: <?php echo $_GET['result_width'] ?>px;
			height:  <?php echo $_GET['result_height'] ?>px;
			overflow: hidden;
			margin-top: 10px;
		}
		</style>

	</head>

	<body>

	<div id="outer">
		<div class="jcExample">
			<div class="article">
				
				<h1>What kind of image would it be?</h1>
				
				<a href="crop.php?ratio=16/9&picture=<?php echo $_GET['picture']; ?>&result_width=280&result_height=150">- Testimonial image</a><br />
				<a href="crop.php?ratio=16/9&picture=<?php echo $_GET['picture']; ?>&result_width=630&result_height=470">- Cases / News image</a><br />
				<a href="crop.php?ratio=16/9&picture=<?php echo $_GET['picture']; ?>&result_width=280&result_height=150">- Team member - Small</a><br />
				<a href="crop.php?ratio=28/33&picture=<?php echo $_GET['picture']; ?>&result_width=280&result_height=330">- Team member - Large</a>
                                <a href="crop.php?ratio=28/33&picture=<?php echo $_GET['picture']; ?>&result_width=280&result_height=330">- Team member - Large</a>

			</div>
		</div>
	</div>
	
	</body>
</html>