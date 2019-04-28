<!DOCTYPE html>

<html lang="en">

<head>
	<title>Sixties Beach Boys Albums | The Beach Boys Cover Database</title>
	<link rel="stylesheet" href="resources/bb.css">
	<meta name="author" content="Chris Cook">
	
	<script
		src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"
		type="text/javascript"></script>
	<script src="resources/stupidtable.min.js"
		type="text/javascript"></script>
	<script src="resources/songLists.js" type="text/javascript"></script>
	
	<!-- sortable tables -->
	<script type="text/javascript">
			$(function(){
			$("#AllSongs").stupidtable();
			});
		 </script>
	
	<!-- google analytics removed -->
</head>

<body id="page">

<?php

require_once ( "../../../resources/autoloader.php");

//Autoload classes
(new autoloader(FALSE));

$output = "";
$output .= loadHeader();

//TODO generate this stuff?
$albums = array(array("Surfin' Safari", 1962),
array("Surfin' U.S.A.", 1963),array("Surfer Girl", 1963), 
array("Little Deuce Coupe", 1963), array("Shut Down Volume 2",1964),
array("All Summer Long", 1964), array("The Beach Boys' Christmas Album",1964),
array("The Beach Boys Today!", 1965), array("Summer Days (And Summer Nights!!)", 1965), 
array("Beach Boys' Party!", 1965), array("Pet Sounds", 1966),
array("Smiley Smile",1967), array("Wild Honey",1967),
array("Friends", 1968), array("20/20", 1969));

$output .= albumDisplay::displayAlbums($albums);

echo $output;
?>


</body>


</html>
