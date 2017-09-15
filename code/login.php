<?php
 ob_start();
 session_start();

 //if ( isset($_SESSION['user'])!="" ) {
  //header("Location: home.php");
  //exit;
 //}

 require_once 'dbconfig.ini.php';

 $error = false;

 if( isset($_POST['btn-login']) ) { 

  // prevent sql injections/ clear user invalid inputs
  $email = trim($_POST['email']);
  $email = strip_tags($email);
  $email = htmlspecialchars($email);

  $pass = trim($_POST['pass']);
  $pass = strip_tags($pass);
  $pass = htmlspecialchars($pass);
  
  if(empty($email)){
   $error = true;
   $emailError = "Please enter your email address.";
  } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
   $error = true;
   $emailError = "Please enter valid email address.";
  }
  
  if(empty($pass)){
   $error = true;
   $passError = "Please enter your password.";
  }
  
  // if there's no error, continue to login
  if (!$error) {
   
   $password = password_hash($pass, PASSWORD_DEFAULT); 
  
   $SQL="SELECT username, password FROM User where email='$email'";
   $res= $conn->query($SQL) or die('SQL Error：'.$conn->errno);

   $row = $res->fetch_assoc();
   $count = $res->num_rows; // if credentials are correct, it returns must be 1 row
   
   if(  $count==1 && $row['password']==$pass ) {
    $_SESSION['user'] = $row['username'];
    header("Location: home.php");
   } else {
    $errMSG = "Incorrect Credentials, Try again...";
   }  
  }
 }
?>



<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cookzilla | login</title>
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
             <h2 class="">Welcome!</h2>
            </div>
             <p class="slogan">
              Begin to explore cookzilla.
            </p>
         <div class="form-group">
             <hr />
            </div>
            
            <?php
   if ( isset($errMSG) ) {
    
    ?>
    <div class="form-group">
             <div class="alert alert-danger">
    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                </div>
             </div>
                <?php
   }
   ?>
            
            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
             <input type="email" name="email" class="form-control" placeholder="Your Email" value="<?php echo $email; ?>" maxlength="40" />
                </div>
                <span class="text-danger"><?php echo $emailError; ?></span>
            </div>
            
            <div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
             <input type="password" name="pass" class="form-control" placeholder="Your Password" maxlength="15" />
                </div>
                <span class="text-danger"><?php echo $passError; ?></span>
            </div>
            
            <div class="form-group">
             <hr />
            </div>

            <span id="control-group">
              <label>
                <input type="checkbox" value="option1">
                Remember Me |
              </label>
              <a href="/user/newpasswd">Forgot Password?</a>
            </span>
            <br>
            
            <div class="form-group">
             <button type="submit" class="btn btn-block btn-danger" name="btn-login">Log In</button>
            </div>
            
            <div class="form-group">
             <p>Don't have an account? <a href="register.php"> Sign up.</a></p>
            </div>
        
        </div>
   
    </form>
    </div> 

</div>

</body>
</html>
<?php ob_end_flush(); ?>