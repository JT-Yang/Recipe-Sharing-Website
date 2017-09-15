<?php
	 ob_start();
	 session_start();
	 require_once 'dbconfig.ini.php';
	 
	  //if session is not set this will redirect to login page
	 if( !isset($_SESSION['user']) ) {
	  header("Location: index.html");
	  exit;
	 }
	 $SQL="SELECT username, firstname, lastname, address, gender, photo, description FROM User where username='$_SESSION[user]'";
	 $res= $conn->query($SQL) or die('SQL Error：'.$conn->errno);
	 $userRow = $res->fetch_assoc();
	 $userpic = $userRow['photo'];
	 
	 if(isset($_POST['btnsave']))
	 {
		  $firstname = test_input($_POST['firstname']);// user name
		  $lastname = test_input($_POST['lastname']);
		  $address = test_input($_POST['address']);
		  $gender = test_input($_POST['gender']);
		  $description = test_input($_POST['description']);

		  $imgFile = $_FILES['photo']['name'];
		  $tmp_dir = $_FILES['photo']['tmp_name'];
		  $imgSize = $_FILES['photo']['size'];
	     
		  if($imgFile)
		  {
			   $upload_dir = 'user_images/'; // upload directory 
			   $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION)); // get image extension
			   $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
			   $userpic = rand(1000,1000000).".".$imgExt;
			   
			   if(in_array($imgExt, $valid_extensions))
			   {   
				    if($imgSize < 5000000)
				    {
				     unlink($userRow['photo']); //delete the old image.
				     move_uploaded_file($tmp_dir, $upload_dir.$userpic); //upload new image from php temp image dir to upload dir.
				     $userpic = $upload_dir.$userpic;

				     //$SQL = "UPDATE User Set photo = '$upload_dir.$userpic' WHERE username='$_SESSION[user]' ";
				     //$res= $conn->query($SQL) or die('SQL Error：'.$conn->errno);
				    }
				    else
				    {
				     $errMSG = "Sorry, your image is too large. It should be less then 5MB";
				    }
			   }
			   else
			   {
			    	$errMSG = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";  
			   } 
		  }
		 // else
		  //{
		   // if no image selected the old image remain as it is.
		   //$userpic = $userRow['photo']; // old image from database
		  //} 
		      
	  
		  // if no error occured, continue ....
		  if(!isset($errMSG))
		  {
		   $stmt = $conn->prepare("UPDATE User  
		           SET firstname=?, 
		               lastname=?, 
		               address=?,
		               gender=?,
		               photo=?,
		               description=? 
		               WHERE username='$_SESSION[user]'");

		   $stmt->bind_param("ssssss", $firstname, $lastname, $address, $gender, $userpic,$description);
		    //$photo = $upload_dir.$userpic;
		   //$stmt->bindParam(':firstname',$firstname);
		   //$stmt->bindParam(':lastname',$lastname);
		   //$stmt->bindParam(':address',$address);
		   //$stmt->bindParam(':gender',$gender);
		   //$stmt->bindParam(':photo',$userpic);
		   //$stmt->bindParam(':description',$description);
		    
		   if($stmt->execute()){
		    ?>
		    <script>
			    alert('Successfully Updated ...');
			    window.location.href='profile.php';
		    </script>
		    <?php
		   		}
		   else{
		    $errMSG = "Sorry Data Could Not Updated !";
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
      <div class="text-muted" style="font-size:20px">Update your public profile.</div>
    </div>
  </div>
  <br>
  <br>

 <div class="container">
 <div class="row">
 	 <form class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
 	<div class="col-sm-5">
 		<div class="col-sm-2">
 		</div>
 		 <img src="<?php echo  $userpic; ?>" class="img-rounded" alt="Upload your photo." width="260" height="180" >
 		 
 		 <center>This is your photo.</center>

		  <div class="form-group">
		  	<div class="col-sm-3">
		  	</div>
		  	<div class="col-sm-8">
		     <input class="input-group" type="file" name="photo" accept="image/*" />
		  </div>
		</div>
		<br>
 	</div>

 	<div class="col-sm-7">
		 
		  <div class="form-group">
		    <label class="control-label col-sm-3" for="user">First Name:</label>
		    <div class="col-sm-6">
		      <input type="text" class="form-control" id="firstname"  name="firstname" value="<?php echo $userRow['firstname']; ?>">
		    </div>
		  </div>
		  <div class="form-group">
		    <label class="control-label col-sm-3" for="user">Last Name:</label>
		    <div class="col-sm-6"> 
		      <input type="txt" class="form-control" id="lastname" name="lastname" value="<?php echo $userRow['lastname']; ?>">
		    </div>
		  </div>

		  <div class="form-group">
		  <label class="control-label col-sm-3" for="sel1">Gender:</label>
		  <div class="col-sm-6">
			  <select id="sel1" name="gender">
			    <option>Male</option>
			    <option>Female</option>
			    <option>Bisexual</option>
			    <option>Self defined</option>
			  </select>
			</div>
		  </div>

		  <div class="form-group">
		    <label class="control-label col-sm-3" for="user">Address:</label>
		    <div class="col-sm-9"> 
		      <input type="txt" class="form-control" id="lastname" name="address" value="<?php echo $userRow['address']; ?>">
		    </div>
		  </div>

		  <div class="form-group">
		    <label class="control-label col-sm-3" for="comment">About me:</label>
		    <div class="col-sm-9"> 
		      <textarea class="form-control" rows="5" id="lastname" name="description"><?php echo $userRow['description']; ?> </textarea>
		    </div>
		</div>

		  <div class="form-group"> 
		    <div class="">
		      <button type="submit" class="btn btn-primary" name="btnsave">Save</button>
		    </div>
		  </div>
		
	</div>
</form>
	</div>
</div>


</body>
</html>