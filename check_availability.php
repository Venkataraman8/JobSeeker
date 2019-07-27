<?php

require("database_connection.php");
//$db_handle = new DBController();


if(!empty($_POST["user_name"])) {
  $select = "SELECT * FROM cv_details WHERE username='{$_POST['user_name']}';";
  $result=mysqli_query($con,$select);
  sleep(1);
  if($row=mysqli_fetch_row($result)!=NULL) {

      echo "<span class='status-not-available'> Username Not Available.</span>";
  }else{
      echo "<span class='status-available'> Username Available.</span>";
  }
}
?>