<?php 


include_once "myFunctions.php";

session_start();
session_regenerate_id();	


function allProducts()
{
	$dbCon = mysqli_connect("localhost", "root", "root", "doctor");

	$sql = "SELECT * FROM products";
	$query = mysqli_query($dbCon, $sql);
	$r = 0;

	while($row = mysqli_fetch_assoc($query)) 
	{
		$data[$r][0] = $row['name'];
		$data[$r][1] = $row['price'];
		$data[$r][2] = $row['image'];
		$data[$r][3] = $row['pID'];
		$r++;
	}

	return $data;
}

function searchedProducts($query)
{
	$dbCon = mysqli_connect("localhost", "root", "root", "doctor");

	$sql = "SELECT * FROM products WHERE keywords LIKE LOWER('%$query%')";
	$query = mysqli_query($dbCon, $sql);

	$r = 0;

	while($row = mysqli_fetch_assoc($query)) 
	{
		$data[$r][0] = $row['name'];
		$data[$r][1] = $row['price'];
		$data[$r][2] = $row['image'];
		$data[$r][3] = $row['pID'];
		$r++;
	}

	return $data;
}

function addToCart($pID, $uID)
{
	$dbCon = mysqli_connect("localhost", "root", "root", "doctor");
	$pID = cleanInput($dbCon, $pID);

	$sql = "SELECT * FROM products WHERE pID='$pID'";
	$query = mysqli_query($dbCon, $sql);

	$_sql = "SELECT * FROM cart WHERE uID='$uID' AND pID='$pID'";
	$_query = mysqli_query($dbCon, $_sql);

	if(mysqli_num_rows($query) == 1 && mysqli_num_rows($_query) == 0)
	{
		$sql = "INSERT INTO cart (uID, pID, quantity) VALUES ('$uID', '$pID', '1')";
		$query = mysqli_query($dbCon, $sql);

		return $query;
	}
	
	return null;
}


function getItemsAndPrice($uID)
{
	$items = 0;
	$price = 0;

	$dbCon = mysqli_connect("localhost", "root", "root", "doctor");

	$sql = "SELECT * FROM cart WHERE uID='$uID'";
	$query = mysqli_query($dbCon, $sql);

	while($row = mysqli_fetch_assoc($query)) 
	{
		$items++;
		$pID = $row['pID'];

		$_sql = "SELECT price FROM products WHERE pID='$pID'";
		$_query = mysqli_query($dbCon, $_sql);
		$_row = mysqli_fetch_row($_query);
		// echo $row['quantity'] . " " . $pID . " " . $_row[0] . "\n";
		$price = $price +  ($row['quantity'] * $_row[0]);
	}

	$data = array(            
            'items' => $items,
            'price' => $price            
        );

	return $data;

}

function cartItems($uID)
{
	$dbCon = mysqli_connect("localhost", "root", "root", "doctor");

	$sql = "SELECT * FROM cart WHERE uID='$uID'";
	$query = mysqli_query($dbCon, $sql);

	$r = 0;

	while($row = mysqli_fetch_assoc($query)) 
	{
		$pID = $row['pID'];

		$_sql = "SELECT name, price FROM products WHERE pID='$pID'";
		$_query = mysqli_query($dbCon, $_sql);
		$_row = mysqli_fetch_row($_query);
		// echo $row['quantity'] . " " . $pID . " " . $_row[0] . "\n";

		$data[$r][0] = $_row[0];
		$data[$r][1] = $row['quantity'];
		$data[$r][2] = $_row[1];
		$data[$r][3] = $pID;

		$r++;
	}

	return $data;
}
?>