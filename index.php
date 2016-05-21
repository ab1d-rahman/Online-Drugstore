<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Home</title>


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




    <div id="intro">

        <div class="width">
          
            <div class="intro-content">
        
                    <h2>Want an appoinment from a doctor? </h2>
                    <p>Find a doctor now!</p>                                       
                    <p><a href="availDoctors.php" class="button button-reversed button-slider"><i class="fa fa-info"></i> Doctor List</a></p>

            </div>
                    
        </div>            

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
            <h2 id="banner"> Latest Products </h2>
            <?php 

            $data = $productController->getLatesProducts();

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
                    <a class='button' id='link' href='index.php?addToCart&pID=" . $d[3] . "' >Add To Cart!</a>
                    </div>

                    ";
            }

            ?>
        </div>
        
        <div class="sidebar small-sidebar right-sidebar" >
    
            <ul>    
               <li>
                    <h4>Categories</h4>
                    <ul class="blocklist">
                        <li><a href="category.php?category=1" style="font-weight: bold;">Anti-infectives</a></li>
                        <li><a href="category.php?category=2" style="font-weight: bold;">Cough and Cold Relief</a></li>
                        <li><a href="category.php?category=3" style="font-weight: bold;">Diabetes Managements</a></li>
                        <li><a href="category.php?category=4" style="font-weight: bold;">Digestion and Nausea</a></li>
                        <li><a href="category.php?category=5" style="font-weight: bold;">Eye, Nose and Ear Care</a></li>
                        <li><a href="category.php?category=6" style="font-weight: bold;">Oral Care</a></li>
                        <li><a href="category.php?category=7" style="font-weight: bold;">Pain and Fever Relief</a></li>
                        <li><a href="category.php?category=8" style="font-weight: bold;">Respiratory and Cardiovascular</a></li>
                        <li><a href="category.php?category=9" style="font-weight: bold;">Skin Care</a></li>
                        <li><a href="category.php?category=10" style="font-weight: bold;">Vitamins and Minerals</a></li>
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

