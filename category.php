<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Category</title>


<link rel="stylesheet" href="css/reset.css" type="text/css" />
<link rel="stylesheet" href="css/styles.css" type="text/css" />
<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css" type="text/css">



<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />


</head>


<body>

<?php

error_reporting(~E_NOTICE);
session_start();
session_regenerate_id();

include_once "controllers/productController.php";

$categoryMap =  array("", "Anti-infectives", "Cough and Cold Relief", "Diabetes Managements", "Digestion and Nausea", 
                        "Eye, Nose and Ear Care", "Oral Care", "Pain and Fever Relief", "Respiratory and Cardiovascular", "Skin Care", "Vitamins and Minerals");

if($_GET['category'])
{
    $category = $categoryMap[$_GET['category']];
}

if(isset($_GET['addToCart']))
{
    if($_SESSION['isUser'] == false)
    {
        ?>
        <script type="text/javascript">
            alert("You need to be logged in as a user to add items to cart.");
        </script>

        <?php 
    }

    else
    {
        if($productController->addProductToCart($_GET['pID'], $_SESSION['uID']) == "Successful")
        {
            ?>
            <script type="text/javascript">
                alert("Product successfully added to cart");
            </script>

            <?php 
        }

        else
        {
            ?>
            <script type="text/javascript">
                alert("Error: Already added to cart/ No such product");
            </script>

            <?php 
        }
    }
}

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

        <div id="cart">
            <?php 

            $data = $productController->getTotalItemsAndPrice($_SESSION['uID']);
            echo "Shopping Cart - ( Items: " . $data['items'] . "   -- Total Price: " . $data['price'] ." TK )";

            ?>
            
            <a class="button" href="cart.php"> Go To Cart </a>

        </div>


        <form class="form-wrapper cf" action="search.php" method="get">
            <input type="text" placeholder="Search for any product..." required name="query"> <br>
            <button type="submit" name="submit" value="Submit">Search</button>
        </form>


         <div id="products_box">
        <h2 id="banner"> Product Category: <?php echo $category; ?> </h2>
        <?php 
        if($_GET['category'])
        {
            $data = $productController->getProductByCategory($category);

            foreach ($data as $d) 
            {
                echo "
                    <div id='single_product'>".
                    $d[0]." <br>";

                if($_SESSION['isAdmin'] == true)
                {
                    echo "Product ID: " . $d[3] . "<br>";
                }

                echo"<img src=\"data:image;base64," . $d[2] . "\" height=\"180\" width=\"180\">
                    <br>Price: ". $d[1]." TK <br>
                    <a href='#'> Details </a> <br>
                    <a class='button' id='link' href='category.php?category=".$_GET['category']."&addToCart&pID=" . $d[3] . "' >Add To Cart!</a>
                    </div>

                    ";
            }
        }
        ?>
        </div>
        
        <div class="sidebar small-sidebar right-sidebar" >
    
            <ul>    
               <li>
                    <h4>Categories</h4>
                    <ul class="blocklist">
                        <?php 
                        
                        if($_GET['category'] == 1) echo "<li><a class='selected' href='category.php?category=1'>Anti-infectives</a></li>";
                        else echo "<li><a style=\"font-weight: bold;\" href='category.php?category=1'>Anti-infectives</a></li>";

                        if($_GET['category'] == 2) echo "<li><a class='selected' href='category.php?category=2'>Cough and Cold Relief</a></li>";
                        else echo "<li><a style=\"font-weight: bold;\" href='category.php?category=2'>Cough and Cold Relief</a></li>";

                        if($_GET['category'] == 3) echo "<li><a class='selected' href='category.php?category=3'>Diabetes Managements</a></li>";
                        else echo "<li><a style=\"font-weight: bold;\" href='category.php?category=3'>Diabetes Managements</a></li>";

                        if($_GET['category'] == 4) echo "<li><a class='selected' href='category.php?category=4'>Digestion and Nausea</a></li>";
                        else echo "<li><a style=\"font-weight: bold;\" href='category.php?category=4'>Digestion and Nausea</a></li>";

                        if($_GET['category'] == 5) echo "<li><a class='selected' href='category.php?category=5'>Eye, Nose and Ear Care</a></li>";
                        else echo "<li><a style=\"font-weight: bold;\" href='category.php?category=5'>Eye, Nose and Ear Care</a></li>";

                        if($_GET['category'] == 6) echo "<li><a class='selected' href='category.php?category=6'>Oral Care</a></li>";
                        else echo "<li><a style=\"font-weight: bold;\" href='category.php?category=6'>Oral Care</a></li>";

                        if($_GET['category'] == 7) echo "<li><a class='selected' href='category.php?category=7'>Pain and Fever Relief</a></li>";
                        else echo "<li><a style=\"font-weight: bold;\" href='category.php?category=7'>Pain and Fever Relief</a></li>";

                        if($_GET['category'] == 8) echo "<li><a class='selected' href='category.php?category=8'>Respiratory and Cardiovascular</a></li>";
                        else echo "<li><a style=\"font-weight: bold;\" href='category.php?category=8'>Respiratory and Cardiovascular</a></li>";

                        if($_GET['category'] == 9) echo "<li><a class='selected' href='category.php?category=9'>Skin Care</a></li>";
                        else echo "<li><a style=\"font-weight: bold;\" href='category.php?category=9'>Skin Care</a></li>";

                        if($_GET['category'] == 10) echo "<li><a class='selected' href='category.php?category=10'>Vitamins and Minerals</a></li>";
                        else echo "<li><a style=\"font-weight: bold;\" href='category.php?category=10'>Vitamins and Minerals</a></li>";


                        
                        ?>
                    </ul>
                </li>  
            </ul>
        
        </div>


        <div class="clear"> </div>



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

