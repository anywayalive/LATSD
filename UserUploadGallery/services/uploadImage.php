<?php
	header("Access-Control-Allow-Origin: *");

	$file = $_FILES["image"];

	//$absolute_path = "http://localhost/files/uploads/";
	$absolute_path = "files/uploads/";
	$relative_path = "../files/uploads/";
	$name = $file["name"];
	
	if (!file_exists($relative_path)) {
	    mkdir($relative_path);
	}
	  
	move_uploaded_file($file["tmp_name"], $relative_path.$name);
	
	echo $absolute_path.$name;
?>