<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Doctor Profile</title>


<link rel="stylesheet" href="css/reset.css" type="text/css" />
<link rel="stylesheet" href="css/styles.css" type="text/css" />
<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">



<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />


</head>
<body>

<?php

error_reporting(~E_NOTICE);
session_start();
session_regenerate_id();

?>

<div id="container">

    <div id="header"> 

       <div class="width">

           <h1><a href="index.php">Online<strong>DrugStore</strong></a></h1>
              <nav>
    
                    <ul class="sf-menu dropdown">

                
                        <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>

                    
                        <li><a href="#"><i class="fa fa-database"></i> All Products</a> </li>
                    
                        <li><a href="#"><i class="fa fa-phone"></i> Contact</a></li>

                        <?php
                        if($_SESSION['username'])
                        {
                        ?>              
                            <li><a href=<?php if($_SESSION['isUser'] == true) echo "userProfile.php"; else if($_SESSION['isDoc'] == true) echo "doctorProfile.php"; else echo "adminActions.php"; ?>><i class="fa fa-user"></i> <?php echo $_SESSION['name']; ?> </a>
                            <li><a href="logout.php"><i class="fa fa-sign-in"></i> Logout </a></li>

                        <?php
                        }

                        else
                        {
                        ?>
                        <li><a href="#"><i class="fa fa-sign-in"></i> Sign In</a>
                            <ul>
                                    <li><a href="userLogin.php">As User</a></li>
                                    <li><a href="doctorLogin.php">As Doctor</a></li>
                            </ul>
                        </li>
                        <li><a href="#"><i class="fa fa-key"></i> Register</a>
                            <ul>
                                    <li><a href="userRegister.php">As User</a></li>
                                    <li><a href="doctorRegister.php">As Doctor</a></li>
                            </ul>
                        </li>
                        <?php
                        }
                        ?>

                    </ul>

                
              </nav>
        </div>

        <div class="clear"></div>

       
    </div>


    <div id="body" class="width">


<?php

include_once "controllers/doctorController.php";
include_once "controllers/userController.php";


if($_SESSION['isDoc'] == true)
{	

	if($_GET['sID'])		// Doctor Pressed Cancel Appointment
	{
		$doctorController->cancelDoctorSchedule($_GET['sID']);
	}

	$dID = $_SESSION['dID'];
	if((isset($_GET['dID']) && $dID == $_GET['dID']) || (empty($_GET['dID']) && $_SESSION['isDoc'] == true))   // Doctor visiting his own profile
	{

		
		$data = $doctorController->getDoctorProfile($dID);

		echo "<img src=\"data:image;base64," . $data['image'] . "\" style=\"float:right; margin: 0 0 10px 10px;\" height=\"250\" width=\"250\">";
		echo "<h3>Name: ". $data['name'] . "<br><br>Email: ". $data['email'] . "<br><br>Specialty: ". $data['specialty'] . "</h3>";
		

		
		echo "<br><br><br><br><br><h2>My Schedule</h2>";

		$data = $doctorController->getDoctorSchedule($dID);

		echo "<table><tr><th>Date</th><th>Time</th><th>Maximum<br>Appointments</th><th>Appointments<br>Taken</th><th></th></tr>";
		foreach ($data as $d) 
		{
			$date = substr($d[0], 8, 2) . substr($d[0], 4, 4) . substr($d[0], 0, 4);

			echo "<tr><td>". $date ."</td><td>". $d[1] ."</td><td>". $d[2] ."</td><td>". $d[3] ."</td>
		        <td><a class=\"button\" href=\"doctorProfile.php?sID=". $d[4] ."\">Cancel Appointments</a></td></tr><br>";
		}		

	
		echo "
		</table> <br> <br>
		<a class=\"button\" id=\"link\" href=\"addSchedule.php\">Add Schedule!</a>
		";
		
	}

	else 																		// Doctor visiting another doctor's profile
	{
		$dID = $_GET['dID'];

		$data = $doctorController->getDoctorProfile($dID);

		echo "<img src=\"data:image;base64," . $data['image'] . "\" style=\"float:right; margin: 0 0 10px 10px;\" height=\"250\" width=\"250\">";
		echo "<h3>Name: ". $data['name'] . "<br><br>Email: ". $data['email'] . "<br><br>Specialty: ". $data['specialty'] . "</h3>";
		

		
		echo "<br><br><br><br><br><h2>Schedule</h2>";

		$data = $doctorController->getDoctorSchedule($dID);

		echo "<table><tr><th>Date</th><th>Time</th><th>Maximum<br>Appointments</th><th>Appointments<br>Taken</th><th></th></tr>";
		foreach ($data as $d) 
		{
			$date = substr($d[0], 8, 2) . substr($d[0], 4, 4) . substr($d[0], 0, 4);

			echo "<tr><td>". $date ."</td><td>". $d[1] ."</td><td>". $d[2] ."</td><td>". $d[3] ."</td>
		        <td></td></tr><br>";
		}		

	
		echo "</table>";
	}
	
}

else
{
	$dID = $_GET['dID'];
	$uID = $_SESSION['uID'];
	if($_GET['sID'] && $_SESSION['isUser'] == true)
	{
		$sID = $_GET['sID'];	

		if($userController->takeAppointment($sID, $uID) == "Successful") 
		{
			?>
			<script type="text/javascript">
			alert("Appointment Successfully Taken!");
			</script>
			<?php
		}

		else 
		{
			?>
			<script type="text/javascript">
			alert("Error");
			</script>
			<?php
		}			
		
	}


	else if($_GET['sID'] && $_SESSION['isUser'] == false)
	{
		?>

		<script type="text/javascript">
			alert("You have to be logged in as a user to make an appointment!");
		</script>
		<?php
	}


	$data = $doctorController->getDoctorProfile($dID);

	echo "<img src=\"data:image;base64," . $data['image'] . "\" style=\"float:right; margin: 0 0 10px 10px;\" height=\"250\" width=\"250\">";
	echo "<h3>Name: ". $data['name'] . "<br><br>Email: ". $data['email'] . "<br><br>Specialty: ". $data['specialty'] . "</h3>";	

	
	echo "<br><br><br><br><br><h2>Schedule</h2>";

	$data = $doctorController->getDoctorSchedule($dID);

	echo "<table><tr><th>Date</th><th>Time</th><th>Maximum<br>Appointments</th><th>Appointments<br>Taken</th><th></th></tr>";
	foreach ($data as $d) 
	{
		$date = substr($d[0], 8, 2) . substr($d[0], 4, 4) . substr($d[0], 0, 4);

		if($userController->appointmentTaken($d[4], $uID) == 0)
		{
			if($d[2] > $d[3]) echo "<tr><td>".$date."</td><td>".$d[1]."</td><td>".$d[2]."</td><td>".$d[3]."</td>
		        <td><a class=\"button\" href=\"doctorProfile.php?sID=".$d[4]."&dID=$dID\">Make Appointment</a></td></tr><br>";

		    else echo "<tr><td>".$date."</td><td>".$d[1]."</td><td>".$d[2]."</td><td>".$d[3]."</td>
		        <td>Appointment Unavailable!</td></tr><br>";
		}


		else echo "<tr><td>".$date."</td><td>".$d[1]."</td><td>".$d[2]."</td><td>".$d[3]."</td>
		        <td>Appointment Taken</td></tr><br>";
	}

	echo "</table>";	
}



?>

    </div>

</div>


<div id="footer">
    <div class="footer-content width">
        
        
        <ul class="endfooter">

            <li><h4>SHARE</h4></li>

            <li>Share our website on social media. <br /><br />

                <div class="social-icons">

                    <a href="#"><i class="fa fa-facebook fa-2x"></i></a>
                    <a href="#"><i class="fa fa-twitter fa-2x"></i></a>
                    <a href="#"><i class="fa fa-youtube fa-2x"></i></a>
                    <a href="#"><i class="fa fa-instagram fa-2x"></i></a>

                </div>

            </li>

         </ul>
                    
        <div class="clear"></div>

    </div>

    <div class="footer-bottom">

        <p>&copy;Abid, Rony, Saqib!2016</p>

    </div>

</div>




</body>
</html>
