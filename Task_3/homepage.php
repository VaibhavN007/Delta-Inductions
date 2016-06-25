<?php
session_start();
$user="";
$user_id="";
$pass="";
$email="";
$phone_no="";
$phone_error="";
if(isset($_SESSION['user'])=="")
{
 header("Location: index.php");
}
include_once 'connect.php';

$user_id=$_SESSION['user'];

$result = mysqli_query($con,"SELECT * FROM users WHERE id='$user_id'");
$row = mysqli_fetch_array($result);
$user = $row['username'];
$email = $row['email'];
$phone_no = $row['phone'];
if($phone_no=="" || $phone_no==0)
	$phone_no="N/A";



?>
<html>
<head>
<title>Login & Registration System</title>
<style>

#details
{
 margin-top:70px;
}
table
{
 border:solid 1px #4dff4d;
 padding:25px;
 padding-left:30px;
 padding-right:30px;
 box-shadow: 2px 2px 3px #33ff33;
 border-radius:40px;
 color:#3c52ff;
}
table tr,td
{
 padding:15px;
 font-family:Geneva,Verdana,sans-serif;
 font-size:17px;
}

table tr td button
{
 width:100%;
 height:45px;
 border:0px;
 margin-left:80px;
 background:#4d88ff;
 border-radius:40px;
 box-shadow: 1px 1px 1px rgba(1,0,0,0.2);
 color:#f9f9f9;
 font-family:Verdana, Geneva, sans-serif;
 font-size:18px;
 font-weight:bolder;
}

table tr td button:active
{
 position:relative;
 top:2px;
 outline:none;
}
table tr td button:focus
{
 outline:none;
}
table tr td a
{
 text-decoration:none;
 color:#00a2d1;
 font-family:Verdana, Geneva, sans-serif;
 font-size:18px;
 margin-left:150px;
}
img{
	height:200px;
	width:200px;
	padding:0;
	margin-left:165px;
	margin-top:0;
	margin-bottom:0;
	margin-right:0px;
	border:1px solid #4d88ff;
	box-shadow:0px 0px 25px #4d88ff;
}

</style>
</head>
<body>
<center>

<div id="details">

<form method="post">

<table align="center" width="30%" border="0">


<tr>
	<td>
		Username :
	</td>
	<td>
		<?php echo $user;?>
	</td>
</tr>
<tr>
	<td>
		Email id :
	</td>
	<td>
		<?php echo $email;?>
	</td>
</tr>
<tr>
	<td>
		Phone number :
	</td>
	<td>
		<?php echo $phone_no;?>
	</td>
</tr>
<tr colspan=2 style="text-align:center;">
	<td>
		<?php if($row['profile_pic']) echo "<br><br><img src='data:image;base64,".$row['profile_pic']."' >";?>
	</td>
</tr>
<tr colspan=2>
	<td style="text-align:center;">
		<a href="alter.php">Update Details</a>
	</td>
</tr>
<tr colspan=2 >
	<td style="text-align:center;">
		<button type="submit" name="logout_button">LOGOUT</button>
	</td>
</tr>

<?php
if(isset($_POST['logout_button'])){
	session_unset();
	session_destroy();
	echo "<script>location.replace('index.php')</script>";
}
?>


</table>

</form>

</div>

</center>

</body>
</html>