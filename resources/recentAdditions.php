<?php

class recentAdditions {
	
	function loadRecentAdditions($iLimit = 30, $sFormat = "table") {
		//Get recent additions for mainpage/own page
		//
		// $iLimit - INT - how many covers to show
		// $sFormat - changes display format
		//
		// RETURN $output HTML
		
		$output = "";
		$conn = new connection();
		
		//Create an sql query
		$coverInfoQuery = "SELECT artists.NAME, covers.SONG, covers.YEAR, covers.CALLED, covers.ALBUM, covers.NOTES, 
	covers.SPOTIFY, covers.YOUTUBE, covers.OTHERLISTEN, covers.OTHERDESC, covers.ID, covers.ALBUMSPECIAL, artists.SORTNAME, 
	artists.ID as artID, songs.TITLE FROM covers INNER JOIN artists INNER JOIN songs WHERE 
	artists.ID = covers.ARTIST AND songs.ID = covers.SONG ORDER BY covers.ID DESC LIMIT $iLimit";
		
		$coverInfoGet = $conn->getQuery($coverInfoQuery);
		
		switch ($sFormat) {
			case "homepage":
				if ($coverInfoGet->num_rows > 0) {
					$output .= "<ul class='recentAdditionsList'>";
					
					while ($cover = $coverInfoGet->fetch_assoc()) {
						
						$output .= "<li>";
						
						// Add artist
						$output .= "<a href=\"artist.php?" . $cover["artID"] . "\">" . $cover['NAME'] . "</a>";
						$output .= " - ";
						// Add song
						$output .= "\"<a href=\"song.php?" . $cover["SONG"] . "\">" . $cover['TITLE'] . "</a>\"";
						// Add alternate name if necessary
						if (!is_null($cover['CALLED'])) {
							$output .= " (as \"" . $cover['CALLED'] . "\")";
						}
						
						$output .= "</li>";
					}
					
					$output .= "</ul>";
				}
				break;
			
			case "table":
			default:
				// format into a table
				if ($coverInfoGet->num_rows > 0) {
					$output .= "<div class='covers-table-div'>";
					$output .= "<table style=\"width:100%\" border = 1>";
					$output .= "<tr>
					 <th>Song</th>
					 <th>Artist</th>
					 <th>Album</th>
					 <th>Year</th> 
					 <th style='width:25%'>Listen</th>
					 <th style='width:35%'>Notes</th>
				 </tr>";
					
					while ($cover = $coverInfoGet->fetch_assoc()) {
						
						$output .= "<tr>";
						
						// Get song title
						// $songInfoQuery = "SELECT songs.TITLE FROM songs WHERE songs.ID = " . $cover['SONG'];
						// $songInfoGet = getQuery( $conn, $songInfoQuery );
						// $songInfo = $songInfoGet->fetch_assoc();
						
						$output .= "<td><a href='song.php?" . $cover['SONG'] . "'>" . $cover['TITLE'] . "</a>";
						if (!is_null($cover['CALLED'])) {
							$output .= "<br /> (as \"" . $cover['CALLED'] . "\")";
						}
						$output .= "<td><a href='artist.php?" . $cover['artID'] . "'>" . $cover['NAME'] . "</a>";
						$output .= "</td>";
						if (!is_null($cover['ALBUMSPECIAL'])) {
							$output .= "<td>";
							$output .= specialAlbum($cover['ALBUM'], $cover['ALBUMSPECIAL']);
							$output .= "</td>";
						}
						else {
							$output .= "<td><i>" . $cover['ALBUM'] . "</i></td>";
						}
						$output .= "<td>" . $cover['YEAR'] . "</td>";
						$output .= "<td>";
						/*
						 * Some have Youtube, some Spotify, some neither, some both.
						 */
						$output .= getListenLinks($cover);
						$output .= "<td>" . $cover['NOTES'] . "</td>";
						$output .= "</tr>";
					}
					$output .= "</table>";
					$output .= "</div>";
				}
				break;
		}
		return $output;
	}
}