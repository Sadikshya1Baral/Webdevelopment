<?php
session_start(); //continue the current session
$pagetitle = "Northampton News - Home"; //set the title for this page

require 'database.php'; //database connection file called

$pagecontent = '<h2> Northampton News</h2>';
$sadistmt = $db->prepare('SELECT * FROM article'); //query from articles table
		$sadistmt->execute();

		foreach ($sadistmt as $row)
		{
			//preview of article in the homepage or other pages
			$pagecontent = $pagecontent . '
		<div name="article">
	  <a href="article.php?article='. $row['article_id'] . '" id="Heading" ><h5>' . $row['title']. '<h5></a>
	  <a href="article.php?article='. $row['article_id'] . '" id="NewsImage" ><p><img src="' . $row['image']. '" id="NewsIimage" height="150px" width="220px"></p></a>
	  <h5>' .$row['published_date']. '</h5>
	  <p>Category: '.$row['category']. '</p>
	  <p>' .$row['content']. '</p>
	  
	  </div>
			';
		}

require 'setup.php';

?>