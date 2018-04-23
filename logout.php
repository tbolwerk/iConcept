<?php
/**
 * Created by PhpStorm.
 * User: t-twa
 * Date: 25-12-2017
 * Time: 15:10
 */
session_start();
session_destroy();
header("Location:index.php");

?>