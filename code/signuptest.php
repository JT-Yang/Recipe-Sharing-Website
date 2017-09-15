<!DOCTYPE html>
<html>
<head>
</head>
<body>
  <?php
  require_once("dbconfig.ini.php");
    if ($conn->connect_errno ){
      die("Connectino failed: ".$conn->connect_error);
    }else{
      echo "fdaf";
    } 
    $email="jb@gmail.com";
    $password="justing";
    $SQL="SELECT username, password FROM User where email='$email'";
   $res= $conn->query($SQL) or die('SQL Error：'.$conn->errno);

   $row = $res->fetch_assoc();
   //$count = mysql_num_rows($res); // if uname/pass correct it returns must be 1 row
   

   echo $count;
   if(  $row['password']==$password ) {
    $_SESSION['user'] = $row['username'];
    echo "right";
    //header("Location: home.php");
   } else {
     echo "Incorrect Credentials, Try again...";
   }  
  ?>

</body>
</html>