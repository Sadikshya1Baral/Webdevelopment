<?php
//here are the codes for showing contact page

session_start();

$pagetitle = 'Contact';

//html form format to post message
$pagecontent = '
<h2>Contact Us</h2>
<article>
<form class="form" action="contact.php" id="contactform" method="post">
		<label>Firstname:</label>
			<input type="text" name="firstname" required />
		<label>Surname:</label>
			<input type="text" name="surname" required />
		<label>E-mail address:</label>
      <input type="text" name="email" required />
    <label>Enter message here:</label>
    <textarea name="contactmessage" form="contactform"></textarea>
		<input type="submit" value="Submit" name="submit" />
	</form>
	</article>
  ';

require 'setup.php';

?>