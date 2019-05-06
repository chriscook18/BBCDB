<?php
require_once('../resources/connection.php');

// Generate drop downs and bulleted lists for artist genres
while (false) {
	if (isset($argv[1])) {
		$code = $argv[1];
	} else {
		echo "Enter an argument";
		break;
	}
	
	if ($code == "ALL") {
		perGenre("C");
		perGenre("E");
		perGenre("K");
		perGenre("J");
		perGenre("P");
		perGenre("R6");
		perGenre("R7");
		perGenre("R9");
		perGenre("V");
		perGenre("M");
		perGenre("Y");
	} else {
		perGenre($code);
	}
}

function perGenre($code) {
	// Create a dropdown for a given genre
	//
	// $code - genre code
	
	$fp = fopen('../resources/generated/artistDropDownGenre' . $code . '.php', 'w');

	$details = genreCodeToName($code);
	
	$output = generateArtistDropDownGenre($code, $details[0], $details[1]);
	fwrite($fp, $output);
	fclose($fp);
}

function genreCodeToName($code) {
	//Get the full description for a code
	//
	// $code - genre code
	//
	//RETURN $returnArray - names for genre
	$returnArray[2] = "";
	
	switch ($code) {
		case "C":
			$returnArray[0] = "Country/Folk";
			$returnArray[1] = "Country & folk  acts";
			break;
		case "E":
			$returnArray[0] = "Electronic";
			$returnArray[1] = "Electronic artists";
			break;
		case "K":
			$returnArray[0] = "Kids";
			$returnArray[1] = "Children's acts";
			break;
		case "J":
			$returnArray[0] = "Jazz";
			$returnArray[1] = "Jazz & orchestral artists";
			break;
		case "P":
			$returnArray[0] = "Punk";
			$returnArray[1] = "Punk, ska & metal bands";
			break;
		case "R6":
			$returnArray[0] = "Rock/Pop 60s";
			$returnArray[1] = "Rock & pop: 1960s artists";
			break;
		case "R7":
			$returnArray[0] = "Rock/Pop 70s80s";
			$returnArray[1] = "Rock & pop: 1970s and 1980s artists";
			break;
		case "R9":
			$returnArray[0] = "Rock/Pop 90s00s10s";
			$returnArray[1] = "Rock & pop: 1990s to present artists";
			break;
		case "V":
			$returnArray[0] = "Vocal";
			$returnArray[1] = "Vocal groups & performers";
			break;
		case "M":
			$returnArray[0] = "Misc";
			$returnArray[1] = "Miscellaneous";
			break;
		case "Y":
			$returnArray[0] = "Youtubers etc.";
			$returnArray[1] = "Youtubers and online artists";
			break;
	}
	return $returnArray;
}

function generateArtistDropDownGenre($code, $genre, $desc) {
	// Actually make the dropdown and list
	//
	//$code - genre code
	//$genre - genre short description
	//$desc - genre long description
	//
	//RETURN PHP code $outputDropdown
	
	$conn = new connection();
	
	echo $genre;
	
	//Get result set
	$sql = "SELECT ID, SORTNAME FROM `artists` WHERE BANDTYPE = '" . $genre . "' ORDER BY SORTNAME ASC";
	$result = $conn->getQuery($sql);
	
	if ($result->num_rows > 0) {
		//Need to create both at once to save on reads
		$outputDropdown = "";
		$outputList = "";
		
		// Create function in php file
		$outputDropdown .= "<?php \n";
		
		$outputDropdown .= "/*Generated on " . date("Y-m-d h:i:sa") . " by generateArtistDropDownByGenre.php*/ \n";
		//Wrap in a class
		$outputDropdown .= "class artistDropDownGenre" . $code . "{\n";
	
		$outputDropdown .= "public static function loadDropDown() {\n";
		$outputList .= "public static function loadList() {\n";
		
		$outputDropdown .= "\$returnVal = \"\";\n";
		$outputList .= "\$returnVal = \"\";\n";
		
		// Set up dropdown
		$outputDropdown .= "\$returnVal .= \"<select class='dropdown' onchange='changesArtist()'>\"; \n";
		$outputList .= "\$returnVal .= \"<h2 id='genre" . $code . "'>" . $desc . "</h2>\"; \n";
		$outputDropdown .= "\$returnVal .= \"<option value='NULL'>Other " . $desc . "</option>\"; \n";
		$outputList .= "\$returnVal .= \"<ul>\";\n";
		$outputDropdown .= "\$returnVal .= \"<option value='NULL'>---------</option>\"; \n";
		
		while ($master = $result->fetch_assoc()) {
			// Add artist to dropdown
			$outputDropdown .= "\$returnVal .= \"<option value = " . $master['ID'] . ">" . $master['SORTNAME'] . " </option>\"; \n";
			$outputList .= "\$returnVal .=\"<li><a href='artist.php?" . $master['ID'] . "'>" . $master['SORTNAME'] . "</a></li>\"; \n";
		}
		$outputDropdown .= "\$returnVal .= \"</select>\"; \n";
		$outputList .= "\$returnVal .= \"</ul>\"; \n";
		$outputList .= "\$returnVal .= \"<a href='#top'>Return to top</a>\"; \n";
		
		$outputDropdown .= "return \$returnVal; \n";
		$outputList .= "return \$returnVal; \n";
		$outputDropdown .= "} \n";
		$outputList .= "} \n";
		
		//Close class
		$outputList .= "} \n";
	}
	else {
		echo "NO RESULTS";
	}
	
	unset($conn);
	
	$outputDropdown .= $outputList;
	return $outputDropdown;
}