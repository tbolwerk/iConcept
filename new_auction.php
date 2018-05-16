<br><br><br><br>
<?php
$current_page='new_auction';
require_once('templates/header.php');

$errors;
$errors = array();

try {
  $seller = $_SESSION['username'];
  $statement = $dbh->prepare("select * from Gebruiker where gebruikersnaam = ?");
  $statement->execute(array($seller));
  $results = $statement->fetch();
} catch (PDOException $e) {
  echo $e;
}


function checkPicture($picture, $id, $i){
  global $errors;

  $pictures = array();
  $allowedExts = array("jpg", "jpeg", "gif", "png", "bmp");
  $tmp_extension = explode(".", $picture["name"]);
  $extension = end($tmp_extension);
  $filename = $id . "_" . $i . "." . $extension;
  if (
      !(
         ($picture["type"] == "image/gif")
      || ($picture["type"] == "image/jpeg")
      || ($picture["type"] == "image/png")
      || ($picture["type"] == "image/pjpeg")
      )
      || ($picture["size"] > 3000000)
      || !in_array($extension, $allowedExts)
      || $picture["error"] > 0)
      {
        $errors['upload'] = 'Afbeeldingen moeten een jpg of png van maximaal 3MB zijn.';
      }
      else {
        return $filename;
      }
}

function newAuction($title,$description,$startprice,$duration,$pay_method,$pay_instructions,$place,$country,$shipping_costs,$shipping_method,$picture){
  global $dbh;
  global $errors;



  $current_date = date('Y-m-d');
  $current_time = date('G:i:s');
  $end_date = date('Y-m-d', strtotime($current_date. ' + ' . $duration . 'days'));

  try {
    $objectdata = $dbh->prepare("select top 1 voorwerpnummer from Voorwerp order by voorwerpnummer desc");
    $objectdata->execute();
    $lastid = $objectdata->fetch();
    $id = $lastid[0] + 1;
  } catch (PDOException $e) {
    $errors['db']=$e;
    echo $errors['db'];
  }

  $pictures = array();
  $picture_keys = array_keys($picture);
  for ($i = 0; $i < 4; $i++) {
  	foreach ($picture_keys as $key) {
  		$pictures[$i][$key] = $picture[$key][$i];
    }
  }

  $num_pictures = 0;
  for ($i = 0; $i < 4; $i++){
    if(!empty($pictures[$i]['name'])){
      $num_pictures++;
    }
  }

  for($i = 0; $i < $num_pictures; $i++){
    if(empty($pictures[$i]['name'])){
      $pictures[$i] = $pictures[$i+1];
      $pictures[$i+1] = null;
      $i--;
    }
    else {
      $filenames[$i] = checkPicture($pictures[$i],$id,$i);
    }
  }

  if(count($errors) == 0){
    try {
      $data = $dbh->prepare("insert into Voorwerp(titel, beschrijving, startprijs, betalingswijze, betalingsinstructie, plaatsnaam, land, looptijd, Looptijdbegindag, Looptijdtijdstip, verzendkosten, verzendinstructies, verkoper, looptijdeindedag, veilinggesloten)
      values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
      $data->execute(array($title, $description, (float)$startprice, $pay_method, $pay_instructions, $place, $country, $duration, $current_date, $current_time, (float)$shipping_costs, $shipping_method, $seller, $end_date, 0));
    } catch (PDOException $e) {
      $error=$e;
      echo $error;
    }
    for($i = 0; $i < $num_pictures; $i++){
      move_uploaded_file($pictures[$i]["tmp_name"],
      "upload/" . $filenames[$i]);
      try {
        $data = $dbh->prepare("insert into Bestand(voorwerpnummer, filenaam) Values(?, ?)");
        $data->execute(array($id, $filenames[$i]));
      } catch (PDOException $e) {
          $error = $e;
          echo $error;
      }
    }
  }
}



if(isset($_POST['submit'])){
  newAuction($_POST['title'],$_POST['description'],$_POST['startprice'],$_POST['duration'],$_POST['pay_method'],$_POST['pay_instructions'],$_POST['place'],$_POST['country'],$_POST['shipping_costs'],$_POST['shipping_instructions'],$_FILES['picture']);
  if(isset($errors['upload'])){
    echo $errors['upload'];
  }
}

?>
<form action="" method="post" enctype="multipart/form-data">
  <label>Titel</label>
  <input type="text" name="title" required><br>
  <label>Beschrijving</label>
  <textarea name="description" required></textarea><br>
  <label>Startprijs</label>
  <input type="number" name="startprice" required><br>
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
  <input type="text" name="place" value="<?=$results['plaatsnaam']?>" required><br>
  <label>Land</label>
  <input type="text" name="country" value="<?=$results['land']?>" required><br>
  <label>Verzendkosten</label>
  <input type="number" name="shipping_costs"><br>
  <label>Verzendinstructies</label>
  <input type="text" name="shipping_instructions"><br>
  <label>Afbeeldingen</label><br>
  <input name="picture[]" id="picture1" type="file"><br>
	<input name="picture[]" id="picture2" type="file" style="display: none;">
	<input name="picture[]" id="picture3" type="file" style="display: none;">
	<input name="picture[]" id="picture4" type="file" style="display: none;">
  <button type="submit" name="submit">Plaats veiling</button>
</form>
<script>
function adduploadbox1(){
  if(document.getElementById("picture1").value != "") {
     document.getElementById("picture2").style.display = "block";
  }
}
function adduploadbox2(){
  if(document.getElementById("picture2").value != "") {
     document.getElementById("picture3").style.display = "block";
  }
}
function adduploadbox3(){
  if(document.getElementById("picture3").value != "") {
     document.getElementById("picture4").style.display = "block";
  }
}
document.getElementById("picture1").onchange = adduploadbox1;
document.getElementById("picture2").onchange = adduploadbox2;
document.getElementById("picture3").onchange = adduploadbox3;

</script>
<?php include 'templates/footer.php'; ?>
