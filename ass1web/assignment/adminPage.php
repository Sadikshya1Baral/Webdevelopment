<?php
$pagetitle = 'Admin Backend';

session_start();

//check to see if the admin is logged in before displaying the page
if(isset($_SESSION['logged_as_admin']) && $_SESSION['logged_as_admin'] == true)
{

  //all the links with features that the admin is allowed
	$pagecontent = '
	<h2>Admin Page</h2>
<nav>
  <ul>
    <li><a href="addAdmin.php">Add Admin Account</a></li>
    <li><a href="addcategory.php">Add Category</a></li>
    <li><a href="addArticle.php">Add Article</a></li>
    <li><a href="deleteAdmin.php">Delete Admin Account</a></li>
    <li><a href="deleteCategory.php">Delete Category</a></li>
    <li><a href="deleteArticle.php">Delete Article</a></li>
    <li><a href="adminEdit.php">Edit Admin Account</a></li>
    <li><a href="categoryEdit.php">Edit News Category</a></li>
    <li><a href="articleEdit.php">Edit Article</a></li>
  </ul>
</nav>
	';

	require 'setup.php';
}


else{ //in case admin is not logged in, go to the login page
	echo '<li><a href = "login.php"> Please login as admin first </a></li>';
}


?>