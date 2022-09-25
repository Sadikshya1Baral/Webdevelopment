<?php
	//continue with user session status
	session_start();

	//provide title to the page
	$pagetitle = 'Add News Article';

	//database connection file called
	require 'database.php';

	//check to make sure if the admin is logged in before displaying the page
	if(isset($_SESSION['logged_as_admin']) && $_SESSION['logged_as_admin'] == true)
	{

		//design a html form to add a new article
		$pagecontent = '
		<h2>Add News Article</h2>
		<article>
		<form class="form" action="addArticle.php" method="post" enctype="multipart/form-data">
			<label>Title:</label>
			<input type="text" name="title" required />
			<label>Category:</label>
			<select name="category" rquired>
			<option value="" disabled selected>Please Select</option>';
		
		//show a dropdown selection to choose a category
		$sadiresults = $db->prepare('SELECT * FROM category');
				$sadiresults->execute();

		foreach ($sadiresults as $row) {
			$pagecontent = $pagecontent . '
				<option value="'. $row['name'].'">'. $row['name'].'</option>
			';
		}

		$pagecontent = $pagecontent . '
			</select>
			<label>Article Content:</label>
	    	<textarea name="content" required></textarea>
			<label>Upload Image:</label>
			<input type ="file" name="image">
			<input type="submit" value="Submit" name="submit" />
		</form>
		</article>
  		';


  		if(isset($_POST['submit'])){
	  		if (isset($_POST['title'], $_POST['category'], $_POST['content'])) {
	  			
	  			$title = $_POST['title'];
	  			$date = date('y-m-d');

	  			//setting the name, path and temporary directory of image that would be uploaded
	  			$image = $_FILES['image']['name'];
	  			$image_path = 'artimage/' . $image . '';
	  			$tmp_dir = $_FILES['image']['tmp_name'];

	  			$publisher_id = $_SESSION['admin_id'];

	  			//set the name of admin as a publisher for that article
	  			$convert_id = $db->prepare('SELECT email FROM admins WHERE admin_id="' . $publisher_id . '"');
			      $convert_id -> execute();

			      foreach ($convert_id as $convert_email) {
			          $publisher = $convert_email['email'];
			      }

			    

	  			//query statement to add a new article with its record details
	  			$sadistmt = $db->prepare('INSERT INTO article (title, category, content, published_date, image, publisher) VALUES ( :title, :category, :content, :published_date, :image, :publisher)');

	  			$criteria  = [
	  				'title' => $_POST['title'],
	  				'category' => $_POST['category'],
	  				'content' => $_POST['content'],
	  				'published_date' => $date,
	  				'image' => $image_path,
	  				'publisher' => $publisher
	  			];

	  			try{
				$sadistmt -> execute($criteria);

				//copy the image file from temporary locatioin to the path given
	  			if(copy($_FILES['image']['tmp_name'], $image_path))
	  			{

	  			}

				//show an alert statement if the article has been added to the page
				echo '<script type="text/javascript">
				  alert("News Article has been added successfully");
				</script>';

				} catch (PDOException $e) {
				   if ($e->errorInfo[1] == 1062) {
				   	//show an alert if duplicate entry exception arises
				      echo '<script type="text/javascript">
						alert("The Article already exists.");
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