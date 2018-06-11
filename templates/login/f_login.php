<?php
/*login function */
function login($username_input, $password)
{
  global $dbh;
  global $messages;

	$username = $username_input;
	$email = $username_input;

  // $username=trim($username);
  $password = trim($password);

  $messages = array();

  if (strlen($username) >= 25) {
    $messages['username'] = "Gebruikersnaam heeft meer dan 25 karakters";
  } else
  if (strlen($password) >= 50) {
    $message['password'] = "Wachtwoord heeft meer dan 50 karakters";
  } else
  if (empty($username)) {
    $messages['username'] = "Gebruikersnaam is leeg";
  } else
  if (empty($password)) {
    $messages['password'] = "Wachtwoord is leeg";
  } else {
    try { //Attempt to receive data about the user with the submitted credentials
    	$password_check = $dbh->prepare("SELECT * FROM Gebruiker WHERE gebruikersnaam=? OR email=?");

    	$password_check->execute(array($username, $email));
      $password_result =$password_check->fetch(PDO::FETCH_ASSOC);
      $password_from_db = $password_result["wachtwoord"];


    } catch(PDOException $e){
    	$messages = $e;
    }
try{
    if(!isset($password_from_db)){
      $messages['username'] = "Logingegevens zijn onjuist";
    }else
    if(!password_verify($password,$password_from_db)){ //If the result is empty then there are no users with the submitted username+password
    	$messages['password'] = "Logingegevens zijn onjuist";
    } else if ($password_result['geactiveerd'] == 0) { //If the user does exist, check whether the account has been activated
      $messages['verification'] = "Account is nog niet geactiveerd";
    } else if($password_result['geblokkeerd'] == 1){
      $messages['geblokkeerd'] = "Account is geblokkeerd";
    }else{
      $_SESSION['seller'] = $password_result['verkoper'];
      $_SESSION['username'] = $password_result['gebruikersnaam'];
      $_SESSION['email'] = $password_result['email'];
      $_SESSION['firstname'] = $password_result['voornaam'];
      $_SESSION['lastname'] = $password_result['achternaam'];
      $_SESSION['admin'] = 1;


      header('Location: index.php');
    }
  }catch(PDOException $e){
    $messages['username']=$e;
}

}
}
?>
