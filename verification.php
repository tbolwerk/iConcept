<?php
$current_page='register';
require('templates/header.php');

verification($_GET['username'],$_GET['code']);
?>

<!--
<p>Code Geldig: <?=$codeValid?></p>
<p>Opgegeven Code: <?=$submittedCode?></p>
<p>Verstreken tijd: <?=$deltaTime?></p>
<p><?php print_r($results);?></p>
-->

<main class="py-5 mask rgba-black-light flex-center">
  <div class="bg bg-login"></div>

	<div class="container col-md-4">
		<div class="card login-register-card">
			<div class="card-body">
	    	<div class="login-form-header elegant">
	       	<h3>Account geactiveerd</h3>
	      </div>
				<div class="white-text">
					<p>UW activatie is succesvol afgerond. U kunt nu inloggen.</p>
          <p><a href="index.php">Terug naar hoofdpagina</a></p>
				</div>
			</div>
		</div>
	</div>
</main>

<?php include('templates/footer.php'); ?>
