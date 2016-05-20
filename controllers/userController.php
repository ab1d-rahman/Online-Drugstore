<?php 

include_once "models/userModel.php";

class userController
{

	public function __construct() { 
		
	}

	

	public function registerUser($data)
	{		
		if(insert($data)) return "Successful";
		return "Error";
	}



	public function loginUser($data)
	{
		if(authenticate($data)) return "Successful";
		return "Error";
	}
}



$userController = new userController();

?>