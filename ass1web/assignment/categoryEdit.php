<?php
		session_start();

		$pagetitle = 'Edit Category';

		//Database connection file called
		require 'database.php';

		//Checks to make sure that an admin is logged in before displaying the page
		if (isset($_SESSION['logged_as_admin']) && $_SESSION['logged_as_admin'] == true) {

		$pagecontent = '<h2>Select a Category to Edit</h2>
		<form class="form" action="categoryEdit.php" method="GET">
				<label>Select Category:</label>
				<select name="editName">
					<option value="" disabled selected>Please Select</option>';

						//prepared statement to select all articles for drop down menu
						$sadistmt = $db->prepare('SELECT * FROM category');
						$sadistmt -> execute();

						foreach ($sadistmt as $row)
						{
							$pagecontent = $pagecontent. '
							<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
						}

		//pagecontent varibale continues
		$pagecontent =$pagecontent . '
					</select>
					<input type="submit" value="Edit" name="submit" />
				</form>
		';

		if(isset($_GET['editName'])){
			$editName = $_GET['editName'];
			// header("Location: editCat.php?editName=$editName");
			echo("<script>location.href = 'editCategory.php?editName=$editName';</script>");
		}

		//End of admin logged in IF
		}
		else {
			echo '<li><a href = "login.php"> Please login as admin first </a></li>';
		}


		require 'setup.php';
	?>