<?php
session_start();
if(isset($_SESSION["user_name"]) ||isset($_SESSION["user_id"]))
{
session_unset();
session_destroy();
}
$_SESSION["user_name"]=false;
$_SESSION["user_id"]=false;


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <title></title>
	<script src="https://code.jquery.com/jquery-3.4.1.js"></script> 
    <link rel="stylesheet" href="index8.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
      
</head>
<body>
    <section class="header">
        <div class="container">
          <nav class="navbar navbar-expand-lg navbar-light">
              <a class="navbar-brand"><img src="logo.png" height=150 width=150></a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto text-right">
                  <li class="nav-item">
                    <a class="nav-link active-home" href="index.php">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="signup_c.php">Company Signup</a>
                  </li>
				  <li class="nav-item">
                    <a class="nav-link" href="signup_a.php">Applicant Signup</a>
                  </li>
                </ul>
              </div>
            </nav>
            
            <div class="row banner">
			<h1>Login To find the Perfect Job for you.</h1>
                    <a href="login.php" class="express-btn">LOGIN</a>      
            </div>        
        </div>
    </section>
</body>
</html>
