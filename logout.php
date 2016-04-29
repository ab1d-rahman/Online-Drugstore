<html>
<head> 
	<title>Logout</title>	
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<form method="" action="index.php">
		<button type="submit" value="Submit" name="submit">Home</button> 
</form> 

<body>


<?php 

session_start();
session_destroy();
header("Location: index.php");
?>



</body>
</html>