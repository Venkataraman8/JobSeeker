<?php
session_start();

if(!isset($_SESSION["user_name"]) || !isset($_SESSION['type']))
{
header("Location:index.php");
exit();
}

if($_SESSION['type']!='applicant')
{
header("Location:index.php");
exit();
}

require "database_connection.php";
$username=$_SESSION['user_name'];

echo "<body>
<section class='header'>
<div class='container'>
<nav class='navbar navbar-expand-lg navbar-light'>
              <a class='navbar-brand'><img src='logo.png' height=100 width=100></a>
              <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarNav' aria-controls='navbarNav' aria-expanded='false' aria-label='Toggle navigation'>
                <span class='navbar-toggler-icon'></span>
              </button>
			  
              <div class='collapse navbar-collapse' id='navbarNav'>
			  <div class='col-sm-5 col-md-5 navbar-nav ml-auto text-right'>
        <form class='navbar-form' role='search' method='POST' action='search.php'>
        <div class='input-group'>
            <input type='text' class='form-control' placeholder='Search By Field' name='search'>
            <div class='input-group-btn'>
                <button class='btn btn-light' type='submit'>Go</button>
            </div>
        </div>
        </form>
    </div>
                <ul class='navbar-nav ml-auto text-right'>
                  <li class='nav-item'>
                    <a class='nav-link active-home ' href='app_dashboard.php'>Dashboard</a>
                  </li>
                  <li class='nav-item'>
                    <a class='nav-link' href='profile.php'>Profile</a>
                  </li>
				  <li class='nav-item'>
                    <a class='nav-link ' href='index.php'>Logout</a>
                  </li>
                </ul>
				
              </div>
  </nav>
";


$select=$mysqli->prepare("SELECT * FROM jobs");
$select->execute();
$result=$select->get_result();



		echo
"<table class='table  table-dark' style='opacity:0.8;'>
<tr>
<th>COMPANY NAME</th>
<th>JOB</th>	
<th>CATEGORY</th>
<th>DETAILS</th>
</tr>
";
while($row=$result->fetch_assoc())
{
	$color='white';
	echo"<tr>
	<td>{$row['company']}</td>
	<td>{$row['title']}</td>
	<td>{$row['fields']}</td>";
						$select1=$mysqli->prepare("SELECT * from sent_cvs where username=? and job_id=?");
						$select1->bind_param("si",$username,$row['job_id']);
						$select1->execute();
						$result1=$select1->get_result();
						$row1=$result1->fetch_assoc();
						if($row1==NULL) {$color='white';$display='none';}
							else {$color='green';$display='block';}
						$select1->close();
						
						$sel=$mysqli->prepare("SELECT * from company where username=?");
						$sel->bind_param("s",$row['employer']);
						$sel->execute();
						$res=$sel->get_result();
						$r=$res->fetch_assoc();
						$sel->close();
						$file_system_path=$r['logo'];
						$web_path=str_replace("'","\'",str_replace($_SERVER['DOCUMENT_ROOT'].'/JobSeeker/', './', $file_system_path));
echo"<td><input type='button' class='btn btn-primary' value='More...' onclick=\"(function(){
	
	if(document.getElementById('myModal') && document.getElementById('modal-content') )
  {
	var modal=document.getElementById('myModal');
	var content=document.getElementById('modal-content');
	
		modal.style.display='block';
		content.innerHTML='<center><h3><img src=\'{$web_path}\' width=50 height=50 />".$row['company']."</h3></center>'+
		'<center>".$row['title']."</center><br>'+
			'Description: ".$row['description']."</br>'+
			'Fields: ".$row['fields']."</br>'+
			'Experience: ".$row['experience']."</br>'+
			'Salary: ".$row['salary']."</br>'+
			'Vacancies: ".$row['vacancies']."</br>'+
			'Qualification: ".$row['qualification']."</br>'+
			'Location: ".$row['location']."</br>'+
			'Interview:<span style=\'color:blue\'> ".$row['interview']."</span></br>'+
			'<center><input type=button style=\'background-color:".$color."\' id=send value=SendCV onclick=\'action1(". $row['job_id'].")\' /></center>'+
			'<center><span id=senttxt style=\'color:red;display:".$display."\' >Your CV details has been Sent</center>';
	
  }
})()\"  /></td></tr>";



}
echo"</table><br/><br/>";

$select->close();

?>
<html>
<head>
<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<link href='app_dashboard8.css' rel='stylesheet' type='text/css'>	
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>

window.onclick = function(event) 
{
	var modal = document.getElementById("myModal");
var content = document.getElementById("modal-content");
		  if (event.target == modal)
			  {
			modal.style.display = "none";
			content.innerHTML="";
			
			}
 }
  
 function action1(id)
{
	var username= '<?php echo $_SESSION['user_name']?>';
	$.ajax({
		url: 'sendcv.php',
		type: 'post',
		data:{ job_id: id , username: username },
		success:function(data)
		{
			$('#send').css('background-color','green');
			$('#senttxt').css('display','block');
		}
	});
} 
</script>

<Title>Dashboard</Title>
</head>
<body>
		<div id="myModal" class="modal">
			<div class="modal-content" id="modal-content">
			</div>
		</div>

</div>
</section>
</body>
</html>

