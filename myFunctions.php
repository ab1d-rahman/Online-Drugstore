<?php


function cleanInput($conn, $value)
{
	$value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
	$value =  mysqli_real_escape_string($conn, $value);
	return $value;
}

function hashPassword($value)
{
	return password_hash($value, PASSWORD_DEFAULT, ['cost' => 12]);
}

function getProducts($dbCon)
{
	$sql = "SELECT * FROM products";
	$query = mysqli_query($dbCon, $sql);

	if($query)
	{
		while($row = mysqli_fetch_assoc($query))
		{			
			$prodName = $row["name"];
			$prodPrice = $row["price"];

			echo "
			<div id='single_product'>
			$prodName <br>
			<img src=\"data:image;base64," . $row["image"] . "\" height=\"180\" width=\"180\">
			<br> <br>
			$prodPrice TK <br>
			<a href='#'> Details </a> <br>
			<a class='button' id='link' href='#' >Add To Cart!</a>
			</div>

			";
		}
	}
}


?>