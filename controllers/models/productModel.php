<?php 


include_once "myFunctions.php";

session_start();
session_regenerate_id();	

function insertProduct($data)
{
	$dbCon = mysqli_connect("localhost", "root", "root", "doctor");


	$name = cleanInput($dbCon, $data['name']);
	$price = cleanInput($dbCon, $data['price']);
	$description = cleanInput($dbCon, $data['description']);
	$category = cleanInput($dbCon, $data['category']);
	$keywords = cleanInput($dbCon, $data['keywords']);


	$image = addslashes($data['image']);
	$image = file_get_contents($image);	
	$image = base64_encode($image);


	$sql = "INSERT INTO products (name, price, category, description, keywords, image) 
			VALUES ('$name', '$price', '$category', '$description', '$keywords', '$image')";
	$query = mysqli_query($dbCon, $sql);
	return $query;
}


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

function latestProducts()
{
	$dbCon = mysqli_connect("localhost", "root", "root", "doctor");

	$sql = "SELECT * FROM products ORDER BY pID desc LIMIT 8";
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

function categoricalProducts($category)
{
	$dbCon = mysqli_connect("localhost", "root", "root", "doctor");

	$sql = "SELECT * FROM products WHERE category='$category'";
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

function updateProduct($data)
{
	$dbCon = mysqli_connect("localhost", "root", "root", "doctor");

	$pID = $data['pID'];
	// echo implode(" ",$data);
	$sql = "UPDATE products SET ";

	if($data['name'])
	{
		$name = $data['name'];
		$sql = $sql . "name = '$name',";

	} 

	if($data['price'])
	{
		$price = $data['price'];
		$sql = $sql . " price = '$price',";

	} 

	if($data['description'])
	{
		$description= $data['description'];
		$sql = $sql . " description = '$description',";

	} 

	if($data['keywords'])
	{
		$keywords = $data['keywords'];
		$sql = $sql . " keywords = '$keywords',";

	} 

	if($data['category'])
	{
		$category = $data['category'];
		$sql = $sql . " category = '$category',";

	} 

	if($data['image'])
	{
		$image = addslashes($data['image']);
		$image = file_get_contents($image);	
		$image = base64_encode($image);
		$sql = $sql . " image = '$image',";

	} 

	$sql = rtrim($sql, ',');

	$sql = $sql . " WHERE pID='$pID'";

	// echo "\n" . $sql;

	$query = mysqli_query($dbCon, $sql);

	return $query;
}


function deleteProduct($pID)
{
	$dbCon = mysqli_connect("localhost", "root", "root", "doctor");

	$pID = cleanInput($dbCon, $pID);
	
	$sql = "DELETE FROM products WHERE pID='$pID'";
	$query = mysqli_query($dbCon, $sql);

	$sql = "DELETE FROM cart WHERE pID='$pID'";
	$query = mysqli_query($dbCon, $sql);

	return $query;
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

function updateCart($uID, $update, $updatePID)
{
	$dbCon = mysqli_connect("localhost", "root", "root", "doctor");

	$cnt = count($update);

	for($i=0; $i<$cnt; $i++)
	{
		if($update[$i] && $update[$i]>0)
		{
			$quantity = $update[$i];
			$quantity = cleanInput($dbCon, $quantity);
			$pID = $updatePID[$i];

			$sql = "UPDATE cart SET quantity = '$quantity' WHERE uID='$uID' AND pID='$pID'";
			$query = mysqli_query($dbCon, $sql);
		}
	}
}

function removeFromCart($pID, $uID)
{
	$dbCon = mysqli_connect("localhost", "root", "root", "doctor");

	$pID = cleanInput($dbCon, $pID);
	
	$sql = "DELETE FROM cart WHERE uID='$uID' AND pID='$pID'";
	$query = mysqli_query($dbCon, $sql);
}


?>