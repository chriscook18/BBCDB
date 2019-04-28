<!DOCTYPE html>

<html lang=en>

<head>
	<title>Contact | The Beach Boys Cover Database</title>
	<link rel="stylesheet" href="resources/bb.css">
	<meta name="author" content="Chris Cook">
<!-- google analytics removed -->


</head>

<body id="page">
<div id="margins" align="center">

	<?php
	
	require_once ( "../../../resources/autoloader.php");
	
	//Autoload classes
	//TODO a proper contact page...
	(new autoloader(FALSE));
	
	echo loadHeader();
	?>


	<div class="mainPageBox">
		<h2>Contact us</h2>
		<p>Have a cover we don't? Know a link we are missing? Get in touch.</p>
		<p>Until we get a working contact page, just email beachboyscovers[@]gmail.com</p>
	</div>

</div>
</body>


</html>
