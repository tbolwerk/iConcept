<?php
if(!isset($_SESSION['username'])){header('Location: index.php');}
$current_page='register_seller';
require_once('templates/header.php');
require_once('templates/connect.php');
$username = $_SESSION['username'];


function createVerificationCodeSeller($username, $random_password) {
	global $dbh;
	global $error;

    try {
		$userdata = $dbh->prepare("insert into VerificatieVerkoper(gebruikersnaam, code) Values(?, ?)");
		$userdata->execute(array($username, $random_password));
    } catch (PDOException $e) {
		$error=$e;
    }
}

function registerSeller($username, $checkoption, $creditcard, $bank, $banknumber){
  global $dbh;
  global $errors;
  $errors = array();

  try {
    $data = $dbh->prepare("select verkoper from Gebruiker where gebruikersnaam = ?");
    $data->execute(array($username));
    $seller = $data->fetch();

  } catch (PDOException $e) {
    $error=$e;
    echo $error;
  }
  if($seller[0] == 1)//checks if user is seller
  {
    $errors['seller'] = "U bent al een verkoper.";
  }
  else {
    if(empty($checkoption))//checks if checkoption is not empty
    {
      $errors['checkoption'] = "Dit is een verplicht veld.";
    }
    if($checkoption == "creditcard" && empty($creditcard))//checks if title is not empty and if creditcardoption is selected
    {
      $errors['creditcard'] = "Dit is een verplicht veld.";
    }
    if(empty($bank) && empty($creditcard) && $checkoption != "creditcard"){
      $errors['bank'] = "Dit is een verplicht veld.";
    }
    if(empty($banknumber) && empty($creditcard) && $checkoption != "creditcard"){
      $errors['banknumber'] = "Dit is een verplicht veld.";
    }

    if(count($errors) == 0){//checks if there are errors
      if($checkoption == "creditcard"){
				try {
					$data = $dbh->prepare("insert into Verkoper(gebruikersnaam, controleoptienaam, creditcardnummer, banknaam, rekeningnummer) values(?, ?, ?, ?, ?)");
					$data->execute(array($username, $checkoption, $creditcard,  null, null));
					$userdata = $dbh->prepare("update Gebruiker set verkoper = 1 where gebruikersnaam = ?;");
	        $userdata->execute(array($username));
				}
				catch (PDOException $e) {
					$error=$e;
					echo $error;
				}
      }
      else {
				$data = $dbh->prepare("insert into Verkoper(gebruikersnaam, controleoptienaam, creditcardnummer, banknaam, rekeningnummer) values(?, ?, ?, ?, ?)");
				$data->execute(array($username, $checkoption, null,  $bank, $banknumber));
        $code = random_password(6);
  			createVerificationCodeSeller($username, $code);
      }
    }
  }
}

if(isset($_POST['registerseller'])){
  registerSeller($username, $_POST['checkoption'],$_POST['creditcard'],$_POST['bank'],$_POST['banknumber']);
}

?>



<form method="post" action="">

	<div class="md-form">
		<select name="checkoption" id="checkoption" class="form-control" required>
			<option value="">Kies controleoptie...</option>
			<option value="post">Code via post</option>
			<option value="creditcard">Creditcard</option>
		</select>
	</div>

	<div class="md-form" id="creditcardDiv" style="display: none;">
		<label for="creditcard">Creditcardnummer</label>
		<input type="text" class="form-control" name="creditcard" id="creditcard" value="">
	</div>

	<div class="md-form" id="bankDiv" style="display: none;">
		<label for="bank">Banknaam</label>
		<input type="text" class="form-control" name="bank" id="bank" value="">
	</div>

	<div class="md-form" id="banknumberDiv" style="display: none;">
		<label for="banknumber">Rekeningnummer</label>
		<input type="text" class="form-control" name="banknumber" id="banknumber" value="">
	</div>

	<button type="submit" name="registerseller">Word verkoper</button>
</form>
<script>
function updateForm() {
  if (document.getElementById("checkoption").value == "post") {
    document.getElementById("bankDiv").style.display = "block";
		document.getElementById("banknumberDiv").style.display = "block";
		document.getElementById("bank").required = true;
		document.getElementById("banknumber").required = true;
  } else {
		document.getElementById("bankDiv").style.display = "none";
		document.getElementById("banknumberDiv").style.display = "none";
		document.getElementById("bank").required = false;
		document.getElementById("banknumber").required = false;
	}
	if (document.getElementById("checkoption").value == "creditcard") {
    document.getElementById("creditcardDiv").style.display = "block";
		document.getElementById("creditcard").required = true;
  } else {
		document.getElementById("creditcardDiv").style.display = "none";
		document.getElementById("creditcard").required = false;
	}
}

document.getElementById("checkoption").onchange = updateForm;
</script>
