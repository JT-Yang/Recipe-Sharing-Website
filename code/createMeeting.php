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
	 $gid=intval($gid);
	 echo $gid;

	 $error = false;
	 $meetingNameErr = $descriptionErr = $starttimeErr=$endtimeErr=$locationErr="";
	 if(isset($_POST['btn-submit']))
	 {	  
		   if (empty($_POST["meetingName"])) {
		     $meetingNameErr = "Meeting name is needed.";
		     $error = true;
		   } else {
		     $meetingName = test_input($_POST['meetingName']);
		   }
		   
		   if (empty($_POST["description"])) {
		     $descriptionErr = "Description is needed.";
		     $error = true;
		   } else {
		     $description= test_input($_POST['description']);
		   }
		     
		    if (empty($_POST["starttime"])) {
		     $starttimeErr = "Start time is needed.";
		     $error = true;
		   } else {
		     $starttime= test_input($_POST['starttime']);
		   }
	  
	  		if (empty($_POST["endtime"])) {
		     $endtimeErr = "End time is needed.";
		     $error = true;
		   } else {
		     $endtime= test_input($_POST['endtime']);
		   }

		   if (empty($_POST["location"])) {
		     $locationErr = "Location is needed.";
		     $error = true;
		   } else {
		     $location= test_input($_POST['location']);
		   }

		  // if no error occured, continue ....
		   //$stmt = $conn->prepare("INSERT Into GroupMeeting(mname,gid, organizer,starttime, endtime,mdescription,location) values(?,?,?,?,?,?,?)");

		 // $stmt->bind_param("sdsssss", $meetingName, $gid,  $_SESSION['user'], $starttime,$endtime,$description, $location);
		$res = $conn->query("INSERT Into GroupMeeting(mname,gid, organizer,starttime, endtime,mdescription,location) values('$meetingName', $gid,  '$_SESSION[user]', '$starttime','$endtime','$description', '$location')") or die('SQL Error：'.$conn->errno);
		   //if($stmt->execute()){
		if($res){
		    ?>
		    <script>
			    alert('Meeting is successfully set ...');
			    window.location.href='groupMeeting.php';
		    </script>
		    <?php }
		   else{
		    echo  "Sorry Group Could Not Added !";
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
	<title>Create your group</title>
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
      <div class="text-muted" style="font-size:20px">Set a meeting here.</div>
    </div>
  </div>
  <br>

<h2 > <center>Set a Meeting<center></h2>
 <div class="container" >
 <div class="row">
 	<div class="col-sm-2">
 	</div>
 	<form class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">

 	<div class="col-sm-8">
		  
		  <div class="form-group"> 
		  	  <label class="control-label " for="user">Meeting title:</label>
		      <input type="text" class="form-control" id="groupName"  name="meetingName" placeholder="Enter a Meeting Title" value="<?php echo $meetingName ?>">
		      <span class="text-danger"><?php echo $meetingNameErr; ?></span>
		  </div>

		  <div class="form-group"> 
		  	  <label class="control-label " for="user">Start Time:</label>
		      <input type="text" class="form-control" id="groupName"  name="starttime" placeholder="Enter a Start Time" value="<?php echo $starttime ?>">
		      <span class="text-danger"><?php echo $starttimeErr; ?></span>
		  </div>

		  <div class="form-group"> 
		  	  <label class="control-label " for="user">End time:</label>
		      <input type="text" class="form-control" id="groupName"  name="endtime" placeholder="Enter a End Time" value="<?php echo $endtime ?>">
		      <span class="text-danger"><?php echo $endtimeErr; ?></span>
		  </div>


		
		  <div class="form-group">
		  	<label class="control-label " for="user">Description:</label>
		      <input type="txt" class="form-control" id="groupDescription" name="description" placeholder="Enter group description." value="<?php echo $description  ?>">
		      <span class="text-danger"><?php echo $descriptionErr; ?></span>
		  </div>

		    <div class="form-group"> 
		  	  <label class="control-label " for="user">Location:</label>
		      <input type="text" class="form-control" id="groupName"  name="location" placeholder="Enter a Location" value="<?php echo $location ?>">
		      <span class="text-danger"><?php echo $locationErr; ?></span>
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

</body>
</html>

