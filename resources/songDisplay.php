<?php
class songDisplay {
	
	/* ************** */
	/* TABLE FORMATS */
	/* ************** */
	public function songTableFormat($sID) {
		$output = ""; // Return value
		
		$output .= "<table style=\"width:100%\" border = 1 id='" . $sID . "'>";
		$output .= "<thead>";
		$output .= "<tr>
				 <th data-sort='string'>Song <img src='resources/images/sort.png' height=\"15\" width=\"15\"></th>
				<th>Album</th> 
				<th>Writers</th>
				 <th data-sort='int'>Number of covers <img src='resources/images/sort.png' height=\"15\" width=\"15\"></th>
				 </tr>";
		$output .= "</thead>";
		$output .= "<tbody>";
		
		return $output;
	}
	
	public function outputSongLineTable($songRecord, $bCountZeros = false, $bArtists = false, $bHideZeros = false, $bCSSHideZero = false) {
		// Output song line in the correct format for displaying in a table
		// bCountZeros adds a zeroRow type to rows with no covers
		// bArtists adds a bbRow or otherRow depending on artist
		// bHideZeros defaults the zeroRows to a hidden css class. Don't use with bCSSControl
		// bCSSHideZero adds hide classes (similar to invisible but for each class)
		$line = '';
		$sClass = '';
		$iLink = 0;
		
		if ($bArtists) {
			
			if ($songRecord['BBSONG'] == true) {
				$sClass .= 'bbRow ';
			}
			else {
				$sClass .= 'otherRow ';
			}
		}
		
		if ($sClass != '') {
			$line .= '<tr class="' . $sClass . '">';
		}
		else {
			$line .= '<tr>';
		}
		
		// todo add more info
		
		if (!is_null($songRecord['DISPLAYSONG'])) {
			$iLink = $songRecord['DISPLAYSONG'];
		}
		else {
			$iLink = $songRecord['ID'];
		}
		
		$line .= '<td>"<a href="song.php?' . $iLink . '">' . $songRecord['TITLE'] . '</a>"</td>';
		$line .= '<td>' . specialAlbum($songRecord['ALBUM'], $songRecord['ALBUMTYPE']);
		if ($songRecord['ARTIST'] != "The Beach Boys") {
			$line .= "<br />(" . $songRecord['ARTIST'] .")</br>"; 
		};
		$line .= '</td>';
		$line .= '<td>' . $songRecord['WRITERS'] . '</td>';
		$line .= '<td>' . $songRecord['COUNT'] . '</td>';
		
		$line .= '</tr>';
		
		return $line;
	}
	
	public function songTableEnd() {
		$output = "</tbody>";
		$output = "</table>";
		return $output;
	}
	
	/**
	 * LIST FORMATS *
	 */
	public function songListFormat($sID) {
		$output = ""; // Return value
		
		$output .= "<ol id='" . $sID . "'>";
		
		return $output;
	}
	
	public function songListEnd() {
		$output = "</ol>";
		return $output;
	}
	
	public function outputSongLineList($songRecord) {
		// Output song line in the correct format for displaying on list page
		$line = '';
		
		$line .= '<li>';
		$link = (is_null($songRecord['DISPLAYSONG']) ? $songRecord['ID'] : $songRecord['DISPLAYSONG']);

		If ($songRecord['COVER'] != 1) {
			$line .= '"<a href="song.php?' . $link . '">' . $songRecord['TITLE'] . '</a>" (' . $songRecord['WRITERS'] . ')';
		}
		else {
			$line .= '"' . $songRecord['TITLE'] . '" (' . $songRecord['WRITERS'] . ')';
		}
		$line .= '</li>';
		
		return $line;
	}
}
