<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Login</title>


<link rel="stylesheet" href="css/reset.css" type="text/css" />
<link rel="stylesheet" href="css/styles.css" type="text/css" />
<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css" type="text/css">


<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />


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
session_regenerate_id();

include_once "controllers/userController.php";


if($_POST['submit'])
{
    $data = array(            
            'username' => $_POST['username'],
            'password' => $_POST['password']            
        );



	if($userController->loginAdmin($data) == "Successful")
	{		
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

else if($_SESSION['username'])
{
	header("Location: index.php");
}


?>



        <section class="login">
        	<div class="titulo">Admin Login</div>
        	<form action="adminLogin.php" method="post" >
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
