<?php
session_start();

	require 'database.php';
	$pagetitle = 'Login';


	//a html form format for admin login page
	$pagecontent = '
	<h2>Login </h2>
	<article>
	<form class="form" action="login.php" method="post">
		<label>Email:</label>
				<input type="text" name="email" required />
		<label>Password:</label>
			<input type="password" name="password" required />
		<input type="submit" value="Login" name="submit" />
	</form>
	</article>
	';

if (isset($_POST['submit'])) {
	

	if (isset($_POST['email'], $_POST['password'])) {

		$email = $_POST['email'];
		$pass = $_POST['password'];

		
		//check to see if the inputted email exists in admins table or not
		$sadistmt = $db-> prepare('SELECT *FROM admins WHERE email="' . $email . '";');
		$sadiresult = $sadistmt->execute();


		//check to see if the inputted email exists in users table or not
		$sadistmt2 = $db-> prepare('SELECT *FROM viewers WHERE email="' . $email . '";');
		$sadiresult2 = $sadistmt2->execute();

		//when the email is found in admins table run the following codes
		if($sadistmt->rowCount() == 1){
			// var_dump($stmt -> fetch());

			while($admin = $sadistmt->fetch(PDO::FETCH_ASSOC)){

				//check if the password is correct or not
				if($_POST['password'] == $admin['password']){

					$_SESSION['admin'] = $admin['email'];
					$_SESSION['logged_as_admin'] = true;
					$_SESSION['logged_as_user'] = false;
					$_SESSION['admin_id'] = $admin['admin_id'];

					//the admin is moved to index page
					echo("<script>location.href = 'index.php';</script>");
					//header("Location: index.php");
				}
				else{

					//if there is any error, following alert statement is shown
					echo '<script type="text/javascript">
					alert("You entered an incorrect password.");
					</script>';
				}					
			
			}
		}

		//when the email is found in admins table run the following codes
		else if($sadistmt2->rowCount() == 1){
			while($viewer = $sadistmt2->fetch(PDO::FETCH_ASSOC))
			{
				
				if(password_verify($_POST['password'], $viewer['password'])){

					$_SESSION['user'] = $viewer['email'];
					$_SESSION['user_id'] = $viewer['user_id'];
					$_SESSION['logged_as_user']  = true;
					$_SESSION['logged_as_admin'] = false;
							
					//the user is moved to index page
					echo("<script>location.href = 'index.php';</script>");

					
				}
				else{
					//if there is any error, following alert statement is shown
					echo '<script type="text/javascript">
					alert("You entered an incorrect password");
					</script>';
				}
					
			}
		}
		else{

			echo '<script type="text/javascript">
					alert("You entered an incorrect email or password");
					</script>';
		}
	}
}


	require 'setup.php';
?>