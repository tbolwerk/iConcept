<?php
//Takes an image and stores it as {username}.png in /img/avatar
function addAvatar($file, $username){
	global $error;
	global $dbh; //database object

	$error="";

	//If the file is a supported image
	if ((
			 ($file["type"] == "image/jpeg")
		|| ($file["type"] == "image/png")
		|| ($file["type"] == "image/pjpeg")
	) && ($file["size"] < 4000000)) {
		if ($file["error"] > 0) {
			$error.= "Return Code: " . $file["error"] . "<br />";
		} else {
			$error.= "Upload: " . $file["name"] . "<br />";
			$error.= "Type: " . $file["type"] . "<br />";
			$error.=  "Size: " . ($file["size"] / 1024) . " Kb<br />";
			$error.= "Temp file: " . $file["tmp_name"] . "<br />";

			//Move and rename uploaded image
			$filename = "img/avatar/" . $username . ".png";
			move_uploaded_file($file["tmp_name"], $filename);

			$error.= "Stored in: " . $filename;
		}
	} else {
		$error.= $file["type"]."<br />";
		$error.= "Verkeerd bestand, selecteer een nieuwe";
	}
}

?>