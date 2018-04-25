<!DOCTYPE html>

<?php
$current_page='verification';
require('templates/header.php');

if(isset($_GET['code'])){
 verification($_GET['code']);
}
?>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>

<body>
	<br><br><br>
	<p>Code Geldig: <?=$codeValid?></p>
	<p>Opgegeven Code: <?=$submittedCode?></p>
	<p>Verstreken tijd: <?=$deltaTime?></p>
	<p><?php print_r($resultaten);?></p>
</body>

</html>
