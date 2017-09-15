<?php
   ob_start();
   session_start();
   require_once 'dbconfig.ini.php';
   
    //if session is not set this will redirect to login page
   if( !isset($_SESSION['user']) ) {
    header("Location: index.html");
    exit;
   }
   $rid = $_GET['rid'];
   $ridr = $rid;
   $ridr=intval($ridr);
   $ridb = $_POST['ridb'];
   $ridb=intval($ridb);
   
   $sql="SELECT  username, title FROM Recipe where rid = $ridr";
   echo $sql;
   echo $ridb."ridb";
   echo $ridr."dr";
   $restitle= $conn->query($sql) or die('SQL Error：'.$conn->errno);
   $titleRow = $restitle->fetch_assoc();
   //$SQL="SELECT username, firstname, lastname, address, gender, photo, description FROM User where username='$_SESSION[user]'";
   //$res= $conn->query($SQL) or die('SQL Error：'.$conn->errno);
   //$userRow = $res->fetch_assoc();
      date_default_timezone_set('America/New_York');
       $time = date('Y-m-d H:i:s');
   $error = false;
   $titleErr = $reviewErr = $ratingErr ="";
   if(isset($_POST['btn-submit']))
   {    
       if (empty($_POST["rtitle"])) {
         $titleErr = "Title is needed.";
         $error = true;
       } else {
         $rtitle = test_input($_POST['rtitle']);
       }
       
       if (empty($_POST["review"])) {
         $reviewErr = "Review is needed.";
         $error = true;
       } else {
         $review= test_input($_POST['review']);
       }
         
       if (empty($_POST["rating"])) {
        $error = true;
         $ratingErr = "rating is needed.";
       } else {
         $rating = $_POST['rating'];
         $rating=intval($rating);
       }


          $suggestion = test_input($_POST['suggestion']);
          echo $rtitle;
       echo $review;
       echo $rating;
       echo $suggestion;
       echo $time."s";
       echo $rid;

       

      $imgFile = $_FILES['picture']['name'];
      $tmp_dir = $_FILES['picture']['tmp_name'];
      $imgSize = $_FILES['picture']['size'];
       
       $upload_dir="";
       $userpic="";
      if($imgFile)
      {
         $upload_dir = 'recipe_images/'; // upload directory 
         $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
         $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
         $userpic = rand(1000,1000000).".".$imgExt;
         
         if(in_array($imgExt, $valid_extensions))
         {   
            if($imgSize < 5000000)
            {
             move_uploaded_file($tmp_dir, $upload_dir.$userpic); //upload new image from php temp image dir to upload dir.
            }
            else
            {
             $error = true;
             $errMSG = "Sorry, your image is too large. It should be less then 5MB";
            }
         }
         else
         {
            $error = true;
            $errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";  
         } 
      }
      
          
    
      // if no error occured, continue ....
       //$stmt = $conn->prepare("INSERT Into Recipe(username, title, description,serving, direction,cooktime, picture, posttime) values(?,?,?,?,?,?,?,?)");

      // $stmt->bind_param("ssssssss", $_SESSION['user'],$title, $description, $serving, $direction, $cooktime,$upload_dir.$userpic,strtotime($date));
      $reviewPic = $upload_dir.$userpic;
    if(!$error){
       $SQL="INSERT Into Review(username, rid, rtime, rtitle, reviews,rating, suggestions,picture) values('$_SESSION[user]','$ridb','$time','$rtitle','$review', '$rating', '$suggestions', '$reviewPic')";
       echo $SQL;
      $res= $conn->query($SQL) or die('SQL Error：'.$conn->errno);
      
        $result=$conn->query("SELECT LAST_INSERT_ID()");
        $row = $result->fetch_assoc();
        $reviewid = $row['LAST_INSERT_ID()'];
        $reviewid = intval($rid);
       //if($stmt->execute()){
      //insert ingredient here through a loop.
        //Ingredient name and tag name should not same.
        //if(count($iname)!==count(array_unique($iname))){}

        if($results){
        ?>
        <script>
          alert('Recipe is successfully added ...');
          //window.location.href='home.php?rid=',$rid;
        </script>
        <?php 
      }
       else{
        $errMSG = "Sorry Review Could Not Added !";
       }
    }
  }
   function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
   }
 ?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Your Recipes - <?php echo $userRow['username']; ?></title>
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
     <a href="myRecipes.php"><span class="glyphicon glyphicon-star"></span>&nbsp;My Recipes</a>       
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
      <div class="text-muted" style="font-size:20px">Add a review.</div>
    </div>
  </div>
  <br>

<div  style="text-align: center">
<h3> <?php echo  $titleRow['title']; ?></h3>
    <p> -----By <a href=userRecipes.php?username=<?php echo $titleRow['username'] ?>  target=_blank> <?php echo  $titleRow['username']; ?></a></p><br>
</div>
 <div class="container" >
 <div class="row">
  <div class="col-sm-2">
  </div>
  <form class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>?ridb=$rid" enctype="multipart/form-data">

  <div class="col-sm-8">
          
      <div class="form-group">
      <label class="control-label " for="sel1">Rating:</label>
     
        <select id="sel1" name="rating">
          <option>5</option>
          <option>4</option>
          <option>3</option>
          <option>2</option>
          <option>1</option>
        </select>
    
      </div>

      <div class="form-group"> 
          <label class="control-label " for="user">Title:</label>
          <input type="text" class="form-control" id="recipe_title"  name="rtitle" placeholder="Enter review title" value="<?php echo $rtitle ?>">
          <span class="text-danger"><?php echo $titleErr; ?></span>
      </div>

      
      <div class="form-group">   
        <label class="control-label " for="user">Review:</label>
          <textarea class="form-control" rows="7" id="recipe_direction" name="review" placeholder="Enter reviews here. Put each point in one line." value="<?php echo $review ?>"></textarea>
          <span class="text-danger"><?php echo $reviewErr; ?></span>
    </div>

    <div class="form-group">   
        <label class="control-label " for="user">Suggestion:</label>
          <textarea class="form-control" rows="5" id="recipe_suggestion" name="suggestion" placeholder="Enter suggestions here. Put each point in one line." value="<?php echo $suggestions ?>"></textarea>
    </div>

      
        <img src="<?php echo  $userpic; ?>" class="img-rounded" alt="upload a photo" width="260" height="180" >
     
     <p>Your review photo<p>

      <div class="form-group">
        <div class="col-sm-10">
         <input class="input-group" type="file" name="picture" accept="image/*" />
         <span class="text-danger"><?php echo $errMSG; ?></span>
      </div>
    </div>
    <div class="col-sm-5"></div>
      <div class="form-group"> 
        
        <div class=" ">
          <button type="submit" class="btn btn-success" id="submit" name="btn-submit">Finish</button>
        </div>
      </div>
  </div>
  </div>
  </form>
  </div>
</div>


</body>
</html>

