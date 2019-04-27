<?php

class artwork {
	
	private function albumGetArtworkByName($sAlbum) {
		// Get artwork for given album name
		//
		// $sAlbum - album name to lookup
		//
		// RETURN $file - filename;
		$sAlbum = preg_replace("/\"/","\\\"", $sAlbum);
		
		$sql = "SELECT `FILENAME` FROM `artwork` WHERE `ALBUM` = \"" . $sAlbum . "\" LIMIT 1";
		$file = "";
		
		$file = artwork::albumGetArtworkInternal($sql);
		
		return $file;
	}
	
	private function albumGetArtworkById($iId) {
		// Get artwork for given artwork id
		//
		// $iID - album artwork id
		//
		// RETURN $file - filename;
		$sql = "SELECT `FILENAME` FROM `artwork` WHERE `ID` = $iId LIMIT 1";
		$file = "";
		
		$file = artwork::albumGetArtworkInternal($sql);
		
		return $file;
	}
	
	private function albumGetArtworkInternal($sSQL) {
		// Perform artwork look up
		//
		// $sSQL - sql query to execute
		//
		// RETURN $file - filename;
		
		// TODO Don't like how it needs a whole new connection
		$conn = new connection(FALSE);
		$file = "";
		
		$rArtwork = $conn->getQuery($sSQL);
		
		if ($rArtwork != "" && $rArtwork->num_rows > 0) {
			while ($art = $rArtwork->fetch_assoc()) {
				$file = $art['FILENAME'];
			}
		}
		
		unset($conn);
		
		return $file;
	}
	
	public static function getArtwork($sAlbum, $iOverride = 0) {
		// Get artwork for page
		//
		// $sAlbum - album name to lookup
		// $iOverride - Artwork ID
		//
		// RETURN $sReturn - img HTML;
		if ($iOverride == 0) {
			$sFile = artwork::albumGetArtworkByName($sAlbum);
		}
		else {
			$sFile = artwork::albumGetArtworkById($iOverride);
		}
		
		$sPathTest = "resources/images/" . $sFile;
		if ($sFile != "") {
			
			$sPath = $sPathTest;
			$sReturn = "<img class='flex-item' src=\"" . $sPath . "\" alt=\"" . $sAlbum . " cover\" height=\"100\" width=\"100\">";
		}
		else {
			$sReturn = "";
		}
		
		return $sReturn;
	}
	
	public static function displayArtwork($sAlbum) {
		// Get artwork for tracklist page
		//
		// $sAlbum - album name to lookup
		//
		// RETURN img HTML;
		return self::getArtwork($sAlbum);
		;
	}
}
