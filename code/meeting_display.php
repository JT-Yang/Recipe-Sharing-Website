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
    }
    $mid = intval($mid);
    


   $SQL = "SELECT mname, organizer, starttime, endtime, mdescription, location From GroupMeeting where mid = $mid";
   //$res= $conn->query($SQL) or die('SQL Error：'.$conn->errno);
   //$userRow = $res->fetch_assoc();
   $stmt = $conn->prepare($SQL);
    
       if($stmt->execute()){
        $stmt->bind_result($mname, $organizer, $starttime, $endtime, $description, $location);
        
        }
       while($stmt->fetch()){
        $mn = $mname;
        $or = $organizer;
        $st = $starttime;
        $et = $endtime;
        $ds=$description;
        $lc=$location;
       }
   
 ?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>check groups</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
  <nav class="navbar navbar-inverse" style="margin: 0">
  <div class="container">
    <div class="navbar-header" >
      <a class="navbar-brand" href="#">cookzilla</a>
    </div>

    <ul class="nav navbar-nav">
      <li><a href="home.php">Home</a></li>
      <li><a href="#">About</a></li>
      <li><a href="#">Contact</a></li>
    </ul>

<ul class="nav navbar-nav navbar-right">
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
     <span class="glyphicon glyphicon-user"></span>&nbsp; <?php echo $_SESSION['user']; ?>&nbsp;<span class="caret"></span></a>
              
  
  <ul class="dropdown-menu" >
    <li>
     <a href="addRecipes.php"><span class="glyphicon glyphicon-cutlery"></span>&nbsp;Add a Recipe</a>       
    </li>

    <li>
     <a href="myRecipes.php"><span class="glyphicon glyphicon-cutlery"></span>&nbsp;My Recipes</a>       
    </li>

    <li role="presentation">
     <a href="profile.php"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;Profile</a>        
    </li>

    <li role="presentation">
     <a href="#"><span class="glyphicon glyphicon-heart"></span>&nbsp;Favorate</a>        
    </li>

    <li role="presentation">
     <a href="#"><span class="glyphicon glyphicon-flag"></span>&nbsp;Group</a>        
    </li>

    <li role="presentation">
     <a href="#"><span class="glyphicon glyphicon-comment"></span>&nbsp;Friends</a>        
    </li>

          <li role="presentation" class="divider"></li>   

      <li role="presentation">
      <a href="index.html"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Log out</a></li>
  </li>
  </ul>
</li>
</ul>
</div>  
</nav>
  
  <div class="jumbotron" style="margin: 0; height:146px;padding-top: 20px">
    <div class="container" align="center" style="background-image: url('backgroundHome.jpg')">
      <h2 class="text-info" style="font-family:;font-weight:bold;font-size:30px;padding-top:-20px">Hi, <?php echo $_SESSION['user']; ?>!</h2>
      <div class="text-muted" style="font-size:20px">Check out your interesting meetings.</div>
    </div>
  </div>
  <br>


 <div class="container">
 <div class="row">

    <div class="col-sm-3">
    </div>

  <div class="col-sm-6", style="text-align: center">

    <h2> <?php echo  "Meeting".strval($mid).": ".$mname; ?></h2>
    <p> -----By <a href=userMeetings.php?username=<?php echo $organizer ?>  target=_blank> <?php echo  $organizer; ?></a></p><br>
    <h5> Description: <?php echo  $description; ?> </h5>
    <br>
    <h5> Star Time: <?php echo  $starttime; ?> </h5>
    <br>
    <h5> End Time: <?php echo  $endtime; ?> </h5>
    <br>
    <h5> Location: <?php echo  $location; ?> </h5>
    <br>

      
      
    <h3>Meeting Members</h3>
    <table class="table table-striped">
      <thead >
         <th >User Name</th>
         <th>RSVP</th>
         
        
      </thead>
      <tbody>
      <?php
       // while($row = $res->fetch_assoc()){
      $sqlm = "SELECT username , sendRSVP from MeetingMember where mid = $mid";
      $res = $conn->query($sqlm) or die('SQL Error：'.$conn->errno);

      while ($row = $res->fetch_assoc()) {
      
          echo "<tr>";
         // echo "<td><a href=group_display.php?gid=$row[gid] target=_blank>$row[gid]</a></td>";
         // echo "<td>$row[gname]</td>";
        //  echo "<td>$row[creater]</td>"; 
          echo "<td><a href=userMeetings.php?mid=$mid target=_blank>$row[username]</a></td>";
        echo "<td>$row[sendRSVP]</td>"; 

        }
        ?>
      </tbody>
    </table>
  


</div>
</div>
</div>

</body>
</html>