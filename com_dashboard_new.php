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
$username=$_SESSION['user_name'];
$k=0;
echo "<body>
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
                    <a class='nav-link active-home ' href='com_dashboard.php'>Applications</a>
                  </li>
                  <li class='nav-item'>
                    <a class='nav-link' href='create_job.php'>Create Job</a>
                  </li>
				  <li class='nav-item'>
                    <a class='nav-link ' href='index.php'>Logout</a>
                  </li>
                </ul>
				
              </div>
  </nav>
";


$select=$mysqli->prepare("SELECT * FROM jobs where employer=?");
$select->bind_param("s",$_SESSION["user_name"]);
$select->execute();
$result=$select->get_result();


while($row=$result->fetch_assoc())
{
		echo
"<table class='table  table-dark' style='opacity:0.8; width=80%;'>
<h3><center>Applications for {$row['title']}</center></h3>
<tr>
<th>First Name</th>
<th>Last Name</th>
<th>Age</th>
<th>Gender</th>
<th>E-mail</th>
<th>Phone number</th>
<th>Location</th>
<th>Aadhar number</th>
<th>CV</th>
</tr>";

$select1=$mysqli->prepare("SELECT * from sent_cvs where job_id=?");
	$select1->bind_param("i",$row['job_id']);
	$select1->execute();
	$result1=$select1->get_result();
	
while($row1=$result1->fetch_assoc())
{
$username=$row1['username'];
		$select2=$mysqli->prepare("SELECT * from cv_details where username=?");
		$select2->bind_param("s",$username);
		$select2->execute();
		$result2=$select2->get_result();
	
			while($row2=$result2->fetch_assoc())
			{
				$file_system_path=$row2['cv'];
				$web_path=str_replace($_SERVER['DOCUMENT_ROOT'].'/JobSeeker/', './', $file_system_path);
				echo"<tr>
				<td>{$row2['firstname']}</td>
				<td>{$row2['lastname']}</td>
				<td>{$row2['age']}</td>
				<td>{$row2['gender']}</td>
				<td>{$row2['email']}</td>
				<td>{$row2['phone']}</td>
				<td>{$row2['location']}</td>
				<td>{$row2['aadhar']}</td>
				<td><a href='{$web_path}' download>Download CV</a></td>
				<td><button id={$k} onclick=notify({$k},{$row['job_id']},'{$row2['username']}') >Select</button></td>
				</tr>";
				$k++;
			}
			$select2->close();
	}
	$select1->close();
echo"</table><br/><br/>";
}
$select->close();


?>
<html>
<head>
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script>
function notify(button_id,job_id,username) 
{
console.log(username);
jQuery.ajax({
url: "notify.php",
data:{username:username, job_id:job_id},
type: "POST",
success:function(data)
{
$('#'+button_id).css('background-color','green');
},
error:function (){}
});
}


</script>
<link href='com_dashboard8.css' rel='stylesheet' type='text/css'>	
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


<Title>Dashboard</Title>
</head>
<body>
</div>
</section>
</body>
</html>

