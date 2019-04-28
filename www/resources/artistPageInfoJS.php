<?php
//Refresh artist page when a new artist is selected in the dropdown (query string changes)

require ( "../../../../resources/autoloader.php");

//Autoload classes
(new autoloader(FALSE, TRUE));

$output = "";
if ( isset( $_POST['id'] ) ) {
	$output .= artistPageLoad( $_POST['id'] );
	$linkedIDs = ArtistPage::checkLinked( $_POST['id'] );
	foreach ( $linkedIDs as $link ) {
		$output .= artistPageLoad( $link );
	}
}

echo $output;
