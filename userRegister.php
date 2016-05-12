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

    			
                		<li class="selected"><a href="index.php"><i class="fa fa-home"></i> Home</a></li>

                    
        				<li><a href="#"><i class="fa fa-database"></i> All Products</a> </li>
                    
        				<li><a href="#"><i class="fa fa-phone"></i> Contact</a></li>

        				<li><a href="#"><i class="fa fa-sign-in"></i> Sign In</a>
                			<ul>
	                			<li><a href="userLogin.php">As User</a></li>
	                   			<li><a href="doctorLogin.php">As Doctor</a></li>
                			</ul>
                		</li>

                		<li class="selected"><a href="#"><i class="fa fa-key"></i> Register</a>
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
    



<?php

error_reporting(~E_NOTICE);
session_start();
session_regenerate_id();

if($_SESSION['username'])
{
	header("Location: index.php");
}

if($_POST['submit'])
{	

	include_once "database_helper.php";
	include_once "connection.php";
	include_once "myFunctions.php";

	$name = $_POST['name'];
	$name = cleanInput($dbCon, $name);

	$username = $_POST['username'];
	$username = cleanInput($dbCon, $username);

	$password = $_POST['password'];
	$password = cleanInput($dbCon, $password);
	$password = hashPassword($password);

	$email = $_POST['email'];
	$email = cleanInput($dbCon, $email);


	$image = addslashes($_FILES['image']['tmp_name']);
	$imageName = addslashes($_FILES['image']['name']);
	$image = file_get_contents($image);	
	$image = base64_encode($image);

	if(getimagesize($_FILES['image']['tmp_name']) == FALSE)
	{
		?>
		<script type="text/javascript">
		alert("That is not a valid image file!");
		</script>
		<?php
	}

	else
	{

		if($db->insert('userInfo',array('name', 'username', 'password', 'email', 'image'), array($name, $username, $password, $email, $image),              array('anything')))
		{
			?>
			<script type="text/javascript">
			alert("Registration Successful.");
			</script>
			<?php
		}
		else
		{
			?>
			<script type="text/javascript">
			alert("Username Already Exists!");
			</script>
			<?php
		}	
	}	
	
} 




?>


	<div id="body">


		<section class="login">
			<div class="titulo">User Registration</div>
				<form action="userRegister.php" method="post" enctype="multipart/form-data">
					<input type="text" required title="Name required" placeholder="Name" name="name"> 
			    	<input type="text" required title="Username required" placeholder="Username"  name="username">
			        <input type="password" required title="Password required" placeholder="Password"  name="password">
			        <input type="text" required title="Email required" placeholder="Email" name="email">
			        <br> <br>
			        Image: <input type="file" name="image" required>
			        <button class="enviar" type="submit" value="Submit" name="submit">Register</button> 
			    </form>
		</section>

	</div>

</div>

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
