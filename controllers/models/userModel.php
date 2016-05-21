<?php 


include_once "myFunctions.php";

session_start();
session_regenerate_id();

function insertUser($data)
{
	$dbCon = mysqli_connect("localhost", "root", "root", "doctor");


	$name = cleanInput($dbCon, $data['name']);
	$username = cleanInput($dbCon, $data['username']);
	$password = cleanInput($dbCon, $data['password']);
	$email = cleanInput($dbCon, $data['email']);

	$password = hashPassword($password);

	// echo "$name $username $password $email";

	$image = addslashes($data['image']);
	$image = file_get_contents($image);	
	$image = base64_encode($image);


	$sql = "INSERT INTO userInfo (name, username, password, email, image) VALUES ('$name', '$username', '$password', '$email', '$image')";
	$query = mysqli_query($dbCon, $sql);
	return $query;
}

function authenticateUser($data)
{
	$dbCon = mysqli_connect("localhost", "root", "root", "doctor");
	
	$username = cleanInput($dbCon, $data['username']);
	$password = cleanInput($dbCon, $data['password']);

	$sql = "SELECT username, password, uID, name FROM userInfo WHERE username='$username'";
	$query = mysqli_query($dbCon, $sql);

	if($query)
	{
		$row = mysqli_fetch_row($query);
		$DBusenrame = $row[0];
		$DBpassword = $row[1];

		if($username == $DBusenrame && password_verify($password, $DBpassword) == true)
		{
			$_SESSION['username'] = $username;
			$_SESSION['name'] = $row[3];
			$_SESSION['isDoc'] = false;
			$_SESSION['isUser'] = true;			
			$_SESSION['isAdmin'] = false;
			$_SESSION['uID'] = $row[2];
			return "Success";
		}
		return null;
	}

	return null;


}

function authenticateAdmin($data)
{
	$dbCon = mysqli_connect("localhost", "root", "root", "doctor");
	
	$username = cleanInput($dbCon, $data['username']);
	$password = cleanInput($dbCon, $data['password']);

	$sql = "SELECT username, password, adID FROM adminInfo WHERE username='$username'";
	$query = mysqli_query($dbCon, $sql);

	if($query)
	{
		$row = mysqli_fetch_row($query);
		$DBusenrame = $row[0];
		$DBpassword = $row[1];

		if($username == $DBusenrame && $password == $DBpassword)
		{
			$_SESSION['username'] = $username;	
			$_SESSION['name'] = "Admin";		
			$_SESSION['isDoc'] = false;
			$_SESSION['isUser'] = false;
			$_SESSION['isAdmin'] = true;
			$_SESSION['adID'] = $row[2];
			return "Success";
		}
		return null;
	}

	return null;


}
	

function checkAppointment($sID, $uID)
{
	$dbCon = mysqli_connect("localhost", "root", "root", "doctor");
	$sql = "SELECT * FROM appointments WHERE sID='$sID' AND uID='$uID'";
	$query = mysqli_query($dbCon, $sql);
	return mysqli_num_rows($query);
}

function makeAppointment($sID, $uID)
{
	$dbCon = mysqli_connect("localhost", "root", "root", "doctor");

	$sql = "SELECT * FROM doctorSchedule WHERE sID='$sID'";
	$query = mysqli_query($dbCon, $sql);

	$_sql = "SELECT * FROM appointments WHERE sID='$sID' AND uID='$uID'";
	$_query = mysqli_query($dbCon, $_sql);

	if(mysqli_num_rows($query) == 1 && mysqli_num_rows($_query) == 0)
	{
		$sql = "INSERT INTO appointments (sID, uID) VALUES ('$sID', '$uID')";
		$query = mysqli_query($dbCon, $sql);		

		$sql = "UPDATE doctorSchedule SET apptaken = apptaken + 1 WHERE sID='$sID'";
		$query = mysqli_query($dbCon, $sql);

		return $query;
	}

	return null;
}


?>