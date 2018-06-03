<?php
function logout() {
  /**
   * Created by PhpStorm.
   * User: t-twa
   * Date: 25-12-2017
   * Time: 15:10
   */
  //session: all data is retrieved
  session_start();
  //all retrieved data gets deleted
  session_destroy();
  //after the delete, the website redirects to the index
  header("Location:index.php");
}
?>
