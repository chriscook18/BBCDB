<!DOCTYPE html>

<html lang=en>

<?php

require_once ( "../../../resources/autoloader.php");

//Autoload classes
(new autoloader());



$output = "";
$title = "";
$output .= loadHeader();

$id = $_SERVER['QUERY_STRING'];

$output .= "<div id='songPage'>";
$output .= songPage::songPageLoad( $id, $title );
$output .= "</div>";

?>

<head>
	<title><?php echo $title?> | The Beach Boys Cover Database</title>
	<link rel="stylesheet" href="resources/bb.css">
	<meta name="author" content="Chris Cook">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type="text/javascript" src="resources/refreshPage.js"></script>
	<script type="text/javascript" src="resources/songLists.js"></script>
	<script type="text/javascript" src="resources/stupidtable.min.js"></script>

	<!-- sortable tables -->
	<script>
		$(function(){
		$("#covers").stupidtable();
		});
	 </script>
	 
<!-- google analytics removed -->


</head>

<body id = "page">

<?php

echo $output;

?>


</body>


</html>
