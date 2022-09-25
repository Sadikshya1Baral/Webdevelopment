<?php
//record of the selected category can be edited from this page
	session_start();

	$pagetitle = 'Edit Category';

	//Database connection file called
	require 'database.php';

	//assures if the admin is logged or not
	if (isset($_SESSION['logged_as_admin']) && $_SESSION['logged_as_admin'] == true) {

	$currentName = $_GET['editName'];

	$pagecontent = '
	<h2>Edit Category "' . $currentName . '"</h2>
	<form class="form" action="editCategory.php?editName=' . $currentName . '" method="post" enctype="multipart/form-data">
			<label>Category Name:</label>
				<input type="text" placeholder="if you want to change" name="newName" />
			<label>Description:</label>
				<textarea placeholder="if you want to change" name="newDesc"></textarea>
			<input type="submit" value="Done" name="submit" />
		</form>
	';


	//if done button is pressed, change the elements in database
	if(isset($_POST['submit'])){
		if (isset($_POST['newName'], $_POST['newDesc'])) {
			

		  	$newName = $_POST['newName'];
			$newDesc = $_POST['newDesc'];

					
			if($newName != ""){

			    $sadistmt = $db->prepare('UPDATE category SET name = "' . $newName . '" WHERE name = "' . $currentName . '"');

			    try{
				$sadistmt -> execute();

				// echo "name for $currentName has been successfully changed to $newName.";
				//show an alert message if the category name is edited without any errors
			    echo '<script type="text/javascript">
			    alert("Name for \'' . $currentName . '\' category has been sucessfully changed to \'' . $newName . '\'");
				</script>';

				} catch (PDOException $e) {
				   if ($e->errorInfo[1] == 1062) {

				   	//show an alert message if there is duplicate entry exception
				      echo '<script type="text/javascript">
						alert("The category name \'' . $newName . '\' already exists.");
						</script>';
				   } else {

				      echo '<script type="text/javascript">
						alert("Error from: ' . $e->getMessage() . '");
						</script>';
				   }
				}				

			}
			else{

			    // echo  "name was not changed";

			    echo '<script type="text/javascript">
				alert("Category Name was not changed");
				</script>';

			}

				//If article content has been changed
			if($newDesc != ""){

				$sadistmt2=$pdo->prepare('UPDATE category SET description = "' . $newDesc . '" WHERE name = "' . $currentName . '"');
				$sadistmt2->execute();

				// echo "description for $currentName content has been successfully changed to $newDesc.";

				echo '<script type="text/javascript">
				alert("Description for \'' . $currentName . '\' category has been sucessfully changed to \'' . $newDesc . '\'");
				</script>';

			}
			else {
				echo '<script type="text/javascript">
				alert("Description was not changed");
				</script>';

			}

		}

	}
	//End of admin logged in IF
}
else {
	$pagecontent = 'Sorry, please log in as an admin to view this page';
}


require 'setup.php';
 ?>