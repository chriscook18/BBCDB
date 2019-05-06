<?php

class coverTable {
	
	// Build up and return a table of covers
	public static function getCoverTable($coverInfoGet, $bArtistMode = false, $bSkipRadio = false, $sTitles = array(), $id = 0) {
		// Create a HTML table of all covers for a given query $coverInfoGet.
		//
		// $coverInfoGet - database query results
		// $bArtistMode - BOOL - TRUE if displaying on an artist page. ELSE displaying on a song page
		// $bSkipRadios - BOOL - If TRUE we don't give the filtering options.
		// $sTitles - song Titles array
		// $id - song page id
		//
		// RETURN - $output - HTML code
		$output = ""; // Return value
		
		if (!$bSkipRadio) {
			// Show filters
			$output .= self::getCoverTable_filterRadios($bArtistMode);
		}
		
		$output .= "<div class='covers-table-div'>";
		$output .= "<table style=\"width:100%\" border = 1 id=\"covers\" display:default>";
		
		// Table headings
		$output .= self::getCoverTable_headerRow($bArtistMode);
		
		$output .= "<tbody>";
		
		while ($cover = $coverInfoGet->fetch_assoc()) {
			// One line for each row we read.
			$output .= self::getCoverTable_coverRow($cover, $bArtistMode, $sTitles, $id);
		}
		
		$output .= "</tbody>";
		$output .= "</table>";
		$output .= "</div>";
		
		return $output;
	}
	
	public function getCoverTable_filterRadios_Artist() {
		// Wrapper for private routine. Called when main artist lacks covers
		//
		// RETURN filter html
		return self::getCoverTable_filterRadios(TRUE);
	}
	
	private function getCoverTable_filterRadios($bArtistMode = false) {
		// Returns HTML for a set of filter radio boxes
		//
		// $bArtistMode - BOOL - If TRUE then artist page so hide certain options
		//
		// RETURN $output - HTML code.
		$output = "<div class='radios-div'>";
		
		// Doing things as a table for formatting
		$output .= "<table id='radios-table'>";
		
		// Headers - additional tooltips for context.
		$output .= "<thead>";
		$output .= "<tr>";
		$output .= "<td><div class='tooltip'><b>Studio covers</b><span class='tooltiptext'>Any studio recorded cover that doesn't fall into the other categories.</span></div></td>";
		$output .= "<td><div class='tooltip'><b>Live covers</b><span class='tooltiptext'>Any cover only performed live (including those released on live albums).</span></div></td>";
		$output .= "<td><div class='tooltip'><b>Samples</b><span class='tooltiptext'>Cover that samples the original track (or another cover)</span></div></td>";
		
		if (!$bArtistMode) {
			$output .= "<td><div class='tooltip'><b>Beach Boys & solo version</b><span class='tooltiptext'>Any cover by The Beach Boys, either as a group or solo</span></div></td>";
		}
		
		$output .= "<td><div class='tooltip'><b>Medleys</b><span class='tooltiptext'>Covers which are parts of medleys</span></div></td>";
		$output .= "<td><div class='tooltip'><b>\"Bedroom\" covers</b><span class='tooltiptext'>Recorded at home, for Youtube, etc.</span></div></td>";
		$output .= "</tr>";
		$output .= "</thead>";
		
		$output .= "<tbody>";
		
		// Show buttons
		$output .= "<tr>";
		$output .= "<td><input type='radio' name='showHideStudio' value='show' onclick='showHideSongsCSS(\"studioRow\", true)'>Show</input></td>";
		$output .= "<td><input type='radio' name='showHideLive' value='show' onclick='showHideSongsCSS(\"liveRow\", true)'>Show</input></td>";
		$output .= "<td><input type='radio' name='showHideSample' value='show' onclick='showHideSongsCSS(\"sampleRow\", true)'>Show</input></td>";
		
		if (!$bArtistMode) {
			$output .= "<td><input type='radio' name='showHideBB' value='show' onclick='showHideSongsCSS(\"bbRow\", true)'>Show</input></td>";
		}
		
		$output .= "<td><input type='radio' name='showHideMedley' value='show' onclick='showHideSongsCSS(\"medleyRow\", true)'>Show</input></td>";
		$output .= "<td><input type='radio' name='showHideYT' value='show' onclick='showHideSongsCSS(\"miscRow\", true)'>Show</input></td>";
		$output .= "</tr>";
		
		// Hide buttons
		$output .= "<tr>";
		$output .= "<td><input type='radio' name='showHideStudio' value='hide' onclick='showHideSongsCSS(\"studioRow\", false)'>Hide</input></td>";
		$output .= "<td><input type='radio' name='showHideLive' value='hide' onclick='showHideSongsCSS(\"liveRow\", false)'>Hide</input></td>";
		$output .= "<td><input type='radio' name='showHideSample' value='hide' onclick='showHideSongsCSS(\"sampleRow\", false)'>Hide</input></td>";
		
		if (!$bArtistMode) {
			$output .= "<td><input type='radio' name='showHideBB' value='hide' onclick='showHideSongsCSS(\"bbRow\", false)'>Hide</input></td>";
		}
		
		$output .= "<td><input type='radio' name='showHideMedley' value='hide' onclick='showHideSongsCSS(\"medleyRow\", false)'>Hide</input></td>";
		$output .= "<td><input type='radio' name='showHideYT' value='hide' onclick='showHideSongsCSS(\"miscRow\", false)'>Hide</input></td>";
		$output .= "</tr>";
		
		$output .= "</tbody>";
		$output .= "</table>";
		$output .= "</div>";
		
		return $output;
	}
	
	private function getCoverTable_buildClass($cover, $bArtistMode) {
		// Build up the class for the row
		// These classes are used to hide and show rows depending on filtering in place
		//
		// $cover - database row being added to the table
		// $bArtistMode - BOOL - TRUE if displaying on an artist page. ELSE displaying on a song page
		//
		// RETURN $class - a string consisting of CSS classes.
		$class = "";
		
		if ($cover['LIVECOVER']) {
			$class .= "liveRow";
		}
		
		if ($cover['SAMPLES']) {
			$class .= " sampleRow";
		}
		
		if (!$bArtistMode and $cover['BBHIDE']) {
			$class .= " bbRow";
		}
		
		if ($cover['MISCCOVER']) {
			$class .= " miscRow";
		}
		
		if ($cover['MEDLEY']) {
			$class .= " medleyRow";
		}
		
		if (empty($class)) {
			// None selected - so stick to default
			$class .= " studioRow";
		}
		
		return $class;
	}
	
	private function getCoverTable_headerRow($bArtistMode) {
		// Build up the table header row
		//
		// $bArtistMode - BOOL - TRUE if displaying on an artist page. ELSE displaying on a song page
		//
		// RETURN $output, containing the html for the table header
		$output = "<thead>";
		$output .= "<tr>";
		
		if ($bArtistMode) {
			// Key column is the song
			$output .= "<th data-sort='string'>Song <img src='resources/images/sort.png' height=\"15\" width=\"15\"></th>";
		}
		else {
			// Key column is the artist
			$output .= "<th data-sort='string'>Artist <img src='resources/images/sort.png' height=\"15\" width=\"15\"></th>";
		}
		
		$output .= "<th>Album</th>";
		// Data sort for stupidtable. Width fixed to make "sort" image line up
		$output .= " <th data-sort='int'  style='width: 3em'>Year <img src='resources/images/sort.png' height=\"15\" width=\"15\"></th>";
		$output .= "<th style='width:25%'>Listen</th>";
		$output .= "<th style='width:35%'>Notes</th>";
		$output .= "</tr>";
		$output .= "</thead>";
		
		return $output;
	}
	
	private function getCoverTable_coverRow($cover, $bArtistMode, $sTitles = array(), $songID = 0) {
		// Create a table row from the cover record.
		//
		// $cover - database query results
		// $bArtistMode - BOOL - TRUE if displaying on an artist page. ELSE displaying on a song page
		// $sTitles - song title array
		// $songID - song page so we can avoid displaying song titles unnecessarily
		//
		// RETURN - $output - HTML for table row
		$class = self::getCoverTable_buildClass($cover, $bArtistMode);
		
		$output = "<tr class=\"" . $class . "\">";
		
		// First column
		if (!$bArtistMode) {
			// Need artist name
			$output .= "<td data-sort-value='" . $cover['SORTNAME'] . "'><span><a href='artist.php?" . $cover['artID'] . "'>" . $cover['NAME'] . "</a>";
		}
		else {
			// Need song name
			$output .= "<td><span>\"<a href='song.php?" . $cover['song'] . "'>" . $cover['TITLE'] . "</a>\"";
		}
		
		if (!is_null($cover['CALLED'])) {
			$output .= "<br /> (covered as \"" . $cover['CALLED'] . "\")";
		} else if (!$bArtistMode && $cover['SONG'] != $songID ) {
			$output .= "<br /> (cover of \"" . $sTitles[$cover['SONG']] . "\")";
		}
		
		$output .= "</span></td>";
		
		// Album column
		if (!is_null($cover['ALBUMSPECIAL'])) {
			$output .= "<td><span>";
			$output .= specialAlbum($cover['ALBUM'], $cover['ALBUMSPECIAL']);
			$output .= "</span></td>";
		}
		else {
			$output .= "<td><span><i>" . $cover['ALBUM'] . "</i></span></td>";
		}
		
		// Year column
		if ($cover['YEAR'] == 0) {
			$output .= "<td data-sort-value='0'>";
		}
		else {
			$output .= "<td>";
		}
		$output .= "<span>" . $cover['YEAR'] . "</span></td>";
		
		// Some have Youtube, some Spotify, some neither, some both.
		$output .= "<td><span>";
		$output .= getListenLinks($cover);
		$output .= "</span></td>";
		
		$output .= "<td><span>" . parseText($cover['NOTES']) . "</span></td>";
		$output .= "</tr>";
		
		return $output;
	}
}
	