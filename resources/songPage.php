<?php

// Display covers on song page
class songPage
{

    public static function songPageLoad($id, &$title)
    {
        // Send in $id, pass back $title, and return html
        $output = "";
        $bFailOutLink = FALSE;
        $bConnOpen = FALSE;
        $bFoundLink = FALSE;
        $songLink = "";

        do {

            if (is_numeric($id)) {
                $conn = new connection();
                $bConnOpen = TRUE;

                // add id to querystring
                $queryData = array(
                    'id' => $id
                );
                http_build_query($queryData);

                $songInfo = songPage::getSongRecord($id, $conn);

                if ($songInfo == "") {
                    $output .= "<h3>You shouldn't have ended up here. Return <a href='index.php'>home</a>";
                    break;
                }

                if (! is_null($songInfo['SONGLINK'])) {
                    $songLink = songLink::getSongLink($conn, $songInfo['SONGLINK'], $bFoundLink);

                    if ($songLink['MAINSONG'] != $songInfo['ID']) {
                        $bFailOutLink = True;
                    }
                }

                $title = $songInfo['TITLE'];
                If ($bFailOutLink) {
                	$output .= "You shouldn't have ended up here. Find covers of " . $songInfo['TITLE'] . " <a href=\"song.php?" . $songLink['MAINSONG'] . "\">here</a>.";
                    //Try and force a redirect
                	$output .= "<script>changeSong_Forced(" . $songLink['MAINSONG'] . ")</script>";
                    break;
                }
                $output .= songPage::songDetailsHTML($conn, $songInfo, $bFoundLink, $songLink );
                $output .= songPage::coversTable($conn, $id, $songInfo, $bFoundLink, $songLink);
            } else {
                $output .= "<h3>You shouldn't have ended up here. Return <a href='index.php'>home</a>";
            }
        } while (false);

        IF ($bConnOpen) {
            unset($conn);
        }
        
        return $output;
    }

    private function getSongRecord($id, $conn)
    {
        // Get song record from DB
        // $sqlSong = "SELECT `ID`, `TITLE`, `ALBUM`, `ALBUMTYPE`, `YEAR`, `ARTIST`, `WRITERS`, `DESCRIPTION`, `YOUTUBE`, `SPOTIFY`, `OTHERLISTEN`, `OTHERDESC`, `COUNT`, `FIRSTVERART`, `FIRSTVERYR`, `LISTENARTIST`, `ARTOVERRIDE` FROM `songs` WHERE ID = $id ORDER BY TITLE ASC";
        $sqlSong = "SELECT * FROM `songs` WHERE ID = $id ORDER BY TITLE ASC";

        $result = $conn->getQuery($sqlSong);

        if (! empty($result) and $result->num_rows > 0) {
            // while ( $songInfo = $result->fetch_assoc() ) {
            $songInfo = $result->fetch_assoc();
            // Should only be one
            // break
            // }
        } else {
            $songInfo = "";
        }

        return $songInfo;
    }

    private function songDetailsHTML($conn, $songInfo, $bSongLink, $songLink)
    {
        $output = "";
        $output .= "<title>" . $songInfo['TITLE'] . "</title>";
        $output .= songPage::songDropDowns($songInfo['ID']);
        
        $output .= "<div id='headingBox' class='flex-container'>";
      
        	$output .= artwork::getArtwork($songInfo['ALBUM'], $songInfo['ARTOVERRIDE']);
       
      $output .= "<span class='flex-container-internal flex-item padleft'>";
        $output .= "<span class='flex-container-titlerow'><h2 class='songTitle flex-item'>\"" . $songInfo['TITLE'] . "\"</h2>";
        $output .= " <b class='flex-item padhalfleft writers'>(" . $songInfo['WRITERS'] . ")</b></span>";

            $output .= "<b class='flex-item padhalftop'>" . $songInfo['ARTIST'] . " song</b><br />";

        $output .= "<span class='flex-item'>";
        if (! is_null($songInfo['ALBUM'])) {
            $output .= "<b>Album</b>: ";
            if (! is_null($songInfo['ALBUMTYPE'])) {
                $output .= specialAlbum($songInfo['ALBUM'], $songInfo['ALBUMTYPE']);
            } else {
                $output .= "<i>" . $songInfo['ALBUM'] . "</i>";
            }
			if ($songInfo['YEAR'] != 0) {
				$output .= " (" . $songInfo['YEAR'] . ") <br />";
			}
		}
        $output .= "</span>";

        $bListenLinks = (! empty($songInfo['YOUTUBE']) or (! empty($songInfo['SPOTIFY'])) or (! empty($songInfo['OTHERLISTEN'])));

        $output .= "<span class='flex-item padhalftop'>";
        if ($bListenLinks) {
            if (! is_null($songInfo['LISTENARTIST'])) {
                $sOriginal = $songInfo['LISTENARTIST'];
            } elseif (! is_null($songInfo['ARTIST'])) {
                $sOriginal = $songInfo['ARTIST'];
            } else {
                $sOriginal = "The Beach Boys";
            }
            
            
            if (substr($sOriginal,0, 3) === "The") {
            	//Leave as is
            } else {
            	$sOriginal = "the " . $sOriginal;
            }


            $output .= "<b>Listen to $sOriginal version: </b>";
            $output .= getListenLinks($songInfo);
        }
        $output .= "</span>";

      
        if (! is_null($songInfo['FIRSTVERART'])) {
        	$output .= "<span class='flex-item padhalftop'>";
            // Show the first released version
            $output .= "<b>First version released: </b>";
            $output .= $songInfo['FIRSTVERART'];
			if (!is_null($songInfo['FIRSTVERYR'])){
				$output .= " (" . $songInfo['FIRSTVERYR'] . ")";
			}
            $output .= "</span>";
        }
     
        
        $output .= "<span class='flex-item padhalftop'>";
        if ($bSongLink) {
        	$output .= songLink::buildSongLinkCounts($conn, $songInfo, $songLink);
        } else {
        	$output .= "<b>Covers:</b> " . $songInfo['COUNT'];
        }
        $output .= "</span>";
        

        if (! is_null($songInfo['DESCRIPTION']) or $songInfo['DESCRIPTION'] != '') {
        	$output .= "<p class='flex-item' id='songDesc'>";
        	$output .= parseText($songInfo['DESCRIPTION']);
        	$output .= "</p>";
        }
        
        $output .= "</span></div><br/>";

        
        return $output;
    }

    private function coversTable($conn, $id, $songInfo, $bSongLink, $songLink)
    {
        if ($bSongLink) {
            $bConditional = songLink::buildLinkCoversQuery($songInfo, $songLink);
        } else {
            $bConditional = "SONG=" . $id . "";
        }
        $coverInfoQuery = "SELECT artists.NAME, covers.YEAR, covers.CALLED, covers.ALBUM, covers.NOTES, covers.SPOTIFY, covers.YOUTUBE, covers.OTHERLISTEN, covers.OTHERDESC,  covers.ID, covers.ALBUMSPECIAL, covers.LIVECOVER, covers.SAMPLES, covers.MEDLEY, covers.BBHIDE, covers.MISCCOVER, artists.SORTNAME, artists.ID as artID FROM covers INNER JOIN artists WHERE artists.ID = covers.ARTIST AND " . $bConditional . "  ORDER BY SORTNAME ASC";
        $coverInfoGet = $conn->getQuery($coverInfoQuery);
        $output = "";
        
        if ($coverInfoGet->num_rows > 0) {
        	$output .= coverTable::getCoverTable($coverInfoGet);
            $output .= "<h3>Is there a cover of \"" . $songInfo['TITLE'] . "\" missing? Please <a href=\"contact.php\">get in touch.</a>";
        } else {
            if ($songInfo['COVER']) {
                $output .= "<h3>This is a cover of another artist's song.</h3>";
            } else {
                $output .= "<h3>There are no covers of " . $songInfo['TITLE'] . " in the database - if you know of one, please <a href=\"contact.php\">get in touch</a>";
            }
        }

        return $output;
    }

    private function songDropDowns($id) {
     
        $output = "";
        $output .= "<div class='selectorBox flex-container'>";
        $output .= "<span class='flex-item'>";
        $output .= "";
        $output .= songDropDown::loadDropDown();
        $output .= "</span>";
        $output .="";
       
        
        switch ($id) {
            case 0:
                //Surfin
            	$output .= "<span class='flex-item'>";
            	$output .=  albumDropDown::songDropDownSurfinSafari();
                $output .= "<span/>";
                $output .= "<span class='flex-item'>";
                $output .= albumDropDown::songDropDownSummerInParadise();
                $output .= "<span/>";
                break;
            case 6:
                //409
            	$output .= "<span class='flex-item'>";
            	$output .=  albumDropDown::songDropDownSurfinSafari();
                $output .= "</span>";
                $output .= "<span class='flex-item'>";
                $output .= albumDropDown::songDropDownLittleDeuceCoupe();
                $output .= "<span/>";
                break;
            case 17:
                //shut down
            	$output .= "<span class='flex-item'>";
            	$output .=  albumDropDown::songDropDownSurfinUSA();
                $output .= "<span/>";
                $output .= "<span class='flex-item'>";
                $output .= albumDropDown::songDropDownLittleDeuceCoupe();
                $output .= "<span/>";
                break;
            case 29:
                //Little deuce coupe
            	$output .= "<span class='flex-item'>";
            	$output .=  albumDropDown::songDropDownSurferGirl();
                $output .= "<span/>";
                $output .= "<span class='flex-item'>";
                $output .= albumDropDown::songDropDownLittleDeuceCoupe();
                $output .= "<span/>";
                $output .= "<span class='flex-item'>";
                $output .= albumDropDown::songDropDownBeachBoysParty();
                $output .= "<span/>";
                
                break;
            case 32:
                //Our car club
            	$output .= "<span class='flex-item'>";
            	$output .=  albumDropDown::songDropDownSurferGirl();
                $output .= "<span/>";
                $output .= "<span class='flex-item'>";
                $output .= albumDropDown::songDropDownLittleDeuceCoupe();
                $output .= "<span/>";
                break;

                
            case 55:
                //I Get Around
            	$output .= "<span class='flex-item'>";
            	$output .=  albumDropDown::songDropDownAllSummerLong();
                $output .= "<span/>";
                $output .= "<span class='flex-item'>";
                $output .= albumDropDown::songDropDownBeachBoysParty();
                $output .= "<span/>";
                $output .= "<span class='flex-item'>";
                $output .= albumDropDown::songDropDownStillCruisin();
                $output .= "<span/>";
                break;

            case 82: //Rhonda
            	$output .= "<span class='flex-item'>";
            	$output .=  albumDropDown::songDropDownTheBeachBoysToday();
                $output .= "<span/>";
                $output .= "<span class='flex-item'>";
                $output .= albumDropDown::songDropDownSummerDaysAndSummerNights();
                $output .= "<span/>";
                
                break;
                
            case 95: //cali girls
            	$output .= "<span class='flex-item'>";
            	$output .=  albumDropDown::songDropDownSummerDaysAndSummerNights();
                $output .= "<span/>";
                $output .= "<span class='flex-item'>";
                $output .= albumDropDown::songDropDownStillCruisin();
                $output .= "<span/>";
                break;
                           
            case 112: //wibn
            	$output .= "<span class='flex-item'>";
            	$output .=  albumDropDown::songDropDownPetSounds();
                $output .= "<span/>";
                $output .= "<span class='flex-item'>";
                $output .= albumDropDown::songDropDownStillCruisin();
                $output .= "<span/>";
                break;

            case 120: //ego answer
            	$output .= "<span class='flex-item'>";
            	$output .=  albumDropDown::songDropDownPetSounds();
                $output .= "<span/>";
                
                $output .= "<span class='flex-item'>";
                $output .= albumDropDown::songDropDownStillCruisin();
               $output .= "<span/>";
                
                break;
              
            	
            case 125: //H&V
            case 126: //vegatables
            case 130: //GV
            case 132: //wind chimes
            case 134: //wonderful
            	$output .= "<span class='flex-item'>";
            	$output .= albumDropDown::songDropDownSmileySmile();
            	$output .= "<span/>";
            	$output .= "<span class='flex-item'>";
            	$output .= self::songDropDownSmile();
            	$output .= "<span/>";
            	break;
            	
            case 143: //hctn
            	$output .= "<span class='flex-item'>";
            	$output .=  albumDropDown::songDropDownWildHoney();
            	$output .= "</span>";
            	$output .= "<span class='flex-item'>";
            	$output .= albumDropDown::songDropDownLALightAlbum();
            	$output .= "</span>";
            	break;
            	            	
            case 169: //prayer
            case 170: //cabin
            	$output .= "<span class='flex-item'>";
            	$output .=  songDropDown2020();
            	$output .= "</span>";
            	$output .= "<span class='flex-item'>";
            	$output .= self::songDropDownSmile();
            	$output .= "<span/>";
            	break;
  
            case 179: //forever
            	$output .= "<span class='flex-item'>";
            	$output .=  albumDropDown::songDropDownSunflower();
            	$output .= "</span>";
            	$output .= "<span class='flex-item'>";
            	$output .= albumDropDown::songDropDownSummerInParadise();
            	$output .= "</span>";
            	break;
            	
            case 191: //surfs up
            	$output .= "<span class='flex-item'>";
            	$output .=  albumDropDown::songDropDownSurfsUp();
            	$output .= "<span/>";
            	$output .= "<span class='flex-item'>";
            	$output .= self::songDropDownSmile();
            	$output .= "<span/>";
            	break;
            	
            case 348: //Worms
            case 350: //Dada
            case 402: //shape
            case 404: //Look
            case 405: //CIFOTM
            case 407: //workshop
            case 408: //holiday
            case 409: //FIRE
            case 420: //Barnyard
            	$output .= "<span class='flex-item'>";
            	$output .= self::songDropDownSmile();
            	$output .= "<span/>";
            	break;
            	
            default:
            	$output .= "<span class='flex-item'>";
            	$output .=   albumDropDown::getDropdownAlbum($id);
                $output .= "</span>";
                break;
        }
        
        $output .= "</div>";
        return $output;
        
    }
    
    private function songDropDownSmile() {
    	//TODO get this to autogenerate
    	$returnVal = "";
    	$returnVal .= "<select class='dropdown' onchange='changeSong_Dropdown()'>";
    	$returnVal .= "<option value='NULL'>Other songs from <i>The Smile Sessions</i></option>";
    	$returnVal .= "<option value='NULL'>---------</option>";
    	$returnVal .= "<option value = 169>\"Our Prayer\"</option>";
    	$returnVal .= "<option value = 'NULL'>\"Gee [Cover]\"</option>";
    	$returnVal .= "<option value = 125>\"Heroes And Villains\"</option>";
    	$returnVal .= "<option value = 348>\"Do You Like Worms (Roll Plymouth Rock)\"</option>";
    	$returnVal .= "<option value = 402>\"I'm In Great Shape\"</option>";
    	$returnVal .= "<option value = 420>\"Barnyard\"</option>";
    	$returnVal .= "<option value = 'NULL'>\"My Only Sunshine (The Old Master Painter / You Are My Sunshine) [Cover]\"</option>";
    	$returnVal .= "<option value = 170>\"Cabin Essence\"</option>";
    	$returnVal .= "<option value = 134>\"Wonderful\"</option>";
    	$returnVal .= "<option value = 404>\"Look (Song For Children)\"</option>";
    	$returnVal .= "<option value = 191>\"Child Is The Father Of The Man\"</option>";
    	$returnVal .= "<option value = 'NULL'>\"I Wanna Be Around [Cover]\"</option>";
    	$returnVal .= "<option value = 407>\"Workshop\"</option>";
    	$returnVal .= "<option value = 126>\"Vega-Tables\"</option>";
    	$returnVal .= "<option value = 408>\"Holidays\"</option>";
    	$returnVal .= "<option value = 132>\"Wind Chimes\"</option>";
    	$returnVal .= "<option value = 409>\"The Elements: Fire (Mrs. O'Leary's Cow)\"</option>";
    	$returnVal .= "<option value = 350>\"Love To Say Dada\"</option>";
    	$returnVal .= "<option value = 130>\"Good Vibrations\"</option>";
    	
    	$returnVal .= "</select>";
    	return $returnVal;
    } 
    
}

