<?php
if(!isset($_SESSION['username'])){header('Location: index.php');}
$current_page='register_seller';
require_once('templates/header.php');
require_once('templates/connect.php');
require_once("templates/userpage/f_createVerificationCodeSeller.php");
require_once("templates/userpage/f_registerSeller.php");
$username = $_SESSION['username'];

if(isset($_POST['registerseller'])){
  registerSeller($username, $_POST['checkoption'],$_POST['creditcard'],$_POST['bank'],$_POST['banknumber']);
}

?>



<form method="post" action="">
	<div class="userpage-form-header">
		<h1>Verkoper worden</h1>
	</div>

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
		<div class="form-requirements black-text">
			<ul>
				<li>Enkel getallen</li>
				<li>Maximaal 19 getallen</li>
			</ul>
		</div>
	</div>

	<div class="md-form" id="bankDiv" style="display: none;">
		<label for="bank">Banknaam</label>
		<input type="text" class="form-control" name="bank" id="bank" value="">
		<div class="form-requirements black-text">
			<ul>
				<li>Banknaam maximaal 75 karakters</li>
			</ul>
		</div>
	</div>

	<div class="md-form" id="banknumberDiv" style="display: none;">
		<label for="banknumber">Rekeningnummer</label>
		<input type="text" class="form-control" name="banknumber" id="banknumber" value="">
		<div class="form-requirements black-text">
			<ul>
				<li>Mag maximaal 34 karakters bevatten</li>
			</ul>
		</div>
	</div>

	<div class="py-1 mt-3 text-center">
  <button class="btn elegant" type="submit" name="registerseller">Word verkoper</button>
</div>
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
