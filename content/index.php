<?php
include("api/dbconnect.php");
session_start();

#unset($_SESSION['eid']);

if(isset($_SESSION['eid'])){
		$mode = "rsvp";
		$eid = $_SESSION['eid'];
		$code_query = mysql_query("SELECT * FROM  evites where eid='$eid'");

		if(mysql_num_rows($code_query)){
			$code_result = mysql_fetch_assoc($code_query);
			$max = $code_result['max_no_guests'];
			#SET THE TYPE
						
			#NOW FIND OUT HOW MANY EXISTING GUESTS THERE ARE
			$guest_query = mysql_query("SELECT * from guests where eid = $eid");
			$remaining_guests = $max - mysql_num_rows($guest_query);
			$guests = array();
			while($row = mysql_fetch_assoc($guest_query)){
			unset($row['eid']);
			array_push($guests, $row);
			
			}
			
			
			$status = "ok";
		}else{
			$status = "error";
			$type = -1;
		}	
		
		

	}else{
		$mode = "fresh";
	}
?>
	
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Tara & Adam Are Gettin' Hitched!</title>
    <meta name="viewport" content="width=720, maximum-scale=1.0" />
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="/css/bootstrap.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Oswald:400,700,300' rel='stylesheet' type='text/css'>
    
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	<?
   	#<!-- Le fav and touch icons -->
    #<link rel="shortcut icon" href="../assets/ico/favicon.ico">
    #<link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    #<link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    #<link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
    ?>
    <script src="/js/jquery.js"></script>
  </head>

  <body>

  <? if($mode == 'rsvp'): ?>
  
  
 <? if($_SESSION['state'] == "one"){ ?>
  <script>
   $(document).ready(function () {
   show($('#rsvp'),$("#rsvp_pill"));
   });
  </script>
  
 <? $_SESSION['state'] = "two"; }elseif($_SESSION['state'] == "two"){ ?>
  <script>
   $(document).ready(function () {
   show($('#welcome'),$("#welcome_pill"));
   });

  </script>
  
 <? } ?> 
  
  <div id="page_overlay">

	<div id="sidebar-wrapper">
	<div id="sidebar">
	
	
	<div class="sidebar-content" id="welcome"><? include("content/welcome.php");?></div>
	<div class="sidebar-content" id="theevent"><? include("content/theevent.php");?></div>
	<div class="sidebar-content" id="rsvp"><? include("content/rsvp.php");?></div>
	<div class="sidebar-content" id="bridegroom"><? include("content/bridegroom.php");?></div>
	<div class="sidebar-content" id="weddingparty"><? include("content/weddingparty.php");?></div>
	<div class="sidebar-content" id="hotels"><? include("content/hotels.php");?></div>
	
	</div>
	
	
	<div id="nav">
		<ul class="nav-list">
		<li id="welcome_pill">Welcome</li>
		<li id="event_pill">Wedding Day</li>
		<li id="rsvp_pill">RSVP</li>
		<li id="bg_pill">How we met</li>
		<li id="wp_pill">Wedding Party</li>
		<li id="hotel_pill">Hotels</li>
		
		</ul>
	</div>
	</div>
   <div class="container"></div>
	
 </div>
<? else: ?>	
	<div class="modal" id="findModal">
  <div class="modal-header">
    <h3>Hold up just one quick second…</h3>
  </div>
  <div id="guestform" class="modal-body">
    <p>Please enter your postal code in the field below!</p>
    
    <form  class="form-inline">
  <input type="text" id="postal" class="input-small" maxlength="6" placeholder="A1A2B2">
   <button type="button" onClick="search();" class="btn btn-primary btn-large">Search</button>
</form>
    
  </div>
  
</div>

<? endif;?>	
	

	<!-- The container for the background-image -->
   
	<div id="bg" style="" ></div>
	<div id="bg2" style="" ></div>
	<div id="bg_grid" onClick="hide_sidebar();"></div>

    
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/script.js"></script>
	
  </body>
</html>
