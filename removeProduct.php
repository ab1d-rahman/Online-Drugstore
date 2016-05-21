<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Remove Product</title>


<link rel="stylesheet" href="css/reset.css" type="text/css" />
<link rel="stylesheet" href="css/styles.css" type="text/css" />
<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">



<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />


<?php

error_reporting(~E_NOTICE);
session_start();
session_regenerate_id();

include_once "controllers/productController.php";

if($_SESSION['isAdmin'] == false)
{ 
    header("Location: index.php");
    die();
}

?>

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
                                    <li><a href="adminLogin.php">As Admin</a></li>
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
	
	if($productController->removeProduct($_POST['pID']) == "Successful")
	{
		?>
		<script type="text/javascript">
		alert("Product successfully removed.");
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




?>


	<div id="body">


		<section class="login">
			<div class="titulo">Remove Product</div>
				<form action="removeProduct.php" method="post" enctype="multipart/form-data">
                    <input type="text"  title="Product ID"  required placeholder="Product ID" name="pID"> 					
			        <button class="enviar" type="submit" value="Submit" name="submit">Delete Product</button> 
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
