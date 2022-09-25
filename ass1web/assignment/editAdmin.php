<?php
//record of the selected admin account can be edited from this page
	session_start();

	$pagetitle = 'Edit Admin Account';

	//Database connection file called
	require 'database.php';

	//assures if the admin is logged or not
	if (isset($_SESSION['logged_as_admin']) && $_SESSION['logged_as_admin'] == true) {

	$currentEmail = $_GET['editEmail'];

	//prepare html form format for inputting data that need to be edited
	$pagecontent = '
	<h2>Edit Admin Account "' . $currentEmail . '"</h2>
	<form class="form" action="editAdmin.php?editEmail=' . $currentEmail . '" method="post" enctype="multipart/form-data">
			<label>First Name:</label>
				<input type="text" placeholder="if you want to change" name="newfname" />
			<label>Last Name:</label>
				<input type="text" placeholder="if you want to change" name="newlname" />
			<label>Password</label>
				<input type="password" placeholder="if you want to change" name="newpass"/>
			<input type="submit" value="Done" name="submit" />
		</form>
	';


		//if done button is pressed, change the elements in database
		if(isset($_POST['submit'])){
			if (isset($_POST['newfname'], $_POST['newlname'], $_POST['newpass'])) {
				

			  	$newfname = $_POST['newfname'];
				$newlname = $_POST['newlname'];
				$pass = $_POST['newpass'];
				$newpass = password_hash($pass, PASSWORD_DEFAULT);

						
				if($newfname != ""){ //change firstname when user inputs a new firstname

				    $sadistmt = $db->prepare('UPDATE admins SET admin_name = "' . $newfname . '" WHERE email = "' . $currentEmail . '"');

				    try{
					$sadistmt -> execute();

					// echo "Firstname for $currentEmail has been successfully changed to $newfname.";

				    echo '<script type="text/javascript">
				    alert("Firstname for \'' . $currentEmail . '\' has been sucessfully changed to \'' . $newfname . '\'");
					</script>';

					} catch (PDOException $e) {
					   
						echo '<script type="text/javascript">
						alert("Error from: ' . $e->getMessage() . '");
						</script>';
					   
					}				

				}
				else{

				    // echo  "Firstname was not changed";

				    echo '<script type="text/javascript">
					alert("Firstname was not changed");
					</script>';

				}

					
				if($newlname != ""){ //change lastname when user inputs a new lastname

					$sadistmt2=$db->prepare('UPDATE admins SET admin_surname = "' . $newlname . '" WHERE email = "' . $currentEmail . '"');

					try{
					$sadistmt2 -> execute();

					// echo "Lastname for $currentEmail content has been successfully changed to $newlname.";

					echo '<script type="text/javascript">
					alert("Lastname for \'' . $currentEmail . '\' has been sucessfully changed to \'' . $newlname . '\'");
					</script>';

					} catch (PDOException $e) {
					   
						echo '<script type="text/javascript">
						alert("Error from: ' . $e->getMessage() . '");
						</script>';
					   
					}				

				}
				else {
					echo '<script type="text/javascript">
					alert("Lastname was not changed");
					</script>';

				}


				if($pass != ""){ //change password when user inputs a new one

					$sadistmt3=$db->prepare('UPDATE admins SET password = "' . $newpass . '" WHERE email = "' . $currentEmail . '"');

					try{
					$sadistmt3 -> execute();

					// echo "Password for $currentEmail content has been successfully changed.";

					echo '<script type="text/javascript">
					alert("Password for \'' . $currentEmail . '\' has been sucessfully changed");
					</script>';

					} catch (PDOException $e) {
					   
						echo '<script type="text/javascript">
						alert("Error from: ' . $e->getMessage() . '");
						</script>';
					   
					}
					
				}
				else {
					// echo  "Password was not changed";

					echo '<script type="text/javascript">
					alert("Password was not changed");
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