<?php
require "database_connection.php";


$create1="CREATE TABLE IF NOT EXISTS cv_details (
	user_id int AUTO_INCREMENT PRIMARY KEY,
	
	username varchar(20) NOT NULL,
	password varchar(80) NOT NULL,
	
	firstname varchar(20) NOT NULL,
	lastname varchar(20) NOT NULL,
	age varchar(20) NOT NULL,
	gender varchar(20) NOT NULL,

	email varchar(20) NOT NULL,
	phone varchar(20) NOT NULL,
	location varchar(100) NOT NULL,
	aadhar varchar(20) NOT NULL,
	
	cv varchar(100) NOT NULL
	
);";

$create2="CREATE TABLE IF NOT EXISTS company (
	user_id int AUTO_INCREMENT PRIMARY KEY,
	
	username varchar(20) NOT NULL,
	password varchar(80) NOT NULL,
	
	company varchar(20) NOT NULL,
	company_id varchar(20) NOT NULL,
	address varchar(100) NOT NULL,

	email varchar(20) NOT NULL,
	phone varchar(20) NOT NULL,

	logo varchar(20) NOT NULL
	
);";

$create3="CREATE TABLE IF NOT EXISTS jobs(
job_id int AUTO_INCREMENT PRIMARY KEY,
employer varchar(20) NOT NULL,
  company varchar(20) NOT NULL,
  title varchar(20) NOT NULL,
  description varchar(100) NOT NULL,
  fields varchar(20) NOT NULL,
  experience varchar(10) NOT NULL,
  salary varchar(10) NOT NULL,
  vacancies varchar(10) NOT NULL,
  qualification varchar(100) NOT NULL,
  location varchar(50) NOT NULL,
  interview varchar(50) NOT NULL
);";

$create4="CREATE TABLE IF NOT EXISTS sent_cvs(
    username varchar(20) NOT NULL,
	job_id int NOT NULL,
	selected varchar(10)
);";


mysqli_query($con,$create1) or die(mysqli_error($con));
mysqli_query($con,$create2) or die(mysqli_error($con));
mysqli_query($con,$create3) or die(mysqli_error($con));
mysqli_query($con,$create4) or die(mysqli_error($con));
?>