<?


?>

<div class="content-header">
<h1>RSVP</h1>
<h2>We Look Forward To Having You Join Us!</h2>
</div>
<div id="rsvp-body" class="content-body">

We've filled out what we can - please take a moment to fill in the rest and be sure to hit UPDATE RSVP on each person once you've added or updated their information.  If you need help with any part of the RSVP process, please email Adam - <a href="mailto:adamhare@cutthroatdesign.com">adamhare@cutthroatdesign.com</a>. Thanks!

<br /><br />

<div id="guest-wrapper">

<?

if($status == "ok"){

	
		//NO DINNER

		foreach ($guests as &$guest) {
		?>
		
		<div class="guest">
		<form class="form-horizontal">
		
		
		
		<span class="gname"><?=$guest['first_name'];?> <?=$guest['last_name'];?></span>
		
		
		<fieldset>
		<div class="control-group">
		<label class="control-label" for="gattending">Attending</label>
		<div class="controls">
		<select id="gattending" name="gattending">
		<option value="0" <? if($guest['status'] == 0){echo "SELECTED";}?>>No</option>
		<option value="1" <? if($guest['status'] == 1){echo "SELECTED";}?>>Yes</option>
		</select>
		</div>
		</div>
		
		<div class="control-group">
		<label class="control-label" for="gnotes">Allergies/Notes</label>
		<div class="controls">
		<textarea id="gnotes" name="gnotes"><?=$guest['notes'];?></textarea>
		</div>
		</div>
		
	
		<button type="button" class="btn btn-primary" data-loading-text="Saving…" data-complete-text="Saved!" onclick="update_guest($(this).parents('form:first'),'<?=$guest['gid'];?>',$(this));">Update RSVP</button>
				
		
		</fieldset>
		</form>
		</div>		
		<?
		}
		
			echo "</div>";	
			
			
		$num = $max - count($guests);
		
		if($num > 0){echo "<div id=\"adguest\" class=\"content-header\"><h1>Additional Guests</h1></div>";}
	
	
	
	for($i = 0;$i<$num;$i++){?>
	
	<div class="guest">
	<form id="newguest<?=$i;?>" name="newguest<?=$i;?>" class="form-horizontal">
		
		
		<span class="gname">Additional Guest <?=$i+1;?></span>
		
		
		<div class="control-group">
		<label class="control-label" for="first_name">Fist Name</label>
		<div class="controls">
		<input type="text" id="first_name" name="first_name" />
		</div>
		</div>
		
		<div class="control-group">
		<label class="control-label" for="last_name">Last Name</label>
		<div class="controls">
		<input type="text" id="last_name" name="last_name" />
		</div>
		</div>
				
		<div class="control-group">
		<label class="control-label" for="gmeal">Allergies/Notes</label>
		<div class="controls">
		<textarea id="gnotes" name="gnotes"></textarea>
		</div>
		</div>
		
		
		<input type="button" class="btn btn-primary" value="Add Guest" onclick="add_guest($('#newguest<?=$i;?>'));">
		
		
		
	</form>	
	</div>

	
		
	
	<? 
			
			
	}	
}
?>
			    
</div>			    
