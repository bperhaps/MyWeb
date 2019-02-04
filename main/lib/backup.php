<?php
	include "functions.php";
	$data = $_POST['data'];
	
	$myfile = fopen("/tmp/$id", "w") or die("Unable to open file!");
	fwrite($myfile, $data);
	fclose($myfile);
?>
