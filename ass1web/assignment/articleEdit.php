<?php
	session_start();

	$pagetitle = 'Edit News Article';

	//Database connection file called
	require 'database.php';

	//Checks to make sure that an admin is logged in before displaying the page
	if (isset($_SESSION['logged_as_admin']) && $_SESSION['logged_as_admin'] == true) {

	$pagecontent = '<h2>Select a News Article to Edit</h2>
	<form class="form" action="articleEdit.php" method="GET">
			<label>Select Article Title:</label>
			<select name="editTitle">
				<option value="" disabled selected>Please Select</option>';

					//prepared statement to select all articles for drop down menu
					$sadistmt = $db->prepare('SELECT * FROM article');
					$sadistmt -> execute();

					foreach ($sadistmt as $row)
					{
						$pagecontent = $pagecontent. '
						<option value="' . $row['title'] . '">' . $row['title'] . '</option>';
					}

	//pagecontent varibale continues
	$pagecontent =$pagecontent . '
				</select>
				<input type="submit" value="Edit" name="submit" />
			</form>
	';

	//jump to the article detail edit part once the form is submitted
	if (isset($_GET['editTitle'])) {

		$currentTitle = $_GET['editTitle'];
		//header("Location: editArticle.php?editTitle=$currentTitle");
		echo("<script>location.href = 'editArticle.php?editTitle=$currentTitle';</script>");
	}

	//End of admin logged in IF
	}
	else {
		echo '<li><a href = "login.php"> Please login as admin first </a></li>';
	}


	require 'setup.php';
?>