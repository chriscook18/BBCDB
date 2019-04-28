<!DOCTYPE html>

<html lang=en>

<?php

require_once ( "../../../resources/autoloader.php");

//Autoload classes
(new autoloader(FALSE));

$output = "";
$title = "";
$dummyTitle="";
$output .= loadHeader();

$id = $_SERVER['QUERY_STRING'];

$output .= "<div id='artistPage'>";
$output .= artistPage::artistPageLoad( $id, $title );
$output .= "</div>";

// Get linked artists if any exist
$linkedIDs = artistPage::checkLinked( $id );
foreach ( $linkedIDs as $link ) {
	$output .= "<br />";
	$output .= artistPage::artistPageLoad( $link, $dummyTitle, true );
}

// I assume this was to stop a caching issue? But can't remember.
unset($link);

$output .= "</div>";

?>

<head>
<title> <?php echo $title ?> | The Beach Boys Cover Database</title>
	<link rel="stylesheet" href="resources/bb.css">
	<meta name="author" content="Chris Cook">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> <!-- JQuery -->
	<script type="text/javascript" src="resources/refreshPage.js"></script>
	<script type="text/javascript" src="resources/songLists.js"></script>
	<script type="text/javascript" src="resources/stupidtable.min.js"></script>

	<!-- google analytics removed -->

	<!-- sortable tables -->
	<script>
		$(function(){
		$("#covers").stupidtable();
		});
	 </script>
</head>

<body id="page">
<div id="margins">

	<?php
	echo $output;
	?>

</div>
</body>


</html>
