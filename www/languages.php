<!DOCTYPE html>

<html lang=en>

<head>
	<title> Covers in Other Languages | The Beach Boys Cover Database</title>
	<link rel="stylesheet" href="resources/bb.css">
	<meta name="author" content="Chris Cook">
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript" src="resources/songLists.js"></script>
	<script type="text/javascript" src="resources/stupidtable.min.js"></script>
	
	<!-- sortable tables -->
	<script>
		$(function(){
		$("#covers").stupidtable();
		});
	 </script>
	 
	<!-- Global site tag (gtag.js) - Google Analytics -->

</head>

<body id = "page">


<?php

require_once ( "../../../resources/autoloader.php");

//Autoload classes
(new autoloader());


$output = "";
$output .= loadHeader();

$output .= "<div id=\"margins\">";

$conn = new connection();

$output .= "<div id='songPage'>";
$output .= "<h2>Covers in non-English languages.</h2>";
$output .= languagePage::languageListBar();

$output .= "<h3 id='Catalan'>Catalan</h3>";
$output .= languagePage::listPageLang($conn, "Catalan" );
$output .= "<br />";
$output .= "<a href='#top'>Return to top</a>";

$output .= "<h3 id='Czech'>Czech</h3>";
$output .= languagePage::listPageLang($conn, "Czech" );
$output .= "<br />";
$output .= "<a href='#top'>Return to top</a>";

$output .= "<h3 id='Danish'>Danish</h3>";
$output .= languagePage::listPageLang($conn, "Danish");
$output .= "<br />";
$output .= "<a href='#top'>Return to top</a>";

$output .= "<h3 id='Dog'>Dog</h3>";
$output .= languagePage::listPageLang($conn, "Dog");
$output .= "<br />";
$output .= "<a href='#top'>Return to top</a>";

$output .= "<h3 id='Dutch'>Dutch</h3>";
$output .= languagePage::listPageLang($conn, "Dutch" );
$output .= "<br />";
$output .= "<a href='#top'>Return to top</a>";

$output .= "<h3 id='Finnish'>Finnish</h3>";
$output .= languagePage::listPageLang($conn, "Finnish" );
$output .= "<br />";
$output .= "<a href='#top'>Return to top</a>";

$output .= "<h3 id='French'>French</h3>";
$output .= languagePage::listPageLang($conn, "French" );
$output .= "<br />";
$output .= "<a href='#top'>Return to top</a>";

$output .= "<h3 id='German'>German</h3>";
$output .= languagePage::listPageLang($conn, "German" );
$output .= "<br />";
$output .= "<a href='#top'>Return to top</a>";

$output .= "<h3 id='Icelandic'>Icelandic</h3>";
$output .= languagePage::listPageLang($conn, "Icelandic" );
$output .= "<br />";
$output .= "<a href='#top'>Return to top</a>";

$output .= "<h3 id='Italian'>Italian</h3>";
$output .= languagePage::listPageLang($conn, "Italian" );
$output .= "<br />";
$output .= "<a href='#top'>Return to top</a>";

$output .= "<h3 id='Japanese'>Japanese</h3>";
$output .= languagePage::listPageLang($conn, "Japanese" );
$output .= "<br />";
$output .= "<a href='#top'>Return to top</a>";

$output .= "<h3 id='Norwegian'>Norwegian</h3>";
$output .= languagePage::listPageLang($conn, "Norwegian" );
$output .= "<br />";
$output .= "<a href='#top'>Return to top</a>";

$output .= "<h3 id='Polish'>Polish</h3>";
$output .= languagePage::listPageLang($conn, "Polish" );
$output .= "<br />";
$output .= "<a href='#top'>Return to top</a>";

$output .= "<h3 id='Portuguese'>Portuguese</h3>";
$output .= languagePage::listPageLang($conn, "Portuguese" );
$output .= "<br />";
$output .= "<a href='#top'>Return to top</a>";

$output .= "<h3 id='Romanian'>Romanian</h3>";
$output .= languagePage::listPageLang($conn, "Romanian" );
$output .= "<br />";
$output .= "<a href='#top'>Return to top</a>";

$output .= "<h3 id='Romansch'>Romansch</h3>";
$output .= languagePage::listPageLang($conn, "Romansch" );
$output .= "<br />";
$output .= "<a href='#top'>Return to top</a>";

$output .= "<h3 id='Slovene'>Slovene</h3>";
$output .= languagePage::listPageLang($conn, "Slovene" );
$output .= "<br />";
$output .= "<a href='#top'>Return to top</a>";

$output .= "<h3 id='Spanish'>Spanish</h3>";
$output .= languagePage::listPageLang($conn, "Spanish" );
$output .= "<br />";
$output .= "<a href='#top'>Return to top</a>";


$output .= "<h3 id='Swedish'>Swedish</h3>";
$output .= languagePage::listPageLang($conn, "Swedish" );
$output .= "<br />";
$output .= "<a href='#top'>Return to top</a>";

$output .= "<h3 id='WestFlemish'>West Flemish</h3>";
$output .= languagePage::listPageLang($conn, "West Flemish" );
$output .= "<br />";
$output .= "<a href='#top'>Return to top</a>";

$output .= "<br /><br />";
$output .= languagePage::languageListBar();

$output .= "</div>";
$output .= "</div>";

echo $output;
?>

</body>


</html>
