<?php
session_start();

if(!isset($_SESSION["user_name"]) || !isset($_SESSION['type']))
{
header("Location:index.php");
exit();
}

if($_SESSION['type']!='company')
{
header("Location:index.php");
exit();
}

require "database_connection.php";
$flag=0;
$select=$mysqli->prepare("SELECT * FROM company WHERE username=?");
$select->bind_param("s",$_SESSION['user_name']);
$select->execute();
$result=$select->get_result();
$row=$result->fetch_assoc();
$select->close();
$company=$row['company'];
$employer=$row['username'];
$titleErr = $descriptionErr =$fieldsErr=$experienceErr=$salaryErr=$vacanciesErr= $qualificationErr=$locationErr=$interviewErr="";
$filled_title= $filled_description= $filled_experience=$filled_salary= $filled_vacancies=$filled_qualification=$filled_location=$filled_interview="";


if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
	$flag=0;
		 
	{
			if (empty($_POST["title"]))
		  {
			$titleErr = "Title is required";
			$flag=-1;
		  }
		  else 
		  {
			  $filled_title=$_POST["title"];
		
		  }
		  
		  if (empty($_POST["description"]))
		  {
			$descriptionErr = "Description is required";
			$flag=-1;
		  }
		  else 
		  {
			  $filled_description=$_POST["description"];
		
		  }
		  if (empty($_POST["fields"]))
		  {
			$fieldsErr = "Fields is required";
			$flag=-1;
		  }
		  
		  if (empty($_POST["experience"]))
		  {
			$experienceErr = "Experience is required";
			$flag=-1;
		  }
		  else 
		  {
			  $filled_experience=$_POST["experience"];
		
		  }
		  if (empty($_POST["salary"]))
		  {
			$salaryErr = "Salary is required";
			$flag=-1;
		  }
		  else 
		  {
			  $filled_salary=$_POST["salary"];
		
		  }
		  if (empty($_POST["vacancies"]))
		  {
			$vacanciesErr = "Vacancies is required";
			$flag=-1;
		  }
		  else 
		  {
			  $filled_vacancies=$_POST["vacancies"];
		
		  }
		  if (empty($_POST["qualification"]))
		  {
			$qualificationErr = "Qualification is required";
			$flag=-1;
		  }
		  else 
		  {
			  $filled_qualification=$_POST["qualification"];
		
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
		  if (empty($_POST["interview"]))
		  {
			$interviewErr = "INterview Details is required";
			$flag=-1;
		  }
		  else 
		  {
			  $filled_interview=$_POST["interview"];
		
		  }
		  
		   
		  
		 
	}
  
  if($flag==0)
  {	

	 
	 $insert=$mysqli->prepare("INSERT INTO jobs(employer,company,title,description,fields,experience,salary,vacancies,qualification,location,interview)".
	 " VALUES(?,?,?,?,?,?,?,?,?,?,?)");
	 $insert->bind_param("sssssssssss",$employer,$company,$_POST['title'],$_POST['description'],$_POST['fields'],$_POST['experience'],$_POST['salary'],$_POST['vacancies'],$_POST['qualification'],$_POST['location'],$_POST['interview']);
		$insert->execute();
		$insert->close();
		header("Location:com_dashboard.php");

 }
}
  


?>
<html>
<head>
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
	<link rel="stylesheet" href="create_job.css">
	
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    
<Title>Create Job</Title>

</head>

<body>
<section class='header'>
<div class='container'>
<nav class='navbar navbar-expand-lg navbar-light'>
              <a class='navbar-brand'><img src='logo.png' height=100 width=100></a>
              <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarNav' aria-controls='navbarNav' aria-expanded='false' aria-label='Toggle navigation'>
                <span class='navbar-toggler-icon'></span>
              </button>
			  
              <div class='collapse navbar-collapse' id='navbarNav'>
			
                <ul class='navbar-nav ml-auto text-right'>
                  <li class='nav-item'>
                    <a class='nav-link  ' href='com_dashboard.php'>Applications</a>
                  </li>
                  <li class='nav-item'>
                    <a class='nav-link active-home' href='create_job.php'>Create Job</a>
                  </li>
				  <li class='nav-item'>
                    <a class='nav-link ' href='index.php'>Logout</a>
                  </li>
                </ul>
				
              </div>
  </nav>
<form class="form-horizontal" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" enctype="multipart/form-data">
<h1><center>Job Specifications</center></h1>

		<div class="form-group">
		<label for="title" class="col-md-3 control-label">Job Title:*</label>
		<div class="col-md-5">
		<input type="text" name="title" placeholder="Job Title" class="form-control" autofocus value="<?php echo $filled_title?>"size=20 />
		<span class="error"> <?php echo $titleErr;?></span>
		 </div>
		</div>
		
<div class="form-group">
<label for ="description" class="col-md-3 control-label">Job Description: *</label>
<div class="col-md-5">
<textarea name='description' class="form-control" autofocus rows=5 cols=20 >
<?php echo $filled_description?>
</textarea>
<span class="error"> <?php echo $descriptionErr;?></span>
</div>
</div>
	
<div class="form-group">	
<label for ="fields" class="col-md-3 control-label">Job Field:*</label>
<div class="col-md-5">
<span class="error"> <?php echo $fieldsErr;?></span>
<div class="radio">
  <label><input type="radio" name="fields" value="arts">Arts & Architecture</label>
</div>
<div class="radio">  
  <label><input type="radio" name="fields"   value="education">Education</label>
</div>
<div class="radio">   
 <label><input type="radio" name="fields"   value="entertainment">Entertainment</label>
 </div>
<div class="radio">   
 <label> <input type="radio" name="fields"   value="finance">Finance</label>
  </div>
<div class="radio">  
<label><input type="radio" name="fields"  value="health">Health</label>
</div>
<div class="radio">  
 <label> <input type="radio" name="fields"   value="home">Home Services</label> 
</div>
<div class="radio">  
 <label> <input type="radio" name="fields"   value="hospitality">Hospitality </label>
</div>
<div class="radio">  
 <label> <input type="radio" name="fields"    value="IT(product)">IT (product)</label>
</div>
<div class="radio">  
  <label><input type="radio" name="fields"    value="IT(service)">IT (service)</label>
</div>
<div class="radio">  
  <label><input type="radio" name="fields"   value="management">Management</label>
</div>
<div class="radio">  
  <label><input type="radio" name="fields"   value="marketing">Marketing & Sales</label>
</div>
<div class="radio">  
  <label><input type="radio" name="fields"  value="transportation">Transportation</label>
</div>  

  </div>
</div>

<div class="form-group">
<label for ="experience" class="col-md-3 control-label">Experience*</label>
<div class="col-md-5">
<input type="text" name="experience" size="10" class="form-control" value="<?php echo $filled_experience?>" />
<span class="error"><?php echo $experienceErr;?></span>
</div>
</div>

<div class="form-group">
<label for ="salary"class="col-md-3 control-label">Salary*</label>
<div class="col-md-5">
<input type="text"  class="form-control" name="salary" size="10" value="<?php echo $filled_salary?>" />
<span class="error"> <?php echo $salaryErr;?></span>
</div>
</div>

<div class="form-group">
<label for ="vacancies" class="col-md-3 control-label">Vacancies*</label>
<div class="col-md-5">
<input type="text" name="vacancies" class="form-control" size="10" value="<?php echo $filled_vacancies?>" />
<span class="error"> <?php echo $vacanciesErr;?></span>
</div>
</div>

<div class="form-group">
<label for ="qualification" class="col-md-3 control-label">Required Qualification: </label>
<div class="col-md-5">
<textarea name="qualification" class="form-control" rows=3 cols=30>
<?php echo $filled_qualification;?>
</textarea>
<span class="error"> <?php echo $qualificationErr;?></span>
</div>
</div>

<div class="form-group">
<label for ="location" class="col-md-3 control-label">Job Location*</label>
<div class="col-md-10">
<input type="text" name="location" size="50" class="form-control" value="<?php echo $filled_location?>" />
<span class="error"><?php echo $locationErr;?></span>
</div>
</div>

<div class="form-group">
<label for ="interview" class="col-md-3 control-label">Interview details*</label>
<div class="col-md-10">
<input type="text" name="interview" size="50" class="form-control" value="<?php echo $filled_interview?>" />
<span class="error"> <?php echo $interviewErr;?></span>
</div>
</div>

</fieldset>

<center><input type="submit" class="btn btn-dark" value="Create" />
 <input type="reset" value="Clear " class="btn btn-dark" /></center>
</form>

</div>


</section>
</body>
</html>