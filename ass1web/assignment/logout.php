<?php
//
$pagetitle = 'Logged out';
session_start();

//logs out of either admin or user
unset($_SESSION['logged_as_user']);
unset($_SESSION['logged_as_admin']);
echo '<script type="text/javascript">
		alert("You are now logged out");
		</script>';

$pagecontent = 'You are now logged out';

require 'setup.php';
?>