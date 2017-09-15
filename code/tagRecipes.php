<?php
 ob_start();
 session_start();
 require_once 'dbconfig.ini.php';
 
  //if session is not set this will redirect to login page
 if( !isset($_SESSION['user']) ) {
  header("Location: index.html");
  exit;
 }

$tagname="";
if(isset($_GET['tagname'])){
  $tagname=$_GET['tagname'];
}

$sqltag = "SELECT r.rid, r.username,r.title,r.posttime, r.picture from RecipeTag re join Recipe r on re.rid = r.rid where re.tname = '$tagname' order by r.rid ";
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
 



 <div class="jumbotron" style="margin: 0; height:146px;padding-top: 20px">
    <div class="container" align="center" style="background-image: url('backgroundHome.jpg')">
      <h2 class="text-info" style="font-family:;font-weight:bold;font-size:30px;padding-top:-20px">Hi, <?php echo $_SESSION['user']; ?>!</h2>
      <div class="text-muted" style="font-size:20px">Recipes with a tag!.</div>
    </div>
  </div>
<br>

 
    
        
        <div class="row">
          <div class="col-sm-1"></div>
          <div class="col-sm-10">
          <h2> Recipes with the tag: <?php echo $tagname ?></h2>
            <table class="table table-striped">
              <thead >
                <th> ID</th>
                <th>Made By</th>
                 <th >Title</th>
                 
                 
                 <th>Post Time</th>
                 <th>Picture</th>
              </thead>
              <tbody>
              <?php
               // while($row = $res->fetch_assoc()){
              while ($tagRow=$restag->fetch_assoc()) {
                  echo "<tr >";
                 
                 // echo "<td><a href=recipe_display.php?rid=$rid target=_blank>$avrRow[r.title]</a></td>";
               //   echo "<td>$avrRow[r.username]</td>";

               // echo "<td>$avrRow[avr]</td>"; 
            //echo "</tr >";
                  $i=0;
             foreach($tagRow as $column){
              if($i==0){
                echo "<td><a href=recipe_display.php?rid=$column target=_blank>$column</a></td>";
                $i=$i+1;
                continue;
              }

              if($i==4){
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
          
          
        
         
         </div>
       </div>
    
   
    
    
    
</body>
</html>
<?php ob_end_flush(); ?>