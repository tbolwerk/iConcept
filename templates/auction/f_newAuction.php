<?php
//Stores all information in the database
function newAuction($title,$description,$startprice,$duration,$pay_method,$pay_instructions,$place,$country,$shipping_costs,$shipping_method,$picture,$category){
  global $dbh;
  global $errors;
  global $seller;

  //Strip all html tags and remove any double quotes
  $title = str_replace("\"", "", strip_tags($title));
  $description = str_replace("\"", "", str_replace("\n", "<br>", strip_tags($description)));
  $startprice = str_replace("\"", "", strip_tags($startprice));
  $duration = str_replace("\"", "", strip_tags($duration));
  $pay_method = str_replace("\"", "", strip_tags($pay_method));
  $pay_instructions = str_replace("\"", "", strip_tags($pay_instructions));
  $place = str_replace("\"", "", strip_tags($place));
  $country = str_replace("\"", "", strip_tags($country));
  $shipping_costs = str_replace("\"", "", strip_tags($shipping_costs));
  $shipping_method = str_replace("\"", "", strip_tags($shipping_method));

  //Construct time objects with the current time and date
  $current_date = date('Y-m-d');
  $current_time = date('G:i:s');

  $pictures = array();
  $picture_keys = array_keys($picture);
  for ($i = 0; $i < 4; $i++) { //rearranges the picture array so it's more usable
  	foreach ($picture_keys as $key) {
  		$pictures[$i][$key] = $picture[$key][$i];
    }
  }

  $num_pictures = 0;
  for ($i = 0; $i < 4; $i++){//counts number of selected pictures
    if(!empty($pictures[$i]['name'])){
      $num_pictures++;
    }
  }

  if(count($errors) == 0){//Inserts all data in database if no errors occured
    do {
      $id = rand(0, 999999999); //generate random id to be used as voorwerpnummer
      $retry = false;

      try {//inserts all data in table 'Voorwerp'
        $data = $dbh->prepare("insert into Voorwerp(voorwerpnummer, titel, beschrijving, startprijs, betalingswijze, betalingsinstructie, plaatsnaam, land, looptijd, Looptijdbegindag, Looptijdtijdstip, verzendkosten, verzendinstructies, verkoper, veilinggesloten)
        values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $data->execute(array($id, $title, $description, (float)$startprice, $pay_method, $pay_instructions, $place, $country, $duration, $current_date, $current_time, (float)$shipping_costs, $shipping_method, $seller, 0));
      } catch (PDOException $e) {
        if ($e->getCode() == 23000) { //sqlstate 23000 means that there was a constraint violation
          $retry = true;
        } else {
          $error=$e;
          echo $error;
          $errors['upload'] = "Er is iets misgegaan";
        }
      }
    } while ($retry == true); //if there was an error, try again

    for($i = 0; $i < $num_pictures; $i++){//makes the indexes of the pictures right for if user deselected a picture
      if(empty($pictures[$i]['name'])){
        $pictures[$i] = $pictures[$i+1];
        $pictures[$i+1] = null;
        $i--;
      }
      else {
        //Check whether we allow these pictures and generate the filename
        $filenames[$i] = checkPicture($pictures[$i],$id,$i);
      }
    }

    for($i = 0; $i < $num_pictures; $i++){//Inserts data for every selected picture
      move_uploaded_file($pictures[$i]["tmp_name"], //uploads picture to server
      "img/producten/" . $filenames[$i]);
      try {//inserts picturedata in database
        $data = $dbh->prepare("insert into Bestand(voorwerpnummer, filenaam) Values(?, ?)");
        $data->execute(array($id, "img/producten/" . $filenames[$i]));
      } catch (PDOException $e) {
          $error = $e;
          echo $error;
          $errors['upload'] = "Er is iets misgegaan";
      }
    }
    try {//inserts categorydata in database
      $data = $dbh->prepare("insert into Voorwerp_in_Rubriek(voorwerpnummer, rubrieknummer) Values(?, ?)");
      $data->execute(array($id, $category));
    } catch (PDOException $e) {
        $error = $e;
        echo $error;
        $errors['upload'] = "Er is iets misgegaan";
    }
    if(count($errors) == 0){
      $errors['upload'] = "Veiling is succesvol geplaatst!";
    }
  }
}
?>
