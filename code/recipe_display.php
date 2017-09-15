<?php
   ob_start();
   session_start();
   require_once 'dbconfig.ini.php';
   
    //if session is not set this will redirect to login page
   if( !isset($_SESSION['user']) ) {
    header("Location: index.html");
    exit;
   }
   
   if(isset($_GET['rid'])){
      $rid=$_GET['rid'];
    }
    $rid = intval($rid);
    


   $SQL="SELECT rid, username, title, description, serving, direction, cooktime, picture FROM Recipe where rid = $rid";
   $res= $conn->query($SQL) or die('SQL Error：'.$conn->errno);
   $userRow = $res->fetch_assoc();
   $pic = $userRow['picture'];
   $rname=$userRow['title'];

   $sql = "SELECT iname, amount, unit from RecipeIngredient where rid = $rid";
   $resIngredient= $conn->query($sql) or die('SQL Error：'.$conn->errno);

  $sqlavr = "SELECT rid, avg(rating) as avr from Review where rid = $rid Group By rid";
   $resavr= $conn->query($sqlavr) or die('SQL Error：'.$conn->errno);
   $avrRow = $resavr->fetch_assoc();
   
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
      <div class="text-muted" style="font-size:20px">Check out your intersting recipes.</div>
    </div>
  </div>
  <br>


 <div class="container">
 <div class="row">

    <div class="col-sm-3">
    </div>

  <div class="col-sm-6", style="text-align: center">


    <h2> <?php echo  $userRow['title']; ?></h2>
    <p> -----By <a href=userRecipes.php?username=<?php echo $userRow['username'] ?>  target=_blank> <?php echo  $userRow['username']; ?></a></p><br>
    <h5> Average rating score: <?php echo  $avrRow['avr']; ?></h5><br>
    <h5> ( <?php echo  $userRow['description']; ?> )</h5>
    <br>
    <img src="<?php echo $pic; ?>" class="img-rounded" alt="Recipe photo." width="480" height="300" /><br>
  
   <br>
    
    <div style="text-align: left">
      <div>
      <div class="form-group"> 
        <div class="">
          <a href="listReviews.php?rid=<?php echo $rid; ?>&&rname=<?php echo $rname; ?>" class="btn btn-danger" role="button">List reviews</a>
        </div>
      </div>
      <div>

        <h3>Cooktime </h3><p style="font-size:15px"><?php
          echo " $userRow[cooktime]"
        ?></p>
      
        
        <h3>Serving </h3><p style="font-size:15px"> <?php
          echo "$userRow[serving]"
        ?></p>
       

      <div>
      <h3>Ingredient</h3>
      <?php
      while($ingredientRow = $resIngredient->fetch_assoc()){
        echo "<p style=font-size:15px> $ingredientRow[iname]: $ingredientRow[amount] $ingredientRow[unit]</p>";
      }
      ?>
      </div>
    </div>
   

    <div style="text-align: left">
      <h3>Direction</h3>
      <?php
      $separator = "\r\n";
      $line = strtok($userRow['direction'], $separator);

      while($line !== false){
        echo "<p style=font-size:15px>$line </p>";
        $line = strtok( $separator );
        
      }
      ?>
    </div>

      <div class="form-group"> 
        <div class="">
          <a href="addReviews.php?rid=<?php echo $rid; ?>" class="btn btn-info" role="button">Write a review</a>
        </div>
      </div>


    
    


  </div>
</div>
</div>

</body>
</html>