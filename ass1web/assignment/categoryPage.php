<?php
session_start();

$pagetitle = 'News Articles';

//database connection file called
require 'database.php';

$category = $_GET['category'];

$pagecontent = '<h2>' . $category . ' Articles</h2>';
  
  //select all the articles from database which fall in the requested category
  $sadistmt = $db->prepare('SELECT * FROM article WHERE category="' . $category . '" ORDER BY published_date DESC ');
  $sadistmt -> execute();

  //Getting all the comments from the database
  $sadistmt1 = $db->prepare('SELECT * FROM comment');
  $sadistmt1 -> execute();

  //Adding news acrticles to page with a specific category.
  foreach ($sadistmt as $row) {
    $pagecontent = $pagecontent . '
    <div>
      <a href="article.php?article='. $row['article_id'] . '" id="Heading" ><h5>' . $row['title']. '<h5></a>
      <a href="article.php?article='. $row['article_id'] . '" id="NewsImage" ><p><img src="' . $row['image']. '" id="News-image" height="150px" width="220px"></p></a>
      <h5>' .$row['published_date']. '</h5>
      <p>Category: '.$row['category']. '</p>
      <p>' .$row['content']. '</p>
    </div>';
    }
      

require 'setup.php';
?>