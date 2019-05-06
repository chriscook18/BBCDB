<!DOCTYPE html>

<html lang=en>

<head>
	<title>Covers involving Beach Boys | The Beach Boys Cover Database</title>
	<link rel="stylesheet" href="resources/bb.css">
	<meta name="author" content="Chris Cook">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript" src="resources/songLists.js"></script>
	
	<!-- Global site tag (gtag.js) - Google Analytics -->

</head>

<body id = "page">


<?php

require_once ( "../../../resources/autoloader.php");

//Autoload classes
(new autoloader());


$output = "";
$output .= loadHeader();

$output .= "<div id=\"margins\">";

$output .= "<div id='songPage'>";

$involvesBB = new involvesBB();

$output .= $involvesBB->involvedBB();

$output .= "</div>";
$output .= "</div>";

echo $output;
?>

</body>

</html>
