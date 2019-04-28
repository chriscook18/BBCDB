<?php 

/*
 * This generates the cover counts for the main page
 * IT DOES NOT UPDATE INDIVIDUAL SONG COUNTS
 */

require_once ( "../resources/connection.php");


$output = "";

//Create count function
$output .= "<?php \n";
$output .= "/*Generated on " . date("Y-m-d h:i:sa") . " by getCoverCount.php*/ \n";
$output .= "class frontPageCounts{";
$routine = "function coverCount() {\n";
$routine .= "return " . coverCount() . ";\n";
$routine .= "}\n";
$output .= $routine;

//Create updated function
$routine = "function coverDate() {\n";
$routine .= "return '" . date("jS \of F Y") . "';\n";
$routine .= "}\n";
$output .= $routine;
$output .= "}";

//Save back as generated resource
$fp=fopen('../resources/generated/frontPageCounts.php','w');
fwrite($fp, $output);
fclose($fp);


function coverCount() {
	// How many covers in the table?
	//
	// RETURN int - $number - how many covers there are
	
	$conn = new connection();
	$query = "SELECT COUNT(*) FROM `covers`";
	
	$result = $conn->getQuery($query);
	$row = $result->fetch_row();
	$number = $row[0];
	
	return $number;
	
}
