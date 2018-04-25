<?php
$current_page='register';
require('templates/header.php');


 verification($_GET['username'],$_GET['code']);

?>


	<br><br><br>
	<p>Code Geldig: <?=$codeValid?></p>
	<p>Opgegeven Code: <?=$submittedCode?></p>
	<p>Verstreken tijd: <?=$deltaTime?></p>
	<p><?php print_r($results);?></p>
<?php include('templates/footer.php'); ?>
