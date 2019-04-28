
function showHideSongs(sClass, sButtonName) {
	//Button click to hide songs
	var bButtonState = $('#' + sButtonName).text().includes("Show");
	
	if ( bButtonState == true) {
		//Now will show zero covers
		$('.' + sClass).show();
		
		$('#' + sButtonName).text( function() {
			return $(this).text().replace("Show","Hide");
		});
	} else {
		//Hide zero covers
		$('.' + sClass).hide();
								
		$('#' + sButtonName).text( function() {
			return $(this).text().replace("Hide","Show");
		});
	}
	
}

function showHideSongsRadio(sClass, bShow = false) {
	//Radio dial to hide songs
	if ( bShow == true ) {
		$('.' + sClass).show();
	} else {
		$('.' + sClass).hide();
	}
		
}

function showHideSongsCSS(sClass, bShow = false) {
	//Radio + CSS to hide song
	if ( bShow == true ) {
		$("." + sClass + "Hide").removeClass( sClass + "Hide");
	} else {
		$("." + sClass).addClass(sClass + "Hide");
	}
	
}

$(document).ready(function() {

	//Default in radio dials.
	$( "input[type=radio][name=showBBSongs][value=show]").prop('checked', true);
	$( "input[type=radio][name=showOtherSongs][value=show]").prop('checked', true);
	$( "input[type=radio][name=showHideStudio][value=show]").prop('checked', true);
	$( "input[type=radio][name=showHideLive][value=show]").prop('checked', true);
	$( "input[type=radio][name=showHideSample][value=show]").prop('checked', true);
	$( "input[type=radio][name=showHideBB][value=show]").prop('checked', true);
	$( "input[type=radio][name=showHideYT][value=show]").prop('checked', true);
	$( "input[type=radio][name=showHideMedley][value=show]").prop('checked', true);

	//Initialise mobile display
	cellHeaders('covers');
	
})

/* Function modified from Adrian Roselli's article, A Responsive Accessible Table, http://adrianroselli.com/2017/11/a-responsive-accessible-table.html 
 * and https://www.smashingmagazine.com/2019/01/table-design-patterns-web/
*/
function cellHeaders(tableId) {
  try {
    let thArray = [];
    const table = document.getElementById(tableId);
    const headers = table.getElementsByTagName('th');
    for (let i = 0; i < headers.length; i++) {
      const headingText = headers[i].innerHTML;
      thArray.push(headingText.replace(/<img[^>]*>/g,""));
     //console.log(headingText.replace(/<img[^>]*>/g,""));
    }
    const styleElm = document.createElement('style');
    let styleSheet;
    document.head.appendChild(styleElm);
    styleSheet = styleElm.sheet;
    for (let i = 0; i < thArray.length; i++) {
      styleSheet.insertRule(
        '#' +
          tableId +
          ' td:nth-child(' +
          (i + 1) +
          ')::before {content:"' +
          thArray[i] +
          ': ";}',
        styleSheet.cssRules.length
      );
    }
  } catch (err) {
    console.log('cellHeaders(): ' + err);
  }
}
