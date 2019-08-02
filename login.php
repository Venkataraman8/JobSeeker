<?php

session_start();
require "database_connection.php";


$PassErr="";
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	$flag=0;
$user_name=trim($_REQUEST["username"]);
$pass_word=trim($_REQUEST["password"]);
$type=trim($_REQUEST["type"]);


if($type=='applicant')
{
$select=$mysqli->prepare("SELECT * from cv_details where username =?");
$select->bind_param("s",$user_name);
$select->execute();



$result=$select->get_result();


$row=$result->fetch_assoc();

$correct_password=$row["password"];
$correct_user_id=$row["user_id"];
$select->close();
		if($flag==0)
		{
			if(password_verify($pass_word,$correct_password))
			{	
				$flag=1;
				
				$_SESSION["user_name"]=$user_name;
				$_SESSION["user_id"]=$correct_user_id;
				$_SESSION['type']='applicant';
				header("Location:app_dashboard_new.php");
				exit();
			}
			
			else 
			{
				$PassErr="Username or Password incorrect!!";
			}
			
		}
}

else if($type=='company')
{
$select=$mysqli->prepare("SELECT * from company where username =?");
$select->bind_param("s",$user_name);
$select->execute();



$result=$select->get_result();


$row=$result->fetch_assoc();

$correct_password=$row["password"];
$correct_user_id=$row["user_id"];
$select->close();
		if($flag==0)
		{
			if(password_verify($pass_word,$correct_password))
			{	
				$flag=1;
				
				$_SESSION["user_name"]=$user_name;
				$_SESSION["user_id"]=$correct_user_id;
				$_SESSION['type']='company';
				header("Location:com_dashboard_new.php");
				exit();
			}
			
			else 
			{
				$PassErr="Username or Password incorrect!!";
			}
			
		}
}


	
}
?>
<html>

<head>
<link rel="stylesheet" href="login8.css">
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    
<Title>Login page</Title>
</head>

<body>
<section class='header'>
<div class="container">
<nav class="navbar navbar-expand-lg navbar-light">
              <a class="navbar-brand" ><img src="logo.png" height=150 width=150></a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto text-right">
                  <li class="nav-item">
                    <a class="nav-link " href="index.php">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link " href="signup_c.php">Company Signup</a>
                  </li>
				  <li class="nav-item">
                    <a class="nav-link " href="signup_a.php">Applicant Signup</a>
                  </li>
                </ul>
              </div>
            </nav>

<form class="form-horizontal" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
<h1><center>LOGIN </center></h1>

<div class="form-group">
<label for ="username" class="col-md-3 control-label">Username:</label>
<div class="col-md-5">
<input type="text" name="username" class="form-control" autofocus size="20"/><br/>
</div>
</div>

<div class="form-group">		
<label for ="password"  class="col-md-3 control-label">Password :</label>
<div class="col-md-5">
<input type="password" name="password" class="form-control" size="20"/><br/>
</div>
</div>

<div class="form-group">
<label for ="type" class="col-md-3 control-label">Login Type :</label>
<div class="col-md-5">
<select name="type" class="form-control">
<option value="applicant">Applicant</option>
<option value="company">Company</option>
</select>
</div>
</div>

<div class="error"> <?php echo $PassErr;?></div>
<center><input type="submit" class="btn btn-dark" value="Login" />
 <input type="reset" value="Clear " class="btn btn-dark" /></center>
</form>
</div>

</section>
</body>
</html>