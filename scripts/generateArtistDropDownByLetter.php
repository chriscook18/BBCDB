<?php
require_once ('../resources/connection.php');

// Generate drop downs and bulleted lists for artist sortnames

$id = $argv[1];

if ($id == "ALL") {
	perLetter("A");
	perLetter("B");
	perLetter("C");
	perLetter("D");
	perLetter("E");
	perLetter("F");
	perLetter("G");
	perLetter("H");
	perLetter("I");
	perLetter("J");
	perLetter("K");
	perLetter("L");
	perLetter("M");
	perLetter("N");
	perLetter("O");
	perLetter("P");
	perLetter("Q");
	perLetter("R");
	perLetter("S");
	perLetter("T");
	perLetter("U");
	perLetter("V");
	perLetter("W");
	perLetter("X");
	perLetter("Y");
	perLetter("Z");
	perLetter("0");
	perLetter("1");
	perLetter("2");
	perLetter("3");
	perLetter("4");
	perLetter("5");
	perLetter("6");
	perLetter("7");
	perLetter("8");
	perLetter("9");
}
else {
	perLetter($id);
}

function perLetter($letter) {
	// Create a dropdown for a given letter
	//
	// $letter - letter of sortname
	$fp = fopen('../resources/generated/artistDropDownLetter' . $letter . '.php', 'w');
	
	$output = generateArtistDropDownLetter($letter);
	
	fwrite($fp, $output);
	fclose($fp);
}

function generateArtistDropDownLetter($letter) {
	// Actually make the dropdown and list
	//
	//$letter - letter of sortname
	//
	//RETURN PHP code $outputDropdown

	$conn = new connection();
	
	//Get result set
	$sql = "SELECT ID, SORTNAME, LINK FROM `artists` WHERE SORTNAME LIKE '" . $letter . "%' ORDER BY SORTNAME ASC";
	$result = $conn->getQuery($sql);
	
	//Need to create both at once to save on reads
	$outputDropdown = "";
	$outputList = "";
	
	// Create function in php file
	$outputDropdown .= "<?php \n";
	$outputDropdown .= "/*Generated on " . date("Y-m-d h:i:sa") . " by generateArtistDropDownByLetter.php*/ \n";
	
	//Wrap in a class
	$outputDropdown .= "class artistDropDownLetter" . $letter . "{\n";
	$outputDropdown .= "public static function loadDropDown() {\n";
	$outputList .= "public static function loadList() {\n";
	
	if ($result->num_rows > 0) {
		
		$outputDropdown .= "\$returnVal = \"\";\n";
		$outputList .= "\$returnVal = \"\";\n";
		
		// Set up dropdown
		$outputDropdown .= "\$returnVal .= \"<select class='dropdown' onchange='changesArtist()'>\"; \n";
		$outputList .= "\$returnVal .= \"<h2 id='letter" . $letter . "'>" . $letter . "</h2>\";\n";
		
		$outputDropdown .= "\$returnVal .= \"<option value='NULL'>Other " . $letter . " artists</option>\"; \n";
		$outputList .= "\$returnVal .= \"<ul>\";\n";
		$outputDropdown .= "\$returnVal .= \"<option value='NULL'>---------</option>\"; \n";
		
		while ($master = $result->fetch_assoc()) {
			// Add artist to dropdown
			IF (is_null($master['LINK'])) {
				$outputDropdown .= "\$returnVal .= \"<option value = " . $master['ID'] . ">" . $master['SORTNAME'] . " </option>\"; \n";
				$outputList .= "\$returnVal .= \"<li><a href='artist.php?" . $master['ID'] . "'>" . $master['SORTNAME'] . "</a></li>\"; \n";
			}
		}
		$outputDropdown .= "\$returnVal .= \"</select>\"; \n";
		$outputList .= "\$returnVal .= \"</ul>\"; \n";
		$outputList .= "\$returnVal .= \"<a href='#top'>Return to top</a>\"; \n";
		
		$outputDropdown .= "return \$returnVal; \n";
		$outputList .= "return \$returnVal; \n";
		
	}
	else {
		echo "NO RESULTS";
	}
	
	
	unset($conn);
	
	$outputDropdown .= "} \n";
	$outputList .= "} \n";
	
	$outputDropdown .= $outputList;
	//Close class
	$outputDropdown .= "} \n";

	return $outputDropdown;
}



