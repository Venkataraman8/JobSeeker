<?php

require "database_constants.php";

$con=mysqli_connect(DATABASE_HOST,DATABASE_USERNAME,DATABASE_PASSWORD)
or die("<p>Error connecting to database".mysqli_error($con)."</p>");

mysqli_select_db($con,DATABASE_NAME)
or die("<p>Error selecting database". DATABASE_NAME .mysqli_error($con)."</p>");

try {
  $mysqli = new mysqli(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);
  $mysqli->set_charset("utf8mb4");
} catch(Exception $e) {
  error_log($e->getMessage());
  exit('Error connecting to database'); 
}
?>
