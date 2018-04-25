<?php
$current_page='verification';
require('templates/header.php');


 verification($_GET['code']);

?>



	<p>Code Geldig: <?=$codeValid?></p>
	<p>Opgegeven Code: <?=$submittedCode?></p>
	<p>Verstreken tijd: <?=$deltaTime?></p>
	<p><?php print_r($resultaten);?></p>
<?php include('templates/footer.php'); ?>
