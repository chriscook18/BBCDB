<?php
class involvesBB {
	
	
	function involvedBB( ) {
		$output = "";
		
		$conn = new connection();
		
		$output .= "<div class='mainPageBox'>";
		$output .= "<h2>Covers involving Beach Boys</h2>";
		$output .= "<p>This list contains covers featuring Beach Boys members. This doesn't include covers released under the Beach Boys name, which can be found <a href=\"artist.php?0\">here</a>.</p>";
		$output .= "</div>";
		$output .= "<br />";
		$output .= "<br />";
		
		/** Nav bar **/
		$output .= "<div class = 'mainPageBox navbox' id='top'>";
		
		$output .= "<a href='#Brian'>Brian Wilson</a> &#8226; <a href='#Carl'>Carl Wilson</a> &#8226; <a href='#Dennis'>Dennis Wilson</a> &#8226;
			<a href='#Mike'>Mike Love</a> &#8226; <a href='#Al'>Al Jardine</a> &#8226; <a href='#Bruce'>Bruce Johnston</a>  &#8226; <a href='#David'>David Marks</a>
			 &#8226; <a href='#Blondie'>Blondie Chaplin</a> &#8226; <a href='#Ricky'>Ricky Fataar</a>";
		
		$output .= "</div>";
				
		$output .= "<div class = 'mainPageBox songListBar' id='top'>";
		$output .= "<h1 id='Brian'>Brian Wilson</h1><p>This doesn't include covers released as a solo record by Brian. See <a href=\"artist.php?222\">here</a>.</p>";
		$output .= $this->involvedBB_person( $conn, "BRIAN" );
		$output .= "</div>";
		
		$output .= "<div class = 'mainPageBox songListBar' id='top'>";
		$output .= "<h1 id='Carl'>Carl Wilson</h1>";
		$output .= $this->involvedBB_person( $conn, "CARL" );
		$output .= "</div>";
		
		$output .= "<div class = 'mainPageBox songListBar' id='top'>";
		$output .= "<h1 id='Dennis'>Dennis Wilson</h1><p>This doesn't include covers released as a solo record by Dennis. See <a href=\"artist.php?389\">here</a>.</p>";
		$output .= $this->involvedBB_person( $conn, "DENNIS" );
		$output .= "</div>";
		
		$output .= "<div class = 'mainPageBox songListBar' id='top'>";
		$output .= "<h1 id='Mike'>Mike Love</h1><p>This doesn't include covers released as a solo record by Mike. See <a href=\"artist.php?391\">here</a>.</p>";
		$output .= $this->involvedBB_person( $conn, "MIKE" );
		$output .= "</div>";
		
		$output .= "<div class = 'mainPageBox songListBar' id='top'>";
		$output .= "<h1 id='Al'>Al Jardine</h1><p>This doesn't include covers released as a solo record by Al. See <a href=\"artist.php?355\">here</a>.</p>";
		$output .= $this->involvedBB_person( $conn, "AL" );
		$output .= "</div>";
		
		$output .= "<div class = 'mainPageBox songListBar' id='top'>";
		$output .= "<h1 id='Bruce'>Bruce Johnston</h1><p>This doesn't include covers released as a solo record by Bruce. See <a href=\"artist.php?401\">here</a>.</p>";
		$output .= $this->involvedBB_person( $conn, "BRUCE" );
		$output .= "</div>";
		
		$output .= "<div class = 'mainPageBox songListBar' id='top'>";
		$output .= "<h1 id='David'>David Marks</h1><p>This doesn't include covers released as a solo record by David. See <a href=\"artist.php?408\">here</a>.</p>";
		$output .= $this->involvedBB_person( $conn, "DAVID" );
		$output .= "</div>";
		
		$output .= "<div class = 'mainPageBox songListBar' id='top'>";
		$output .= "<h1 id='Blondie'>Blondie Chaplin</h1><p>This doesn't include covers released as a solo record by Blondie. See <a href=\"artist.php?359\">here</a>.</p>";
		$output .= $this->involvedBB_person( $conn, "BLONDIE" );
		$output .= "</div>";
		
		$output .= "<div class = 'mainPageBox songListBar' id='top'>";
		$output .= "<h1 id='Ricky'>Ricky Fataar</h1><p>This doesn't include covers released as a solo record by Ricky. See <a href=\"artist.php?360\">here</a>.</p>";
		$output .= $this->involvedBB_person( $conn, "RICKY" );
		$output .= "</div>";
		
		unset($conn);
		
		return $output;
		
	}
	
	private function involvedBB_person( $conn, $sCOLUMN ) {
		
		$output = "";
		
		$coverInfoQuery = "SELECT artists.NAME, covers.SONG, covers.YEAR, covers.CALLED, covers.ALBUM, covers.NOTES,
		covers.SPOTIFY, covers.YOUTUBE, covers.OTHERLISTEN, covers.ID, covers.ALBUMSPECIAL, artists.SORTNAME,
		artists.ID as artID, songs.TITLE, covers.OTHERDESC FROM covers INNER JOIN artists INNER JOIN songs WHERE
		artists.ID = covers.ARTIST AND songs.ID = covers.SONG AND covers." . $sCOLUMN . " = \"Y\" ORDER BY songs.TITLE ASC";
		
		$coverInfoGet = $conn->getQuery( $coverInfoQuery );
		
		if ( $coverInfoGet->num_rows > 0 ) {
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
			
			while ( $cover = $coverInfoGet->fetch_assoc() ) {
				
				$output .= "<tr>";
				
				$output .= "<td><a href='song.php?" . $cover['SONG'] . "'>" . $cover['TITLE'] . "</a>";
				if ( !is_null( $cover['CALLED'] ) ) {
					$output .= "<br /> (as \"" . $cover['CALLED'] . "\")";
				}
				$output .= "<td><a href='artist.php?" . $cover['artID'] . "'>" . $cover['NAME'] . "</a>";
				$output .= "</td>";
				if ( !is_null( $cover['ALBUMSPECIAL'] ) ) {
					$output .= "<td>";
					$output .= specialAlbum( $cover['ALBUM'], $cover['ALBUMSPECIAL'] );
					$output .= "</td>";
				} else {
					$output .= "<td><i>" . $cover['ALBUM'] . "</i></td>";
				}
				$output .= "<td>" . $cover['YEAR'] . "</td>";
				$output .= "<td>";
				/*
				 * Some have Youtube, some Spotify, some neither, some both.
				 */
				$output .= getListenLinks( $cover );
				$output .= "<td>" . parseText($cover['NOTES']) . "</td>";
				$output .= "</tr>";
			}
			$output .= "</table>";
			$output .= "</div>";
		} else {
			$output .= "No covers found<br />";
		}
		
		$output .= "<br />";
		$output .= "<a href='#top'>Return to top</a>";
		
		return $output;
	}
}

