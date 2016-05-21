<?php 

include_once "models/userModel.php";

class userController
{

	public function __construct() { 
		
	}

	

	public function registerUser($data)
	{		
		if(insertUser($data)) return "Successful";
		return "Error";
	}



	public function loginUser($data)
	{
		if(authenticateUser($data)) return "Successful";
		return "Error";
	}

	public function takeAppointment($sID, $uID)
	{
		if(makeAppointment($sID, $uID)) return "Successful";
		return "Error";
	}

	public function appointmentTaken($sID, $uID)
	{
		return checkAppointment($sID, $uID);
	}

	public function loginAdmin($data)
	{
		if(authenticateAdmin($data)) return "Successful";
		return "Error";
	}
}



$userController = new userController();

?>