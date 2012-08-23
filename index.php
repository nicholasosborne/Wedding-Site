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

	<title>Tara &amp; Adam Are Gettin' Hitched!</title>
	<meta content="width=720, maximum-scale=1.0" name="viewport">
	<meta content="" name="description">
	<meta content="" name="author"><!-- Le styles -->
	<link href="/css/bootstrap.css" rel="stylesheet">
	<link href="/css/style.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Oswald:400,700,300' rel=
	'stylesheet' type='text/css'>
	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<?
		#<!-- Le fav and touch icons -->
	<link href="../assets/ico/favicon.ico" rel="shortcut icon">
	<link href="../assets/ico/apple-touch-icon-114-precomposed.png" rel=
	"apple-touch-icon-precomposed" sizes="114x114">
	<link href="../assets/ico/apple-touch-icon-72-precomposed.png" rel=
	"apple-touch-icon-precomposed" sizes="72x72">
	<link href="../assets/ico/apple-touch-icon-57-precomposed.png" rel=
	"apple-touch-icon-precomposed">
</head>

<body>
	# # # # ?&gt; <script src="/js/jquery.js"></script><? if($mode == 'rsvp'): ?>
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

	</script><? } ?>

	<div id="page_overlay">
		<div id="sidebar-wrapper">
			<div id="sidebar">
				<div class="sidebar-content" id="welcome">
					<? include("content/welcome.php");?>
					</div>

				<div class="sidebar-content" id="theevent">
					<? include("content/theevent.php");?>
					</div>

				<div class="sidebar-content" id="rsvp">
					<? include("content/rsvp.php");?>
					</div>

				<div class="sidebar-content" id="bridegroom">
					<? include("content/bridegroom.php");?>
					</div>

				<div class="sidebar-content" id="weddingparty">
					<? include("content/weddingparty.php");?>
					</div>

				<div class="sidebar-content" id="hotels">
					<? include("content/hotels.php");?>
					</div>
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
	</div><? else: ?>

	<div class="modal" id="findModal">
		<div class="modal-header">
			<h3>Hold up just one quick second…</h3>
		</div>

		<div class="modal-body" id="guestform">
			<p>Please enter your postal code in the field below!</p>

			<form class="form-inline" onsubmit="return false;">
				<input class="input-small" id="postal" maxlength="6"
				placeholder="A1A2B2" type="text"> <button class=
				"btn btn-primary btn-large" onclick="search();" type=
				"button">Search</button>
			</form>

			<p class="small">Having troubles? Email
			adamhare@cutthroatdesign.com for assistance.</p>
		</div>
	</div><? endif;?>
	<!-- The container for the background-image -->

	<div id="bg" style=""></div>

	<div id="bg2" style=""></div>

	<div id="bg_grid" onclick="hide_sidebar();"></div><script src=
	"/js/bootstrap.min.js"></script><script src="/js/script.js"></script>
</body>
</html>