<?php
   ob_start();
   session_start();
   require_once 'dbconfig.ini.php';
   
    //if session is not set this will redirect to login page
   if( !isset($_SESSION['user']) ) {
    header("Location: index.html");
    exit;
   }
   
   $rid="";
   if(isset($_GET['rid'])){
      $rid=$_GET['rid'];
    }
    $rid = intval($rid);
    
    $rname="";
   if(isset($_GET['rname'])){
      $rname=$_GET['rname'];
    }


   $SQL = "SELECT username, rtitle, reviews, rating,suggestions, picture from Review where rid = $rid";
   $res= $conn->query($SQL) or die('SQL Error：'.$conn->errno);
   
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
      <div class="text-muted" style="font-size:20px">Reviews can help you better.</div>
    </div>
  </div>
  <br>


 <div class="container">
 <div class="row">

    <div class="col-sm-1">
    </div>

  <div class="col-sm-10", style="text-align: center">

    <h2> Reviews for <?php echo  $rname; ?></h2>
  
    <br>
    
      
      
    
      
    
      
       <h3>Reviews</h3>
    <table class="table table-striped">
      <thead >
         <th >Reviewed By</th>
         <th>title</th>
         <th>contents</th>
         <th>rating score</th>
         <th>suggestion</th>
      </thead>
      <tbody>
      <?php
       while($row = $res->fetch_assoc()){
          echo "<tr >";
         // echo "<td><a href=group_display.php?gid=$row[gid] target=_blank>$row[gid]</a></td>";
         // echo "<td>$row[gname]</td>";
        //  echo "<td>$row[creater]</td>"; 
          echo "<td>$row[username]</a></td>";
          echo "<td>$row[rtitle]</td>";
        echo "<td>$row[reviews]</td>"; 
        echo "<td>$row[rating]</td>"; 
        echo "<td>$row[suggestion]</td>"; 
        echo "<td><img src=$row[picture] width=160 height=100></td>"; 
          echo '</tr>';
        }
        ?>
      </tbody>
    </table>


</div>
</div>
</div>

</body>
</html>