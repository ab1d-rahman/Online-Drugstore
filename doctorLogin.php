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


<div id="container">

    <div id="header"> 

	   <div class="width">

    	   <h1><a href="index.php">Online<strong>DrugStore</strong></a></h1>
		    	<nav>
	
        			<ul class="sf-menu dropdown">

    			
                		<li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>

                    
        				<li><a href="#"><i class="fa fa-database"></i> All Products</a> </li>
                    
        				<li><a href="#"><i class="fa fa-phone"></i> Contact</a></li>

        				<li class="selected"><a href="#"><i class="fa fa-sign-in"></i> Sign In</a>
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

           			</ul>

    			
    			</nav>
       	</div>

	    <div class="clear"></div>

       
    </div>

    <div id="body">


<?php

error_reporting(~E_NOTICE);
session_start();
if($_POST['submit'])
{
	include_once("connection.php");

	$username = $_POST['username'];
	$password = $_POST['password'];

	$sql = "SELECT username, password, dID, name FROM doctorInfo WHERE username='$username'";
	$query = mysqli_query($dbCon, $sql);

	if($query)
	{
		$row = mysqli_fetch_row($query);
		$DBusenrame = $row[0];
		$DBpassword = $row[1];
		$DBid = $row[2];
		//echo "this $DBusenrame $DBpassword";
	}

	if($username == $DBusenrame && $password == $DBpassword)
	{
		$_SESSION['username'] = $username;
		$_SESSION['name'] = $row[3];
		$_SESSION['dID'] = $row[2];
		$_SESSION['isDoc'] = true;
		$_SESSION['isUser'] = false;
		header("Location: index.php");
	}

	else 
	{
		
		?>

	   <script type="text/javascript">
			alert("Invalid Username / Password!");
		</script>		

	<?php 
		
		
	}
} 

else if($_SESSION['username'] && $_SESSION['isUser'] == false && $_SESSION['isDoc'] == true)
{
	header("Location: index.php");
}


?>

        <section class="login">
        	<div class="titulo">Doctor Login</div>
        	<form action="doctorLogin.php" method="post" >
            	<input type="text" required title="Username required" placeholder="Username"  name="username">
                <input type="password" required title="Password required" placeholder="Password"  name="password">
                <div class="olvido">
                    <div class="col"><a href="#" title="Recuperar Password">Forgot Password?</a></div>
                </div>
                <button class="enviar" type="submit" value="Submit" name="submit">Login</button> 
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
