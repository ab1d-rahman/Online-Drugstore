<?php 


include_once "myFunctions.php";

session_start();
session_regenerate_id();

function insert($data)
{
	$dbCon = mysqli_connect("localhost", "root", "root", "doctor");


	$name = cleanInput($dbCon, $data['name']);
	$username = cleanInput($dbCon, $data['username']);
	$password = cleanInput($dbCon, $data['password']);
	$email = cleanInput($dbCon, $data['email']);
	$specialty = cleanInput($dbCon, $data['specialty']);

	$password = hashPassword($password);

	// echo "$name $username $password $email";

	$image = addslashes($data['image']);
	$image = file_get_contents($image);	
	$image = base64_encode($image);


	$sql = "INSERT INTO doctorInfo (name, username, password, email, specialty, image) 
							VALUES ('$name', '$username', '$password', '$email', '$specialty', '$image')";
	$query = mysqli_query($dbCon, $sql);
	return $query;
}

function authenticate($data)
{
	$dbCon = mysqli_connect("localhost", "root", "root", "doctor");
	
	$username = cleanInput($dbCon, $data['username']);
	$password = cleanInput($dbCon, $data['password']);

	$sql = "SELECT username, password, dID, name FROM doctorInfo WHERE username='$username'";
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
			$_SESSION['isDoc'] = true;
			$_SESSION['isUser'] = false;
			$_SESSION['dID'] = $row[2];
			return "Success";
		}
		return null;
	}

	return null;

}
	



?>