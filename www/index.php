<!DOCTYPE html>

<html lang=en>

<head>
	<title>The Beach Boys Cover Database</title>
	<link rel="stylesheet" href="resources/bb.css">
	<meta name="author" content="Chris Cook">

<!-- google analytics removed -->

</head>

<body id="page">
<div id="margins" align="center" class="">

	<?php
	require_once ( "../../../resources/autoloader.php");
	
	//Autoload classes
	(new autoloader());
	echo loadHeader();
	?>
	<div class='mainPageBox'>
	<span class="">
	<h3><?php echo frontPageCounts::coverCount()?> covers of Beach Boys songs</h3>
	 as of <?php echo frontPageCounts::coverDate() ?>. 
	</span>
	</div>
	<div class='mainPageBox'>	<span class="">
		<h2>Recent additions</h2>
		<?php
		echo recentAdditions::loadRecentAdditions(7, "homepage");
		?>
		<p><a href="recentAdditions.php">See all recent additions</a>.</p>
	</span></div>
	
		<div class='mainPageBox'>	<span class="">
		<h2>Latest blog</h2>
		<p>Coming soon
		<br /><!-- <a href="features/beatGirls.php">Read more</a>.--></p>
	</span></div>

	<div class="mainPageBox">
	<span class="">
	<h2>Songs:</h2>
	<div><a href="songList.php">Every Song</a> &#9632  <a href="songListBeachBoys.php">Beach Boys songs</a> &#9632 <a href="songListOther.php">Other songs</a><br />
	<br /><a href="albums60s.php">60s albums</a> &#9632 <a href="albums70s.php">Later albums</a><br />
	<h3>By writer:</h3><a href="songListBrian.php">Brian Wilson</a> &#9632 <a href="songListCarl.php">Carl Wilson</a> &#9632 <a href="songListDennis.php">Dennis Wilson</a> &#9632 
	<a href="songListMike.php">Mike Love</a> &#9632 <a href="songListAL.php">Al Jardine</a><br />
	<br /><a href="songListBruce.php">Bruce Johnston</a> &#9632 <a href="songListDavid.php">David Marks</a> &#9632 <a href="songListBlondie.php">Blondie Chaplin</a>
	&#9632 <a href="songListRicky.php">Ricky Fataar</a> &#9632 <a href="songListOutsideWriters.php">Others</a>
	<h2>Artists:</h2>
	<div><a href="artistList.php">Sorted alphabetically</a> &#9632 <a href="artistListGenre.php">Sorted by genre</a>
	<h2>Lists:</h2>
		<div><a href="InvolvesBeachBoys.php">Involving Beach Boys</a> &#9632 <a href="languages.php">In other languages</a> &#9632 <a href="recentAdditions.php">Recent additions</a> &#9632 <a href="christmas.php">Christmas songs</a> </div>
		<h2></h2>
		</span>

	
	<span class="">
	<p><a href="resources.php">Resources and acknowledgements</a></p>
	</span>
	</div>

	<!--<div class="mainPageBox">-->
	<!-- <span class="">
		<div id="social"><a href="https://www.twitter.com/BeachBoysCovers"><img src="../../../resources/images/Twitter.png" height="42" width="42" /></a><a href="https://www.facebook.com/beachboyscovers"><img src="resources/Facebook.png" height="42" width="42"/></a></div>
	</span>-->
	<!--</div>-->

</div>
</body>


</html>
