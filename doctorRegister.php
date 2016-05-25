<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Registration</title>

    
    <!-- <link rel="stylesheet" href="css/styles.css"> -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
</head>
<body>

<script type="text/javascript" src="bootstrap/js/jquery.min.js"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>


<?php

error_reporting(~E_NOTICE);
session_start();
session_regenerate_id();

include_once "controllers/doctorController.php";

if($_SESSION['username'])
{
	header("Location: index.php");
}

if($_POST['submit'])
{
  if($_POST['password'] != $_POST['repassword'])
    {
        ?>
        <script type="text/javascript">
        alert("Passwords don't match");
        </script>
        <?php
    }

  else
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
  			'password' => $_POST['password'],
  			'email' => $_POST['email'],
  			'specialty' => $_POST['specialty'],
  			'image' => $_FILES['image']['tmp_name']
  		);

  		if($doctorController->registerDoctor($data) == "Successful") 
  		{
  			?>
  			<script type="text/javascript">
  			alert("Registration Successful");
  			</script>
  			<?php
  		}
  		else
  		{
  			?>
  			<script type="text/javascript">
  			alert("Email Already Exists!");
  			</script>
  			<?php
  		}
  	}		
  }
	
} 


$cartItems = 0;

if($_SESSION['isUser'] == true)
{
    $data = $productController->getTotalItemsAndPrice($_SESSION['uID']);
    $cartItems = $data['items'];
}

?>

<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <h1><a class="navbar-brand" href="index.php">Online<myTag style="color: #2A5BBB;">DrugStore</myTag></a></h1>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-left">
        <li><a href="index.php"><span class="glyphicon glyphicon-home"></span> Home</a></li>
        <li><a href="allProducts.php"><span class="glyphicon glyphicon-list"></span> All Products</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <span class="glyphicon glyphicon-phone-alt"></span> Contact Us<span class="caret"></span></a>
          <ul class="dropdown-menu">            
            <li><p style="margin-left: 15px">Hotline: 01XXXXXXX</p></li>
            <li role="separator" class="divider"></li>
            <li><p style="margin-left: 15px">E-mail: help@drugstore.com</p></li>
          </ul>
        </li>
      </ul>
      <form class="navbar-form navbar-right" role="search" style="line-height: 50px;" action="search.php" method="get">
        <div class="form-group" >           
            <input type="text" class="form-control" placeholder="Search for any product..." required name="query">                   
        </div>
        <button type="submit" class="btn btn-default" name="submit" value="Submit"><span class="glyphicon glyphicon-search"></span>Search</button> 
      </form>
      <ul class="nav navbar-nav navbar-right">       
        <li><a href="cart.php"><span class="glyphicon glyphicon-shopping-cart" style="color: #57C5A0;"><?php echo $cartItems; ?></span> Cart</a></li>
        
        <?php
        if($_SESSION['username'])
        {
        ?>
        <li><a href=<?php if($_SESSION['isUser'] == true) echo "userProfile.php"; else if($_SESSION['isDoc'] == true) echo "doctorProfile.php"; else echo "adminActions.php"; ?>><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION['name']; ?></a></li>

        <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>

        <?php
        }

        else
        {
        ?>

        <li class="dropdown">        
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="glyphicon glyphicon-log-in"></span> Login<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="userLogin.php">As User</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="doctorLogin.php">As Doctor</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="adminLogin.php">As Admin</a></li>
          </ul>
        </li>
        <li class="dropdown active">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <span class="glyphicon glyphicon-share"></span> Sign Up<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="userRegister.php">As User</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="doctorRegister.php">As Doctor</a></li>
          </ul>
        </li>

        <?php
        }
        ?>

      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>



<div class="container" style="margin-top: 130px;">
    <section class="login">
		<div class="titulo">Doctor Registration</div>

		<form action="doctorRegister.php" method="post" enctype="multipart/form-data">
			<input type="text" required title="Name required" placeholder="Name" name="name"> 
          <input type="email" required title="Email required" placeholder="Email" name="email">
	        <input type="password" required title="Password required" placeholder="Password"  name="password">
	        <input type="password" required title="Password required" placeholder="Retype Password"  name="repassword">
	        <br><br> Specialty: 
				<select style="color: black;" name="specialty">
				  <option value="Cadiology">Cadiology</option>
				  <option value="ENT">ENT</option>
				  <option value="Gynecology">Gynecology</option>
				  <option value="Medicine">Medicine</option>
          <option value="Neurology">Neurology</option>
          <option value="Orthopedic">Orthopedic</option>
				  <option value="Urology">Urology</option>
				</select> <br> <br>
			Image: <input type="file" name="image" required>
	        <button class="enviar" type="submit" value="Submit" name="submit">Register</button> 
	    </form>
	</section>
</div>



<footer>
    <div class="container-fluid" style="background: black; color: white; height: 70px; margin-top: 200px;">
        <div class="row">
            <h4 style="line-height: 50px; text-align: center;">Copyright &copy;2016 Abid, Salim, Jubayer</h4>
        </div>
    </div>
</footer>

</body>
</html>