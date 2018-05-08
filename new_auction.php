<?php

$current_page='new_auction';
require_once('templates/header.php');

function new_auction($title,$description,$startprice,$duration,$pay_method,$pay_instructions,$place,$country,$shipping_costs,$shipping_method)
{
  global $dbh;
  global $errors;
  $errors = array();


if(empty($title))//checks if title is not empty
{
  $errors['title'] = "Dit is een verplicht veld.";
}
if(empty($description))//checks if description is not empty
{
  $errors['description'] = "Dit is een verplicht veld.";
}
if(empty($startprice))//checks if startprice is not empty
{
  $errors['startprice'] = "Dit is een verplicht veld.";
}
if(empty($place))//checks if place is not empty
{
  $errors['place'] = "Dit is een verplicht veld.";
}
if(empty($country))//checks if country is not empty
{
  $errors['country'] = "Dit is een verplicht veld.";
}


if(count($errors) == 0)//checks if there are errors
{
  $current_date = date('Y-m-d');
  $current_time = date('G:i:s');
  $end_date = date('Y-m-d', strtotime($current_date. ' + ' . $duration . 'days'));

  try {
    $objectdata = $dbh->prepare("select top 1 voorwerpnummer from Voorwerp order by voorwerpnummer desc");
    $objectdata->execute();
    $lastid = $objectdata->fetch();
    $id = $lastid[0] + 1;

  } catch (PDOException $e) {
    $error=$e;
    echo $error;
  }


  $seller = $_SESSION['username'];
  echo ($current_date);
  echo ($end_date);
  echo ($current_time);
  echo ($id);
    try {
      $data = $dbh->prepare("insert into Voorwerp(titel, beschrijving, startprijs, betalingswijze, betalingsinstructie, plaatsnaam, land, looptijd, looptijdbegindag, looptijdtijdstip, verzendkosten, verzendinstructies, verkoper, looptijdeindedag, veilinggesloten)
Values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
      $data->execute(array($title, $description, (float)$startprice, $pay_method, $pay_instructions, $place, $country, $duration, $current_date, $current_time, (float)$shipping_costs, $shipping_method, $seller, $end_date, 0));
    } catch (PDOException $e) {
      $error=$e;
      echo $error;
    }
}
}


if(isset($_POST['submit'])){
  new_auction($_POST['title'],$_POST['description'],$_POST['startprice'],$_POST['duration'],$_POST['pay_method'],$_POST['pay_instructions'],$_POST['place'],$_POST['country'],$_POST['shipping_costs'],$_POST['shipping_instructions']);
}
?>
<br><br><br><br>
<form action="" method="post">
  <label>Titel</label>
  <input type="text" name="title"><br>
  <?php if(isset($errors['title'])){echo $errors['title'];}?><br>
  <label>Beschrijving</label>
  <textarea name="description"></textarea><br>
  <?php if(isset($errors['description'])){echo $errors['description'];}?><br>
  <label>Startprijs</label>
  <input type="text" name="startprice"><br>
  <label>Looptijd</label>
  <select name="duration">
    <option value="1">1 dagen</option>
    <option value="3">3 dagen</option>
    <option value="5">5 dagen</option>
    <option value="7" selected>7 dagen</option>
    <option value="10">10 dagen</option>
  </select><br>
  <label>Betalingswijze</label>
  <input type="radio" name="pay_method" value="contant" checked> Contant
  <input type="radio" name="pay_method" value="bank/giro"> Bank/Giro
  <input type="radio" name="pay_method" value="anders"> Anders<br>
  <label>Betalingsinstructies</label>
  <input type="text" name="pay_instructions"><br>
  <label>Plaats</label>
  <input type="text" name="place"><br>
  <label>Land</label>
  <input type="text" name="country"><br>
  <label>Verzendkosten</label>
  <input type="text" name="shipping_costs"><br>
  <label>Verzendinstructies</label>
  <input type="text" name="shipping_instructions"><br>
  <label>Afbeeldingen</label>
  <input name="myFile" type="file"><br>
  <button type="submit" name="submit">Plaats veiling</button>
</form>
