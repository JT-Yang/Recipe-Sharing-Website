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
    }
    $gid = intval($gid);
    


   $SQL = "SELECT gname, description,creater from CookingGroup where gid = $gid";
   $res= $conn->query($SQL) or die('SQL Error：'.$conn->errno);
   $userRow = $res->fetch_assoc();
   

   $sql = "SELECT username from groupMember where gid = '$gid'";
   $stmt = $conn->prepare($sql);
    
       if($stmt->execute()){
        $stmt->bind_result($username);
        
        }
   //$resMember= $conn->query($sql) or die('SQL Error：'.$conn->errno);

   //$sqlm = "SELECT mid, mname, organizer, starttime, endtime, mdescription, location From GroupMeeting where gid = '$gid'";
   
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

    <h2> <?php echo  "Group".strval($gid).": ".$userRow['gname']; ?></h2>
    <p> -----By <a href=userGroups.php?username=<?php echo $userRow['creater'] ?>  target=_blank> <?php echo  $userRow['creater']; ?></a></p><br>
    <h4> description: <?php echo  $userRow['description']; ?> </h4>
    <br>
    
      
      
    
      <?php
      echo "<h4>Members: </h4>";
       // while($row = $resMember->fetch_assoc()){
       while ($stmt->fetch()) {
        
          echo "<a href=userGroups.php?username=$username>$username</a>";  
          echo ".  ";
         
        }
        ?>
    <br>
       <br>
       <h3>Meetings</h3>
    <table class="table table-striped">
      <thead >
         <th >Meeting ID</th>
         <th>Meeting Name</th>
         <th>Organizer</th>
         <th></th>
      </thead>
      <tbody>
      <?php
       // while($row = $res->fetch_assoc()){
      $sqlm="SELECT mid, mname, organizer From GroupMeeting where gid='$gid'";
        $stmt=$conn->prepare($sqlm);
        if($stmt->execute()){
        $stmt->bind_result($mid, $mname, $organizer);
        
        }
      while ($stmt->fetch()) {
          echo "<tr >";
         // echo "<td><a href=group_display.php?gid=$row[gid] target=_blank>$row[gid]</a></td>";
         // echo "<td>$row[gname]</td>";
        //  echo "<td>$row[creater]</td>"; 
          echo "<td><a href=meeting_display.php?mid=$mid target=_blank>$mid</a></td>";
          echo "<td>$mname</td>";
        echo "<td>$organizer</td>"; 
          echo "<td><a href=joinMeeting.php?mid=$mid target=_blank>Join</a></td>";
          echo '</tr>';
        }
        ?>
      </tbody>
    </table>
  
  <div class="col-sm-4">
    </div>
      <a href="createMeeting.php?gid=<?php echo $gid ?>" target=_blank class="btn btn-danger" role="button">Set a Meeting</a>    <p>   </p>
      <div class="col-sm-4">
    </div>
      <a href="myMeetings.php" target=_blank class="btn btn-info" role="button">My Meetings</a>

      


</div>
</div>
</div>

</body>
</html>