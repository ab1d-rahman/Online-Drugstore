<?php 

include_once "models/productModel.php";

class productController
{

	public function __construct() { 
		
	}

	public function getAllProducts()
	{
		return allProducts();
	}

	public function getSearchedProducts($query)
	{
		return searchedProducts($query);
	}
	
	public function addProductToCart($pID, $uID)
	{
		if(addToCart($pID, $uID)) return "Successful";
		return "Error";
	}
	
	public function getTotalItemsAndPrice($uID)
	{
		return getItemsAndPrice($uID);
	}

	public function getCartItems($uID)
	{
		return cartItems($uID);
	}

	public function updateTheCart($uID, $update, $updatePID)
	{
		updateCart($uID, $update, $updatePID);
	}

	public function removeProductFromCart($pID, $uID)
	{
		removeFromCart($pID, $uID);
	}
}



$productController = new productController();

?>