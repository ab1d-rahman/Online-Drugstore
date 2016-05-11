<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>User Profile</title>


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
include_once("myFunctions.php");

if($_SESSION['isUser'] == true)
{   

    
    $uID = $_SESSION['uID'];

    if($_GET['aID'] && $_GET['sID'])        // User Pressed Cancel Appointment
    {
        $sID = $_GET['sID'];
        $aID = $_GET['aID'];

        $sql = "DELETE FROM appointments WHERE aID='$aID'";
        $query = mysqli_query($dbCon, $sql);

        $sql = "UPDATE doctorSchedule SET apptaken = apptaken - 1 WHERE sID='$sID'";
        $query = mysqli_query($dbCon, $sql);
    }
    

    $sql = "SELECT * FROM userInfo WHERE uID='$uID'";
    $query = mysqli_query($dbCon, $sql);

    if($query)
    {
        $row = mysqli_fetch_row($query);
        $name = $row[1];
        $name = preventXSS($name);
        $email = $row[3];

        echo "<img src=\"data:image;base64," . $row[5] . "\" style=\"float:right; margin: 0 0 10px 10px;\" height=\"250\" width=\"250\">";
        echo "<h3>Name: $name<br>Email: $email<br></h3>";
    }

    

    $sql = "SELECT * FROM appointments WHERE uID='$uID'";
    $query = mysqli_query($dbCon, $sql);
    if($query)
    {

        echo "<table><tr><th>Appointment Date</th><th>Appointment Time</th><th>Appointment<br>With</th><th></th></tr>";
        while($row = mysqli_fetch_assoc($query))
        {
            $sID = $row["sID"];
            $sql = "SELECT * FROM doctorSchedule WHERE sID='$sID'";
            $_query = mysqli_query($dbCon, $sql);
            $_row = mysqli_fetch_assoc($_query);
            $appDate = $_row["date"];
            $appTime = $_row["time"];
            $dID = $_row["dID"];

            $sql = "SELECT * FROM doctorInfo WHERE dID='$dID'";
            $_query = mysqli_query($dbCon, $sql);
            $_row = mysqli_fetch_assoc($_query);
            $doctorName = $_row["name"];

            $appDate = substr($appDate, 8, 2) . substr($appDate, 4, 4) . substr($appDate, 0, 4);

                echo "<tr><td>".$appDate."</td><td>".$appTime."</td><td>".$doctorName."</td>
                <td><a class=\"button\" href=\"userProfile.php?aID=".$row["aID"]."&sID=$sID\">Cancel Appointments</a></td></tr><br>";
       
        }
    }

    ?>

    </table> <br> <br>
    
    <?php    

    
    
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

