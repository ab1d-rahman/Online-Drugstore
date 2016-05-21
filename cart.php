<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cart</title>


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


if($_SESSION['isUser'] == false)
{
    ?>
    <script type="text/javascript">
        alert("You need to be logged in as a user to view this page.");
    </script>

    <?php 

    header("Location: index.php");
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


        <h2 style="text-align: center; font-weight: bold;">Shopping Cart</h2>
        <form method="post" action="cart.php">
        <table><tr><th>#</th><th>Product Name</th><th>Quantity</th><th>Unit Price</th><th>Update Quantity</th><th></th></tr>

        <?php 

            if(isset($_POST['submit']))
            {
                $update = $_POST['update'];  
                $updatePID = $_POST['updatePID']; 

                $productController->updateTheCart($_SESSION['uID'], $update, $updatePID);
            }

            if(isset($_GET['remove']))
            {
                $productController->removeProductFromCart($_GET['pID'], $_SESSION['uID']);
            }

            $data = $productController->getCartItems($_SESSION['uID']);
            $totalPriceData = $productController->getTotalItemsAndPrice($_SESSION['uID']);

            $cnt = 0;
            foreach ($data as $d) 
            {
                $cnt++;
                echo "<tr><td>". $cnt ."</td><td>". $d[0] ."</td><td>". $d[1] ."</td><td>". $d[2] ." TK</td>
                    <td>
                    <input type=\"text\" size=\"5\" name=\"update[]\">
                    <input type=\"hidden\" name=\"updatePID[]\" value=\"". $d[3] ."\">
                    </td>
                    <td><a class=\"button\" href=\"cart.php?remove&pID=". $d[3] ."\">Remove From Cart</a></td></tr><br>";
            }

            echo "<tr><td></td><td style=\"font-weight: bold;\">Total Price</td><td></td><td style=\"font-weight: bold;\">" . $totalPriceData['price'] . " TK</td><td></td><td></td></tr>";

        ?>
        </table>

            <br>
            <input class="submitButton" type="submit" name="submit" value="Update Cart"></input>
        </form>

        <br> <br>
        <form method="post" action="checkout.php">
            <input class="submitButton" type="submit" name="submit" value="Checkout"></input>
        </form>

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

