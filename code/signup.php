<!DOCTYPE html>
<html>
  <head>
    <title>cookzilla | sign up</title>
    <meta charset = "utf-8">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	  <script src="js/bootstrap.min.js"></script>
	  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
    <div class="container">
      <div class="sign-page">
        <div class="alert alert-info" role="alert">
          <p>
            Register successfully. Pleas log in.
          </p>
        </div>
        <div class="signup-page">
          <form>
            <h2>
              Join us now!
            </h2>
            <p class="slogan">
              Explore the food world together.
            </p>
            <div class="input-prepend">
              <span class="glyphicon glyphicon-user"></span>
              <input type="text" placeholder="username">
            </div>
            <br>
            <div class="input-prepend">
              <span class="glyphicon glyphicon-envelope"></span>
              <input type="text" placeholder="Email">
            </div>
            <br>
            <div class="input-prepend">
              <span class="glyphicon glyphicon-lock"></span>
              <input type="password" placeholder="password">
            </div>
            <br>
            <div class="input-prepend">
              <span class="glyphicon glyphicon-lock"></span>
              <input type="password" placeholder="password conformation">
            </div>
            <br>
            <button class="btn btn-lg btn-danger btn-block">
              <span>Sign Up</span>
            </button>
          </form>
        </div>
        
      </div>
    </div>
 


    <style>
  

  .sign-page{
    margin-top:30px;
    padding:40px;
  }

  .alert{
    position:absolute;
    width:18%;
    left:40%;
    top:5%;
    display:none;
  }


  .alert p{
    text-align:center;
  }
  .signup-page{
    float:left;
    width:49%;
    display:inline-block;
    vertical-align:top;
  }

 

  form{
    width:301px;
    display:block;
    margin:20px;
    margin-left:100px;
  }
  .input-prepend span{
    width:42px;
    height:42px;
  }
  .input-prepend input{
    width:228px;
    height:42px;
    padding:4px 12px;
  }
 span#control-group{
   margin:0 0 100px 0;
 }
 </style>
</body>
</html>