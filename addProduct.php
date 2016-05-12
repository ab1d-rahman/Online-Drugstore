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

include_once "database_helper.php";
include_once "connection.php";
include_once "myFunctions.php";



if($_POST['submit'])
{	

	$name = $_POST['name'];

	$price = $_POST['price'];

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

		if($db->insert('products',array('name', 'price', 'image'), array($name, $price, $image), array('anything')))
		{
			?>
			<script type="text/javascript">
			alert("Successful.");
			</script>
			<?php
		}
		else
		{
			?>
			<script type="text/javascript">
			alert("Failed");
			</script>
			<?php
		}	
	}	
	
} 




?>


	<div id="body">


		<section class="login">
			<div class="titulo">Add Product</div>
				<form action="addProduct.php" method="post" enctype="multipart/form-data">
					<input type="text" required title="Name"  placeholder="Name" name="name"> 
			    	<input type="text" required title="Price"  placeholder="Price"  name="price">
			        <br> <br>
			        Image: <input type="file" name="image" required>
			        <button class="enviar" type="submit" value="Submit" name="submit">Insert</button> 
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