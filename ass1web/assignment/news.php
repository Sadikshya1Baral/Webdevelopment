<?php
//when a user clicks on latest articles, articles are arranged according to the date
//newer articles are shown first
	$pagetitle = 'Latest Articles'; //name provided to the title variable

	//session started to apply the session set
	session_start();

	// call to the file that connects to server database
	require 'database.php';

	$pagecontent = '
	<h2>Latest Articles</h2>
	';

	$sadiresults = $db->prepare('SELECT * FROM article ORDER BY published_date DESC'); //select statement to query articles
  	$sadiresults -> execute();

  	//pagecontent to show latest articles
  	foreach($sadiresults as $row){
  		// display type for the article
	  	$pagecontent = $pagecontent . '
	  <div name="articles">
	  <a href="article.php?article='. $row['article_id'] . '" id="News-heading" ><h5>' . $row['title']. '<h5></a>
	  <a href="article.php?article='. $row['article_id'] . '" id="News-image" ><p><img src="' . $row['image']. '" id="News-image" height="150px" width="220px"></p></a>
	  <h5>' .$row['published_date']. '</h5>
	  <p>Category: '.$row['category']. '</p>
	  <p>' .$row['content']. '</p>
	  </div>';
	}

	//call to layout file
  require 'setup.php';
?>