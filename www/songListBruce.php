<!DOCTYPE html>

<html lang=en>

<head>
	<title>Bruce Johnston Songs | The Beach Boys Cover Database</title>
	<link rel="stylesheet" href="resources/bb.css">
	<meta name="author" content="Chris Cook">
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="resources/stupidtable.min.js"></script>
	<script src="resources/songLists.js"></script>
	
	<!-- sortable tables -->
	<script>
		$(function(){
		$("#bruceSongs").stupidtable();
		});
	 </script>
	 
<!-- google analytics removed -->

</head>

<body id = "page">

<?php

require_once ( "../../../resources/autoloader.php");

//Autoload classes
(new autoloader());

$songList = new songLists();

$output = "";
$output .= loadHeader();
$output .= $songList->songListNavbar();

$output .= "This page contains links to all songs in the database written by <a href='artist.php?401'>Bruce Johnston</a>.";
$output .= $songList->radioDialsCSS();
$output .= $songList->getWriter("bruceSongs","BRUCE");

echo $output;
?>


</body>


</html>
