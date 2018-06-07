<?php
$current_page='new_auction';
require_once('templates/header.php');
require_once("templates/auction/f_checkPicture.php");
require_once("templates/auction/f_generateCategoryOptions.php");
require_once("templates/auction/f_newAuction.php");


$seller = $_SESSION['username'];

try { //Select userdata from the database
  $statement = $dbh->prepare("select * from Gebruiker where gebruikersnaam = ?");
  $statement->execute(array($seller));
  $userdata = $statement->fetch();
} catch (PDOException $e) {

}

try { //Select all categories from the database
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

}

if(isset($_POST['submit'])){//executed if button 'Plaats veiling' is pressed
  $j = 1;
  $category;
  while(isset($_POST['subCategories' . $j])){//Selects last selected subcategory
    $category = $_POST['subCategories' . $j];
    $j++;
  }
  //Creates new auction
  newAuction($_POST['title'],$_POST['description'],$_POST['startprice'],$_POST['duration'],$_POST['pay_method'],$_POST['pay_instructions'],$_POST['place'],$_POST['country'],$_POST['shipping_costs'],$_POST['shipping_method'],$_FILES['picture'],$category);
}

?>

<style>
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


<div class="container col-md-9 col-lg-8">
  <!-- Form for creating new auction -->
<form class="newauction-form" action="" method="post" enctype="multipart/form-data" onsubmit="return validateFileExtension(this.fileField)">

  <div class="newauction-form-header">
    <h1>Titel en beschrijving</h1>
  </div>
  <div class="form-row">
      <div class="md-form form-group col-md-12">
        <input type="text" class="form-control" name="title" id="title" maxlength="50" required pattern="[A-z0-9ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿþ\-'’‘ ]+" >
        <div class="form-requirements">
          <ul>
            <li>Verplicht veld</li>
            <li>Maximaal 50 tekens</li>
            <li>De meeste tekens uit het latijns alfabet worden toegestaan</li>
          </ul>
        </div>
        <label class="black-text" for="title">&nbsp;Titel</label>
      </div>
  </div>

  <div class="form-row">
      <div class="md-form form-group col-md-12">
        <textarea type="text" name="description" id="description" class="form-control md-textarea" rows="5" maxlength="255" required></textarea>
        <div class="form-requirements">
          <ul>
            <li>Verplicht veld</li>
            <li>Maximaal 255 tekens</li>
            <li>De meeste tekens uit het latijns alfabet worden toegestaan</li>
          </ul>
        </div>
        <label class="black-text" for="description">&nbsp;Beschrijving</label>
      </div>
  </div>

  <div class="newauction-form-header">
    <h1>Rubriek</h1>
  </div>
  <div class="form-row">
      <div class="md-form form-group col-md-12">
        <select name="mainCategory" id="mainCategories" class="form-control" onchange="createSubCategorySelect(this.value, 0)" required>
          <?=generateCategoryOptions($results) //echos all main categories ?>
        </select>
        <div id="subCategoriesDiv0"></div> <!--empty div which is filled when main category is selected -->
      </div>
  </div>

  <div class="newauction-form-header">
    <h1>Afbeeldingen</h1>
  </div>
  <div class="form-row">
    <div class="auctionPictureFrame">
      <div id="blockPicture1" class="blockFileSelectButton"></div>
      <input name="picture[]" id="picture1" type="file" class="inputfile">
      <label id="labelpicture1" for="picture1"><img style="height: 80px;" src="img/picture-upload-button.png"></img></label>
      <div id="remove-btn1" onclick="removePicture(1)" class="remove-btn"><i class="fa fa-trash" aria-hidden="true"></i></div>
      <input type="text" id="hidden1" class="hiddenInput"></input>
    </div>
    <div class="auctionPictureFrame">
      <div id="blockPicture2" class="blockFileSelectButton"></div>
      <input name="picture[]"  id="picture2" type="file" class="inputfile" style="display: none;">
      <label id="labelpicture2" for="picture2" style="display: none;"><img style="height: 80px;" src="img/picture-upload-button.png"></img></label>
      <div id="remove-btn2" onclick="removePicture(2)" class="remove-btn"><i class="fa fa-trash" aria-hidden="true"></i></div>
      <input type="text" id="hidden2" class="hiddenInput"></input>
    </div>
    <div class="auctionPictureFrame">
      <div id="blockPicture3" class="blockFileSelectButton"></div>
      <input name="picture[]" id="picture3" type="file" class="inputfile" style="display: none;">
      <label id="labelpicture3" for="picture3" style="display: none;"><img style="height: 80px;" src="img/picture-upload-button.png"></img></label>
      <div id="remove-btn3" onclick="removePicture(3)" class="remove-btn"><i class="fa fa-trash" aria-hidden="true"></i></div>
      <input type="text" id="hidden3" class="hiddenInput"></input>
    </div>
    <div class="auctionPictureFrame">
      <div id="blockPicture4" class="blockFileSelectButton"></div>
      <input name="picture[]" id="picture4" type="file" class="inputfile" style="display: none;">
      <label id="labelpicture4" for="picture4" style="display: none;"><img style="height: 80px;" src="img/picture-upload-button.png"></img></label>
      <div id="remove-btn4" onclick="removePicture(4)" class="remove-btn"><i class="fa fa-trash" aria-hidden="true"></i></div>
      <input type="text" id="hidden4" class="hiddenInput"></input>
    </div>
  </div>
  <div>
    <ul>
      <li>Afbeeldingen moeten van het type jpg, png of bmp zijn</li>
      <li>Afbeeldingen mogen maximaal 3MB zijn</li>
    </ul>
  </div>

  <div class="newauction-form-header">
    <h1>Prijs en levering</h1>
  </div>
  <div class="form-row">
      <div class="md-form form-group col-md-6">
        <input type="number" step="0.01" class="form-control" name="startprice" id="startprice"  required>
        <div class="form-requirements">
          <ul>
            <li>Verplicht veld</li>
            <li>Maximaal 2 cijfers achter de komma</li>
          </ul>
        </div>
        <label class="black-text" for="startprice">&nbsp;Startprijs</label>
      </div>
      <div class="md-form form-group col-md-6">
        <select name="duration" class="form-control">
          <option value="" selected>Kies aantal dagen...</option>
          <option value="1">1 dagen</option>
          <option value="3">3 dagen</option>
          <option value="5">5 dagen</option>
          <option value="7">7 dagen</option>
          <option value="10">10 dagen</option>
        </select>
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
          <input type="text" class="form-control" name="pay_instructions" id="pay_instructions" maxlength="255" pattern="[A-z0-9ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿþ\-'’‘ ]+" >
          <div class="form-requirements">
            <ul>
              <li>Optioneel</li>
              <li>Maximaal 255 tekens</li>
              <li>De meeste tekens uit het latijns alfabet worden toegestaan</li>
            </ul>
          </div>
          <label class="black-text" for="pay_instructions">&nbsp;Betalingsinstructies</label>
        </div>
    </div>

    <div class="form-row">
        <div class="md-form form-group col-md-6">
          <input type="text" class="form-control" name="place" id="place"  value="<?=$userdata['plaatsnaam']?>" maxlength="50" required pattern="[A-zÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿþ\-'’‘]+" >
          <div class="form-requirements">
            <ul>
              <li>Verplicht veld</li>
              <li>Maximaal 50 tekens</li>
              <li>De meeste tekens uit het latijns alfabet worden toegestaan</li>
            </ul>
          </div>
          <label class="black-text" for="place">&nbsp;Plaats</label>
        </div>
        <div class="md-form form-group col-md-6">
          <input type="text" class="form-control" name="country" id="country"  value="<?=$userdata['land']?>" maxlength="48" required pattern="[A-zÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿþ\-'’‘]+" >
          <div class="form-requirements">
            <ul>
              <li>Verplicht veld</li>
              <li>Maximaal 48 tekens</li>
              <li>De meeste tekens uit het latijns alfabet worden toegestaan</li>
            </ul>
          </div>
          <label class="black-text" for="country">&nbsp;Land</label>
        </div>
    </div>

    <div class="form-row">
        <div class="md-form form-group col-md-6">
          <input type="number" step="0.01" class="form-control" name="shipping_costs" id="shipping_costs">
          <div class="form-requirements">
            <ul>
              <li>Optioneel</li>
              <li>Maximaal 2 cijfers achter de komma</li>
            </ul>
          </div>
          <label class="black-text" for="shipping_costs">&nbsp;Verzendkosten</label>
        </div>
        <div class="md-form form-group col-md-6">
          <input type="text" class="form-control" name="shipping_method" id="shipping_method"  pattern="[A-z0-9ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿþ\-'’‘ ]+" >
          <div class="form-requirements">
            <ul>
              <li>Optioneel</li>
              <li>Maximaal 255 tekens</li>
              <li>De meeste tekens uit het latijns alfabet worden toegestaan</li>
            </ul>
          </div>
          <label class="black-text" for="shipping_method">&nbsp;Verzendinstructies</label>
        </div>
    </div>



    <div class="mt-3 py-1 text-center">
      <button class="btn elegant" type="submit" name="submit" data-toggle="tooltip" title="Plaats veiling">Plaats veiling</button>
    </div>

</form>

</div>



<script>
//adds pcitureselector if new picture is selected
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

//Generates subcategorie selectors
	function createSubCategorySelect(categorynumberParent, teller){//Gets selected categorynumber


		var results = <?php echo json_encode($results); ?>;//array containing all categories
		var selector = "<select class='form-control' name='subCategories"+(teller+1)+"' id='subCategories"+(teller+1)+"' onchange='createSubCategorySelect(this.value, "+(teller+1)+")' required>";
    selector += "<option value=''>Kies subrubriek...</option>";

		var found = false;
		for (i = 0; i < results.length; i++) { //checks every category parent if it is equal to selected category
			if (results[i].rubrieknummerOuder == categorynumberParent) {
				selector += "<option value='" + results[i].rubrieknummer + "'>" + results[i].rubrieknaam + "</option>";//adds categoryoption to selector
				found = true;
			}
		}


		selector += "</select>";
    selector += "<div id='subCategoriesDiv"+(teller+1)+"'>";
		selector += "</div>";

		if (found) {
			document.getElementById('subCategoriesDiv'+teller).innerHTML = selector;//creates new subcategory selector if subcategories exist

		}
      else {
        document.getElementById('subCategoriesDiv'+teller).innerHTML = "";//deletes subcategory selector if other category is selected
      }
  	}


    document.getElementById('picture1').addEventListener('change', handleFileSelect, false);
    document.getElementById('picture1').pictureId = 1;
    document.getElementById('picture2').addEventListener('change', handleFileSelect, false);
    document.getElementById('picture2').pictureId = 2;
    document.getElementById('picture3').addEventListener('change', handleFileSelect, false);
    document.getElementById('picture3').pictureId = 3;
    document.getElementById('picture4').addEventListener('change', handleFileSelect, false);
    document.getElementById('picture4').pictureId = 4;


    //Handles pictureselection
    function handleFileSelect(evt) {
          var files = evt.target.files;
          var pictureId = evt.target.pictureId;
          var f = files[0];
          var reader = new FileReader();

            reader.onload = (function(theFile) {
                  return function(e) {
                    var extension = theFile.name.split('.').pop().toLowerCase();
                    console.log("hidden" + pictureId);
                    if((extension != "jpg" && extension != "bmp" && extension != "png") || theFile.size > 2000000){
                      document.getElementById("hidden" + pictureId).setCustomValidity("Dit bestand is niet geldig");
                      console.log("hidden" + pictureId);
                    }
                    else {
                      document.getElementById("hidden" + pictureId).setCustomValidity("");
                    }
                    document.getElementById("labelpicture" + pictureId).innerHTML = ['<div class="edit-btn"><i class="fa fa-upload" aria-hidden="true"></i></div><img src="', e.target.result,'" title="', theFile.name, '"  />'].join('');
                    document.getElementById("remove-btn" + pictureId).style.display = "block";
                    document.getElementById("blockPicture" + pictureId).style.display = "block";
                  };
            })(f);
            if(typeof f == 'object'){
              reader.readAsDataURL(f);
            }
            else {
              removePicture(pictureId);
            }



  }

  //Unselects picture
  function removePicture(pictureId) {
    var labelpicture = 'labelpicture' + pictureId;
    var file = document.getElementById('picture' + pictureId);
    file.value = file.defaultValue;
    document.getElementById('labelpicture' + pictureId).innerHTML = ['<img style="height: 80px;" src="img/picture-upload-button.png"></img>'].join('');
    document.getElementById("remove-btn" + pictureId).style.display = "none";
    document.getElementById("blockPicture" + pictureId).style.display = "none";
    document.getElementById("hidden" + pictureId).setCustomValidity("");
}



</script>
<?php include 'templates/footer.php'; ?>
