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
session_regenerate_id();

?>
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



	

<?php



if($_POST['submit'])
{
	include_once "database_helper.php";

	$dID = $_SESSION['dID'];
	$time = $_POST['time'].":00";
	$date = substr($_POST['date'], 6, 4) . substr($_POST['date'], 2, 4) . substr($_POST['date'], 0, 2);
	$maxapp = $_POST['maxapp'];
	$apptaken = 0;


	if($db->insert('doctorSchedule',array('dID', 'date', 'time', 'maxapp', 'apptaken'), array($dID, $date, $time, $maxapp, $apptaken), array('anything')))
	{
			?>
			<script type="text/javascript">
			alert("Schedule Successfully Added");
			</script>
			<?php
	} 	
	
} 




?>

	
	<div id="body" class="width">

	<section class="login">
		<div class="titulo">Add Schedule</div>
		<form action="addSchedule.php" method="post" >
			<input type="text" required  placeholder="Date (Format: DD-MM-YYYY)" name="date">
	    	<input type="text" required  placeholder="Time (Format: HH:MM)" name="time"> <br>
	        <input type="text" required  placeholder="Maximum Appointments" name="maxapp">        
	        <button class="enviar" type="submit" value="Submit" name="submit">Add</button> 
	    </form>
	</section>

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
