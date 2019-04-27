<?php

class albumDisplay{
	
	public static function displayAlbums($sAlbums) {
		//Display album list passed in
		//
		//$sAlbums - array of albums to display (album name, year)
		//
		// RETURN $output HTML
	
		$output = "";
		
		foreach ($sAlbums as $album) {
			$output .= "<div class='albumBox'>";
			$output .= "<h2><i>$album[0]</i> ($album[1])</h2>";
			$output .= "<div class='flex-container'>";
			$output .= "<span class='flex-item'>";
			$output .= artwork::displayArtwork($album[0]);
			$output .= "</span>";
			$output .= "<span class='flex-item'>";
			$output .= self::getAlbumTracklist($album[0]);
			$output .= "</span>";
			$output .= "</span>";
			$output .= "</div>";
			$output .= "</div>";
		}
				
		return $output;
		
	}
	
	private function getAlbumTracklist($album) {
		
		$output = "";
		
		switch ($album) {
			case "The Smile Sessions":
				$output .=  self::smileTracklist();
				break;
			
			default:
				$output .= albumDropDown::getTrackListAlbum($album);
				break;
		}
		
		return $output;
	}
	
	private function smileTracklist() {
		//TODO get this to autogenerate
		$returnVal = "";
		$returnVal .= "<ol id='smile'>";
		$returnVal .= "<li>\"<a href='song.php?169'>Our Prayer</a> (Brian Wilson)\"</li>";
		$returnVal .= "<li>\"Gee\" [Cover] (William Davis / Morris Levy)\"</li>";
		$returnVal .= "<li>\"<a href='song.php?125'>Heroes And Villains</a> (Brian Wilson / Van Dyke Parks)\"</li>";
		$returnVal .= "<li>\"<a href='song.php?348'>Do You Like Worms (Roll Plymouth Rock)</a> (Brian Wilson / Van Dyke Parks)\"</li>";
		$returnVal .= "<li>\"<a href='song.php?402'>I'm In Great Shape</a> (Brian Wilson / Van Dyke Parks)\"</li>";
		$returnVal .= "<li>\"<a href='song.php?420'>Barnyard</a> (Brian Wilson / Van Dyke Parks)\"</li>";
		$returnVal .= "<li>\"My Only Sunshine (The Old Master Painter / You Are My Sunshine)\" [Cover] (Haven Gillespie / Jimmie Davis / Charles Mitchell)</a></li>";
		$returnVal .= "<li>\"<a href='song.php?170'>Cabin Essence</a> (Brian Wilson / Van Dyke Parks)\"</li>";
		$returnVal .= "<li>\"<a href='song.php?134'>Wonderful</a> (Brian Wilson / Van Dyke Parks)\"</li>";
		$returnVal .= "<li>\"<a href='song.php?404'>Look (Song For Children)</a> (Brian Wilson)\"</li>";
		$returnVal .= "<li>\"<a href='song.php?191'>Child Is The Father Of The Man</a> (Brian Wilson / Van Dyke Parks)\"</li>";
		$returnVal .= "<li>\"I Wanna Be Around\" [Cover] (Johnny Mercer)</li>";
		$returnVal .= "<li>\"<a href='song.php?407'>Workshop</a> (Brian Wilson)\"</li>";
		$returnVal .= "<li>\"<a href='song.php?126'>Vega-Tables</a> (Brian Wilson / Van Dyke Parks)\"</li>";
		$returnVal .= "<li>\"<a href='song.php?408'>Holidays</a> (Brian Wilson)\"</li>";
		$returnVal .= "<li>\"<a href='song.php?132'>Wind Chimes</a> (Brian Wilson)\"</li>";
		$returnVal .= "<li>\"<a href='song.php?409'>The Elements: Fire (Mrs. O'Leary's Cow)</a> (Brian Wilson)\"</li>";
		$returnVal .= "<li>\"<a href='song.php?350'>Love To Say Dada</a> (Brian Wilson)\"</li>";
		$returnVal .= "<li>\"<a href='song.php?130'>Good Vibrations</a> (Brian Wilson / Mike Love)\"</li>";
		
		$returnVal .= "</select>";
		return $returnVal;
	} 
}