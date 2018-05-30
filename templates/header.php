<?php
session_start();
require_once("functions.php");
displayColumn();

// require_once('functions.php');
switch($current_page){
//Configure header for each page
//Identify page with $current_page variable in php file
  case 'index':
    if(isset($_SESSION['username'])){

    }else{

    }
    break;

  case 'login':
    if(isset($_SESSION['username'])){//when logged in go to home
      header('Location: index.php');
    }
    break;

  case 'register':
    if(isset($_SESSION['username'])){//when logged in go to home
      header('Location: index.php');
    }
    break;

  case 'account':
    if(!isset($_SESSION['username'])){//when not logged in go to login page
      header('Location: login.php');
    }

  case 'overons':
  if(isset($_SESSION['username'])){

  }else{

  }

  case 'auction':

  break;

    case 'userpage':
      echo "<!-- userpage styling -->
      <link rel='stylesheet' href='css/userpage.css'>";
      break;
    case 'rubriek':
      echo "<link rel='stylesheet' href='css/flyPanels.css'>
      <link rel='stylesheet' href='https://www.w3schools.com/w3css/4/w3.css'";
      // ../sidemenu/demo/
      break;
    case 'new_auction':
    if(!$_SESSION['seller']){
      header("Location: index.php");
    }
    break;

}
?>
<!DOCTYPE html>
<html lang="en" class="full-height">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>EenmaalAndermaal - Home</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
    <!-- Montserrat font -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="css/mdb.min.css" rel="stylesheet">
    <!-- Navigation bar styling -->
    <link rel="stylesheet" href="css/nav.css">
    <!-- Login and register forms styling -->
    <link rel="stylesheet" href="css/register-login-styles.css">
    <!-- Your custom styles (optional) -->
    <link href="css/style.css" rel="stylesheet">
    <!-- Styling for the index page -->
    <link rel="stylesheet" href="css/index.css">
    <!-- Category page styling -->
    <link rel="stylesheet" href="css/rubriek.css">
    <!-- Search overlay styles -->
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/component.css">
    <!-- Index carousel -->
    <link rel="stylesheet" href="css/carousel.css">
    <!-- Rubrieken overlay styling -->
    <link rel="stylesheet" href="css/rubrieken_overlay.css">
    <script type="text/javascript" src="js/timer.js"></script>





</head>
<?php
if ($current_page == 'admin_panel'){
  include 'templates/admin_nav.php';
}
else if ($current_page == 'login' || $current_page == 'register') {
  include 'templates/logo_nav.php';
} else {
  include 'templates/nav.php';
}


?>
<body>
