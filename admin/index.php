
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Adam & Tara</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="bootstrap.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    
 

    
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
    <script src="/js/jquery.js"></script>
  </head>

  <body>
  
  <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#">Admin Panel</a>
        </div>
      </div>
    </div>
  
  
  
  <div class="container-fluid" style="margin-top:60px;">
      <div class="row-fluid">
        
        <div class="span12">
          <table class="table table-bordered table-striped">
  		  <thead>
  		  <tr>
  		  <th>i</th>
  		  <th>Postal Code</th>
  		  <th>Max Guests</th>
  		  <th>Guests</th>
  		  <th>Edit</th>
  		  </tr>
  		  </thead>
  		  <tbody id="tbody">
  		  
  		  </tbody>
    	  </table>
    	  <span class="btn btn-info" onclick="addevite()">+Add Evite</span>
    	  <span><a class="btn btn-info" href="download.php" target="_blank">Guest List CSV</a></span>           
        </div><!--/span-->
      </div><!--/row--> 
		
		
	
  
  
  <hr>

      <footer>
        <p>&copy; Adam & Tara</p>
      </footer>

    </div> <!-- /container -->
	
	
<div class="modal" style="display:none;" id="editinvite">
    <div class="modal-header">
    <button class="close" data-dismiss="modal">×</button>
    <h3>Edit Evite</h3>
    </div>
    <div class="modal-body">
   
   	<form name="fevite" id="fevite" class="form-horizontal">
   	<fieldset>
   	<input id="eid" name="eid" value="" type="hidden">
   	<div class="control-group">
   		<label class="control-label" for="code">Postal Code: </label>
   		<div class="controls">
   			<input id="code" name="code" class="input-xlarge" type="text">
   		</div>
   	</div>
   		<div class="control-group">
   		<label class="control-label" for="max_no_guests">Max:</label>
   		<div class="controls">
   			<input id="max_no_guests" name="max_no_guests" class="input-xlarge" type="text">
   		</div>
   	</div>
   	</fieldset>
   	</form>
   
    </div>
    <div class="modal-footer">
    <a href="#" onclick="$('#editinvite').modal('hide')" class="btn">Close</a>
    <a href="#" onclick="deleteinvite();" class="btn btn-danger">Delete</a>
    <a href="#" onclick="updateinvite();" class="btn btn-primary">Save changes</a>
    </div>
    </div>
    
    <div class="modal" style="display:none;" id="editguest">
    <div class="modal-header">
    <button class="close" data-dismiss="modal">×</button>
    <h3>Edit Guest</h3>
    </div>
    <div class="modal-body">
   
   	<form name="fguest" id="fguest" class="form-horizontal">
   	<fieldset>
   	<input id="gid" name="gid" value="" type="hidden">
   	<div class="control-group">
   		<label class="control-label" for="first_name">First Name: </label>
   		<div class="controls">
   			<input id="first_name" name="first_name" class="input-xlarge" type="text">
   		</div>
   	</div>
   	<div class="control-group">
   		<label class="control-label" for="last_name">Last Name: </label>
   		<div class="controls">
   			<input id="last_name" name="last_name" class="input-xlarge" type="text">
   		</div>
   	</div>
   	<div class="control-group">
   		<label class="control-label" for="status">Status: </label>
   		<div class="controls">
   			<select name="status" id="status">
   			<option value="-1">Awaiting Reply</option>
   			<option value="0">Not Attending</option>
   			<option value="1">Attending</option>
   			</select>
   		</div>
   	</div>
   		<div class="control-group">
   		<label class="control-label" for="notes">Notes:</label>
   		<div class="controls">
   			<textarea id="notes" name="notes" class="input-xlarge" rows="3"></textarea>
   		</div>
   	</div>
   	</fieldset>
   	</form>
   
    </div>
    <div class="modal-footer">
       <a href="#" onclick="$('#editguest').modal('hide')" class="btn">Close</a>
     <a href="#" onclick="deleteguest();" class="btn btn-danger">Delete</a>
    <a href="#" onclick="updateguest();" class="btn btn-primary">Save changes</a>
    </div>
    </div>
    
    
    
	
    
    <script src="bootstrap.min.js"></script>
    <script src="ajax.js"></script>
	
  </body>
</html>
