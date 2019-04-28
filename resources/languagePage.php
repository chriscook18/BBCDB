<?php

class languagePage {
	
	function listPageLang($conn, $lang) {
		//Get covers in language $lang and display in a table
		//
		//$conn - database connection class
		//$lang - language looking up
		//
		//RETURN $output HTML
		
		$output = "";
		
		$coverInfoQuery = "SELECT artists.NAME, covers.SONG, covers.YEAR, covers.CALLED, covers.ALBUM, covers.NOTES,
	covers.SPOTIFY, covers.YOUTUBE, covers.OTHERLISTEN, covers.ID, covers.ALBUMSPECIAL, artists.SORTNAME,
	artists.ID as artID, songs.TITLE, covers.OTHERDESC FROM covers INNER JOIN artists INNER JOIN songs WHERE
	artists.ID = covers.ARTIST AND songs.ID = covers.SONG AND covers.LANGUAGE = \"" . $lang . "\"  ORDER BY songs.TITLE ASC";
		
		$coverInfoGet = $conn->getQuery($coverInfoQuery);
		
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

				// Some have Youtube, some Spotify, some neither, some both.
				$output .= getListenLinks($cover);
				$output .= "<td>" . parseText($cover['NOTES']) . "</td>";
				$output .= "</tr>";
			}
			$output .= "</table>";
			$output .= "</div>";
			
		}
		
		return $output;
	}
	
	function languageListBar() {
		//Nav bar for languages
		//
		//RETURN $output HTML
		
		//TODO what if languages are on a table instead?
		
		$output = "";
		$output .= "<div class = 'mainPageBox navbox' id='top'>";
		
		$output .= "<b>Languages:</b> <a href='#Catalan'>Catalan</a> &#8226; <a href='#Czech'>Czech</a> &#8226; <a href='#Danish'>Danish</a> &#8226; <a href='#Dog'>Dog</a> &#8226; <a href='#Dutch'>Dutch</a> &#8226; <a href='#Finnish'>Finnish</a> &#8226; <a href='#French'>French</a> &#8226;
		<a href='#German'>German</a> &#8226; <a href='#Icelandic'>Icelandic</a> &#8226; <a href='#Italian'>Italian</a> &#8226; <a href='#Japanese'>Japanese</a> &#8226; <a href='#Norwegian'>Norwegian</a> &#8226; <a href='#Polish'>Polish</a>  &#8226; <a href='#Portuguese'>Portuguese</a> &#8226; <a href='#Slovene'>Slovene</a>
		 &#8226; <a href='#Romanian'>Romanian</a> &#8226; <a href='#Romansch'>Romansch</a> &#8226; <a href='#Spanish'>Spanish</a> &#8226; <a href='#Swedish'>Swedish</a> &#8226; <a href='#WestFlemish'>West Flemish</a>";
		
		$output .= "</div>";
		return $output;
	}
}