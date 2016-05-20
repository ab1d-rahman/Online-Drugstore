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

function profile($dID)
{
	$dbCon = mysqli_connect("localhost", "root", "root", "doctor");

	$sql = "SELECT * FROM doctorInfo WHERE dID='$dID'";
	$query = mysqli_query($dbCon, $sql);

	if($query)
	{
		$row = mysqli_fetch_row($query);

		$data = array(            
            'name' => $row[1],
            'email' => $row[4],
            'specialty' => $row[5],
            'image' => $row[6]        
        );

        return $data;
	}

	return null;
}

function schedule($dID)
{
	$dbCon = mysqli_connect("localhost", "root", "root", "doctor");

	$sql = "SELECT * FROM doctorSchedule WHERE dID='$dID' order by date asc, time asc";
	$query = mysqli_query($dbCon, $sql);
	$r = 0;

	while($row = mysqli_fetch_assoc($query)) 
	{
		$data[$r][0] = $row['date'];
		$data[$r][1] = $row['time'];
		$data[$r][2] = $row['maxapp'];
		$data[$r][3] = $row['apptaken'];
		$data[$r][4] = $row['sID'];
		$r++;
	}

	return $data;
}


function addSchedule($data)
{
	$dbCon = mysqli_connect("localhost", "root", "root", "doctor");

	$dID = cleanInput($dbCon, $data['dID']);
	$time = cleanInput($dbCon, $data['time']);
    $date = cleanInput($dbCon, $data['date']);
	$maxapp = cleanInput($dbCon, $data['maxapp']);   
	$apptaken = 0;

	$time = $time .":00";
    $date = substr($date, 6, 4) . substr($date, 2, 4) . substr($date, 0, 2);

	$sql = "INSERT INTO doctorSchedule (dID, date, time, maxapp, apptaken) 
							VALUES ('$dID', '$date', '$time', '$maxapp', '$apptaken')";

	$query = mysqli_query($dbCon, $sql);

	return $query;
}


function deleteSchedule($sID)
{
	$dbCon = mysqli_connect("localhost", "root", "root", "doctor");

	$sql = "DELETE FROM appointments WHERE sID='$sID'";
	$query = mysqli_query($dbCon, $sql);

	$sql = "DELETE FROM doctorSchedule WHERE sID='$sID'";
	$query = mysqli_query($dbCon, $sql);
}
	



?>