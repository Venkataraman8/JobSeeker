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

if(!empty($_POST['username']) && !empty($_POST['job_id']))
{
	
	$username=$_POST['username'];
	$job_id=$_POST['job_id'];
	
	$select=$mysqli->prepare("SELECT * from notifications WHERE username=? and job_id=?");
	$select->bind_param("si",$username,$job_id);
	$select->execute();
	$result=$select->get_result();
	$row=$result->fetch_assoc();
	$select->close();
	
	if($row==NULL)
	{
	$insert=$mysqli->prepare("INSERT INTO notifications(username,job_id) VALUES(?,?)");
	$insert->bind_param("si",$username,$job_id);
	$insert->execute();
	$insert->close();
	}
}