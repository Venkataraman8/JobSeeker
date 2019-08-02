<?php
// define variables and set to empty values

session_start();
if(isset($_SESSION["user_name"]) ||isset($_SESSION["user_id"]))
{
session_unset();
session_destroy();
}
$_SESSION["user_name"]=false;
$_SESSION["user_id"]=false;



require "database_connection.php";
$flag=0;

$nameErr = $passErr =$firstErr=$lastErr=$ageErr=$genderErr =$emailErr=$phoneErr=$locationErr=$aadharErr=$cvErr="";
$filled_name= $filled_pass= $filled_first= $filled_last=$filled_age=$filled_gender=$filled_email= $filled_phone=$filled_location=$filled_aadhar="";


if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	$flag=0;
		
	{
			if (empty($_POST["user_name"]))
		  {
			$nameErr = "Name is required";
			$flag=-1;
		  }
		  else 
		  {
			  $filled_name=$_POST["user_name"];
		
		  }
		  
		   if (empty($_POST["pass_word"]))
		  {
			$passErr = "Password is required";
			$flag=-1;
		  }
		  else 
		  {
			
			$filled_pass=$_POST["pass_word"];
		  }
		  
		  
		   if (empty($_POST["first_name"]))
		  {
			$firstErr = "firstname is required";
			$flag=-1;
		  }
		  else 
		  {
			
			$filled_first=$_POST["first_name"];
		  }
		  
		   if (empty($_POST["last_name"]))
		  {
			$lastErr = "lastname is required";
			$flag=-1;
		  }
		  else 
		  {
			
			$filled_last=$_POST["last_name"];
		  }
		  
		  if (empty($_POST["age"]))
		  {
			$ageErr = "Age is required";
			$flag=-1;
		  }
		  else 
		  {
			  $filled_age=$_POST["age"];
			
		  }
		  if (empty($_POST["gender"]))
		  {
			$genderErr = "Gender is required";
			$flag=-1;
		  }
		  else 
		  {
			  $filled_gender=$_POST["gender"];
			
		  }
		  
		  if (empty($_POST["email"]))
		  {
			$emailErr = "Email is required";
			$flag=-1;
		  }
		   else 
		  {
			
			$filled_email=$_POST["email"];
		  }
		  
		  if (empty($_POST["phone_no"]))
		  {
			$phoneErr = "Phone Number is required";
			$flag=-1;
		  }
		  else 
		  {
			  $filled_phone=$_POST["phone_no"];
			
		  }
		  
		  if (empty($_POST["location"]))
		  {
			$locationErr = "Location is required";
			$flag=-1;
		  }
		  else 
		  {
			  $filled_location=$_POST["location"];
		
		}
		  
		  if (empty($_POST["aadhar"]))
		  {
			$aadharErr = "Aadhar is required";
			$flag=-1;
		  }
		  else 
		  {
			  $filled_aadhar=$_POST["aadhar"];
			
		  }
		  
		  if(!file_exists($_FILES["cv"]['tmp_name']) || !is_uploaded_file($_FILES["cv"]['tmp_name']))
		  {
			$cvErr = "CV is required";
			$flag=-1;
		  }
		 
	}
  
  if($flag==0)
  {
	  $upload_dir1 = HOST_WWW_ROOT . "uploads/cv/";
	  $file_fieldname ;
	  
	  $php_errors = array(1 => 'Maximum file size in php.ini exceeded',
							    2 => 'Maximum file size in HTML form exceeded',
							    3 => 'Only part of the file was uploaded',
							    4 => 'No file was selected to upload.');
	
	$file_fieldname="cv";
		// Make sure we didn't have an error uploading the file
	($_FILES[$file_fieldname]['error'] == 0)
	 or die("error uploading to server.");
	 
		 // Is this file the result of a valid upload?
	is_uploaded_file($_FILES[$file_fieldname]['tmp_name'])
	 or die("Error naming file ");
	 

		// Name the file uniquely
	$now = time();
	while (file_exists($upload_filename = $upload_dir1 . $now .
	 '-' .
	 $_FILES[$file_fieldname]['name'])) 
	{
	 $now++;
	}
	
		// Finally, move the file to its permanent location
	move_uploaded_file($_FILES[$file_fieldname]['tmp_name'], $upload_filename)
	 or die("error saving file");
	 
	  $hash = password_hash($_POST['pass_word'], PASSWORD_DEFAULT);
	 $insert=$mysqli->prepare("INSERT INTO cv_details(username,password,firstname,lastname,age,gender,email,phone,location,aadhar,cv)".
	 " VALUES(?,?,?,?,?,?,?,?,?,?,?)");
	
	 $insert->bind_param("sssssssssss",$_POST['user_name'],$hash,$_POST['first_name'],$_POST['last_name'],$_POST['age'],$_POST['gender'],$_POST['email'],$_POST['phone_no'],$_POST['location'],$_POST['aadhar'],$upload_filename);
		$insert->execute();
		$insert->close();
		
		header("Location:index.php");

 }
}
  


?>
<html>
<head>
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
	<link rel="stylesheet" href="signup8.css">
	
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    
<Title>Sign Up</Title>
<script>
function checkAvailability() 
{
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'user_name='+$("#user_name").val(),
type: "POST",
success:function(data)
{
$("#user-availability-status").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}


</script>
</head>

<body>
<section class='header'>

<div class="container">
<nav class="navbar navbar-expand-lg navbar-light">
              <a class="navbar-brand"><img src="logo.png" height=150 width=150></a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto text-right">
                  <li class="nav-item">
                    <a class="nav-link " href="index.php">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="signup_c.php">Company Signup</a>
                  </li>
				  <li class="nav-item">
                    <a class="nav-link active-home" href="signup_a.php">Applicant Signup</a>
                  </li>
                </ul>
              </div>
            </nav>
<form class="form-horizontal" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" enctype="multipart/form-data">
<h1><center>Applicant details</center></h1>

		<div class="form-group">
		<label for="user_name" class="col-md-3 control-label">User Name:*</label>
		<div class="col-md-5">
		<input type="text" name="user_name" id="user_name" placeholder="User Name" class="form-control" autofocus value="<?php echo $filled_name?>"onBlur="checkAvailability()" size=10 />
		<span id="user-availability-status"></span>
		<span class="error"> <?php echo $nameErr;?></span>
		<p><img src="LoaderIcon.gif" id="loaderIcon" style="display:none" /></p>
		 </div>
		</div>

		<div class="form-group">
		<label for ="pass_word"class="col-md-3 control-label" >Password :*</label>
		<div class="col-md-5">
		<input type="password" name="pass_word" placeholder="Password" class="form-control" autofocus size="20" value="<?php echo $filled_pass;?>"/>
		<span class="error"> <?php echo $passErr;?></span><br/></br>
		</div>
		</div>

		<div class="form-group">
		<label for ="first_name" class="col-md-3 control-label" >FirstName :*</label>
		<div class="col-md-5">
		<input type="text" name="first_name" placeholder="First Name" class="form-control" autofocussize="10"value="<?php echo $filled_first;?>"/>
		<span class="error"> <?php echo $firstErr;?></span><br/>
		</div>
		</div>
		
		<div class="form-group">
		<label for ="last_name" class="col-md-3 control-label" >Lastname :*</label>
		<div class="col-md-5">
		<input type="text" name="last_name" placeholder="Last Name" class="form-control" autofocus size="10" value="<?php echo $filled_last;?>"/>
		<span class="error"> <?php echo $lastErr;?></span><br/><br/>
		</div>
		</div>
		
		
		<div class="form-group">
		<label for ="age" class="col-md-3 control-label" >Age :*</label>
		<div class="col-md-5">
		<input type="text" pattern="[0-9]{1,2}" name="age" size="10" placeholder="Age" class="form-control" autofocus value="<?php echo $filled_age;?>"/>
		<span class="error"> <?php echo $ageErr;?></span><br/>
		</div>
		</div>

		<div class="form-group">
		<label for ="gender" class="col-md-3 control-label" >Gender :*</label>
		<div class="col-md-5">		
		<input type="text" name="gender" size="10" placeholder="Gender" class="form-control" autofocus value="<?php echo $filled_gender;?>"/>
		<span class="error"> <?php echo $genderErr;?></span><br/><br/>
		</div>
		</div>

		<div class="form-group">
		<label for ="Email" class="col-md-3 control-label" >Email :*</label>
		<div class="col-md-5">
		<input type="text" name="email" pattern="[^@]+@[^@]+\.[a-zA-Z]{2,}" placeholder="Email ID" class="form-control" autofocus size="20" value="<?php echo $filled_email;?>"/>
		<span class="error"> <?php echo $emailErr;?></span><br/>
		</div>
		</div>
		
		<div class="form-group">
		<label for ="phone_no" class="col-md-3 control-label" >Phone No :*</label>
		<div class="col-md-5">
		<input type="text" name="phone_no" pattern="[0-9]{10}" placeholder="Phone " class="form-control" autofocus size="20" value="<?php echo $filled_phone;?>"/>
		<span class="error"> <?php echo $phoneErr;?></span><br/><br/>
		</div>
		</div>
		
		<div class="form-group">
<label for ="location" class="col-md-10 control-label">Location: *</label>
<div class="col-md-5">
<textarea name='location' class="form-control" autofocus rows=5 cols=80 >
<?php echo $filled_location?>
</textarea>
<span class="error"> <?php echo $locationErr;?></span><br/><br/><br/>
</div>
</div>
		
		<div class="form-group">
		<label for ="aadhar" class="col-md-3 control-label" >Aadhar no :*</label>
		<div class="col-md-5">
		<input type="text" name="aadhar" size="20" pattern="[0-9]{12}"placeholder="Aadhar" class="form-control"value="<?php echo $filled_aadhar;?>"/>
		<span class="error"> <?php echo $aadharErr;?></span><br/><br/>
		</div>
		</div>
		
		<div class="form-group">
		<label for ="cv" class="col-md-3 control-label" >Upload CV :*</label>
		<div class="col-md-5"><input type='hidden' name='MAX_FILE_SIZE' value='2000000' />
		<input type="file" name="cv" size="20" accept='.pdf'/>
		<span class="error"> <?php echo $cvErr;?></span><br/><br/>
		</div>
		</div>

<center><input type="submit" class="btn btn-dark" value="SignUp" />
 <input type="reset" value="Clear " class="btn btn-dark" /></center>
</form>
</div>


</section>
</body>
</html>