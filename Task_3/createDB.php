<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Webdev_Task_by_Vaibhav";
$con = mysqli_connect($servername,$username,$password);

if(!$con){
	die("Connection failed: ".mysqli_connect_error());
}

$createDB = "CREATE DATABASE $dbname";

if(mysqli_query($con,$createDB)){
	echo "Database created successfully";
}
else{
	echo "Error creating databse: ".mysqli_error($con);
}

if(!mysqli_select_db($con,$dbname))
	echo nl2br("\nDatabase could not be selected");
else{
	
$createTB = "CREATE TABLE users(
 id int(11) NOT NULL AUTO_INCREMENT UNIQUE,
 username varchar(255) NOT NULL,
 password varchar(40) NOT NULL,
 email varchar(255) NOT NULL,
 profile_pic longblob,
 phone int(11) DEFAULT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=latin1";

if(mysqli_query($con,$createTB))
{
	echo nl2br("\nTable users created successfully");
}
else
{
	echo nl2br("\nError creating table: ".mysqli_error($con));
}

}
mysqli_close($con);
?>