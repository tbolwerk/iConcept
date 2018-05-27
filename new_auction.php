<?php
$current_page='new_auction';
require_once('templates/header.php');

$errors;
$errors = array();
$seller = $_SESSION['username'];
try {
  $statement = $dbh->prepare("select * from Gebruiker where gebruikersnaam = ?");
  $statement->execute(array($seller));
  $userdata = $statement->fetch();
} catch (PDOException $e) {
  echo $e;
}

try {
  $data = $dbh->prepare("select * from Rubriek order by volgnummer");
  $data->execute();
  $i = 0;
  while ($row = $data->fetch()) {
    $results[$i]['rubrieknaam'] = $row['rubrieknaam'];
    $results[$i]['rubrieknummer'] = $row['rubrieknummer'];
    $results[$i]['rubrieknummerOuder'] = $row['rubrieknummerOuder'];
    $results[$i]['volgnummer'] = $row['volgnummer'];
    $i++;
  }
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

function generateCategoryOptions($results){
  $options = "<option value=''>Kies rubriek...</option>";
  for ($i = 0; $i < count($results); $i++) {
    if($results[$i]['rubrieknummerOuder'] == -1){
      $options .= "<option value='" . $results[$i]['rubrieknummer'] . "'>" . $results[$i]['rubrieknaam'] . "</option>";
    }
  }
  return $options;
}

function newAuction($title,$description,$startprice,$duration,$pay_method,$pay_instructions,$place,$country,$shipping_costs,$shipping_method,$picture,$category){
  global $dbh;
  global $errors;
  global $seller;



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
    try {
      $data = $dbh->prepare("insert into Voorwerp_in_Rubriek(voorwerpnummer, rubrieknummer) Values(?, ?)");
      $data->execute(array($id, $category));
    } catch (PDOException $e) {
        $error = $e;
        echo $error;
    }
  }
}



if(isset($_POST['submit'])){
  $j = 1;
  $category;
  while(isset($_POST['subCategories' . $j])){
    $category = $_POST['subCategories' . $j];
    $j++;
  }
  newAuction($_POST['title'],$_POST['description'],$_POST['startprice'],$_POST['duration'],$_POST['pay_method'],$_POST['pay_instructions'],$_POST['place'],$_POST['country'],$_POST['shipping_costs'],$_POST['shipping_method'],$_FILES['picture'],$category);
  if(isset($errors['upload'])){
    echo $errors['upload'];
  }
}

?>

<style>
.inputfile {
  display: block;
	width: 0.1px;
	height: 0.1px;
	opacity: 0;
	overflow: hidden;
	/* position: absolute; */
	z-index: -1;
}

.inputfile + label {
  position: relative;
  height: 202px;
  width: 202px;
  border-style: solid;
  border-width: 1px;
  border-color: #bebebe;
  margin-right: 10px;
}

.inputfile + label img {
  position: absolute;
  margin: auto;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  max-height: 200px;
  max-width:200px;
}

.newauction-form {
  background-color: #ffffff;
  padding: 40px;
  margin-top: 50px;
  margin-bottom: 50px;
}

.newauction-form-header h1 {
  color: #000000;
  font-weight: bold;
  font-size: 32px;
  text-align: center;
}

body {
  background-color: #ebebeb;
}

</style>

<div class="view index-header">
  <img src="img/bgs/account-bg.png" class="" height="350">
  <div class="mask index-banner rgba-niagara-strong">
    <h1 class="white-text banner-text">Veiling aanmaken</h1>
  </div>
</div>


<div class="container col-md-9 col-lg-7">
<!-- <div class="row justify-content-center col-sm-12"> -->
<form class="newauction-form" action="" method="post" enctype="multipart/form-data">
  <div class="newauction-form-header">
    <h1>Titel en beschrijving</h1>
  </div>
  <div class="form-row">
      <div class="md-form form-group col-md-12">
        <input type="text" class="form-control" name="title" id="title"  required pattern="[A-zÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿþ\-\'’‘]+" >
        <div class="form-requirements">
          <ul>
            <li>Minimaal 2 tekens</li>
            <li>Maximaal 35 tekens</li>
            <li>De meeste tekens uit het latijns alfabet worden toegestaan</li>
          </ul>
        </div>
        <label class="black-text" for="title">&nbsp;Titel</label>
      </div>
  </div>

  <div class="form-row">
      <div class="md-form form-group col-md-12">
        <textarea type="text" name="description" id="description" class="form-control md-textarea" rows="5" required></textarea>
        <label class="black-text" for="description">&nbsp;Beschrijving</label>
      </div>
  </div>

  <div class="newauction-form-header">
    <h1>Rubriek</h1>
  </div>
  <div class="form-row">
      <div class="md-form form-group col-md-12">
        <select name="mainCategory" id="mainCategories" class="form-control" onchange="createSubCategorySelect(this.value, 0)" required>
          <?=generateCategoryOptions($results)?>
        </select>
        <div id="subCategoriesDiv0"></div>
      </div>
  </div>

  <div class="newauction-form-header">
    <h1>Afbeeldingen</h1>
  </div>
  <div class="form-row">
    <div class="hoi">
      <input name="picture[]" id="picture1" type="file" class="inputfile">
      <label id="labelpicture1" for="picture1"><img style="height: 80px;" src="img/picture-upload-button.png"></img></label>
    </div>
    <div class="hoi">
      <input name="picture[]"  id="picture2" type="file" class="inputfile" style="display: none;">
      <label id="labelpicture2" for="picture2" style="display: none;"><img style="height: 80px;" src="img/picture-upload-button.png"></img></label>
    </div>
    <div class="hoi">
      <input name="picture[]" id="picture3" type="file" class="inputfile" style="display: none;">
      <label id="labelpicture3" for="picture3" style="display: none;"><img style="height: 80px;" src="img/picture-upload-button.png"></img></label>
    </div>
    <div class="hoi">
      <input name="picture[]" id="picture4" type="file" class="inputfile" style="display: none;">
      <label id="labelpicture4" for="picture4" style="display: none;"><img style="height: 80px;" src="img/picture-upload-button.png"></img></label>
    </div>
  </div>

  <div class="newauction-form-header">
    <h1>Prijs en levering</h1>
  </div>
  <div class="form-row">
      <div class="md-form form-group col-md-6">
        <input type="number" step="0.01" class="form-control" name="startprice" id="startprice"  required pattern="[A-zÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿþ\-\'’‘]+" >
        <div class="form-requirements">
          <ul>
            <li>Minimaal 2 tekens</li>
            <li>Maximaal 35 tekens</li>
            <li>De meeste tekens uit het latijns alfabet worden toegestaan</li>
          </ul>
        </div>
        <label class="black-text" for="startprice">&nbsp;Startprijs</label>
      </div>
      <div class="md-form form-group col-md-6">
        <select name="duration" class="form-control">
          <option value="1">1 dagen</option>
          <option value="3">3 dagen</option>
          <option value="5">5 dagen</option>
          <option value="7" selected>7 dagen</option>
          <option value="10">10 dagen</option>
        </select>
        <div class="form-requirements">
          <ul>
            <li>Minimaal 2 tekens</li>
            <li>Maximaal 35 tekens</li>
            <li>De meeste tekens uit het latijns alfabet worden toegestaan</li>
          </ul>
        </div>
      </div>
    </div>

    <div class="form-row">
        <div class="md-form form-group col-md-6">
          <select name="pay_method" class="form-control" required>
            <option value="" selected>Kies betalingswijze...</option>
            <option value="contant">Contant</option>
            <option value="bank/giro">Bank/giro</option>
            <option value="anders">Anders</option>
          </select>
        </div>
        <div class="md-form form-group col-md-6">
          <input type="text" class="form-control" name="pay_instructions" id="pay_instructions"  required pattern="[A-zÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿþ\-\'’‘]+" >
          <label class="black-text" for="pay_instructions">&nbsp;Betalingsinstructies</label>
        </div>
    </div>

    <div class="form-row">
        <div class="md-form form-group col-md-6">
          <input type="text" class="form-control" name="place" id="place"  value="<?=$userdata['plaatsnaam']?>" required pattern="[A-zÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿþ\-\'’‘]+" >
          <label class="black-text" for="place">&nbsp;Plaats</label>
        </div>
        <div class="md-form form-group col-md-6">
          <input type="text" class="form-control" name="country" id="country"  value="<?=$userdata['land']?>" required pattern="[A-zÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿþ\-\'’‘]+" >
          <label class="black-text" for="country">&nbsp;Land</label>
        </div>
    </div>

    <div class="form-row">
        <div class="md-form form-group col-md-6">
          <input type="number" step="0.01" class="form-control" name="shipping_costs" id="shipping_costs">
          <label class="black-text" for="shipping_costs">&nbsp;Verzendkosten</label>
        </div>
        <div class="md-form form-group col-md-6">
          <input type="text" class="form-control" name="shipping_method" id="shipping_method"  pattern="[A-zÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿþ\-\'’‘]+" >
          <label class="black-text" for="shipping_method">&nbsp;Verzendinstructies</label>
        </div>
    </div>



    <div class="mt-3 py-1 text-center">
      <button class="btn elegant" type="submit" name="submit">Plaats veiling</button>
    </div>


  <!-- <br>
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
  <input type="text" name="place" value="<?=$userdata['plaatsnaam']?>" required><br>
  <label>Land</label>
  <input type="text" name="country" value="<?=$userdata['land']?>" required><br>
  <label>Verzendkosten</label>
  <input type="number" name="shipping_costs"><br>
  <label>Verzendinstructies</label>
  <input type="text" name="shipping_instructions"><br>
  <label>Afbeeldingen</label><br>
  <input name="picture[]" id="picture1" type="file"><br>
	<input name="picture[]" id="picture2" type="file" style="display: none;">
	<input name="picture[]" id="picture3" type="file" style="display: none;">
	<input name="picture[]" id="picture4" type="file" style="display: none;">
  <select name="mainCategory" id="mainCategories" onchange="createSubCategorySelect(this.value, 0)" required>
    <?=generateCategoryOptions($results)?>
  </select>
  <div id="subCategoriesDiv0"></div>
  <button type="submit" name="submit">Plaats veiling</button>-->
</form>
<!-- </div> -->
</div>
<!-- </div> -->


<script>
function adduploadbox1(){
  if(document.getElementById("picture1").value != "") {
     document.getElementById("picture2").style.display = "block";
     document.getElementById("labelpicture2").style.display = "block";
  }
}
function adduploadbox2(){
  if(document.getElementById("picture2").value != "") {
     document.getElementById("picture3").style.display = "block";
     document.getElementById("labelpicture3").style.display = "block";
  }
}
function adduploadbox3(){
  if(document.getElementById("picture3").value != "") {
     document.getElementById("picture4").style.display = "block";
     document.getElementById("labelpicture4").style.display = "block";
  }
}
document.getElementById("picture1").onchange = adduploadbox1;
document.getElementById("picture2").onchange = adduploadbox2;
document.getElementById("picture3").onchange = adduploadbox3;

	//teller = 0;
	function createSubCategorySelect(categorynumberParent, teller){


		var results = <?php echo json_encode($results); ?>;
		var selector = "<select class='form-control' name='subCategories"+(teller+1)+"' id='subCategories"+(teller+1)+"' onchange='createSubCategorySelect(this.value, "+(teller+1)+")' required>";
    selector += "<option value=''>Kies subrubriek...</option>";
		//console.log(results.length);

		var gevonden = false;
		for (i = 0; i < results.length; i++) {
			if (results[i].rubrieknummerOuder == categorynumberParent) {
				selector += "<option value='" + results[i].rubrieknummer + "'>" + results[i].rubrieknaam + "</option>";
				gevonden = true;
			}
		}


		selector += "</select>";
    selector += "<div id='subCategoriesDiv"+(teller+1)+"'>";
		selector += "</div>";
		console.log(gevonden);
		if (gevonden) {
			document.getElementById('subCategoriesDiv'+teller).innerHTML = selector;
			//teller++;
		}
      else {
        document.getElementById('subCategoriesDiv'+teller).innerHTML = "";
        console.log(document.getElementById('subCategories'+teller).value);
      }
  	}


    document.getElementById('picture1').addEventListener('change', handleFileSelect, false);
    document.getElementById('picture1').labelpicture = "labelpicture1";
    document.getElementById('picture2').addEventListener('change', handleFileSelect, false);
    document.getElementById('picture2').labelpicture = "labelpicture2";
    document.getElementById('picture3').addEventListener('change', handleFileSelect, false);
    document.getElementById('picture3').labelpicture = "labelpicture3";
    document.getElementById('picture4').addEventListener('change', handleFileSelect, false);
    document.getElementById('picture4').labelpicture = "labelpicture4";

    function handleFileSelect(evt) {
          var files = evt.target.files;
          var labelpicture = evt.target.labelpicture;
          var f = files[0];
          var reader = new FileReader();

            reader.onload = (function(theFile) {
                  return function(e) {
                    document.getElementById(labelpicture).innerHTML = ['<img src="', e.target.result,'" title="', theFile.name, '"  />'].join('');
                  };
            })(f);

            reader.readAsDataURL(f);
  }


</script>
<?php include 'templates/footer.php'; ?>
