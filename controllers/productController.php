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
	

	
}



$productController = new productController();

?>