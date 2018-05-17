function livesearch($post_livesearch){
  global $dbh;
  global $rubrieken;
  global $subrubrieken;
  global $veilingen;

//Getting value of "search" variable from "script.js".
$return ="";
$rubrieken="";
$name = $post_livesearch;
  // $name = $_POST['livesearch'];
  try{
  $statement = $dbh->prepare("SELECT * FROM Rubriek WHERE rubrieknaam LIKE ? AND rubrieknummerOuder=-1");
  $statement->execute(array("%".$name."%"));
}catch(PDOException $e){
  $error = $e;
}

  while($row = $statement->fetch()){
    $rubrieknaam = $row['rubrieknaam'];
    $function = "fill('".$rubrieknaam."')";
    $rubrieken.="<li onclick='".$function."'><a href='#'>".$rubrieknaam."</li></a>";
  }
  //Sub-rubrieken
  $subrubrieken="";
  try{
    $statement = $dbh->prepare("SELECT * FROM Rubriek WHERE rubrieknaam LIKE ? AND rubrieknummerOuder!=-1 AND rubrieknummerOuder!=1");
    $statement->execute(array("%".$name."%"));
  }catch(PDOException $e){
    $error = $e;
  }

  while($row = $statement->fetch()){
    $rubrieknaam = $row['rubrieknaam'];
    $function = "fill('".$rubrieknaam."')";
    $subrubrieken.="<li onclick='".$function."'><a href='#'>".$rubrieknaam."</li></a>";
  }

  $veilingen="";
  try{
    $statement = $dbh->prepare("SELECT * FROM Voorwerp where titel LIKE ?");
    $statement->execute(array("%".$name."%"));
  }catch(PDOException $e){
    $error = $e;
  }

  while($row = $statement->fetch()){
    $voorwerptitel = $row['titel'];
    $function = "fill('".$rubrieknaam."')";
    $veilingen.="<li onclick='".$function."'><a href='#'>".$voorwerptitel."</li></a>";
  }


}
