<?php

//continue with user session status
session_start();

	//provide title to the page
	$pagetitle = 'Add News Category';

//call the database connection file
require 'database.php';

//Check to make sure that an admin is logged in before displaying the page
if (isset($_SESSION['logged_as_admin']) && $_SESSION['logged_as_admin'] == true) {

	//Design a html form to add new category
	$pagecontent = '
	<h2>Add News Category</h2>
	<article>
	<form class="form" action="addcategory.php" method="post">
			<label>Category Name:</label>
					<input type="text" placeholder="Max 50 characters" name="name" required />
	    <label>Category Description:</label>
	    		<textarea name="description" required ></textarea>
	    <input type="submit" value="Submit" name="submit" />
	</form>
	';

	//If submit button has been clicked.
	if(isset($_POST['submit'])){
		if (isset($_POST['name'], $_POST['description'])) {

			

				//query statement to add a new category name & description to categories table
				$sadistmt = $db->prepare('INSERT INTO category (name, description) VALUES (:name, :description)');

				$criteria = [
					'name' => $_POST['name'],
					'description' => $_POST['description']
				];

				try{
				$sadistmt -> execute($criteria);

				//show an alert statement if the category is added
				echo '<script type="text/javascript">
					alert("The category \'' . $_POST['name'] . '\' has successfully been created");
				</script>';

			} catch (PDOException $e) {
			   if ($e->errorInfo[1] == 1062) {

			   	//show an alert if duplicate record exception arises
			      echo '<script type="text/javascript">
					alert("The category name \'' . $_POST['name'] . '\' already exists.");
				</script>';
			   } else {
			   	//show an alert if other exception arise
			      echo '<script type="text/javascript">
					alert("Error from: ' . $e->getMessage() . '");
					</script>';
			   }
			}	          

		}
	}
}
	//if admin is not logged in
	else {
		header("Location: login.php");
	}


require 'setup.php';
?>