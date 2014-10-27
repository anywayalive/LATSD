<?php	
	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
	require_once('lib/init.php');
	//header("Access-Control-Allow-Origin: *");


	$guid = $_GET['design_id'];
	$design_folder_path = "../files/".$guid."/";
	$LAJS_folder_path = "../";
	$sources = "sources/";
	$files_to_zip = array();
	$log = "";

	//read saved design
	$file = file_get_contents($design_folder_path."design.json");
	if (get_magic_quotes_gpc()) {
		$design = stripslashes($file);
	} else {
        $design = $file;
	}
	$json = json_decode($design);


	// page body
	echo ('<!doctype html><html><body>');
	echo ('<link href="../assets/bootstrap/css/bootstrap.css" type="text/css" rel="stylesheet"/>');
	echo "<style>body {padding: 10px;} div.location > svg {position: relative !important;} div.location {height: 590px;float:left;width:590px;}</style>";
	//print guid
	echo ('<h1>Details for order #'.$guid.':</h1>');
	
	//print product name and color
	if (isset($json->data->product->name)) {
	    echo('<h4>Product: '.$json->data->product->name);
	    if (isset ($json->data->product->colorName)) {
	       echo(" (" . $json->data->product->colorName . ")" );
	    }
	    echo('</h4>');
	}

	$svg = "";
	//iterating design locations
	foreach($json->data->locations as $loc) {
		
		$svg = $loc->svg;
		echo "<div class='location'>";
		echo "<a href='".$design_folder_path."design_".$loc->name.".svg'><h5>Location: ".$loc->name."</h5></a>";
		
		//form list of all external images
		$attrib = 'xlink:href';
		$regexp = '/' . preg_quote($attrib) . '=([\'"]([^#][^\s>]+)["\'])/is';	
		//matching pattern  xlink:href="url/files.ext"
		preg_match_all($regexp, $svg, $external_images_list, PREG_PATTERN_ORDER);
		//echo('<code>');var_dump($external_images_list);echo('</code>');
		
		//create folder for external images (if not exist)
		if (!file_exists($design_folder_path.$sources)) {
			if (!mkdir($design_folder_path.$sources, 0777)) {
			    $log .= 'Failed to create folder $sources :('.'<br />';
			} else {
				$log .=  'Created directory '.$sources.'<br />';
			}
		}
		
		//iterating all external images
		for($i = 0; $i < count($external_images_list[2]); $i++) {
			//$external_images_list[2] - array of attr values, e.g. 'url/files.ext' (without xlink:href and quotes)
			$image_url_orig = $external_images_list[2][$i];
			if (strrpos($image_url_orig, "http") !== 0 ) {
				$image_url_full = $LAJS_folder_path.$image_url_orig;
			} else {
				//copy images with absolute url
				$image_url_full = $image_url_orig;
			}
		        $image_file_name = basename($image_url_orig);
		        $image_url_destination = $design_folder_path.$sources.$image_file_name;

		        //copy all external images to $sources
			if (strlen($image_url_orig)) {
				if(!copy($image_url_full, $image_url_destination))
				{
				    $errors= error_get_last();
				    $log .=  "<b>COPY ERROR:</b> ".$errors['type'];
				    $log .=  "<br />\n".$errors['message'].'<br />';
				    //replace url to one from LAJS folder
				    $svg = str_replace($image_url_orig, $image_url_full, $svg);
				} else {
					//replace image url to one from $sources folder
				    $log .=  "<a href='$image_url_destination'>$image_url_orig</a> copied to $sources".'<br />';
				    $svg = str_replace($image_url_orig, $sources.$image_file_name, $svg);
				    array_push($files_to_zip, $sources.$image_file_name);
				}
			}
		}

		//write file
		$filename = "design_".$loc->name.".svg";
		$filename_full = $design_folder_path.$filename;
		//if (!file_exists($filename_full)) {
			$f = fopen($filename_full, "w");
			fwrite($f, $svg);
			fclose($f);
			array_push($files_to_zip, $filename);
		//}
		//load saved file
		echo "<object type='image/svg+xml' data='".$filename_full."'	width='587' height='543'></object>";
		echo "</div>";
	}

	$zip = new ZipArchive();
	$zip_filename = $design_folder_path.$guid.".zip";

	if ($zip->open($zip_filename, ZipArchive::CREATE)!==TRUE) {
	    exit("cannot open <$zip_filename>\n");
	}

	for($i = 0; $i < count($files_to_zip); ++$i) {
		$zip->addFile($design_folder_path.$files_to_zip[$i], $files_to_zip[$i]);
	}
	
	echo '<div class="well well-small" style="clear: both; margin: 20px 50px; 10px 50px;">';
	$log .= "Zip filename: " . $guid . ".zip" . " numfiles: " . $zip->numFiles . " status: " . $zip->status . "\n";
	$zip->close();
	
	echo "<a href='$zip_filename'><h4><i class='icon-download-alt'></i>download zip package</h4></a>";
	echo '<small>'.$log.'</small>';
	echo '<div/>';

	echo ('</body></html>');	
?>