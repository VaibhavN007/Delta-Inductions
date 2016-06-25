<?php
session_start();
$user="";
$pass="";
$email="";
$phone_no="";
$phone_error="";
$image="";
$pre_image="";
$imageName="";
$image_message="";
if(isset($_SESSION['user'])=="")
{
 header("Location: index.php");
}

include_once 'connect.php';
$result="";
$row=[];
if($result = mysqli_query($con,"SELECT * FROM users WHERE id=".$_SESSION['user']."")){

while($row = mysqli_fetch_row($result)){
		$user = $row[1];
		$email = $row[3];
		$pre_image = $row[4];
		$phone_no = $row[5];
	}

if($phone_no=="" || $phone_no==0)
	$phone_no = "NULL";

?>

<?php
}

if(isset($_POST['update_button']))
{
 $user = mysqli_real_escape_string($con,$_POST['username']);
 $email = mysqli_real_escape_string($con,$_POST['email']);
 
 if(empty($_POST['phone']) || $_POST['phone']==="NULL"){
	$phone_no="NULL";
 }
 else{
	$phone_no = $_POST['phone'];
	if(preg_match("/^[1-9][0-9]{5,10}$/",$phone_no))
	{
		$phone_no=$_POST['phone'];
	}
	else
	{	
		$phone_error = "Invalid phone number";
	}
 }
 
if(isset($_FILES['image']))
{
	$image = addslashes($_FILES['image']['tmp_name']);
	
	if($image)
	{
		$image = file_get_contents($image);
		$image = base64_encode($image);
		
		$imageName = addslashes($_FILES['image']['name']);
		
		$image_type = addslashes($_FILES['image']['type']);
		if(substr($image_type,0,5)!="image")
		{
			$image_message = "Only images are allowed";
		}
	
	}
}
 
 
 if(empty($phone_error) && empty($image_message) && mysqli_query($con,"INSERT INTO users(username,password,email,profile_pic,phone) VALUES('$user','$pass','$email','$image','$phone_no')"))
 {
  ?>
        <script>alert('Data successfully updated');</script>
        <?php
 }
 else
 {
  ?>
        <script>alert('error while updating...');</script>
        <?php
 }
 
}
?>
<html>
<head>
<title>Login & Registration System</title>
<style>

#error{
	color:red;
	margin-top:2px;
}
#profile{
 color:#0055ff;
 margin-top:0px;
 padding-left:40px;
 font-family:Verdana, Geneva, sans-serif;
 font-size:16px;
 
}
p{
	margin:0;
	padding:0;
	display:inline;
}
#signup_form
{
 margin-top:5px;
}
table
{
 border:solid 1px #4dff4d;
 padding:25px;
 box-shadow: 2px 2px 3px #33ff33;
 border-radius:40px;
}
#profile_pic{
	height:200px;
	width:200px;
	padding:0;
	margin-left:15px;
	margin-top:0;
	margin-bottom:0;
	margin-right:0px;
	border:1px solid #4d88ff;
	box-shadow:0px 0px 25px #4d88ff;
}
#upload_pic{
	margin-top:10px;
	margin-left:70px;
}
#profile_data{
	padding:18px;
	border:1px solid #e2e2e2;
	background:#f9f9f9;
	border-radius:40px;
}
table tr,td
{
 padding:15px;
}
table tr td input
{
 width:100%;
 height:45px;
 border:solid 1px #e1e1e1;
 border-radius:40px;
 color:#0055ff;
 padding-left:20px;
 font-family:Verdana, Geneva, sans-serif;
 font-size:16px;
 background:#f9f9f9;
 box-shadow: 1px 0px 2px #f8f8f8;
}

table tr td input:active{
	position:relative;
	top:2px;
}
table tr td input:focus{
	outline:none;
	border:1px solid #f8f8f8;
	box-shadow:1px 1px 3px #4d88ff;
}
#uploadImg	{
	display:none;
}
table tr td button
{
 width:100%;
 height:45px;
 border:0px;
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

table tr td a
{
 text-decoration:none;
 color:#00a2d1;
 font-family:Verdana, Geneva, sans-serif;
 font-size:18px;
}

</style>
</head>
<body>
<center>

<div id="signup_form">

<form method="post" enctype="multipart/form-data" name="details">

<table align="center" width="30%" border="0">


<tr>
	<td>
		<input type="text" id="Uname" name="username" placeholder="Username" value="<?php echo $user;?>" required autofocus/>
	</td>
</tr>
<tr>
	<td>
		<input type="email" name="email" placeholder="Email Address" value="<?php echo $email;?>" required />
	</td>
</tr>
<tr>
	<td>
		<input type="text" name="phone" placeholder="Phone number" value="<?php echo $phone_no;?>"/>
		&nbsp;&nbsp;<span id="error"><?php echo $phone_error;?></span>
	</td>
</tr>
<tr colspan=2 style="text-align:center;">
	<td>
		<?php if($pre_image) echo "<br><br><img id='profile_pic' src='data:image;base64,".$pre_image."' >";?>
	</td>
</tr>
<tr>
	<td id="profile_data">
		<span id="profile">Profile Picture : 
		<p id="url">
		Not Selected
		</p>
		<br>
		<img id="upload_pic" src="upload.png" height="45px" onclick="document.getElementById('uploadImg').click();"/>
		</span>
		
		&nbsp;&nbsp;<span id="error"><?php echo $image_message;?></span>
	</td>
</tr>
<tr>
	<td>
		<button  style="margin-top:20;" type="submit" name="update_button">Update details</button>
	</td>
</tr>
<tr>
	<td style="text-align:center">
		<a href="homepage.php">Return to Homepage</a>
	</td>
</tr>

<input type="file" id="uploadImg" name="image" onchange="var file=document.getElementById('uploadImg').value; var name = file.substr(0,12) ; document.getElementById('url').innerHTML=file.replace(name,'');"/><br>
</table>

</form>

</div>

</center>
</body>
</html>