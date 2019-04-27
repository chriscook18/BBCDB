<?php

class artistLists {
	
	/* Routines to display on artist list pages */
	public static function getListDropDownArtistAlpha($sortname) {
		// Get HTML for artist dropdown
		//
		// $sortname - so we can get the right letter
		//
		// RETURN HTML
		$letter = substr($sortname, 0, 1);
		return self::switchAlphabetical($letter);
	}
	
	private static function switchAlphabetical($letter) {
		// Get HTML for artist dropdown
		//
		// $letter - first letter of sortname
		//
		// RETURN $output - HTML
		$output = "";
		
		// TODO - not have to hard code all this!
		switch ($letter) {
			case "A":
				$output = artistDropDownLetterA::loadDropDown();
				break;
			case "B":
				$output = artistDropDownLetterB::loadDropDown();
				break;
			case "C":
				$output = artistDropDownLetterC::loadDropDown();
				break;
			case "D":
				$output = artistDropDownLetterD::loadDropDown();
				break;
			case "E":
				$output = artistDropDownLetterE::loadDropDown();
				break;
			case "F":
				$output = artistDropDownLetterF::loadDropDown();
				break;
			case "G":
				$output = artistDropDownLetterG::loadDropDown();
				break;
			case "H":
				$output = artistDropDownLetterH::loadDropDown();
				break;
			case "I":
				$output = artistDropDownLetterI::loadDropDown();
				break;
			case "J":
				$output = artistDropDownLetterJ::loadDropDown();
				break;
			case "K":
				$output = artistDropDownLetterK::loadDropDown();
				break;
			case "L":
				$output = artistDropDownLetterL::loadDropDown();
				break;
			case "M":
				$output = artistDropDownLetterM::loadDropDown();
				break;
			case "N":
				$output = artistDropDownLetterN::loadDropDown();
				break;
			case "O":
				$output = artistDropDownLetterO::loadDropDown();
				break;
			case "P":
				$output = artistDropDownLetterP::loadDropDown();
				break;
			case "Q":
				$output = artistDropDownLetterQ::loadDropDown();
				break;
			case "R":
				$output = artistDropDownLetterR::loadDropDown();
				break;
			case "S":
				$output = artistDropDownLetterS::loadDropDown();
				break;
			case "T":
				$output = artistDropDownLetterT::loadDropDown();
				break;
			case "U":
				$output = artistDropDownLetterU::loadDropDown();
				break;
			case "V":
				$output = artistDropDownLetterV::loadDropDown();
				break;
			case "W":
				$output = artistDropDownLetterW::loadDropDown();
				break;
			case "X":
				$output = artistDropDownLetterX::loadDropDown();
				break;
			case "Y":
				$output = artistDropDownLetterY::loadDropDown();
				break;
			case "Z":
				$output = artistDropDownLetterZ::loadDropDown();
				break;
			case "1":
				$output = artistDropDownLetter1::loadDropDown();
				break;
			case "2":
				$output = artistDropDownLetter2::loadDropDown();
				break;
			case "3":
				$output = artistDropDownLetter3::loadDropDown();
				break;
			case "4":
				$output = artistDropDownLetter4::loadDropDown();
				break;
			case "5":
				$output = artistDropDownLetter5::loadDropDown();
				break;
			case "6":
				$output = artistDropDownLetter6::loadDropDown();
				break;
			case "7":
				$output = artistDropDownLetter7::loadDropDown();
				break;
			case "8":
				$output = artistDropDownLetter8::loadDropDown();
				break;
			case "9":
				$output = artistDropDownLetter9::loadDropDown();
				break;
			case "0":
				$output = artistDropDownLetter0::loadDropDown();
				break;
			case "&":
			default:
				// Starts with special character
				$output .= self::artistDropDownSpecial();
				break;
		}
		
		return $output;
	}
	
	public static function getListDropDownArtistGenre($bandType) {
		// Get HTML for genre dropdown
		//
		// $bandType - genre
		//
		// RETURN $output - HTML
		switch ($bandType) {
			case "Rock/Pop 60s":
				$output = artistDropDownGenreR6::loadDropDown();
				break;
			case "Rock/Pop 70s80s":
				$output = artistDropDownGenreR7::loadDropDown();
				break;
			case "Rock/Pop 90s00s10s":
				$output = artistDropDownGenreR9::loadDropDown();
				break;
			case "Kids":
				$output = artistDropDownGenreK::loadDropDown();
				break;
			case "Country/Folk":
				$output = artistDropDownGenreC::loadDropDown();
				break;
			case "Jazz":
				$output = artistDropDownGenreJ::loadDropDown();
				break;
			case "Punk":
				$output = artistDropDownGenreP::loadDropDown();
				break;
			case "Electronic":
				$output = artistDropDownGenreE::loadDropDown();
				break;
			case "Vocal":
				$output = artistDropDownGenreV::loadDropDown();
				break;
			case "Misc":
				$output = artistDropDownGenreM::loadDropDown();
				break;
			case "Youtubers etc.":
				$output = artistDropDownGenreY::loadDropDown();
				break;
			default:
				$output = "";
		}
		
		return $output;
	}
	
	/* Manual override for artist names with unicode characters at start */
	private static function artistDropDownSpecial() {
		$returnVal = "";
		$returnVal .= "<select class='dropdown' onchange='changesArtist()'>";
		$returnVal .= "<option value='NULL'>Other ! artists</option>";
		$returnVal .= "<option value='NULL'>---------</option>";
		$returnVal .= "<option value = 167>&#x014C;sama (&#x738B;&#x69D8;)</option>";
		$returnVal .= "</select>";
		return $returnVal;
	}
	
	private static function artistListSpecial() {
		$returnVal = "";
		$returnVal .= "<h2 id='letterSpecial'>!</h2>";
		$returnVal .= "<ul>";
		$returnVal .= "<li><a href='artist.php?626'>&#x014C;sama (&#x738B;&#x69D8;)</a></li>";
		$returnVal .= "</ul>";
		$returnVal .= "<a href='#top'>Return to top</a>";
		return $returnVal;
	}
	
	public static function listAlphabetical() {
		// Get HTML for artist lists
		//
		//
		// RETURN $output - HTML
		$output = "";
		$output .= self::artistListSpecial();
		$output .= artistDropDownLetter0::loadList();
		$output .= artistDropDownLetter1::loadList();
		$output .= artistDropDownLetter2::loadList();
		$output .= artistDropDownLetter3::loadList();
		$output .= artistDropDownLetter4::loadList();
		$output .= artistDropDownLetter5::loadList();
		$output .= artistDropDownLetter6::loadList();
		$output .= artistDropDownLetter7::loadList();
		$output .= artistDropDownLetter8::loadList();
		$output .= artistDropDownLetter9::loadList();
		$output .= artistDropDownLettera::loadList();
		$output .= artistDropDownLetterB::loadList();
		$output .= artistDropDownLetterC::loadList();
		$output .= artistDropDownLetterD::loadList();
		$output .= artistDropDownLetterE::loadList();
		$output .= artistDropDownLetterF::loadList();
		$output .= artistDropDownLetterG::loadList();
		$output .= artistDropDownLetterH::loadList();
		$output .= artistDropDownLetterI::loadList();
		$output .= artistDropDownLetterJ::loadList();
		$output .= artistDropDownLetterK::loadList();
		$output .= artistDropDownLetterL::loadList();
		$output .= artistDropDownLetterM::loadList();
		$output .= artistDropDownLetterN::loadList();
		$output .= artistDropDownLetterO::loadList();
		$output .= artistDropDownLetterP::loadList();
		$output .= artistDropDownLetterQ::loadList();
		$output .= artistDropDownLetterR::loadList();
		$output .= artistDropDownLetterS::loadList();
		$output .= artistDropDownLetterT::loadList();
		$output .= artistDropDownLetterU::loadList();
		$output .= artistDropDownLetterV::loadList();
		$output .= artistDropDownLetterW::loadList();
		$output .= artistDropDownLetterX::loadList();
		$output .= artistDropDownLetterY::loadList();
		$output .= artistDropDownLetterZ::loadList();
		
		return $output;
	}
	
	public static function listbyGenre() {
		// Get HTML for artist lists
		//
		// RETURN $output - HTML
		$output = "";
		
		$output .= artistDropDownGenreC::loadList();
		$output .= artistDropDownGenreE::loadList();
		$output .= artistDropDownGenreJ::loadList();
		$output .= artistDropDownGenreK::loadList();
		$output .= artistDropDownGenreM::loadList();
		$output .= artistDropDownGenreP::loadList();
		$output .= artistDropDownGenreR6::loadList();
		$output .= artistDropDownGenreR7::loadList();
		$output .= artistDropDownGenreR9::loadList();
		$output .= artistDropDownGenreV::loadList();
		$output .= artistDropDownGenreY::loadList();
		
		return $output;
	}
	
	public static function lettersArtist() {
		//Nav box for artist list
		//
		// RETRUN $output - HTML
		
		$output = "";
		$output .= "<div class = 'mainPageBox navbox' id='top'>";
		
		$output .= "<a href='#letterSpecial'>!</a> &#8226; <a href='#letter0'>0</a> &#8226; <a href='#letter1'>1</a> &#8226; &#8226; <a href='#letter2'>2</a>
		&#8226; <a href='#letter3'>3</a> &#8226; <a href='#letter4'>4</a> &#8226; <a href='#letter5'>5</a> &#8226; <a href='#letter6'>6</a>
		&#8226; <a href='#letter7'>7</a> &#8226; <a href='#letter8'>8</a> &#8226; <a href='#letter9'>9</a> &#8226; 
		<a href='#letterA'>A</a> &#8226; <a href='#letterB'>B</a> &#8226; <a href='#letterC'>C</a> &#8226; <a href='#letterD'>D</a> &#8226; E
		&#8226; <a href='#letterF'>F</a> &#8226; <a href='#letterG'>G</a> &#8226; <a href='#letterH'>H</a>
		&#8226; <a href='#letterI'>I</a> &#8226; <a href='#letterJ'>J</a> &#8226; <a href='#letterK'>K</a>
		&#8226; <a href='#letterL'>L</a> &#8226; <a href='#letterM'>M</a> &#8226; <a href='#letterN'>N</a>
		&#8226; <a href='#letterO'>O</a> &#8226; <a href='#letterP'>P</a> &#8226; <a href='#letterQ'>Q</a>
		&#8226; <a href='#letterR'>R</a> &#8226; <a href='#letterS'>S</a> &#8226; <a href='#letterT'>T</a>
		&#8226; <a href='#letterU'>U</a> &#8226; <a href='#letterV'>V</a> &#8226; <a href='#letterW'>W</a>
		&#8226; <a href='#letterX'>X</a> &#8226; <a href='#letterY'>Y</a> &#8226; <a href='#letterZ'>Z</a>";
		
		$output .= "</div>";
		return $output;
	}
	
	public static function genreListsBar() {
		//Nav box for artist list
		//
		// RETRUN $output - HTML
		$output = "";
		$output .= "<div class = 'mainPageBox navbox' id='top'>";
		
		$output .= "<b>Genres:</b> <a href='#genreC'>Country & Folk</a> &#8226; <a href='#genreE'>Electronic</a> &#8226; <a href='#genreJ'>Jazz & Orchestral</a> &#8226;
		<a href='#genreK'>Kids</a> &#8226; <a href='#genreM'>Miscellaneous</a> &#8226; <a href='#genreP'>Punk & Metal</a>  &#8226; <a href='#genreR6'>Rock & Pop 60s</a>
		 &#8226; <a href='#genreR7'>Rock & Pop 70s, 80s</a> &#8226; <a href='#genreR9'>Rock & Pop 90s, 00s, 10s</a> &#8226; <a href='#genreV'>Vocal</a> &#8226; <a href='#genreY'>Youtubers etc.</a>";
		
		$output .= "</div>";
		return $output;
	}
}
