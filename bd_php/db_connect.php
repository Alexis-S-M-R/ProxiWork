<?php

$sname= "localhost";
$unmae= "root";
$password = "your_root_password";

$db_name = "proxiWork";

$conn = mysqli_connect($sname, $unmae, $password, $db_name);

if (!$conn) {
	echo "Connection failed!";
} 