<!DOCTYPE html>

<html lang=en>

<head>
	<title>Ricky Fataar Songs| The Beach Boys Cover Database</title>
	<link rel="stylesheet" href="resources/bb.css">
	<meta name="author" content="Chris Cook">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="resources/stupidtable.min.js"></script>
	<script src="resources/songLists.js"></script>
	
	<!-- sortable tables -->
	<script>
		$(function(){
		$("#rickySongs").stupidtable();
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

$output .= "This page contains links to all songs in the database written by <a href='artist.php?360'>Ricky Fataar</a>.";
$output .= $songList->radioDialsCSS();
$output .= $songList->getWriter("rickySongs","RICKY");

echo $output;
?>


</body>


</html>
