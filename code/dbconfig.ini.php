<?php
  define('DBHOST', 'localhost');
  define('DBUSER', 'root');
  define('DBPASS', '3035651');
  define('DBNAME', 'cooking');

  $conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
    if ($conn->connect_errno ){
      die("Connectino failed: ".$conn->connect_error);
    } 
 ?>