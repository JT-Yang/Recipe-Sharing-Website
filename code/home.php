<?php
 ob_start();
 session_start();
 require_once 'dbconfig.ini.php';
 
  //if session is not set this will redirect to login page
 if( !isset($_SESSION['user']) ) {
  header("Location: index.html");
  exit;
 }

$sqlavr = "SELECT r.rid, r.username,r.title,avg(re.rating),r.posttime, r.picture as avr from Review re join Recipe r on re.rid = r.rid Group By r.rid order by avr DESC limit 5";
   $resavr= $conn->query($sqlavr) or die('SQL Error：'.$conn->errno);
   
  $sqllst = "SELECT r.rid, r.username,r.title,  avg(re.rating),r.posttime,r.picture as avr from Review re join Recipe r on re.rid = r.rid Group By r.rid order by r.posttime DESC limit 5";
   $reslst= $conn->query($sqllst) or die('SQL Error：'.$conn->errno);

   $sqltag="SELECT distinct tname From RecipeTag";
   $restag= $conn->query($sqltag) or die('SQL Error：'.$conn->errno);


if(isset($_POST['btn-search']))
   {    
      $keyword = $_POST['keyword'];
       if (empty($keyword)) {
         header("Location:searchRecipes.php");
       } else{
        header("Location:listRecipes.php?keyword=$keyword");
       }
  }
 
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Welcome - <?php echo $$_SESSION['user'] ?></title>
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
      <li class="active"><a href="#">Home</a></li>
      <li><a href="#">About</a></li>
      <li><a href="#">Contact</a></li>
      <li> <form class="navbar-form " role="search" id="navBarSearchForm" method="post">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Find a recipe" name="keyword" id="keyword">
            <div class="input-group-btn">
                <button class="btn btn-default" type="submit" name="btn-search"><i class="glyphicon glyphicon-search"></i></button>
            </div>
        </div>
        </form>

        <style>
            #navBarSearchForm input[type=text]{width:430px !important;}
        </style></li>
     
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
     <a href="myRecipes.php"><span class="glyphicon glyphicon-star"></span>&nbsp;My Recipes</a>       
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
 
</div>
  <style>
    div.item img{
      width:100%;
      background-size: contain;
    }
    div#carousel-example-generic{
     width:100%;
     margin:0 auto;
    }
  </style>

  <div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="5000">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
    <li data-target="#carousel-example-generic" data-slide-to="3"></li>
  </ol>
 
  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active">
      <img src="img/slide1.jpg" >
    </div>
    <div class="item">
            <img src="img/slide2.jpg" >
    </div>
    <div class="item">
            <img src="img/slide3.jpg" >
    </div>
 
    <div class="item">
            <img src="img/slide4.jpg" >
    </div>
 
  </div>
</div>


 <div class="jumbotron" style="margin: 0; height:146px;padding-top: 20px">
    <div class="container" align="center" style="background-image: url('backgroundHome.jpg')">
      <h2 class="text-info" style="font-family:;font-weight:bold;font-size:30px;padding-top:-20px">Hi, <?php echo $_SESSION['user']; ?>!</h2>
      <div class="text-muted" style="font-size:20px">Now it's time to play in Cookzilla!.</div>
    </div>
  </div>
<br>

 
    
        
        <div class="row">
          <div class="col-sm-1"></div>
          <div class="col-sm-10">
          <h2>Top 5 rated Recipes!</h2>
            <table class="table table-striped">
              <thead >
                <th> ID</th>
                <th>Made By</th>
                 <th >Title</th>
                 
                 <th>Rating Score</th>
                 <th>Post Time</th>
                 <th>Picture</th>
              </thead>
              <tbody>
              <?php
               // while($row = $res->fetch_assoc()){
              while ($avrRow=$resavr->fetch_assoc()) {
                  echo "<tr >";
                 
                 // echo "<td><a href=recipe_display.php?rid=$rid target=_blank>$avrRow[r.title]</a></td>";
               //   echo "<td>$avrRow[r.username]</td>";

               // echo "<td>$avrRow[avr]</td>"; 
            //echo "</tr >";
                  $i=0;
             foreach($avrRow as $column){
              if($i==0){
                echo "<td><a href=recipe_display.php?rid=$column target=_blank>$column</a></td>";
                $i=$i+1;
                continue;
              }

              if($i==5){
                echo "<td><img src=$column width=120 height=80></td>";
                break;
               }
               echo "<td>$column</td>";
               $i=$i+1;
               
              }
             echo "</tr>";
             }
                   
                
                ?>
              </tbody>
            </table>

          </div>
        </div>
          
         <div class="row">
        <div class="col-sm-1"></div>
          <div class="col-sm-10">
          <h2>Top 5 Latest Recipes!</h2>
            <table class="table table-striped">
              <thead >
                <th> ID</th>
                 
                 <th>Made By</th>
                 <th >Title</th>
                 <th>Rating Score</th>
                 <th>Post Time</th>
                 <th>Picture</th>
                </thead>
              <tbody>
              <?php
               // while($row = $res->fetch_assoc()){
              while ($lstRow=$reslst->fetch_assoc()) {
                  echo "<tr >";
                 
                 // echo "<td><a href=recipe_display.php?rid=$rid target=_blank>$avrRow[r.title]</a></td>";
               //   echo "<td>$avrRow[r.username]</td>";

               // echo "<td>$avrRow[avr]</td>"; 
            //echo "</tr >";
                  $j=0;
             foreach($lstRow as $column){
              if($j==0){
                echo "<td><a href=recipe_display.php?rid=$column target=_blank>$column</a></td>";
                $j=$j+1;
                continue;
              }

              if($j==5){
                echo "<td><img src=$column width=120 height=80></td>";
                break;
               }
               echo "<td>$column</td>";
               $j=$j+1;
              }
             echo "</tr>";
             }
                   
                
                ?>
              </tbody>
            </table>
          </div>
          </div>
          </div>
          
          <div class="row"</div>
            <div class="col-sm-1"></div>
            <div class="col-sm-8">
            <h4>Tags</h4>
            <?php

              while ($tagRow=$restag->fetch_assoc()) {
                
                foreach($tagRow as $column){
                  echo "<a href=tagRecipes.php?tagname=$column target=_blank>$column</a>".","." ";
                }

              }

              ?>
         </div>
       </div>
    
   
    
    
    
</body>
</html>
<?php ob_end_flush(); ?>