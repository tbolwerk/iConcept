<?php
function displayColumn(){

	global $dbh;
	global $column;
  $column = "";
  try{
    $data = $dbh->query("SELECT * FROM Rubriek");
    while($row = $data->fetch()){
			if($row['rubrieknummerOuder'] == -1){//als rubrieknummerOuder == -1 geeft hoofdrubrieken
      $column.="<a href='rubriek.php?rubrieknummer=".$row['rubrieknummer']."'>".$row['rubrieknaam']."</a>";
		}else if(isset($_GET['rubrieknummer'])){//als er een get request is , zoekt bij behorende rubrieknummerOuder
			if($row['rubrieknummerOuder'] == $_GET['rubrieknummer']){
				$column.="<a href='rubriek.php?rubrieknummer=".$row['rubrieknummer']."'>".$row['rubrieknaam']."</a>";
			}
		}
    }
    }catch(PDOException $e){
      $column = $e;
  }
}
?>
