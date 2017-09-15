<?php
   ob_start();
   session_start();
   require_once 'dbconfig.ini.php';
   
    //if session is not set this will redirect to login page
   if( !isset($_SESSION['user']) ) {
    header("Location: index.html");
    exit;
   }

   
   $SQL = "SELECT c.gid, c.gname,c.creater from cookingGroup c natural join GroupMember G where g.username='$_SESSION[user]'";
  
   //$res= $conn->query($SQL) or die('SQL Error：'.$conn->errno);

   $stmt = $conn->prepare($SQL);
    
       if($stmt->execute()){
        $stmt->bind_result($gid, $gname, $creater);
        
        }
       
   
 ?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome - <?php echo $userRow['username']; ?></title>
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
     <a href="group.php"><span class="glyphicon glyphicon-flag"></span>&nbsp;Group</a>        
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
      <div class="text-muted" style="font-size:20px">Check out groups your joint.</div>
    </div>
  </div>
  <br>


 <div class="container">
 <div class="row">

    <div class="col-sm-3">
    </div>

  <div class="col-sm-6">
    <table class="table table-striped">
      <thead >
         <th >groupID</th>
         <th>name</th>
         <th>creater</th>
      </thead>
      <tbody>
      <?php
       // while($row = $res->fetch_assoc()){
      while ($stmt->fetch()) {
          echo "<tr >";
         // echo "<td><a href=group_display.php?gid=$row[gid] target=_blank>$row[gid]</a></td>";
         // echo "<td>$row[gname]</td>";
        //  echo "<td>$row[creater]</td>"; 
          echo "<td><a href=groupMeeting.php?gid=$gid target=_blank>$gid</a></td>";
          echo "<td>$gname</td>";
        echo "<td>$creater</td>"; 
          
          echo '</tr>';
        }
        ?>
      </tbody>
    </table>
    <div >
    <div class="col-sm-4">
    </div>
      <a href="createGroup.php" target=_blank class="btn btn-danger" role="button">Create a Group</a>    <p>   </p>
     
  </div>
</div>
</div>

</body>
</html>