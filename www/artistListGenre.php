<!DOCTYPE html>

<html lang=en>

<head>
	<title>Artists by genre | The Beach Boys Cover Database</title>
	<link rel="stylesheet" href="resources/bb.css">
	<meta name="author" content="Chris Cook">
	
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
$output .= "<div id=\"songList\">";

$output .= artistLists::genreListsBar();
$output .= "<p>Genres are only approximate.</p>";
$output .= artistLists::listbyGenre();
$output .= artistLists::genreListsBar();
$output .= "</div>";
$output .= "</div>";

echo $output;
?>

</body>


</html>
