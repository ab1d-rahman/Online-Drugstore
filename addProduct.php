<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Add Product</title>


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
		$data = array(
			'name' => $_POST['name'], 
			'price' => $_POST['price'],
			'description' => $_POST['description'],
			'category' => $_POST['category'],
			'keywords' => $_POST['keywords'],
			'image' => $_FILES['image']['tmp_name']
		);
		
		
		if($productController->addProduct($data) == "Successful")
		{
			?>
			<script type="text/javascript">
			alert("Product successfully added.");
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
	
} 




?>


	<div id="body">


		<section class="login">
			<div class="titulo">Add Product</div>
				<form action="addProduct.php" method="post" enctype="multipart/form-data">
					<input type="text" required title="Name"  placeholder="Name" name="name"> 
			    	<input type="text" required title="Price"  placeholder="Price"  name="price">
			    	<textarea name="description" cols="29" rows="10" placeholder="Product Description"></textarea>
			    	<textarea name="keywords" cols="29" rows="2" placeholder="Keywords"></textarea>
			    	<br><br> Category: 
					<select name="category">
					  <option value="Anti-infectives">Anti-infectives</option>
					  <option value="Cough and Cold Relief">Cough and Cold Relief</option>
					  <option value="Diabetes Managements">Diabetes Managements</option>
					  <option value="Digestion and Nausea">Digestion and Nausea</option>
					  <option value="Eye, Nose and Ear Care">Eye, Nose and Ear Care</option>
					  <option value="Oral Care">Oral Care</option>
					  <option value="Pain and Fever Relief">Pain and Fever Relief</option>
					  <option value="Respiratory and Cardiovascular">Respiratory and Cardiovascular</option>
					  <option value="Skin Care">Skin Care</option>
					  <option value="Vitamins and Minerals">Vitamins and Minerals</option>
					</select> 
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
