<!DOCTYPE html>

<html lang=en>

<head>
	<title>Recent additions | The Beach Boys Cover Database</title>
	<link rel="stylesheet" href="resources/bb.css">
	<meta name="author" content="Chris Cook">
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	
<!-- google analytics removed -->


</head>

<body id = "page">


<?php

require_once ( "../../../resources/autoloader.php");

//Autoload classes
(new autoloader(FALSE));


$output = "";
$output .= loadHeader();

$output .= "<div id=\"margins\">";

$output .= "<div id='songPage'>";

$output .= "<h2>Recent additions</h2>";
$output .= "The latest 30 covers to enter the database";
$output .= recentAdditions::loadRecentAdditions();

$output .= "</div>";
$output .= "</div>";

echo $output;
?>

</body>


</html>
