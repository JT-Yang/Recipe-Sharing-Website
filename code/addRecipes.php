<?php
	 ob_start();
	 session_start();
	 require_once 'dbconfig.ini.php';
	 
	  //if session is not set this will redirect to login page
	 if( !isset($_SESSION['user']) ) {
	  header("Location: index.html");
	  exit;
	 }

	 //$SQL="SELECT username, firstname, lastname, address, gender, photo, description FROM User where username='$_SESSION[user]'";
	 //$res= $conn->query($SQL) or die('SQL Error：'.$conn->errno);
	 //$userRow = $res->fetch_assoc();
			date_default_timezone_set('America/New_York');
		   $time = date('Y-m-d H:i:s');
	 $error = false;
	 $titleErr = $descriptionErr = $directionErr = $servingErr = $cooktimeErr ="";
	 if(isset($_POST['btn-submit']))
	 {	  
		   if (empty($_POST["title"])) {
		     $titleErr = "Title is needed.";
		     $error = true;
		   } else {
		     $title = test_input($_POST['title']);
		   }
		   
		   if (empty($_POST["description"])) {
		     $descriptionErr = "Description is needed.";
		     $error = true;
		   } else {
		     $description= test_input($_POST['description']);
		   }
		     
		   if (empty($_POST["direction"])) {
		   	$error = true;
		     $directionErr = "Direction is needed.";
		   } else {
		     $direction = $_POST['direction'];
		   }

		   if (empty($_POST["serving"])) {
		   	$error = true;
		     $servingErr = "Serving Number is needed.";
		   } else {
		      $serving = test_input($_POST['serving']);
		   }

		   if (empty($_POST["cooktime"])) {
		   	$error = true;
		     $cooktimeErr = "Cooktime is needed.";
		   } else {
		      $cooktime = test_input($_POST['cooktime']);
		   }

		  $imgFile = $_FILES['picture']['name'];
		  $tmp_dir = $_FILES['picture']['tmp_name'];
		  $imgSize = $_FILES['picture']['size'];
	     
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
		  else
		  {
		   //$userpic = $userRow['photo']; // Must upload a picture.
		  	$errMSG = "picture is needed.";
		  	$error = true;
		  } 
		      
	  
		  // if no error occured, continue ....
		   //$stmt = $conn->prepare("INSERT Into Recipe(username, title, description,serving, direction,cooktime, picture, posttime) values(?,?,?,?,?,?,?,?)");

		  // $stmt->bind_param("ssssssss", $_SESSION['user'],$title, $description, $serving, $direction, $cooktime,$upload_dir.$userpic,strtotime($date));
		  $recipePic = $upload_dir.$userpic;
		if(!$error){
		   $SQL="INSERT Into Recipe(username, title, description,serving, direction,cooktime, picture, posttime) values('$_SESSION[user]','$title','$description', '$serving', '$direction', '$cooktime','$recipePic','$time')";
	 		$res= $conn->query($SQL) or die('SQL Error：'.$conn->errno);
	 		
	 			$result=$conn->query("SELECT LAST_INSERT_ID()");
	 			$row = $result->fetch_assoc();
	 			$rid = $row['LAST_INSERT_ID()'];
	 			$rid = intval($rid);
		   //if($stmt->execute()){
	 		//insert ingredient here through a loop.
	 			//Ingredient name and tag name should not same.
	 			//if(count($iname)!==count(array_unique($iname))){}
	 		for($i = 0; $i < count($_POST['iname']); $i++)
			{
			    $iname = test_input( $_POST['iname'][$i]);
			    $amount = test_input($_POST['amount'][$i]);
			    $unit = test_input($_POST['unit'][$i]);

			   

			    $sql = "INSERT INTO RecipeIngredient(rid, iname, amount, unit)
			            VALUES('$rid', '$iname', '$amount', '$unit')";
			    $result= $conn->query($sql) or die('SQL Error：'.$conn->errno);
			    if(!$result){
			    	$errMSG = "Sorry Recipe Added Failed !";
			    }
			}

			//insert tags
			for($i = 0; $i < count($_POST['tag']); $i++)
			{
			    $tname = test_input( $_POST['tag'][$i]);

			    $sql = "INSERT INTO RecipeTag(rid,  tname)
			            VALUES('$rid', '$tname')";
			    $results= $conn->query($sql) or die('SQL Error：'.$conn->errno);
			    if(!$results){
			    	$errMSG = "Sorry Recipe Added Failed !";
			    }
			}

		   	if($results){
		    ?>
		    <script>
			    alert('Recipe is successfully added ...');
			    //window.location.href='home.php?rid=',$rid;
		    </script>
		    <?php
		    	header("Location: recipe_display.php?rid=$rid");
		   		}
		   else{
		    $errMSG = "Sorry Recipe Could Not Added !";
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
      <div class="text-muted" style="font-size:20px">Welcom to your recipes repository.</div>
    </div>
  </div>
  <br>

<h2 > <center>Add Your Recipe<center></h2>
 <div class="container" >
 <div class="row">
 	<div class="col-sm-2">
 	</div>
 	<form class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">

 	<div class="col-sm-8">
		  
		  <div class="form-group"> 
		  	  <label class="control-label " for="user">Title:</label>
		      <input type="text" class="form-control" id="recipe_title"  name="title" placeholder="Enter recipe title" value="<?php echo $title ?>">
		      <span class="text-danger"><?php echo $titleErr; ?></span>
		  </div>

		  <div class="form-group">
		  	<label class="control-label " for="user">Description:</label>
		      <input type="txt" class="form-control" id="recipe_description" name="description" placeholder="Enter recipe description." value="<?php echo $description  ?>">
		      <span class="text-danger"><?php echo $descriptionErr; ?></span>
		  </div>

		  <div class="form-group">
		  <table class="table " id="dynamic_field">
		  	<thead>
		  		<tr>
			        <th>Ingredient</th>
			        <th>Amount</th>
			        <th>Unit</th>
			     </tr>
		  	</thead>
                <tr>                
                        <!--div class="top-row"-->
                        <div class="field-wrap">
                            <td>
                            <input type="text"  required autocomplete="off" name="iname[]" placeholder="Enter ingredient name."/>
                            </td>  
                            <td>            
                            <input type="text" required autocomplete="off" name="amount[]" placeholder="Amount(ex.,1,many)"/>
                            </td>   
                            <td>
                            <input type="text" autocomplete="off" name="unit[]" placeholder="Unit or leave blank"/>
                        	</td>
                        </div>
                   
                    <td><button type="button" name="add" id="add" class="btn btn-primary">More</button></td>
                </tr>
            </table>

            </div>
		  
		  <div class="form-group">   
		  	<label class="control-label " for="user">Direction:</label>
		      <textarea class="form-control" rows="7" id="recipe_direction" name="direction" placeholder="Enter direction here. Put each step in one line." value="<?php echo $direction ?>"></textarea>
		      <span class="text-danger"><?php echo $directionErr; ?></span>
		</div>

		<div class="form-group">
		    <label class="control-label " for="user">Number of serving:</label>
		      <input type="txt" class="form-control" id="recipe_serving" name="serving" placeholder="Enter number of serving." value="<?php echo $serving ?>">
		      <span class="text-danger"><?php echo $servingErr; ?></span>
		</div>

		<div class="form-group">
		    <label class="control-label " for="user">cooktime:</label>
		      <input type="txt" class="form-control" id="recipe_cooktime" name="cooktime" placeholder="Enter the cooktime" value="<?php echo $cooktime ?>">
		      <span class="text-danger"><?php echo $cooktimeErr; ?></span>
		  </div>
		
		  <div class="form-group">
		  <table class="table " id="dynamic_tag">
		  	<thead>
		  		<tr>
			        <th>Tags:</th>   
			     </tr>
		  	</thead>
		  	<tbody>
                <tr>
                        <!--div class="top-row"-->
                       <div class="field-wrap">
                            
                            <td>
                            <input type="text" requiered autocomplete="off" name="tag[]" placeholder="Enter a tag"/>
                            <span class="text-danger"><?php echo $tagErr ?></span>
                        	</td>
                        </div>
                   
                    <td><button type="button" name="add_tag" id="add_tag" class="btn btn-primary">More</button></td>
                </tr>
            </tbody>
            </table>
        </div>
      
        <img src="<?php echo  $userpic; ?>" class="img-rounded" alt="upload a photo" width="260" height="180" >
 		 
 		 <p>Your Cover Photo<p>

		  <div class="form-group">
		  	<div class="col-sm-10">
		     <input class="input-group" type="file" name="picture" accept="image/*" />
		     <span class="text-danger"><?php echo $errMSG; ?></span>
		  </div>
		</div>
		<div class="col-sm-5"></div>
		  <div class="form-group"> 
		  	
		    <div class=" ">
		      <button type="submit" class="btn btn-success" id="submit" name="btn-submit">Submit</button>
		    </div>
		  </div>
	</div>
 	</div>
	</form>
	</div>
</div>

<script>
        $(document).ready(function(){
            var i = 1;
            $('#add').click(function(){
                i++;
                $('#dynamic_field').append('<tr id="row'+i+'"><div class="field-wrap"><td><input type="text" required autocomplete="off" name="iname[]" placeholder="Enter the ingredient name"/></td><td><input type="text" required autocomplete="off" name="amount[]" placeholder="amount"/></td><td><input type="text" autocomplete="off" name="unit[]" placeholder="unit"/></div></td></td><td><button name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
            });

            $(document).on('click','.btn_remove', function(){
                var button_id = $(this).attr("id");
                $("#row"+button_id+"").remove();
            });

            
        });
    </script>

    <script>
        $(document).ready(function(){
            var i = 1;
            $('#add_tag').click(function(){
                i++;
                $('#dynamic_tag').append('<tr id="row'+i+'"><div class="field-wrap"><td><input type="text"  required autocomplete="off" name="tag[]" placeholder="Enter a tag"/><span class="text-danger"><?php echo $tagErr ?></span></td></td><td><button name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
            });

            $(document).on('click','.btn_remove', function(){
                var button_id = $(this).attr("id");
                $("#row"+button_id+"").remove();
            });

            
        });
    </script>


</body>
</html>

