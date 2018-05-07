<?php

$current_page='new_auction';
require_once('templates/connect.php');


function reArrayFiles(&$file_post) {

    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
}




function addPicture($picture,$file_name){
	// $file = array();
	// foreach ($picture as $key1 => $value1) {
	// 	foreach ($value1 as $key2 => $value2) {
	// 	$file[$key2][$key1] = $value2;
	// }
	// }
global $error;
global $dbh;

$error="";
//in production
$file = $picture;
$error="";
//in production
	 $allowedExts = array("jpg", "jpeg", "gif", "png", "bmp");
				$tmp_extension = explode(".", $file["name"]);
				$extension = end($tmp_extension);
				if (
						(
							 ($file["type"] == "image/gif")
						|| ($file["type"] == "image/jpeg")
						|| ($file["type"] == "image/png")
						|| ($file["type"] == "image/pjpeg")
						)
						&& ($file["size"] < 2000000)
						&& in_array($extension, $allowedExts))
					{
				 if ($file["error"] > 0)
								{
										$error.= "Return Code: " . $file["error"] . "<br />";
								} else {
										$error.= "Upload: " . $file["name"] . "<br />";
										$error.= "Type: " . $file["type"] . "<br />";
										$error.=  "Size: " . ($file["size"] / 1024) . " Kb<br />";
										$error.= "Temp file: " . $file["tmp_name"] . "<br />";
										move_uploaded_file($file["tmp_name"],
										"upload/" . $file_name . "." . $extension);
										$error.= "Stored in: " . "upload/" . $file_name . "." . $extension;
								}
					}    else {

						$error.= $file["type"]."<br />";
							$error.= "Invalid file try another Image";
					}
					return $extension;

}


function new_auction($title,$description,$startprice,$duration,$pay_method,$pay_instructions,$place,$country,$shipping_costs,$shipping_method,$picture)
{
  global $dbh;
  global $errors;
  $errors = array();


if(empty($title))//checks if title is not empty
{
  $errors['title'] = "Dit is een verplicht veld.";
}
if(empty($description))//checks if description is not empty
{
  $errors['description'] = "Dit is een verplicht veld.";
}
if(empty($startprice))//checks if startprice is not empty
{
  $errors['startprice'] = "Dit is een verplicht veld.";
}
if(empty($place))//checks if place is not empty
{
  $errors['place'] = "Dit is een verplicht veld.";
}
if(empty($country))//checks if country is not empty
{
  $errors['country'] = "Dit is een verplicht veld.";
}

$pictures = array();
$num_pictures = count($picture['name']);
$picture_keys = array_keys($picture);

for ($i=0; $i<$num_pictures; $i++) {
		foreach ($picture_keys as $key) {
				$pictures[$i][$key] = $picture[$key][$i];
		}
}

print_r($pictures);
for ($i = 0; $i<$num_pictures; $i++) {
  echo $pictures[$i]['name'];
}
echo $pictures[1]['size'];
// echo $file_ary[0]['name'];
// print_r($picture);
// echo $picture["type"][1];

if(count($errors) == 0)//checks if there are errors
{
  $current_date = date('Y-m-d');
  $current_time = date('G:i:s');
  $end_date = date('Y-m-d', strtotime($current_date. ' + ' . $duration . 'days'));

  try {
    $objectdata = $dbh->prepare("select top 1 voorwerpnummer from Voorwerp order by voorwerpnummer desc");
    $objectdata->execute();
    $lastid = $objectdata->fetch();
    $id = $lastid[0] + 1;

  } catch (PDOException $e) {
    $error=$e;
    echo $error;
  }


  $seller = "janbeenham";
  // echo ($current_date);
  // echo ($end_date);
  // echo ($current_time);
  echo ($id);
  echo ($picture['name']);

    try {
      $data = $dbh->prepare("insert into Voorwerp(titel, beschrijving, startprijs, betalingswijze, betalingsinstructie, plaatsnaam, land, looptijd, Looptijdbegindag, Looptijdtijdstip, verzendkosten, verzendinstructies, verkoper, looptijdeindedag, veilinggesloten)
Values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
      $data->execute(array($title, $description, (float)$startprice, $pay_method, $pay_instructions, $place, $country, $duration, $current_date, $current_time, (float)$shipping_costs, $shipping_method, $seller, $end_date, 0));
    } catch (PDOException $e) {
      $error=$e;
      echo $error;
    }


    for ($i = 0; $i<$num_pictures; $i++) {
      echo $pictures[$i]['name'];
      try {
        $filename = $id . "_" . $i . addPicture($pictures[$i],$id);
        $data = $dbh->prepare("insert into Bestand(voorwerpnummer, filenaam) Values(?, ?)");
        $data->execute(array($id, $filename));
      } catch (PDOException $e) {
        $error=$e;
        echo $error;
      }
    }
    // foreach ($pictures as $picture) {
    //   echo $picture['name'];
    //   try {
    //     $filename = addPicture($picture,$id) . "_" .
    //     $data = $dbh->prepare("insert into Bestand(voorwerpnummer, filenaam) Values(?, ?)");
    //     $data->execute(array($id, ));
    //   } catch (PDOException $e) {
    //     $error=$e;
    //     echo $error;
    //   }
    // }


}
}




if(isset($_POST['submit'])){
  new_auction($_POST['title'],$_POST['description'],$_POST['startprice'],$_POST['duration'],$_POST['pay_method'],$_POST['pay_instructions'],$_POST['place'],$_POST['country'],$_POST['shipping_costs'],$_POST['shipping_instructions'],$_FILES['picture']);
}
?>
<br><br><br><br>
<form action="" method="post" enctype="multipart/form-data">
  <label>Titel</label>
  <input type="text" name="title" value="<?php if(isset($_POST['title'])){echo $_POST['title'];}?>"><br>
  <?php if(isset($errors['title'])){echo $errors['title'];}?><br>
  <label>Beschrijving</label>
  <textarea name="description" value=""><?php if(isset($_POST['description'])){echo $_POST['description'];}?></textarea><br>
  <?php if(isset($errors['description'])){echo $errors['description'];}?><br>
  <label>Startprijs</label>
  <input type="text" name="startprice" value="<?php if(isset($_POST['startprice'])){echo $_POST['startprice'];}?>"><br>
  <label>Looptijd</label>
  <select name="duration">
    <option value="1">1 dagen</option>
    <option value="3">3 dagen</option>
    <option value="5">5 dagen</option>
    <option value="7" selected>7 dagen</option>
    <option value="10">10 dagen</option>
  </select><br>
  <label>Betalingswijze</label>
  <input type="radio" name="pay_method" value="contant" checked> Contant
  <input type="radio" name="pay_method" value="bank/giro"> Bank/Giro
  <input type="radio" name="pay_method" value="anders"> Anders<br>
  <label>Betalingsinstructies</label>
  <input type="text" name="pay_instructions"><br>
  <label>Plaats</label>
  <input type="text" name="place"><br>
  <label>Land</label>
  <input type="text" name="country"><br>
  <label>Verzendkosten</label>
  <input type="text" name="shipping_costs"><br>
  <label>Verzendinstructies</label>
  <input type="text" name="shipping_instructions"><br>
  <label>Afbeeldingen</label><br>
  <input name="picture[]" type="file"><br>
	<input name="picture[]" type="file"><br>
	<input name="picture[]" type="file"><br>
	<input name="picture[]" type="file"><br>
  <button type="submit" name="submit">Plaats veiling</button>
</form>
