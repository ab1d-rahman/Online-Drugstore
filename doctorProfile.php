<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>city - Free CSS Template by ZyPOP</title>


<link rel="stylesheet" href="css/reset.css" type="text/css" />
<link rel="stylesheet" href="css/styles.css" type="text/css" />
<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">


<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/slider.js"></script>
<script type="text/javascript" src="js/superfish.js"></script>

<script type="text/javascript" src="js/custom.js"></script> -->

<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />

<!--
city, a free CSS web template by ZyPOP (zypopwebtemplates.com/)

Download: http://zypopwebtemplates.com/

License: Creative Commons Attribution
//-->
</head>
<body>

<?php

error_reporting(~E_NOTICE);
session_start();

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
                            <li><a href=<?php if($_SESSION['isUser'] == true) echo "userProfile.php"; else echo "doctorProfile.php" ?>><i class="fa fa-user"></i> <?php echo $_SESSION['name']; ?> </a>
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

include_once("connection.php");
include_once("database_helper.php");

if($_SESSION['isDoc'] == true)
{	

	if($_GET['sID'])		// Doctor Pressed Cancel Appointment
	{
		$sID = $_GET['sID'];
		$sql = "DELETE FROM appointments WHERE sID='$sID'";
		$query = mysqli_query($dbCon, $sql);

		$sql = "DELETE FROM doctorSchedule WHERE sID='$sID'";
		$query = mysqli_query($dbCon, $sql);
	}

	$dID = $_SESSION['dID'];
	if(isset($_GET['dID']) && $dID == $_GET['dID'] || empty($_GET['dID']))   // Doctor visiting his own profile
	{

		$sql = "SELECT * FROM doctorInfo WHERE dID='$dID'";
		$query = mysqli_query($dbCon, $sql);
		if($query)
		{
			$row = mysqli_fetch_row($query);
			$name = $row[1];
			$email = $row[3];
			$specialty = $row[5];

			echo "<h3>Name: $name<br>Email: $email<br>Specialty: $specialty<br></h3>";
		}

		echo "<img height=\"300\" width=\"300\" src=\"data:image;base64," . $row[6] . "\">";

		$sql = "SELECT * FROM doctorSchedule WHERE dID='$dID' order by date asc, time asc";
		$query = mysqli_query($dbCon, $sql);
		if($query){

		echo "<table><tr><th>Date</th><th>Time</th><th>Maximum<br>Appointments</th><th>Appointments<br>Taken</th><th></th></tr>";
		while($row = mysqli_fetch_assoc($query)) {
			$date = substr($row["date"], 8, 2) . substr($row["date"], 4, 4) . substr($row["date"], 0, 4);
		        echo "<tr><td>".$date."</td><td>".$row["time"]."</td><td>".$row["maxapp"]."</td><td>".$row["apptaken"]."</td>
		        <td><a class=\"button\" href=\"doctorProfile.php?sID=".$row["sID"]."\">Cancel Appointments</a></td></tr><br>";
		    }
		}

		?>

		</table> <br> <br>
		<a class="button" id="link" href="addSchedule.php">Add Schedule!</a>
		<?php 
	}

	else 																		// Doctor visiting another doctor's profile
	{
		$dID = $_GET['dID'];

		$sql = "SELECT * FROM doctorInfo WHERE dID='$dID'";
		$query = mysqli_query($dbCon, $sql);
		if($query)
		{
			$row = mysqli_fetch_row($query);
			$name = $row[1];
			$email = $row[3];
			$specialty = $row[5];

			echo "<h3>Name: $name<br>Email: $email<br>Specialty: $specialty<br></h3>";
		}

		$sql = "SELECT * FROM doctorSchedule WHERE dID='$dID' order by date asc, time asc";
		$query = mysqli_query($dbCon, $sql);
		if($query){

		echo "<table><tr><th>Date</th><th>Time</th><th>Maximum<br>Appointments</th><th>Appointments<br>Taken</th></tr>";
		while($row = mysqli_fetch_assoc($query)) {
			$date = substr($row["date"], 8, 2) . substr($row["date"], 4, 4) . substr($row["date"], 0, 4);
		        echo "<tr><td>".$date."</td><td>".$row["time"]."</td><td>".$row["maxapp"]."</td><td>".$row["apptaken"]."</td>
		        </tr><br>";
		    }
		}

		?>
		</table> <br> <br>
		<?php 
	}
	
}

else
{
	$dID = $_GET['dID'];
	$uID = $_SESSION['uID'];
	if($_GET['sID'] && $_SESSION['isUser'] == true)
	{
		$sID = $_GET['sID'];	
		$sql = "SELECT * FROM doctorSchedule WHERE sID='$sID'";
		$query = mysqli_query($dbCon, $sql);

		$_sql = "SELECT * FROM appointments WHERE sID='$sID' AND uID='$uID'";
		$_query = mysqli_query($dbCon, $_sql);

		if(mysqli_num_rows($query) == 1 && mysqli_num_rows($_query) == 0)
		{

			//$sql = "SELECT dID FROM doctorSchedule WHERE id='$sID'";
			//$query = mysqli_query($dbCon, $sql);
			//$row = mysqli_fetch_row($query);
			//$dID = $row[0];


			if($db->insert('appointments',array('sID', 'uID'), array($sID, $uID), array('anything'))) 
			{
				?>

				<script type="text/javascript">
				alert("Appointment Successfully Taken!");
				</script>
				<?php
			}

			$sql = "UPDATE doctorSchedule SET apptaken = apptaken + 1 WHERE sID='$sID'";
			$query = mysqli_query($dbCon, $sql);
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

	


	$sql = "SELECT * FROM doctorInfo WHERE dID='$dID'";
	$query = mysqli_query($dbCon, $sql);
	if($query)
	{
		$row = mysqli_fetch_row($query);
		$name = $row[1];
		$email = $row[3];
		$specialty = $row[5];

		echo "<h3>Name: $name<br>Email: $email<br>Specialty: $specialty<br></h3>";
	}

	$sql = "SELECT * FROM doctorSchedule WHERE dID='$dID' order by date asc, time asc";
	$query = mysqli_query($dbCon, $sql);
	if($query)
	{
		echo "<table><tr><th>Date</th><th>Time</th><th>Maximum<br>Appointments</th><th>Appointments<br>Taken</th><th>Availability</th></tr>";
		while($row = mysqli_fetch_assoc($query)) 
		{
			$sID = $row["sID"];
			$_sql = "SELECT * FROM appointments WHERE sID='$sID' AND uID='$uID'";
			$_query = mysqli_query($dbCon, $_sql);
			if(mysqli_num_rows($_query) == 0)
			{
				$date = substr($row["date"], 8, 2) . substr($row["date"], 4, 4) . substr($row["date"], 0, 4);
		        echo "<tr><td>".$date."</td><td>".$row["time"]."</td><td>".$row["maxapp"]."</td><td>".$row["apptaken"]."</td>
		        <td><a class=\"button\" href=\"doctorProfile.php?sID=".$row["sID"]."&dID=$dID\">Make Appointment</a></td></tr><br>";
		    }
		    else
		    {
		    	$date = substr($row["date"], 8, 2) . substr($row["date"], 4, 4) . substr($row["date"], 0, 4);
		        echo "<tr><td>".$date."</td><td>".$row["time"]."</td><td>".$row["maxapp"]."</td><td>".$row["apptaken"]."</td>
		        <td>Appointment Taken</td></tr><br>";
		    }
		    
		}
		echo "</table>";
	}
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

