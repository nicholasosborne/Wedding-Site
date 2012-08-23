<?php
include_once("dbconnect.php");

#GET FUNCTION

$function = $_REQUEST['function'];

$return_data = array();

switch($function){

	case "search":
	$return_data = search();
	break;


	case "pick":
	$return_data = pick();
	break;

	
	case "getcode":
	$return_data = get_code();
	break;
	
	case "addguest":
	$return_data = add_guest();
	break;
	
	case "updateguest":
	$return_data = update_guest();
	break;

	default:
    $return_data['status'] = "error";
    $return_data['error'] = "nofunction";
    break;
}

echo json_encode($return_data);

### FUNCTION TIME

function pick(){

	if(isset($_REQUEST['gid'])){

		$gid = mysql_real_escape_string($_REQUEST['gid']);
		
		$pick_query = mysql_query("SELECT eid FROM guests where gid='$gid'");
		
		$row = mysql_fetch_row($pick_query);
		
		#echo $row[0];
		
		$return_data['status'] = "ok";
		
		session_start();
		$_SESSION['eid'] = $row[0];
		$_SESSION['state'] = "one";
		#$return_data['eid'] = $row[0];
		
	}else{
		$return_data['status'] = "error";
		$return_data['error'] = "No gid";
	}

	return $return_data;
}


function search(){

	if($_REQUEST['postal'] <> ''){

		$postal = mysql_real_escape_string($_REQUEST['postal']);
		
		$post_query = mysql_query("SELECT * FROM evites where code='$postal'");
		
		if(mysql_num_rows($post_query) < 1){
		
			$return_data['status'] = "error";
			$return_data['error'] = "Invalid Code";
		
		}elseif(mysql_num_rows($post_query) == 1){
				
			session_start();
			$row = mysql_fetch_assoc($post_query);
			$_SESSION['eid'] = $row['eid'];
			$_SESSION['state'] = "one";
			
			
			$return_data['status'] = "found";
			$return_data['eid'] = $row['eid'];
		
		}else{
		#MULTIPLE RESULTS
			$return_data['status'] = "ok";
			$return_data['content'] = '<p>Who are you?</p>';
               
               while($row = mysql_fetch_assoc($post_query)){
               
               $tempid = $row['eid'];
               
               $query2 = mysql_query("SELECT gid,first_name,last_name FROM guests WHERE eid = '$tempid'");
               
             
               $return_data['content'].= '<p>';
               
               while($row2 = mysql_fetch_assoc($query2)){
               
               $return_data['content'].= '<span onclick="pick(\''.$row2['gid'].'\')" class="badge badge-info">'.$row2['first_name'].' '.$row2['last_name'].'</span>';
               
               }
             
               $return_data['content'].= '</p>';
               } 
                
                #<option>1</option>
                #<option>2</option>
                #<option>3</option>
                #<option>4</option>
                #<option>5</option>
             $return_data['content'].='';
		
		}

	}else{
		$return_data['status'] = "error";
		$return_data['error'] = "No Postal Code";
	}
	
	return $return_data;
}



#GET CODE
function get_code(){

	if(isset($_REQUEST['code'])){

		$code = mysql_real_escape_string($_REQUEST['code']);
	
		$code_query = mysql_query("SELECT * FROM  evites where code='$code'");

		if(mysql_num_rows($code_query)){
			$code_result = mysql_fetch_assoc($code_query);
			$eid = $code_result['eid'];
			$max = $code_result['max_no_guests'];
			#SET THE TYPE
			$return_data['type'] = $code_result['type'];
			
			#NOW FIND OUT HOW MANY EXISTING GUESTS THERE ARE
			$guest_query = mysql_query("SELECT * from guests where eid = $eid");
			$return_data['remaining_guests'] = $max - mysql_num_rows($guest_query);
			$return_data['guests'] = array();
			while($row = mysql_fetch_assoc($guest_query)){
			unset($row['eid']);
			array_push($return_data['guests'], $row);
			
			}
			$return_data['status'] = "ok";
		}else{
			$return_data['status'] = "error";
			$return_data['error'] = "invalidcode";
		}
		
		

	}else{
		$return_data['status'] = "error";
		$return_data['error'] = "nocode";
	}

	return $return_data;	
}


#ADD GUEST
function add_guest(){
session_start();
	if(isset($_SESSION['eid'])){
		$eid = mysql_real_escape_string($_SESSION['eid']);
		$code_query = mysql_query("SELECT max_no_guests FROM evites where eid='$eid'");

		if(mysql_num_rows($code_query)){
		
			$result = mysql_fetch_array($code_query);
			$max = $result[0];
			
			#echo $eid;
			#COOL NOW WE"RE GOING TO FETCH THE REST OF THE FORM DATA AND STORE IT
			$fname = mysql_real_escape_string($_REQUEST['first_name']);
			$lname = mysql_real_escape_string($_REQUEST['last_name']);
			$notes = mysql_real_escape_string($_REQUEST['gnotes']);
			
			
			#GREAT WE're all prepped but can we add this?
			#NOW FIND OUT HOW MANY EXISTING GUESTS THERE ARE
			$guest_query = mysql_query("SELECT * from guests where eid = $eid");
			if(mysql_num_rows($guest_query) < $max){
				$return_data['remaining'] =  $max - mysql_num_rows($guest_query) - 1;
			
				#INSERT THE NEW GUEST
				mysql_query("INSERT INTO guests (eid,first_name,last_name,status,notes) VALUES ('$eid','$fname','$lname','1','$notes')");
				if(mysql_affected_rows() > 0){
				
					$gid = mysql_insert_id();
					#NOW ASSEMBLE THE OUTPUT
					$return_data['status'] = "ok";
					$return_data['guests'] = array();
					$temp = array("gid" => $gid, "first_name" => $fname, "last_name" => $lname, "status" => $status, 'notes' => $notes);
					
				
					
					
					
					
					$return_data['item'] ='';
					
$return_data['item'].='<div class="guest">';
$return_data['item'].='<form class="form-horizontal" id="form'.$temp['gid'].'" name="form'.$temp['gid'].'">';
#$return_data['item'].='<div class="control-group">';
$return_data['item'].='<span class="gname">'.$temp['first_name'].' '.$temp['last_name'].'</span>';
#$return_data['item'].='</div>';
		
$return_data['item'].='<fieldset>';
$return_data['item'].='<div class="control-group">';
$return_data['item'].='<label class="control-label" for="gattending">Attending</label>';
$return_data['item'].='<div class="controls">';
$return_data['item'].='<select id="gattending" name="gattending">';
$return_data['item'].='<option value="0">No</option>';
$return_data['item'].='<option value="1" SELECTED>Yes</option>';
$return_data['item'].='</select>';
$return_data['item'].='</div>';
$return_data['item'].='</div>';
			
$return_data['item'].='<div class="control-group">';
$return_data['item'].='<label class="control-label" for="gnotes">Allergies/Notes</label>';
$return_data['item'].='<div class="controls">';
$return_data['item'].='<textarea id="gnotes" name="gnotes">'.$temp['notes'].'</textarea>';
$return_data['item'].='</div>';
$return_data['item'].='</div>';
		
#$return_data['item'].='<div class="control-group">';
#$return_data['item'].='<div class="controls">';
$return_data['item'].='<button type="button" class="btn btn-success" data-loading-text="Saving…" data-complete-text="Saved!" onclick="update_guest($(this).parents(\'form:first\'),\''.$temp['gid'].'\',$(this));">Saved!</button>';
#$return_data['item'].='</div>';
#$return_data['item'].='</div>';
		
		
$return_data['item'].='</fieldset>';
$return_data['item'].='</form>';
$return_data['item'].='</div>';
					
					
					
#RETURN ITEM							
					
					
					array_push($return_data['guests'],$temp);
				}else{
					$return_data['status'] = "error";
					$return_data['error'] = "mysqlinsert";
				}
			}else{
				$return_data['status'] = "error";
				$return_data['error'] = "overquota";
			}
		}else{
			$return_data['status'] = "error";
			$return_data['error'] = "invalidcode";
		}
	
	}else{
		$return_data['status'] = "error";
		$return_data['error'] = "nocode";
	}
	
	return $return_data;
}

#UPDATE GUEST
function update_guest(){
session_start();
	if(isset($_SESSION['eid'])){
		$eid = mysql_real_escape_string($_SESSION['eid']);
		
			
			$gid = mysql_real_escape_string($_REQUEST['gid']);
			$status = mysql_real_escape_string($_REQUEST['gattending']);
			$notes = mysql_real_escape_string($_REQUEST['gnotes']);
			
			#echo $type;
			
			
			mysql_query("UPDATE guests SET status='$status', notes='$notes' WHERE gid='$gid' AND eid = '$eid'");
			
			
			
			/*
			if (isset($_REQUEST['status'])){
			mysql_query("UPDATE guests SET status='$status' WHERE gid='$gid' AND eid = '$eid'");
			}
			if (isset($_REQUEST['meal'])){
			mysql_query("UPDATE guests SET meal='$meal' WHERE gid='$gid' AND eid = '$eid'");
			}
			if (isset($_REQUEST['notes'])){
			mysql_query("UPDATE guests SET notes='$notes' WHERE gid='$gid' AND eid = '$eid'");
			}
			*/
			
			if(mysql_affected_rows() > 0){
			$return_data['status'] = "ok";
					
			}else{
			$return_data['status'] = "error";
			$return_data['error'] = "invalidupdate";
			}
			
	
	
	}else{
		$return_data['status'] = "error";
		$return_data['error'] = "nocode";
	}
	
	return $return_data;
}

?>