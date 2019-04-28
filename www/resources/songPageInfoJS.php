<?php
// Refresh song page when a new song is selected in the dropdown (query string changes)

require_once ( "../../../../resources/autoloader.php");

//Autoload classes
(new autoloader(FALSE, TRUE));


$output = "";
$title = "";
if (isset($_POST['id'])) {
	$output .= songPage::songPageLoad($_POST['id'], $title);
}

echo $output;
