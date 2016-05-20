<?php 

include_once "models/doctorModel.php";

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

	public function  getDoctorProfile($dID)
	{
		return profile($dID);
	}

	public function getDoctorSchedule($dID)
	{
		return schedule($dID);
	}

	public function addDoctorSchedule($data)
	{
		if(addSchedule($data)) return "Successful";
		return "Error";
	}

	public function cancelDoctorSchedule($sID)
	{
		deleteSchedule($sID);
	}


}



$doctorController = new doctorController();

?>