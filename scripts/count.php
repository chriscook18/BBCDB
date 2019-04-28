<?php

	include ( "../resources/connection.php" );
	$conn = new connection(TRUE);

	//Get highest ID since there are a couple of gaps in the table
	$query = "SELECT MAX(`ID`) as max_id FROM `songs`";
	$coverInfoGet = $conn->getQuery( $query )->fetch_assoc();

	$songCount = $coverInfoGet['max_id'];

	echo ( $songCount );

	for ( $x = 0; $x < $songCount+1; $x++ ) {
		$query2 = "SELECT COUNT(`ID`) FROM `covers` WHERE SONG = " . $x;
		$getCount = $conn->getQuery( $query2 )->fetch_assoc();
		echo ( "\n song" . $x  . " " . $getCount['COUNT(`ID`)'] . "\n" );
		$query3 = "UPDATE `songs` SET `COUNT`= " . $getCount['COUNT(`ID`)'] . " WHERE `ID` = " . $x;
		$conn->getQuery( $query3);
	}