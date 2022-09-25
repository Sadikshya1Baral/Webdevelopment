<?php
//this page displays all the full details of an article
//this is the full page of an article

session_start();

$pagetitle = 'News Articles';

//Connection to the database
require 'database.php';

//article located using url
$article_id = $_GET['article'];

  //query from articles on the basis of article id
  $sadistmt = $db->prepare('SELECT * FROM article WHERE article_id="' . $article_id . '"');
  $sadistmt -> execute();

  //addition of article 
  foreach ($sadistmt as $row) {

    //news article information
    $pagecontent = '
      <h2 id="heading">' .$row['title']. '</h2>
        <article>
    ';


      //added main body
      $pagecontent = $pagecontent . '
      <p><img src="' . $row['image'] . '" id="News-image" height="300px" width="500px">  </p>
      <p id="">News Category: ' . $row['category']. '</p>
      <p id="">' . $row['content'] . '</p>
      <p>Published by: ' . $row['publisher'] . '</p>
      <p id="">' . $row['published_date'] . '</p>
      <h3 id="Comments">Comments:</h3>
      </article>
      ';
  }

  //query from comments table on the basis of id
  $sadistmt1 = $db->prepare('SELECT * FROM comment WHERE article_id="' . $article_id . '"');
  $sadistmt1 -> execute();

  //Displaying already added comments on news article
  foreach ($sadistmt1 as $row1){

    //Converting id of user to their email
    $ConvertUser = $db->prepare('SELECT email FROM viewers WHERE viewer_id="' .$row1['viewer_id']. '"');
    $ConvertUser -> execute();

    foreach ($ConvertUser as $userConvert) {
      $username = $userConvert['email'];
    }

    //adding up to content variable
    $pagecontent = $pagecontent. '
      <h5 id="Comment-username"><b>' . $username .'</b> commented on '. $row1['date'] .'</h5>
      <p id="comment_content">' . $row1['content'] .'</p>
    ';
  }


//check if the user is logged in or not
if (isset($_SESSION['logged_as_user']) && $_SESSION['logged_as_user'] == true) {

  //add comments from the form
  $pagecontent = $pagecontent.'
    <h3 id="Comments">Enter your comment</h3>
    <form action="article.php?article='. $article_id . '" method="post">
      <label>Please Enter your comments here:</label>
        <textarea name="comment" placeholder="Max 200 Characters"></textarea>
      <input type="submit" value="Submit" name="submit" />
    </form>
    ';

//when submit is pressed
if (isset($_POST['comment'])){

  //user session used to pass information
  $current_user = $_SESSION['viewer'];

  //query from users to locate user ID from email
  $viewer_search = $db->prepare('SELECT viewer_id FROM viewers WHERE email = "' . $current_user . '"');
  $viewer_search -> execute();

  foreach ($viewer_search as $row2){
    $logged_in_user_id = $row2['viewer_id'];
  }

  $date = date('Y-m-d H:i:s');

  //insert statement to add into comments table
  $sadistmt3 = $db->prepare('INSERT INTO comment (content, date, viewer_id, article_id)
                        VALUES ( :comment, :date, :viewer_id, :article_id)');

  $criteria = [
    'comment' => $_POST['comment'],
    'date' => $date,
    'viewer_id' => $logged_in_user_id,
    'article_id' => $article_id
  ];

  unset($_POST['submit']);
  $sadistmt3 -> execute($criteria);

}

}
//in case a user is not logged in
else {

  //adding up to the content
  $pagecontent = $pagecontent .'
    <h3>Please Create an account or Log in as user to add a comment</h3>
  ';
}

require 'setup.php';
?>