<?php 

// Display song lists

class songLists {
	
	protected function getOutline($sTableName, $sQuery, $bCountZeros = false, $bCountArtists = false, $bHideZeros = false, $bCSSControl = false) {
		//List all songs with covers in table format.
		//bCountZeros adds a zeroRow type to rows with no covers
		//bArtists adds a bbRow or otherRow depending on artist
		//bHideZeros defaults the zeroRows to a hidden css class. Don't use with bCSSControl
		//bCSSHideZero adds hide classes (similar to invisible but for each class)
		$output = "";
		
		$songListClass = new songDisplay;
		
		//DB search
		$conn = new connection(FALSE);
		$sql = "SELECT * FROM `songs` $sQuery ORDER BY TITLE ASC";
		$songs = $conn->getQuery( $sql );
				
		if ( $songs->num_rows > 0 ) {
				
				//Make a list
				$output .= "<div class='covers-table-div'>";
				$output .= $songListClass->songTableFormat($sTableName);
				
				while ( $song = $songs->fetch_assoc() ) {
					
					$output .= $songListClass->outputSongLineTable($song, $bCountZeros, $bCountArtists, $bHideZeros, $bCSSControl);
					
				}
				
				$output .= $songListClass->songTableEnd();
				$output .= "</div>";
			
		} else {
			$output .= "Oops! Something went wrong";
		
		}
		
		unset($conn);
		
		return $output;
	}
	
	protected function getOutlineList($sTableName, $sQuery, $bCountZeros = false, $bCountArtists = false, $bHideZeros = false, $bCSSControl = false, $sOrderBy = "TITLE ASC") {
		//List all songs with covers - in list format.
		//bCountZeros adds a zeroRow type to rows with no covers
		//bArtists adds a bbRow or otherRow depending on artist
		//bHideZeros defaults the zeroRows to a hidden css class. Don't use with bCSSControl
		//bCSSHideZero adds hide classes (similar to invisible but for each class)
		//sOrderBy - defaults to TITLE ASC;
		$output = "";
		
		$songListClass = new songDisplay;
		
		//DB search
		$conn = new connection(FALSE);
		$sql = "SELECT * FROM `songs` $sQuery ORDER BY $sOrderBy";
	
		$songs = $conn->getQuery( $sql );
				
		if ( $songs->num_rows > 0 ) {
				
				//Make a list
				$output .= $songListClass->songListFormat($sTableName);
				
				while ( $song = $songs->fetch_assoc() ) {
					
					$output .= $songListClass->outputSongLineList($song, $bCountZeros, $bCountArtists, $bHideZeros, $bCSSControl);
					
				}
				
				$output .= $songListClass->songListEnd();
			
		} else {
			$output .= "Oops! Something went wrong";
		
		}
		
		unset($conn);
		
		return $output;
	}
	
	public function getAllOld($sTableName) {
		$sQuery = "WHERE COUNT > 0 AND (SONGLINK IS NOT NULL OR DISPLAYSONG IS NULL)";
		
		return $this->getOutline($sTableName, $sQuery, false, false);
	}
	
	public function getAll($sTableName) {
		//$sQuery = "WHERE COVER !=1 AND SONGLINK IS NOT NULL OR DISPLAYSONG IS NULL";
		$sQuery = "WHERE COUNT > 0 AND COVER !=1 AND (SONGLINK IS NOT NULL OR DISPLAYSONG IS NULL)";
		
		return $this->getOutline($sTableName, $sQuery, true, true, false, true);
	}
	
	public function getBB($sTableName) {
		//$sQuery = "WHERE BBSONG = 1 AND COVER != 1 AND SONGLINK IS NOT NULL OR DISPLAYSONG IS NULL";
		$sQuery = "WHERE COUNT > 0 AND BBSONG = 1 AND COVER != 1 AND (SONGLINK IS NOT NULL OR DISPLAYSONG IS NULL)";
		
		return $this->getOutline($sTableName, $sQuery, true);
	}
		
	public function getOthers($sTableName) {
		//$sQuery = "WHERE BBSONG = 0 AND COVER != 1 AND SONGLINK IS NOT NULL OR DISPLAYSONG IS NULL";
		$sQuery = "WHERE COUNT > 0 AND BBSONG = 0 AND COVER != 1 AND (SONGLINK IS NOT NULL OR DISPLAYSONG IS NULL)";
		
		return $this->getOutline($sTableName, $sQuery, true);
	}
	
	public function getWriter($sTableName, $sWriter) {
		//$sQuery = "WHERE " . $sWriter . " = 1 AND COVER != 1 AND SONGLINK IS NOT NULL OR DISPLAYSONG IS NULL";
		$sQuery = "WHERE " . $sWriter . " = 1 AND COUNT > 0 AND COVER != 1 AND (SONGLINK IS NOT NULL OR DISPLAYSONG IS NULL)";
		
		return $this->getOutline($sTableName, $sQuery, true, true, false, true);
	}
	
	public function radioDialsCSS(){
		
		$output = "";

		$output = "<div class='radios-div padhalftop'>";
		$output .= "<table id='radios-table'>";
		$output .= "<thead>";
		$output .= "<tr>";
		$output .= "<td><b>Beach Boys songs</b></td>";
		$output .= "<td><b>Solo & other songs</b></td>";
		$output .= "</tr>";
		$output .= "</thead>";
		
		$output .= "<tbody>";
		$output .= "<tr>";
		$output .= "<td><input type='radio' name='showBBSongs' value='show' onclick='showHideSongsCSS(\"bbRow\", true)'>Show</input></td>";
		$output .= "<td><input type='radio' name='showOtherSongs' value='show' onclick='showHideSongsCSS(\"otherRow\", true)'>Show</input></td>";
		$output .= "</tr>";
		
		$output .= "<tr>";
		$output .= "<td><input type='radio' name='showBBSongs' value='hide' onclick='showHideSongsCSS(\"bbRow\", false)'>Hide</input></td>";
		$output .= "<td><input type='radio' name='showOtherSongs' value='hide' onclick='showHideSongsCSS(\"otherRow\", false)'>Hide</input></td>";
		$output .= "</tr>";
		
		$output .= "</tbody>";
		$output .= "</table>";
		$output .= "</div>";
		
		
		return $output;
		
	}
	
	//UNUSED
	public function getAlbum($sTableName, $sAlbumName) {
		$sQuery = "WHERE ALBUM = \"" . $sAlbumName . "\" AND TRACKNO != 0";

		return $this->getOutlineList($sTableName, $sQuery, false, false, false, false, "TRACKNO ASC");
	}
	
	public function songListNavbar(){
		//Nav bar for song list pages
		//
		//RETURN $output HTML
				
		$output = "";
		
		$output .= "<div class = 'mainPageBox navbox' id='songListBox' id='top'>";
		
		$output .= '<b>Song Lists:</b> <a href="songList.php">Every Song</a> &#8226  <a href="songListBeachBoys.php">Beach Boys songs</a> &#8226 <a href="songListOther.php">Other songs</a> &#8226 
		<a href="albums60s.php">60s albums</a> &#8226 <a href="albums70s.php">Later albums</a><br />
		<br /><b>By writer:</b> <a href="songListBrian.php">Brian Wilson</a> &#8226 <a href="songListCarl.php">Carl Wilson</a> &#8226 <a href="songListDennis.php">Dennis Wilson</a> &#8226
		<a href="songListMike.php">Mike Love</a> &#8226 <a href="songListAl.php">Al Jardine</a> &#8226 <a href="songListBruce.php">Bruce Johnston</a> &#8226 <a href="songListDavid.php">David Marks</a> &#8226 <a href="songListBlondie.php">Blondie Chaplin</a>
		&#8226 <a href="songListRicky.php">Ricky Fataar</a> &#8226 <a href="songListOutsideWriters.php">Others</a>';
		
		
		$output .= "</div>";
		return $output;
	}
	
	
}

