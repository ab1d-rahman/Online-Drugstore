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
		$r++;
	}

	return $data;
}

?>