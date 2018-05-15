<?php

//Including Database configuration file.

include "db.php";

//Getting value of "search" variable from "script.js".

if (isset($_POST['search'])) {
  $name = $_POST['search'];
  $statement = $dbh->prepare("SELECT * FROM Rubriek WHERE rubrieknaam LIKE ?");
  $statement->execute(array("%".$name."%"));
  echo "<ul>";
  while($row = $statement->fetch()){
?>

   <!-- Creating unordered list items.

        Calling javascript function named as "fill" found in "script.js" file.

        By passing fetched result as parameter. -->

   <li onclick='fill("<?php echo $row['rubrieknaam']; ?>")'>

   <a>

   <!-- Assigning searched result in "Search box" in "search.php" file. -->

       <?php echo $row['rubrieknaam']; ?>

   </li></a>

   <!-- Below php code is just for closing parenthesis. Don't be confused. -->
   <?php
}}
?>
</ul>
