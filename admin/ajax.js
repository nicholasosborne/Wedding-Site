function update(){
$.ajax({
        type: 'POST',
        url: 'ajax.php',
        data:{"function": "update"},
        dataType: 'json',
        success: function(json) {
 			if(json.status == "ok"){
 			
 			$('#tbody').html(json.content);
 				

 			}else if(json.status == "error") alert(json.error);
        }	
	});
}


function addguest(eid){
alert(eid);
}



function editinvite(eid){
$.ajax({
        type: 'POST',
        url: 'ajax.php',
        data:{"function": "editinvite","eid": eid},
        dataType: 'json',
        success: function(json) {
 			if(json.status == "ok"){
 			$('#eid').val(json.eid); 
 			$('#code').val(json.code); 
 			$('#max_no_guests').val(json.max_no_guests);
 			}else if(json.status == "error") alert(json.error);
        }	
	});
}

function updateinvite(){
$.ajax({
       type: 'POST',
        url: 'ajax.php',
        data: $("#fevite").serialize() + "&function=updateinvite",
        dataType: 'json',
        success: function(json) {
 		$('#editinvite').modal('hide');	
 		}	
	});

}

function deleteinvite(){
$.ajax({
       type: 'POST',
        url: 'ajax.php',
        data: $("#fevite").serialize() + "&function=deleteinvite",
        dataType: 'json',
        success: function(json) {
 		$('#editinvite').modal('hide');	
 		}	
	});

}

function editguest(gid){
$.ajax({
        type: 'POST',
        url: 'ajax.php',
        data:{"function": "editguest","gid": gid},
        dataType: 'json',
        success: function(json) {
 			if(json.status2 == "ok"){
 			$('#gid').val(json.gid); 
 			$('#first_name').val(json.first_name); 
 			$('#last_name').val(json.last_name);
 			$('#status').val(json.status);
 			$("#notes").html(json.notes);
 			}else if(json.status == "error") alert(json.error);
        }	
	});
}

function updateguest(){
$.ajax({
       type: 'POST',
        url: 'ajax.php',
        data: $("#fguest").serialize() + "&function=updateguest",
        dataType: 'json',
        success: function(json) {
 		$('#editguest').modal('hide');	
 		}	
	});

}

function deleteguest(){
$.ajax({
       type: 'POST',
        url: 'ajax.php',
        data: $("#fguest").serialize() + "&function=deleteguest",
        dataType: 'json',
        success: function(json) {
 		$('#editguest').modal('hide');	
 		}	
	});

}






function addguest(eid){
$.ajax({
       type: 'POST',
        url: 'ajax.php',
        data: {"function":"createguest","eid":eid},
        dataType: 'json',
        success: function(json) {
        update();
        editguest(json.gid);
 		$('#editguest').modal('show');	
 		}	
	});


}


function addevite(){
$.ajax({
       type: 'POST',
        url: 'ajax.php',
        data: {"function":"createinvite"},
        dataType: 'json',
        success: function(json) {
        update();
        editinvite(json.eid);
 		$('#editinvite').modal('show');	
 		}	
	});}




$(document).ready(function() {
  update();
  var intID = setInterval(update, 60000);
});


$('#editinvite').on('hidden', function () {
    update();
    })
    
$('#editguest').on('hidden', function () {
    update();
    })    