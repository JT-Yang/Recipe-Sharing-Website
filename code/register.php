<?php
 ob_start();
 session_start();

 //if( isset($_SESSION['user'])!="" ){
  //header("Location: home.php");
 //}
 require_once 'dbconfig.ini.php';

 $error = false;

 if ( isset($_POST['btn-signup']) ) {
  
  // clean user inputs to prevent sql injections
  $username = trim($_POST['username']);
  $username = strip_tags($username);
  $username = htmlspecialchars($username);
  
  $email = trim($_POST['email']);
  $email = strip_tags($email);
  $email = htmlspecialchars($email);
  
  $pass = trim($_POST['pass']);
  $pass = strip_tags($pass);
  $pass = htmlspecialchars($pass);
  
  // basic name validation
  if (empty($username)) {
   $error = true;
   $nameError = "Please enter your full name.";
  } else if (strlen($username) < 3) {
   $error = true;
   $nameError = "Name must have atleat 3 characters.";
  } else if (!preg_match("/^[a-zA-Z0-9 .\-]+$/",$username)) {
   $error = true;
   $nameError = "Name must contain alphabets,number,.,- and space.";
  }
  
  //basic email validation
  if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
   $error = true;
   $emailError = "Please enter valid email address.";
  } else {
   // check email exist or not
   $SQL = "SELECT email FROM User WHERE email='$email'";
   $res= $conn->query($SQL) or die('SQL Error：'.$conn->errno);
   $count = $res->num_rows; 
   if($count!=0){
    $error = true;
    $emailError = "Provided Email is already in use.";
   }
  }
  // password validation
  if (empty($pass)){
   $error = true;
   $passError = "Please enter password.";
  } else if(strlen($pass) < 6) {
   $error = true;
   $passError = "Password must have at least 6 characters.";
  }
  
  // password encrypt using SHA256();
  $password = password_hash($pass, PASSWORD_DEFAULT);
  
  // if there's no error, continue to signup
  if( !$error ) {
   $query = "INSERT INTO User(username,password,email) values('$username', '$password', '$email')";
   $res= $conn->query($query) or die('SQL Error：'.$conn->errno);
    
   if ($res) {
    $errTyp = "success";
    $errMSG = "Successfully registered, you may login now in 5 seconds...";
    //unset($name);
    //unset($email);
    unset($pass);
    header("refresh:5;url=login.php"); 
   } else {
    $errTyp = "danger";
    $errMSG = "Something went wrong, try again later..."; 
   } 
  }
 }
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Ccookzilla | sign up</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">

 <div id="login-form">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
    
     <div class="col-md-6">
        
         <div class="form-group">
             <h2 class="">Join now.</h2>
            </div>
        <p class="slogan">
              Start your trip to cookzilla.
            </p>
         <div class="form-group">
             <hr />
            </div>
            
            <?php
   if ( isset($errMSG) ) {
    
    ?>
    <div class="form-group">
             <div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
             </div>
                <?php
   }
   ?>
            
            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
             <input type="text" name="username" class="form-control" placeholder="Enter Username" maxlength="50" value="<?php echo $username ?>" />
                </div>
                <span class="text-danger"><?php echo $nameError; ?></span>
            </div>
            
            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
             <input type="email" name="email" class="form-control" placeholder="Enter Your Email" maxlength="40" value="<?php echo $email ?>" />
                </div>
                <span class="text-danger"><?php echo $emailError; ?></span>
            </div>
            
            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
             <input type="password" name="pass" class="form-control" placeholder="Enter Password" maxlength="15" />
                </div>
                <span class="text-danger"><?php echo $passError; ?></span>
            </div>
            
            <div class="form-group">
             <hr />
            </div>
            
            <p>
             <button type="submit" class="btn btn-block btn-danger" name="btn-signup">Sign Up</button>
            </p>
            
            <div class="form-group">
             <p>Already have an account?<a href="index.php">Log In</a></p>
            </div>
        
        </div>
   
    </form>
    </div> 

</div>

</body>
</html>
<?php ob_end_flush(); ?>