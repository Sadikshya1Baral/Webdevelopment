<?php
session_start();

$pagetitle = 'Delete Admin Account';

//Connection to database
require 'database.php';

//Checks to make sure that an admin is logged in before displaying the page
if (isset($_SESSION['logged_as_admin']) && $_SESSION['logged_as_admin'] == true) {
    $pagecontent = '
    <h2>Delete Admin Account</h2>
    <form class="form" action="deleteadmin.php" method="post">
    <label>Admin Email to delete:</label>
      <select name="email">
      <option value="" disabled selected>Please Select</option>';

      //options to select which admin account has to be deleted from database
        $results = $db->prepare('SELECT * FROM admins');
        $results->execute();

        foreach ($results as $row)
        {
          $pagecontent = $pagecontent. '
          <option value="'. $row['email'].'">'. $row['email'].'</option>';
        }

    $pagecontent =$pagecontent.'
      </select>
        <input type="submit" value="Delete" name="submit" />
    </form>
    ';

    //If an account is choosen and delete button is pressed, delete Admin email
    if (isset($_POST['email']))
    {
      $email=$_POST['email'];

      //query statement to delete admin account with the choosen email
      $sadistmt = $db->prepare('DELETE FROM admins WHERE email= :email');
      $sadistmt->bindParam(":email", $email);
      $sadistmt->execute();


      //show an alert statement once the admin account is deleted
      echo '<script type="text/javascript">
          alert("The admin account ' . $email . ' has successfully been deleted");
        </script>';
    }


//End of admin logged in IF
}
else {
	echo '<li><a href = "login.php"> Please login as admin first </a></li>';
}


require 'setup.php';
?>