<?php
include("../api/dbconnect.php");

function rand_string( $length ) {
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";	

	$size = strlen( $chars );
	for( $i = 0; $i < $length; $i++ ) {
		$str .= $chars[ rand( 0, $size - 1 ) ];
	}

	return $str;
}


if($_REQUEST['function'] == "update"){

	$query = mysql_query("SELECT * FROM evites order by eid asc");
	$data = array();
	$data['content'] = "";
	while($row = mysql_fetch_assoc($query)){
		
		$eid = $row['eid'];
		
		$data["content"] .= "<tr>";
		$data["content"].= '<td>'.$row['eid'].'</td>';
		$data["content"].= '<td>'.$row['code'].'</td>';
		$data["content"].= '<td>'.$row['max_no_guests'].'</td>';
		$data["content"].= '<td>';
		$query2 = mysql_query("SELECT * from guests where eid='$eid'");
		
		while($row2 = mysql_fetch_assoc($query2)){
		if ($row2['status'] == 1){
			$data["content"].= "<span class=\"badge badge-success\" data-toggle=\"modal\" href=\"#editguest\" onclick=\"editguest('".$row2['gid']."');\">".$row2['first_name']." ".$row2['last_name']."</span><br>";
		}elseif($row2['status'] == -1){
			$data["content"].= "<span class=\"badge badge-info\" data-toggle=\"modal\" href=\"#editguest\" onclick=\"editguest('".$row2['gid']."');\">".$row2['first_name']." ".$row2['last_name']."</span><br>";	
		}elseif($row2['status'] == 0){
			$data["content"].= "<span class=\"badge badge-important\" data-toggle=\"modal\" href=\"#editguest\" onclick=\"editguest('".$row2['gid']."');\">".$row2['first_name']." ".$row2['last_name']."</span><br>";	
		}
		}
		$data["content"].= "<span class=\"btn btn-info\" onclick=\"addguest('".$row['eid']."');\">+Add Guest</span><br>";
		$data["content"].= '</td>';
		$data["content"].=  "<td><span class=\"btn btn-info\" data-toggle=\"modal\" href=\"#editinvite\" onclick=\"editinvite('".$row['eid']."');\">edit</span></td>";
		$data['content'].= "</tr>";
}

$max_query= mysql_query("SELECT sum(max_no_guests) from evites");
$max_result = mysql_fetch_row($max_query);
$max = $max_result[0];



$attending_query = mysql_query("SELECT count(*) FROM guests WHERE status=1");
$attending_result = mysql_fetch_row($attending_query);
$attending = $attending_result[0];




$data['content'].= "<tr><td></td><td></td><td>Total Invited Guests: $max</td><td>Total Attending: $attending</td><td></td></tr>";
#$data['content'];
$data['status'] = "ok";
}

if($_REQUEST['function'] == "editinvite"){

$eid = mysql_real_escape_string($_REQUEST['eid']);

$query = mysql_query("SELECT * FROM evites where eid = '$eid'");

$row = mysql_fetch_assoc($query);

$data = $row;
$data['status'] = "ok";


}


if($_REQUEST['function'] == "updateinvite"){
$eid = mysql_real_escape_string($_REQUEST['eid']);
$email = mysql_real_escape_string($_REQUEST['email']);
$max_no_guests = mysql_real_escape_string($_REQUEST['max_no_guests']);

$query = mysql_query("UPDATE evites SET code='$code', max_no_guests='$max_no_guests' WHERE eid='$eid'"); 
$data['status'] = "ok";
}


if($_REQUEST['function'] == "editguest"){

$gid = mysql_real_escape_string($_REQUEST['gid']);

$query = mysql_query("SELECT * FROM guests where gid = '$gid'");

$row = mysql_fetch_assoc($query);


$data = $row;
$data['status2'] = "ok";


}


if($_REQUEST['function'] == "updateguest"){
$gid = mysql_real_escape_string($_REQUEST['gid']);
$first_name = mysql_real_escape_string($_REQUEST['first_name']);
$last_name = mysql_real_escape_string($_REQUEST['last_name']);
$status = mysql_real_escape_string($_REQUEST['status']);
$notes = mysql_real_escape_string($_REQUEST['notes']);


$query = mysql_query("UPDATE guests SET first_name='$first_name', last_name='$last_name', status='$status', notes='$notes' WHERE gid='$gid'"); 
$data['status'] = "ok";
}


if($_REQUEST['function'] == "createguest"){

$eid = $_REQUEST['eid'];

mysql_query("INSERT INTO guests (eid, first_name, last_name,status,notes) VALUES ('$eid','New','Guest','-1','')");

$data['status'] = "ok";
$data['gid'] = mysql_insert_id();
}


if($_REQUEST['function'] == "createinvite"){

$rndstr = strtolower(rand_string(5));

mysql_query("INSERT INTO evites (code,max_no_guests) VALUES ('','1')");

$data['status'] = "ok";
$data['eid'] = mysql_insert_id();
}


if($_REQUEST['function'] == "deleteinvite"){

$eid = $_REQUEST['eid'];

#DELETE GUESTS
mysql_query("DELETE from guests where eid='$eid'");
#DELETE EVITE
mysql_query("DELETE from evites where eid='$eid'");
$data['status'] = "ok";
}

if($_REQUEST['function'] == "deleteguest"){
$gid = $_REQUEST['gid'];
mysql_query("DELETE from guests where gid='$gid'");
$data['status'] = "ok";
}


echo json_encode($data);

?>


