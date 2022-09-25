<?php
session_start();

$pagetitle = 'Delete News Article';

//Connection to database
require 'database.php';

//Checks to make sure that an admin is logged in before displaying the page
if (isset($_SESSION['logged_as_admin']) && $_SESSION['logged_as_admin'] == true) {
$pagecontent = '
<h2>Delete News Article</h2>
<form class="form" action="deletearticle.php" method="post">
  <label>News Article:</label>
    <select name="article">
      <option value="" disabled selected>Please Select</option>';


    $results = $db->prepare('SELECT * FROM article');
    $results->execute();

    foreach ($results as $row)
    {
      $pagecontent = $pagecontent. '<option value="'. $row['article_id'].'">'. $row['title'].'</option>';
    }

//pagecontent variable continues
$pagecontent = $pagecontent.'
    </select>
    <input type="submit" value="Delete" name="submit" />
</form>
';


//If delete button is pressed delete news category Username
if (isset($_POST['article']))
{
  $article = $_POST['article'];

  //prepare statement to delete article from articles table
  $sadistmt = $db->prepare('DELETE FROM article WHERE article_id = :article');
  $sadistmt->bindParam(":article", $article);
  $sadistmt->execute();

  //show an alert statement once the article is deleted
  echo '<script type="text/javascript">
          alert("The article ' . $article . ' has successfully been deleted");
        </script>';
}

//if admin is not logged in, show the following
}
else {
	echo '<li><a href = "login.php"> Please login as admin first </a></li>';
}

require 'setup.php';
?>