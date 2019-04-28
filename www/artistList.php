<!DOCTYPE html>

<html lang=en>

<head>
	<title>Artist list | The Beach Boys Cover Database</title>
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

$output .= "<p>Ordered by surname, without 'The' or other language equivalents.</p>";
$output .= artistLists::lettersArtist();
$output .= artistLists::listAlphabetical();
$output .= artistLists::lettersArtist();

$output .= "</div>";
$output .= "</div>";

echo $output;
?>

</body>


</html>
