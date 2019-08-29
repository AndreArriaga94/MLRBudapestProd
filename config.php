<?php
$user = 'root';
$password = 'root';
$db = 'UMG_PROD_GT';
$host = 'localhost';
$port = 8889;

$link = mysqli_init();
$success = mysqli_real_connect(
   $link,
   $host,
   $user,
   $password,
   $db,
   $port
);

/* Connect to MySQL */
$connection = mysqli_connect($host, $user, $password) or die ('Unable to connect to MySQL server.<br ><br >Please make sure your MySQL login details are correct.');


$db = mysqli_select_db($connection, $db);

?>