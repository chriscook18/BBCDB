<!DOCTYPE html>

<html lang=en>

<head>
	<title>Later Beach Boys Albums | The Beach Boys Cover Database</title>
	<link rel="stylesheet" href="resources/bb.css">
	<meta name="author" content="Chris Cook">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="resources/stupidtable.min.js"></script>
	<script src="resources/songLists.js"></script>
	<!-- sortable tables -->
	<script>
		$(function(){
		$("#AllSongs").stupidtable();
		});
	 </script>
	<!-- google analytics removed -->

</head>

<body id = "page">

<?php

require_once ( "../../../resources/autoloader.php");

//Autoload classes
(new autoloader(FALSE));

$output = "";
$output .= loadHeader();

//TODO generate this stuff?
$albums = array(array("Sunflower", 1970),
array("Surf's Up", 1971),array("Carl And The Passions - \"So Tough\"", 1972),
array("Holland", 1973), array("15 Big Ones",1976),
array("The Beach Boys Love You", 1977), array("M.I.U. Album",1978),
array("L.A. (Light Album)", 1979), array("Keepin' The Summer Alive", 1980),
array("The Beach Boys", 1985), array("Still Cruisin'", 1989),
array("Summer In Paradise",1992), array("The Smile Sessions","2011 (rec. 1966/1967)"),
array("That's Why God Made The Radio", 2012));

$output .= albumDisplay::displayAlbums($albums);


echo $output;
?>


</body>


</html>
