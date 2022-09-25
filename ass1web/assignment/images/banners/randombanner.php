<?php 
/*
	Random image script, picks a file at random from the current directory


	Usage:

	Just reference this script as an image in HTML 


	<img src="randombanner.php" alt="Image" />

*/



$files = [];
foreach (new DirectoryIterator('./') as $file) {
	if ($file->isDot()) {
		continue;
	}
	
	if (!strpos($file->getFileName(), '.jpg')) {
		continue;
	}

	$files[] = $file->getFileName();
}


header('Content-Type: image/jpeg');


$contents = load_file('./' . $files[rand(0,count($files)-1)]);
header('Content-Length: ' . strlen($contents));

echo $contents;
//echo 'AAA';

//


function load_file($name) {
	/*
	* Start the buffer 
	*/
	ob_start();

	/*
	* Read the contents of the file
	*/
	$contents = file_get_contents($name);
	
	return $contents;
}



