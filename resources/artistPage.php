<?php

// Display covers on artist page
class artistPage {
	
	public static function artistPageLoad($id, &$title, $bLink = false) {
		// Create an artist page HTML
		//
		// $id - query string
		// $title - BYREF - returns artist name
		// $bLink - BOOL - If TRUE then adding a link artist to a main artist page.
		//
		// RETURN HTML for artist page
		$output = "";
		$bOk = FALSE; // Successfully made artist page
		
		do {
			
			if (!is_numeric($id)) {
				// No artist to get.
				break;
			}
			
			// Load up artist details
			$conn = new connection();
			
			$artist = artistPage::getArtistRecord($id, $conn);
			
			if ($artist->num_rows <= 0) {
				// No artist with that ID
				break;
			}
			
			while ($artistInfo = $artist->fetch_assoc()) {
				// Add artist info - should only be one result
				
				if (!$bLink) {
					// Only first artist box gets dropdowns.
					$output .= self::getArtistDropDowns($artistInfo['SORTNAME'], $artistInfo['BANDTYPE']);
				}
				
				$output .= self::getArtistDetails($artistInfo, $title);
				$output .= self::getArtistCovers($artistInfo['ID'], $conn, $bLink);
			}
			
			$bOk = TRUE;
		} while (FALSE);
		
		// Clean up connection if exists
		unset($conn);
		
		if (!$bOk) {
			// Error!
			$output .= "<h3>You shouldn't have ended up here. Return <a href='index.php'>home</a>";
		}
		
		return $output;
	}
	
	private function getArtistRecord($id, $conn) {
		// DB query to get artist record
		//
		// $id - artist record id
		// $conn - DB Connection
		//
		// RETURN $result - result set
		$sql = "SELECT * FROM `artists` WHERE ID = $id ORDER BY SORTNAME ASC";
		$result = $conn->getQuery($sql);
		
		return $result;
	}
	
	private function getArtistDetails($artistInfo, &$title) {
		// Create artist info section from record
		//
		// $artistInfo - artist record
		// $title - BYREF - page title
		//
		// RETURN $output HTML
		$bPutSpace = FALSE; // Already added a link so need a space
		$output = "";
		
		$output .= "<div id='headingBox'>";
		$output .= "<h2>" . $artistInfo['NAME'] . "</h2>";
		
		// Set title from artist name
		$title = $artistInfo['NAME'];
		
		if (!is_null($artistInfo['DESCRIPTION'])) {
			$output .= "<p>" . $artistInfo['DESCRIPTION'] . "</p>";
		}
		
		if (!empty($artistInfo['WIKIPEDIA'])) {
			if ($bPutSpace) {
				$output .= " &#8226; ";
			}
			$output .= "<a href=\"https://en.wikipedia.org/wiki/" . $artistInfo['WIKIPEDIA'] . "\">Wikipedia</a>";
			$bPutSpace = TRUE;
		}
		
		if (!empty($artistInfo['DISCOGS'])) {
			if ($bPutSpace) {
				$output .= " &#8226; ";
			}
			$output .= "<a href=\"https://www.discogs.com/artist/" . $artistInfo['DISCOGS'] . "\">Discogs</a>";
			$bPutSpace = TRUE;
		}
		
		if (!empty($artistInfo['WEBSITE'])) {
			if ($bPutSpace) {
				$output .= " &#8226; ";
			}
			
			if (is_null($artistInfo['WEBSITEDESC'])) {
				$sWebsiteDesc = "Website";
			} else {
				$sWebsiteDesc = $artistInfo['WEBSITEDESC'];
			}
			
			$output .= "<a href=\"" . $artistInfo['WEBSITE'] . "\">" . $sWebsiteDesc . "</a>";
			$bPutSpace = TRUE;
		}
		
		$output .= "</div><br/>";
		return $output;
	}
	
	private function getArtistCovers($artistID, $conn, $bLink = false) {
		// Get covers for the artist, and then go make the HTML
		//
		// $artistID - artist ID
		// $conn - DB connection
		// $bLink - BOOL - whether main artist or linked one
		//
		// RETURN $output - HTML of covers table
		$output = "";
		
		$coverInfoQuery = "SELECT songs.TITLE, covers.CALLED, covers.ALBUM, covers.ALBUMSPECIAL, covers.YOUTUBE, covers.SPOTIFY, covers.OTHERLISTEN, covers.NOTES, covers.YEAR, covers.ID, songs.ID as song, covers.LIVECOVER, covers.MEDLEY, covers.SAMPLES, covers.BBHIDE, covers.MISCCOVER, covers.OTHERDESC FROM covers INNER JOIN songs WHERE songs.ID = covers.song AND covers.ARTIST=" . $artistID . " ORDER BY TITLE ASC";
		$coverInfoGet = $conn->getQuery($coverInfoQuery);
		
		if ($coverInfoGet->num_rows > 0) {
			
			$output .= coverTable::getCoverTable($coverInfoGet, true, $bLink);
		} else {
			$output .= coverTable::getCoverTable_filterRadios_Artist();
			$output .= "<h4>No entries</h4>";
		}
		
		return $output;
	}
	
	private function getArtistDropDowns($sSortName, $sBandType) {
		// Get the right drop downs
		//
		// $sSortName - artist sortname
		// $sBandType - artist genre/category
		//
		//RETURN $output - HTML
		
		$output = "<div class='selectorBox flex-container'>";
		$output .= "<span class='flex-item'>";
		$output .= "Select artist: ";
		$output .= artistLists::getListDropDownArtistAlpha($sSortName);
		$output .= "</span>";
		$output .= "<span class='flex-item'>";
		$output .= " ";
		$output .= artistLists::getListDropDownArtistGenre($sBandType);
		$output .= "</span>";
		$output .= "</div>";
		
		return $output;
	}
	
	public static function checkLinked($artistID) {
		//Find if there are any linked artist IDs
		//
		//$artistID - main artist ID
		//
		// RETURN $ids - array of linked ids.
		
		$ids = array();
		
		//Search link table for any matches
		$sqlSearch = "SELECT ID FROM `artist_link` WHERE LINK1 = " . $artistID . " OR LINK2 = " . $artistID . " OR LINK3 = " . $artistID . " OR LINK4 = " . $artistID . " OR LINK5 = " . $artistID;
		$conn = new connection();
		$resultSearch = $conn->getQuery($sqlSearch);
		
		while ($result = $resultSearch->fetch_assoc()) {
			//For each linked, get the artist ID
			$sqlGetArtistFromLink = "SELECT ID FROM `artists` WHERE LINK = " . $result['ID'];
			$resultGetSongArtist = $conn->getQuery($sqlGetArtistFromLink)->fetch_assoc();
			array_push($ids, $resultGetSongArtist['ID']);
		}
		
		unset($conn);
		
		return $ids;
	}
}
