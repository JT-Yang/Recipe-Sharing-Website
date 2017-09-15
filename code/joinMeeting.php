<?php
   ob_start();
   session_start();
   require_once 'dbconfig.ini.php';
   
    //if session is not set this will redirect to login page
   if( !isset($_SESSION['user']) ) {
    header("Location: index.html");
    exit;
   }

   $mid="";
   if(isset($_GET['mid'])){
    $mid=$_GET['mid'];
    $mid = intval($mid);
    
   }

   
   
   //$res= $conn->query($SQL) or die('SQL Error：'.$conn->errno);
  //$SQL = "INSERT INTO MeetingMember(mid, username, sendRSVP) values('?', '?','0') ";

$SQL = "INSERT INTO MeetingMember(mid, username, sendRSVP) values($mid, '$_SESSION[user]',0)";

   //$res= $conn->query($SQL) or die('SQL Error：'.$conn->errno);

  // $stmt = $conn->prepare($SQL);
  $res = $conn->query($SQL) or die('SQL Error：'.$conn->errno);;

    
      //$stmt->bind_param("dsd", $mid, $_SESSION['user']);
    //$stmt->execute();
    
       if($res){
        
        //echo "<script>alert(you are successfully joined ...); </script>";
         
          header('Location:meeting_display.php?mid='.$mid);
            }
       else{
        echo "Sorry You Could Not Join !";
       }
     

 ?>
