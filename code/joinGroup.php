<?php
   ob_start();
   session_start();
   require_once 'dbconfig.ini.php';
   
    //if session is not set this will redirect to login page
   if( !isset($_SESSION['user']) ) {
    header("Location: index.html");
    exit;
   }

   $gid="";
   if(isset($_GET['gid'])){
    $gid=$_GET['gid'];
    $gid = intval($gid);
    
   }

   
   
   //$res= $conn->query($SQL) or die('SQL Error：'.$conn->errno);
 // $SQL = "INSERT INTO GroupMember(gid, username) values('?', '?') ";

$SQL = "INSERT INTO GroupMember(gid, username) values($gid, '$_SESSION[user]')";  

 //  $stmt = $conn->prepare($SQL);
  $res = $conn->query($SQL) or die('SQL Error：'.$conn->errno);

    
     // $stmt->bind_param("ds", $gid, $_SESSION['user']);
    //$stmt->execute();
    
       if($res){
        
        //echo "<script>alert(you are successfully joined ...); </script>";
         
          header('Location:group_display.php?gid='.$gid);
            }
       else{
        echo "Sorry You Could Not Join !";
       }
     

 ?>
