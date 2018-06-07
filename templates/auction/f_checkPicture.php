<?php
//Checks if file is the right type and checks if the file is not too large
function checkPicture($picture, $id, $i){
  global $errors;

  $pictures = array();
  $allowedExts = array("jpg", "jpeg", "png", "bmp");//Allowed filetypes
  $tmp_extension = explode(".", $picture["name"]);
  $extension = end($tmp_extension);
  $filename = $id . "_" . $i . "." . $extension;
  if (//checks file type and size
    !(
    ($picture["type"] == "image/jpeg")
    || ($picture["type"] == "image/png")
    || ($picture["type"] == "image/pjpeg")
    || ($picture["type"] == "image/bmp")
    )
    || ($picture["size"] > 2000000) //File must be smaller than 2MB
    || !in_array($extension, $allowedExts)
    || $picture["error"] > 0)
  {
    $errors['upload'] = 'Afbeeldingen moeten een jpg of png van maximaal 3MB zijn.';
    $errors['upload'] = $picture["error"];
  } else {
    return $filename;//returns filename
  }
}
?>
