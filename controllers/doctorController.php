<?php 

include_once "doctorModel.php";

class doctorController
{

	public function __construct() { 
		
	}

	

	public function registerDoctor($data)
	{		
		if(insert($data)) return "Successful";
		return "Error";
	}



	public function loginDoctor($data)
	{
		if(authenticate($data)) return "Successful";
		return "Error";
	}
}



$doctorController = new doctorController();

?>