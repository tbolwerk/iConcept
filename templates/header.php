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

}
?>
<!DOCTYPE html>
<html lang="en" class="full-height">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Material Design Bootstrap</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
    <!-- Montserrat font -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="css/mdb.min.css" rel="stylesheet">
    <!-- Your custom styles (optional) -->
    <link href="css/style.css" rel="stylesheet">
    <!-- Search overlay styles -->
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/component.css">

</head>
<?php
if ($current_page == 'login' || $current_page == 'register') {
  include 'templates/logo_nav.php';
} else {
  include 'templates/nav.php';
}


?>
<body>
