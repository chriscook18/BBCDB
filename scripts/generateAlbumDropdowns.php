<?php

require_once('../resources/connection.php');

$conn = new connection();

//Get hardcoded album list
$listAlbums = listAlbums();

$outputDropDown = "";

//TODO this could be refactored I'm sure

//Create function in php file
$outputDropDown .= "<?php \n";

$outputDropDown .= "/*Generated on " . date("Y-m-d h:i:sa") . "by generateAlbumDropdowns.php*/ \n";


//Start a function for select case from album
$outputDropDown .= "class albumDropDown{\n";

$selectCase = "function getTracklistDropdownAlbum(\$album) {\n";
$selectCase .= "\$output = '';\n";
$selectCase .= "switch (\$album) {\n ";

$selectCaseSong = "function getDropdownAlbum(\$song) {\n";
$selectCaseSong .= "\$output = '';\n";
$selectCaseSong .= "switch (\$song) {\n ";

$selectTrackList = "function getTrackListAlbum(\$album) {\n";
$selectTrackList .= "\$output = '';\n";
$selectTrackList .= "switch (\$album) {\n ";

$albumDropDown = "";
$albumTracklist = "";

foreach ($listAlbums as $album) {
   // add to select
    $albumShort = preg_replace(array("/ /", "/'/", "/\"/", "/\(/", "/\)/", "/\./", "/-/", "/\//", "/\!/", "/\\\\/"), array("","","","","", "", "", "", ""), $album);
    $albumShort = str_replace("'", "", $albumShort);
    $selectCase .= "case \"$album\":\n";
    $selectCase .= "\$output = \"songDropDown" . $albumShort  . "()\";\n";
    $selectCase .= "break;\n";
    
    $selectTrackList .= "case \"$album\":\n";
    $selectTrackList .= "\$output .= self::songList" . $albumShort  . "();\n";
    $selectTrackList .= "break;\n";
   
    $albumDropDown .= "function songDropDown" . $albumShort . "() {\n";
    $albumDropDown .= "\$returnVal = \"\";\n";
    
    $albumTracklist .= "function songList" . $albumShort . "() {\n";
    $albumTracklist .= "\$returnVal = \"\";\n";
    
    $listofSongs = getSongs($conn, getSQLAlbum($album), TRUE);
    
    //Set up dropdown
    $albumDropDown .= "\$returnVal .= \"<select class='dropdown' onchange='changeSong_Dropdown()'>\"; \n";
    $albumDropDown .= "\$returnVal .= \"<option value='NULL'>Other songs from <i>$album</i></option>\"; \n";
    $albumDropDown .= "\$returnVal .= \"<option value='NULL'>---------</option>\"; \n";
    
    $albumTracklist .= "\$returnVal .= \"<ol id='" . $album . "'>\";\n";
   
    foreach( $listofSongs as $song) {
        //Add song to dropdown
        echo "now added ".$song[1];
        
        $selectCaseSong .= "case $song[0]:\n";
        $selectCaseSong .= "\$output .= albumDropDown::songDropDown" . $albumShort  . "();\n";
        $selectCaseSong .= "break;\n";
        
        $albumTracklist .= "\$returnVal .= \"<li>\"; \n";
        
        
        if ($song[2]) {
        	$albumDropDown .= "\$returnVal .= \"<option value='NULL'>" .  str_replace('"', '\"', $song[1]) . " </option>\"; \n";
        	$albumTracklist .= "\$returnVal .= \"" . str_replace('"', '\"', $song[1]) . " (" . $song[3] . ")\";\n";
        } else {
        	$albumDropDown .= "\$returnVal .= \"<option value = " . $song[0] . ">" .  str_replace('"', '\"', $song[1]) . "</option>\"; \n";
        	$albumTracklist .= "\$returnVal .= \"<a href='song.php?" . $song[0] . "'>" .  str_replace('"', '\"', $song[1]) . "</a> (" .  $song[3] . ")\";\n";
        }

        $albumTracklist .= "\$returnVal .= \"</li>\";\n";
        
    }
        
        
    $albumDropDown .= "\$returnVal .= \"</select>\"; \n";
    
    $albumDropDown .= "return \$returnVal; \n";
    $albumDropDown .= "} \n";
    $albumDropDown .= "\n";
    
    $albumTracklist .= "return \$returnVal; \n";
    $albumTracklist .= "} \n";
    
}

/* Other BB songs */
$albumDropDown .= "function songDropDownOtherBB() {\n";
$albumDropDown .= "\$returnVal = \"\";\n";

$listofSongs = getSongs($conn, getSQLOtherBB());

//Set up dropdown
$albumDropDown .= "\$returnVal .= \"<select class='dropdown' onchange='changeSong_Dropdown()'>\"; \n";
$albumDropDown .= "\$returnVal .= \"<option value='NULL'>Other Beach Boys songs</option>\"; \n";
$albumDropDown .= "\$returnVal .= \"<option value='NULL'>---------</option>\"; \n";
foreach( $listofSongs as $song) {
    //Add song to dropdown
    echo "now added ".$song[1];
    
    $selectCaseSong .= "case $song[0]:\n";
    $selectCaseSong .= "\$output .= albumDropDown::songDropDownOtherBB();\n";
    $selectCaseSong .= "break;\n";
    
    $albumDropDown .= "\$returnVal .= \"<option value = " . $song[0] . ">" . str_replace('"', '\"', $song[1]) . "</option>\"; \n";
}
$albumDropDown .= "\$returnVal .= \"</select>\"; \n";

$albumDropDown .= "return \$returnVal; \n";
$albumDropDown .= "} \n";
$albumDropDown .= "\n";


/* Non-BB Songs */
$albumDropDown .= "function songDropDownNonBB() {\n";
$albumDropDown .= "\$returnVal = \"\";\n";

$listofSongs = getSongs($conn, getSQLNonBB());

//Set up dropdown
$albumDropDown .= "\$returnVal .= \"<select class='dropdown' onchange='changeSong_Dropdown()'>\"; \n";
$albumDropDown .= "\$returnVal .= \"<option value='NULL'>Solo and other songs</option>\"; \n";
$albumDropDown .= "\$returnVal .= \"<option value='NULL'>---------</option>\"; \n";
foreach( $listofSongs as $song) {
	//Add song to dropdown
	echo "now added ".$song[1];
	
	$selectCaseSong .= "case $song[0]:\n";
	$selectCaseSong .= "\$output .= albumDropDown::songDropDownNonBB();\n";
	$selectCaseSong .= "break;\n";
	
	$albumDropDown .= "\$returnVal .= \"<option value = " . $song[0] . ">" . str_replace('"', '\"', $song[1]) . "</option>\"; \n";
}
$albumDropDown .= "\$returnVal .= \"</select>\"; \n";

$albumDropDown .= "return \$returnVal; \n";
$albumDropDown .= "} \n";
$albumDropDown .= "\n";

// Close select cases
$selectCaseSong .= "}\n";
$selectCaseSong .= "return \$output;\n";
$selectCaseSong .= "}\n";

$selectCase .= "}\n";
$selectCase .= "return \$output;\n";
$selectCase .= "}\n";

$selectTrackList .= "}\n";
$selectTrackList .= "return \$output;\n";
$selectTrackList .= "}\n";


//Finalise
$outputDropDown .= $selectCaseSong;
$outputDropDown .= $selectCase;
$outputDropDown .= $albumDropDown;
$outputDropDown .= $albumTracklist;
$outputDropDown .= $selectTrackList;

//Close Class
$outputDropDown .= "}\n";

$fp=fopen('../resources/generated/albumDropDown.php','w');
fwrite($fp, $outputDropDown);
fclose($fp);

unset($conn);

function listAlbums() {
    $albums = array("Surfin' Safari", "Surfin' U.S.A.", "Surfer Girl");
    array_push($albums, "Little Deuce Coupe", "Shut Down Volume 2", "All Summer Long");
    array_push($albums, "The Beach Boys' Christmas Album", "The Beach Boys Today!");
    array_push($albums, "Summer Days (And Summer Nights!!)", "Beach Boys' Party!");
    array_push($albums, "Pet Sounds", "Smiley Smile", "Wild Honey");
    array_push($albums, "Friends", "20/20", "Sunflower", "Surf's Up");
    array_push($albums, 'Carl And The Passions - \"So Tough\"', "Holland");
    array_push($albums, "15 Big Ones", "The Beach Boys Love You", "M.I.U. Album");
    array_push($albums, "L.A. (Light Album)", "Keepin' The Summer Alive", "The Beach Boys");
    array_push($albums, "Still Cruisin'", "Summer In Paradise", "That's Why God Made The Radio");
    
    return $albums;
    
}

function getSongs($conn, $sql, $bAlbum = FALSE) {
	
	$result = $conn->getQuery($sql );
	
	$list = array();
	
	while ( $master = $result->fetch_assoc() ) {
		//Add song to dropdown
		echo ("\n added " . $master['TITLE'] );
		
		if (!is_null($master['DISPLAYSONG'])) {
			$iLink = $master['DISPLAYSONG'];
		} else {
			$iLink = $master['ID'];
		}
		
		//Commented lines are if we want quotes around the title.
		//Proper but filtering a pain
		//$sTitle = "\"" . $master['TITLE'];
		$sTitle = $master['TITLE'];
		
		if ($master['COVER']) {
			//$sTitle .= "\" [Cover]";
			$sTitle .= " [Cover]";
			$bExclude = true;
		} else {
			//$sTitle .= "\"";
			$bExclude = false;
		}
		
		$listBuffer[0] = $iLink;
		$listBuffer[1] = $sTitle;
		$listBuffer[2] = $bExclude;
		if ($bAlbum){
			$listBuffer[3] = $master['WRITERS'];
		}
		
		array_push( $list, $listBuffer );
	}
	
	return $list;
}

function getSQLAlbum($album) {

    $sql = "SELECT ID, TITLE, COUNT, DISPLAYSONG, COVER, WRITERS FROM `songs` WHERE ALBUM = \"" . $album . "\" and NONALBUMTRACK = 0 ORDER BY TRACKNO ASC";
        
    return $sql;
}

function getSQLOtherBB() {
	
	$sql = "SELECT ID, TITLE, COUNT, DISPLAYSONG, COVER FROM `songs` WHERE COUNT > 0 AND BBSONG = 1 AND  NONALBUMTRACK = 1 ORDER BY TITLE ASC";
	
	return $sql;
}

function getSQLNonBB() {
	
	$sql = "SELECT ID, TITLE, COUNT, DISPLAYSONG, COVER FROM `songs` WHERE COUNT > 0 AND BBSONG = 0 ORDER BY TITLE ASC";
	
	return $sql;
}
