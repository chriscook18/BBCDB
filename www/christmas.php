<!DOCTYPE html>

<html lang=en>

<head>
	<title> Christmas covers | The Beach Boys Cover Database</title>
	<link rel="stylesheet" href="resources/bb.css">
	<meta name="author" content="Chris Cook">
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	
<!-- google analytics removed -->

</head>

<body onload = "checkJQuery()" id = "page">


<?php

require_once ( "../../../resources/autoloader.php");

//Autoload classes
(new autoloader(FALSE));

//TODO make this display the covers.
$output = "";
$output .= loadHeader();

$output .= "<div id=\"margins\">";

$output .= "<h2>Christmas Covers</h2>";
$output .= "<p>Below you will find all Christmas songs in the database:</p>";

$output .= "<ul>";
$output .= "<li><a href='song.php?423'>Alone On Christmas Day</a> (rec. 1977)</li>";
$output .= "<li><a href='song.php?382'>Bells Of Christmas</a> (rec. 1977)</li>";
$output .= "<li><a href='song.php?370'>Child Of Winter</a> (1973)</li>";
$output .= "<li><a href='song.php?71'>Christmas Day</a> (1964)</li>";
$output .= "<li><a href='song.php?67'>Little Saint Nick</a> (1963)</li>";
$output .= "<li><a href='song.php?68'>The Man With All The Toys</a> (1964)</li>";
$output .= "<li><a href='song.php?383'>Melekalikimaka</a> (rec. 1977)</li>";
$output .= "<li><a href='song.php?70'>Merry Christmas, Baby</a> (1964)</li>";
$output .= "<li><a href='song.php?384'>Morning Christmas</a> (rec. 1977)</li>";
$output .= "<li><a href='song.php?69'>Santa's Beard</a> (1964)</li>";
$output .= "</ul>";
$output .= "</div>";
echo $output;
?>

</body>


</html>
