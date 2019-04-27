<?php

class songLink {
	
	public function getSongLink($conn, $songLinkID, &$bFound) {
		// Get songLink details
		//
		// $conn - database connection class
		// $songLinkID - ID looking up
		// $bFound - BYREF - whether record exists or not
		//
		// RETURN $songLinkRecord
		$songLinkRecord = "";
		
		if ($songLinkID != 0) {
			
			$sqlSong = "SELECT * FROM `songlink` WHERE ID = $songLinkID ORDER BY ID ASC LIMIT 1";
			
			$result = $conn->getQuery($sqlSong);
			
			if (!empty($result) and $result->num_rows > 0) {
				$songLinkRecord = $result->fetch_assoc();
				$bFound = true;
			}
		}
		
		return $songLinkRecord;
	}
	
	public function buildSongLinkCounts($conn, $songInfo, $songLink, &$iTotal = 0) {
		// Format cover counts properly when page consists of multiple songs
		//
		// $conn - database connection object
		// $songInfo - song record
		// $songLink - songLink record
		// $iTotal - BYREF - how many covers total
		//
		// RETURN $output - count display HTML
		$output = "";
		$totalCount = $songInfo['COUNT'];
		$bFound1 = false;
		$bFound2 = false;
		$bFound3 = false;
		
		if (!is_null($songLink['ALTSONG1'])) {
			$song1 = self::getSongRecordLink($songLink['ALTSONG1'], $conn, $bFound1);
			if ($bFound1) {
				$totalCount += $song1['COUNT'];
			}
		}
		if (!is_null($songLink['ALTSONG2'])) {
			$song2 = self::getSongRecordLink($songLink['ALTSONG2'], $conn, $bFound2);
			if ($bFound2) {
				$totalCount += $song2['COUNT'];
			}
		}
		if (!is_null($songLink['ALTSONG3'])) {
			$song3 = self::getSongRecordLink($songLink['ALTSONG3'], $conn, $bFound3);
			if ($bFound3) {
				$totalCount += $song3['COUNT'];
			}
		}
		
		$output .= "Covers: " . $totalCount . ", of which";
		$output .= " <br />" . $songInfo['TITLE'] . ": " . $songInfo['COUNT'];
		if ($bFound1) {
			$output .= " <br />" . $song1['TITLE'] . ": " . $song1['COUNT'];
			$iTotal += $song1['COUNT'];
		}
		if ($bFound2) {
			$output .= " <br />" . $song2['TITLE'] . ": " . $song2['COUNT'];
			$iTotal += $song2['COUNT'];
		}
		if ($bFound3) {
			$output .= " <br />" . $song3['TITLE'] . ": " . $song3['COUNT'];
			$iTotal += $song3['COUNT'];
		}
		
		return $output;
	}
	
	private function getSongRecordLink($id, $conn, &$bFound) {
		// Get song record from DB using ID
		//
		// $id - record we're looking up
		// $conn - database connection object
		// $bFound - BYREF BOOL whether found it or not
		//
		// RETURN $songInfo - song record
		$songInfo = "";
		
		$sqlSong = "SELECT `ID`, `COUNT`, `TITLE` FROM `songs` WHERE ID = $id ORDER BY TITLE ASC LIMIT 1";
		$result = $conn->getQuery($sqlSong);
		
		if (!empty($result) and $result->num_rows > 0) {
			$songInfo = $result->fetch_assoc();
			$bFound = true;
		}
		
		return $songInfo;
	}
	
	public function buildLinkCoversQuery($songInfo, $songLink) {
		// Build up the covers query to include linked songs
		//
		// $songInfo - song record
		// $songLink - song link record
		//
		// RETURN $output - SQL component
		$output = "SONG IN (" . $songInfo['ID'];
		
		if (!is_null($songLink['ALTSONG1'])) {
			$output .= ", " . $songLink['ALTSONG1'];
		}
		if (!is_null($songLink['ALTSONG2'])) {
			$output .= ", " . $songLink['ALTSONG2'];
		}
		if (!is_null($songLink['ALTSONG3'])) {
			$output .= ", " . $songLink['ALTSONG3'];
		}
		
		$output .= ")";
		
		return $output;
	}
	
	public function linkedCoverCount($conn, $songInfo, $songLink) {
		// Count how many linked covers there are for lists
		//
		// $conn - database connection object
		// $songInfo - song record
		// $songLink - song link record
		//
		// RETURN $iTotal INT - how many covers?
		$iTotal = 0;
		
		songLink::buildSongLinkCounts($conn, $songInfo, $songLink, $iTotal);
		
		return $iTotal;
	}
}