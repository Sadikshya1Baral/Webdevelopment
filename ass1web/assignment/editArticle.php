<?php

//record of the selected article can be edited from this page
	session_start();

	$pagetitle = 'Edit News Article';

	//Database connection file called
	require 'database.php';

	//assures if the admin is logged or not
	if(isset($_SESSION['logged_as_admin']) && $_SESSION['logged_as_admin'] == true){

	$currenttitle = $_GET["editTitle"];

	$pagecontent = '
	<h2>Edit News Article "' . $currenttitle . '"</h2>
	<form class="form" action="editArticle.php?editTitle=' . $currenttitle . '" method="POST" enctype="multipart/form-data">
			<label>New Article Title:</label>
				<input type="text" placeholder="If you want to change" name="newtitle" />
			<label>Category*:</label>
			<select name="newcategory" required>
				<option value="" disabled selected>Choose category</option>';

					//prepared statement to edit category name for the article
					$sadistmt = $db->prepare('SELECT * FROM category');
					$sadistmt->execute();

					foreach ($sadistmt as $row)
					{
						$pagecontent = $pagecontent. '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
					}

	$pagecontent = $pagecontent . '</select>
			<label>Content:</label>
			<textarea name="newcontent" placeholder="If you want to change"></textarea>
	<input type="submit" value="Done" name="submit" />
		</form>
	';

	if(isset($_POST['submit'])){
		if(isset($_POST['newtitle'], $_POST['newcategory'], $_POST['newcontent'])) {
			// echo "It worked";

		  	$newtitle = $_POST['newtitle'];
			$newcategory = $_POST['newcategory'];
			$newcontent = $_POST['newcontent'];



					//Update category name
			$sadistmt2=$db->query('UPDATE article SET category = "' . $newcategory . '" WHERE title = "' . $currenttitle . '"');
			$sadistmt2->execute();

					
					
			if($newtitle != ""){

			    $sadistmt3=$db->prepare('UPDATE article SET title = "' . $newtitle . '" WHERE title = "' . $currenttitle . '"');

			    try{
				$sadistmt -> execute();

				// echo "$currenttitle - has been successfully changed to $newtitle  -";

				//show an alert message if the title is edited
				echo '<script type="text/javascript">
				alert("Title of \'' . $currenttitle . '\' has been sucessfully changed to \'' . $newtitle . '\'");
				</script>';

			} catch (PDOException $e) {
			   if ($e->errorInfo[1] == 1062) {
			      echo '<script type="text/javascript">
					alert("The Article Title already exists.");
					</script>';
			   } else {
			      echo '<script type="text/javascript">
					alert("Error from: ' . $e->getMessage() . '");
					</script>';
			   }
			}

			    // header("Location: editArticle.php?editTitle=$newtitle");
			}
			else {

				// echo  "No news title changed-";

				echo '<script type="text/javascript">
				alert("Title was not changed");
				</script>';
			}

			if($newcontent != ""){

				$sadistmt4=$db->prepare('UPDATE article SET content = "' . $newcontent . '" WHERE title = "' . $currenttitle . '"');
			    $sadistmt4->execute();

			   // echo "$currenttitle - has been successfully changed to $newtitle  -";

			    echo '<script type="text/javascript">
				alert("Contents of \'' . $currenttitle . '\' has been sucessfully changed to \'' . $newtitle . '\'");
				</script>';
				// header('Location: articleEditSelection.php');
			}
			else {

			    // echo  "No news title changed-";

			    echo '<script type="text/javascript">
				alert("Content was not changed");
				</script>';
			}
				
		}
	}

	//if admin is not logged in, show the following
	}
	else {
		echo '<li><a href = "login.php"> Please login as admin first </a></li>';
	}


	require 'setup.php';
// ?>