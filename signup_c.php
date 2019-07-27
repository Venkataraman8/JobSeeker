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

$nameErr = $passErr =$comErr=$cinErr=$addressErr=$emailErr= $phoneErr=$logoErr="";
$filled_name= $filled_pass= $filled_com= $filled_cin=$filled_address= $filled_phone=$filled_email="";


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
		  
		  
		   if (empty($_POST["company"]))
		  {
			$comErr = "Company name is required";
			$flag=-1;
		  }
		  else 
		  {
			
			$filled_com=$_POST["company"];
		  }
		  
		   if (empty($_POST["cin"]))
		  {
			$cinErr = "Company ID number is required";
			$flag=-1;
		  }
		  else 
		  {
			
			$filled_cin=$_POST["cin"];
		  }
		  
		  if (empty($_POST["address"]))
		  {
			$addressErr = "Main Address is required";
			$flag=-1;
		  }
		  else 
		  {
			  $filled_address=$_POST["address"];
			
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
		  
		  
		  
		  if(!file_exists($_FILES["logo"]['tmp_name']) || !is_uploaded_file($_FILES["logo"]['tmp_name']))
		  {
			$logoErr = "Company Logo is required";
			$flag=-1;
		  }
		 
	}
  
  if($flag==0)
  {	

	  $upload_dir1 = HOST_WWW_ROOT . "uploads/logos/";
	  $file_fieldname ;
	  
	  $php_errors = array(1 => 'Maximum file size in php.ini exceeded',
							    2 => 'Maximum file size in HTML form exceeded',
							    3 => 'Only part of the file was uploaded',
							    4 => 'No file was selected to upload.');
	
	$file_fieldname="logo";
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
	 $insert=$mysqli->prepare("INSERT INTO company(username,password,company,company_id,address,email,phone,logo)".
	 " VALUES(?,?,?,?,?,?,?,?)");
	 $insert->bind_param("ssssssss",$_POST['user_name'],$hash,$_POST['company'],$_POST['cin'],$_POST['address'],$_POST['email'],$_POST['phone_no'],$upload_filename);
		$insert->execute();
		$insert->close();
		
		
		header("Location:index.php");

 }
}
  


?>
<html>
<head>
<Title>Sign Up</Title>
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
	<link rel="stylesheet" href="signup8.css">
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    
<script>

function checkAvailability() 
{
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability1.php",
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
                    <a class="nav-link active-home" href="signup_c.php">Company Signup</a>
                  </li>
				  <li class="nav-item">
                    <a class="nav-link " href="signup_a.php">Applicant Signup</a>
                  </li>
                </ul>
              </div>
            </nav>
<form class="form-horizontal"method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" enctype="multipart/form-data" >
<h1><center>Company details</center></h1>


		<div class="form-group">
		<label for="user_name" class="col-md-3 control-label">User Name:*</label>
		<div class="col-md-5">
		<input type="text" name="user_name" placeholder="User Name" class="form-control" autofocus value="<?php echo $filled_name?>"onBlur="checkAvailability()" size=10 />
		<span id="user-availability-status"></span>
		<span class="error"> <?php echo $nameErr;?></span>
		<p><img src="LoaderIcon.gif" id="loaderIcon" style="display:none" /></p>
		 </div>
		</div>

		<div class="form-group">
		<label for ="pass_word"class="col-md-3 control-label" >Password: *</label>
		<div class="col-md-5">
		<input type="password" name="pass_word" placeholder="Password" class="form-control" autofocus size="20" value="<?php echo $filled_pass;?>"/>
		<span class="error"> <?php echo $passErr;?></span><br/></br>
		</div>
		</div>

<div class="form-group">
<label for ="company" class="col-md-4 control-label">Company name: *</label>
<div class="col-md-5">
<input type="text" name="company" placeholder="Company Name" class="form-control" autofocus size="20"value="<?php echo $filled_com?>"/>
<span class="error"> <?php echo $comErr;?></span><br/><br/>
</div>
</div>

<div class="form-group">
<label for ="cin" class="col-md-10 control-label">Company Identification Number: *</label>
<div class="col-md-5">
<input type="text" name="cin" placeholder="Company ID" class="form-control" autofocus size="20" value="<?php echo $filled_cin?>"/>
<span class="error"> <?php echo $cinErr;?></span><br/><br/>
</div>
</div>

<div class="form-group">
<label for ="address" class="col-md-10 control-label">Company Main Address: *</label>
<div class="col-md-5">
<textarea name='address' class="form-control" autofocus rows=5 cols=80 >
<?php echo $filled_address?>
</textarea>
<span class="error"> <?php echo $addressErr;?></span><br/><br/><br/>
</div>
</div>

<div class="form-group">
<label for ="email" class="col-md-3 control-label">Email ID: *</label>
<div class="col-md-5">
<input type="text" name="email" placeholder="Email" class="form-control" autofocus size="20" value="<?php echo $filled_email?>"/>
<span class="error"> <?php echo $emailErr;?></span><br/><br/>
</div>
</div>

<div class="form-group">
<label for ="phone_no" class="col-md-3 control-label">PhoneNo: *</label>
<div class="col-md-5">
<input type="text" name="phone_no" placeholder="Phone" class="form-control" autofocus size="10" value="<?php echo $filled_phone?>"/>
<span class="error"> <?php echo $phoneErr;?></span><br/><br/>
</div>
</div>

<div class="form-group">
<label for ="logo"class="col-md-10 control-label">Upload Company Logo: *</label>
<div class="col-md-5">
<input type='hidden' name='MAX_FILE_SIZE' value='2000000' />
<input type="file" name="logo" size="10" accept='.jpg'/>
<span class="error"> <?php echo $logoErr;?></span><br/><br/>
</div>
</div>



<center><input type="submit" class="btn btn-dark" value="SignUp" />
 <input type="reset" value="Clear " class="btn btn-dark" /></center>
</form>
</div>


</section>
</body>
</html>