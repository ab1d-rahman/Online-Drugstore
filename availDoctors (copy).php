<html>
<head>
	<title>Doctor List</title>
</head>
<style>
table, th, td {
     border: 1px solid black;
}
</style>
<body>

<?php

include_once("connection.php");


$sql = "SELECT * FROM doctorInfo order by name asc";
$query = mysqli_query($dbCon, $sql);
if($query){

echo "<table><tr><th>ID</th><th>Name</th><th>Email</th><th>Specialty</th></tr>";
while($row = mysqli_fetch_assoc($query)) {
        echo "<tr><td>".$row["dID"]."</td><td><a href=\"doctorProfile.php?dID=".$row["dID"]."\">".$row["name"]."</a></td><td>".$row["email"]."</td><td>".$row["specialty"]."</td></tr>";
    }}

?>

</body>
</html>

