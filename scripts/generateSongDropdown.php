<?php
require ("../resources/connection.php");
require ("../resources/songLink.php");

$conn = new connection();
// Get records with covers OR master pages
$sql = "SELECT ID, TITLE, COUNT, DISPLAYSONG, SONGLINK FROM `songs` WHERE COUNT > 0 OR SONGLINK > 0 ORDER BY TITLE ASC";
$result = $conn->getQuery($sql, $conn);

$listOfSongs = getSongs($result, $conn);

$allSongsDropDown = "";

// Create function in php file
$allSongsDropDown .= "<?php \n";

$allSongsDropDown .= "/*Generated on " . date("Y-m-d h:i:sa") . " by generateSongDropdown.php*/ \n";

//Wrap in a class
$allSongsDropDown .= "class songDropDown {\n";

$allSongsDropDown .= "function loadDropDown() {\n";

$allSongsDropDown .= "\$returnVal = \"\";\n";

// Set up dropdown
$allSongsDropDown .= "\$returnVal .= \"<select class='dropdown' onchange='changeSong_Dropdown()'>\"; \n";
$allSongsDropDown .= "\$returnVal .= \"<option value='NULL'>Select song</option>\"; \n";
$allSongsDropDown .= "\$returnVal .= \"<option value='NULL'>---------</option>\"; \n";
foreach ($listOfSongs as $song) {
	// Add song to dropdown
	echo "now added " . $song[1];
	
	//Version with quotes around titles. Proper but screws up typing to get results
	$allSongsDropDown .= "\$returnVal .= \"<option value = " . $song[0] . ">" . $song[1] . "</option>\"; \n";
	//$allSongsDropDown .= "\$returnVal .= \"<option value = " . $song[0] . ">\\\"" . $song[1] . "\\\"</option>\"; \n";
}
$allSongsDropDown .= "\$returnVal .= \"</select>\"; \n";

$allSongsDropDown .= "return \$returnVal; \n";
$allSongsDropDown .= "} \n";

//Close class
$allSongsDropDown .= "} \n";


$fp = fopen('../resources/generated/songDropDown.php', 'w');
fwrite($fp, $allSongsDropDown);
fclose($fp);

unset($conn);

function getSongs($result, $conn) {
	if ($result->num_rows > 0) {
		$list = array();
		
		while ($master = $result->fetch_assoc()) {
			// Add song to dropdown
			$bFound = FALSE;
			$bUseLinked = FALSE;
			
			$linkInfo = songLink::getSongLink($conn, $master['SONGLINK'], $bFound);
			
			If ($bFound) {
				
				// Probably a nicer way around this
				if ($linkInfo['MAINSONG'] == $master['ID']) {
					if (songLink::linkedCoverCount($conn, $master, $linkInfo) == 0) {
						continue;
					}
				}
				else {
					$bUseLinked = TRUE;
				}
			}
			
			echo ("\n added " . $master['TITLE']);
			
			switch (TRUE) {
				case $bUseLinked:
					$iLink = $linkInfo['MAINSONG'];
					break;
				case (!is_null($master['DISPLAYSONG'])):
					$iLink = $master['DISPLAYSONG'];
					break;
				default:
					$iLink = $master['ID'];
			}
			
			$listBuffer[0] = $iLink;
			$listBuffer[1] = $master['TITLE'];
			
			array_push($list, $listBuffer);
		}
	}
	return $list;
}

