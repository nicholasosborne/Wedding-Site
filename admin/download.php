<?php
include_once("../api/dbconnect.php");

$result = mysql_query("select * from guests where status=1 order by eid asc");
	
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"guestlist.csv\"");
$data="First Name,Last Name,Notes \n";

while($row = mysql_fetch_assoc($result)){

$data.= "\"".$row['first_name']."\",\"".$row['last_name']."\",\"".$row['notes']."\"\n";
}

echo $data;


?>