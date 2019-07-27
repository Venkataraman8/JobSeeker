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
echo"<center><h2>Received Applications</h2></center>";
$select=$mysqli->prepare("SELECT * FROM jobs where employer=?");
$select->bind_param("s",$_SESSION["user_name"]);
$select->execute();
$result=$select->get_result();

while($row=$result->fetch_assoc())
{

echo"<h3>Applications for {$row['title']} </h3>";
echo "<table border=3>";
echo"<tr>
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
				</tr>";
			}
			$select2->close();
	}
	$select1->close();
	
echo "</table>";
}
$select->close();
?>
