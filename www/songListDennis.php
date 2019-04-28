<!DOCTYPE html>

<html lang=en>

<head>
	<title>Dennis Wilson Songs| The Beach Boys Cover Database</title>
	<link rel="stylesheet" href="resources/bb.css">
	<meta name="author" content="Chris Cook">
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="resources/stupidtable.min.js"></script>
	<script src="resources/songLists.js"></script>
	
	<!-- sortable tables -->
	<script>
		$(function(){
		$("#dennisSongs").stupidtable();
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

$output .= "This page contains links to all songs in the database by written by <a href='artist.php?389'>Dennis Wilson</a>.";
$output .= $songList->radioDialsCSS();
$output .= $songList->getWriter("dennisSongs","DENNIS");

echo $output;
?>


</body>


</html>
