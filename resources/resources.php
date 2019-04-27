<?php

/* Classless routines. */
function loadHeader() {
	// Create the top-of-page header
	//
	// RETURN $return HTML
	
	// TODO will need alterations
	$return = "";
	
	$return .= '<div class="navbar">';
	$return .= '<a href="/beachboys/index.php">Home</a>';
	$return .= '<a href="/beachboys/recentAdditions.php">New Additions</a>';
	
	$return .= '<div class="dropdownNav">';
	$return .= '<button class="dropdown_button"><a href="/beachboys/songList.php">Songs</a></button>';
	$return .= '<div class="dropdown_content">';
	$return .= '<a href="/beachboys/songList.php">All songs</a>';
	$return .= '<a href="/beachboys/songListBeachBoys.php">Beach Boy songs</a>';
	$return .= '<a href="/beachboys/songListOther.php">Other songs</a>';
	$return .= '<a href="/beachboys/songListBrian.php">By writer</a>';
	$return .= '<a href="/beachboys/albums60s.php">60s Beach Boys albums</a>';
	$return .= '<a href="/beachboys/albums70s.php">Later Beach Boys albums</a>';
	$return .= '</div>';
	
	$return .= '</div>';
	
	$return .= '<div class="dropdownNav">';
	$return .= '<button class="dropdown_button"><a href="/beachboys/artistList.php">Artists</a></button>';
	$return .= '<div class="dropdown_content">';
	$return .= '<a href="/beachboys/artistList.php">Sorted alphabetical</a>';
	$return .= '<a href="/beachboys/artistListGenre.php">Sorted by genre</a>';
	$return .= '</div>';
	$return .= '</div>';
	$return .= '<a href="/beachboys/languages.php">In other languages</a>';
	
	$return .= '<div class="dropdownNav">';
	$return .= '<button class="dropdown_button">Lists</button>';
	$return .= '<div class="dropdown_content">';
	$return .= '<a href="/beachboys/languages.php">In other languages</a>';
	$return .= '<a href="/beachboys/InvolvesBeachBoys.php">Involving Beach Boys</a>';
	$return .= '<a href="/beachboys/christmas.php">Christmas songs</a>';
	$return .= '</div>';
	$return .= '</div>';
	
	$return .= '<a href="/beachboys/contact.php">Contact</a>';
	
	$return .= '</div>';
	
	$return .= '<div class="header">';
	$return .= '<h1><a href="index.php">The Beach Boys Cover Database</a></h1>';
	$return .= '</div>';
	$return .= '<br />';
	return $return;
}


function getListenLinks($cover) {
	//Format the listen links depending on how many there are
	//
	//$cover - RECORD - cover information
	//
	//RETURN $output HTML
	
	//TODO surely a better way to write this
	$output = "";
	
	//Set description of "other" links.
	$otherDesc = $cover['OTHERDESC'];
	
	if (!empty($cover['OTHERLISTEN']) and empty($cover['OTHERDESC'])) {
		// Set it to default
		$otherDesc = "Other";
	}
	
	//TODO refactor
	if (!empty($cover['YOUTUBE'])) {
		$output .= "<a href=\"" . $cover['YOUTUBE'] . "\">Youtube</a>";
		if (!empty($cover['SPOTIFY'])) {
			$output .= ", ";
			$output .= "<a href=\"" . $cover['SPOTIFY'] . "\">Spotify</a>";
		}
		if (!empty($cover['OTHERLISTEN'])) {
			$output .= ", ";
			$output .= "<a href=\"" . $cover['OTHERLISTEN'] . "\">$otherDesc</a>";
		}
	}
	elseif (!empty($cover['SPOTIFY'])) {
		$output .= "<a href=\"" . $cover['SPOTIFY'] . "\">Spotify</a>";
		if (!empty($cover['OTHERLISTEN'])) {
			$output .= ", ";
			$output .= "<a href=\"" . $cover['OTHERLISTEN'] . "\">$otherDesc</a>";
		}
	}
	elseif (!empty($cover['OTHERLISTEN'])) {
		$output .= "<a href=\"" . $cover['OTHERLISTEN'] . "\">$otherDesc</a>";
	}
	else {
		 //$output .= "Know one? <a href=\"contact.php\">Contact us</a>";
	}
	return $output;
}


function specialAlbum($album, $type) {
	//Format album types properly
	//
	// $album - Album name
	// $type - Type specifier
	//
	// RETURN $output Formatted string
	
	$output = "";
	switch ($type) {
		case 'EP':
			$output .= "<i>$album</i> EP";
			break;
		case 'SB':
			$output .= "<i>$album</i> single B-side";
			break;
		case 'S':
			$output .= "<i>$album</i> single";
			break;
		case 'two':
			$output .= "<i>$album</i> twofer";
			break;
		case 'TV':
			$output .= "<i>$album</i> TV show";
			break;
		case 'U':
			if (!is_null($album)) {
				$output .= "<i>$album</i> (unreleased)";
			}
			else {
				$output .= "Unreleased";
			}
			break;
		case 'V':
			$output .= "<i>$album</i> video game";
			break;
		case 'F':
			$output .= "<i>$album</i> film";
			break;
		case 'L':
			$output .= "Live performance";
			break;
		default:
			$output .= "<i>$album</i>";
			break;
	}
	return $output;
}

