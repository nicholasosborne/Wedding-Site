$(document).ready(function() {
	var imgArr = new Array( // relative paths of images
	'/images/backgrounds/image1.jpg', '/images/backgrounds/image2.jpg', '/images/backgrounds/image3.jpg', '/images/backgrounds/image4.jpg', '/images/backgrounds/image5.jpg', '/images/backgrounds/image6.jpg', '/images/backgrounds/image7.jpg');
	var preloadArr = new Array();
	var i; /* preload images */
	for (i = 0; i < imgArr.length; i++) {
		preloadArr[i] = new Image();
		preloadArr[i].src = imgArr[i];
	}
	var currImg = 1;
	var intID = setInterval(changeImg, 8000);
	var curr = $('#bg');
	var next = $('#bg2'); /* image rotator */

	function changeImg() {
		next.css('-moz-background-size', '100%');
		next.css('background', 'url(' + preloadArr[currImg++ % preloadArr.length].src + ')  no-repeat center fixed');
		next.css('-moz-background-size', '100%');
		curr.animate({
			opacity: 0
		}, 2000, function() {
			next.css('z-index', 1);
			curr.css('z-index', 0);
		}).animate({
			opacity: 1
		}, 0, function() {
			var temp = curr;
			curr = next;
			next = temp;
		});
	}
	$('#rsvpModal').modal({
		backdrop: false
	})
	$('#rsvpModal').modal('show');
	$("#welcome_pill").click(function() {
		show($('#welcome'), $(this));
	});
	$("#hotel_pill").click(function() {
		show($('#hotels'), $(this));
	});
	$("#bg_pill").click(function() {
		show($('#bridegroom'), $(this));
	});
	$("#wp_pill").click(function() {
		show($('#weddingparty'), $(this));
	});
	$("#event_pill").click(function() {
		show($('#theevent'), $(this));
	});
	$("#rsvp_pill").click(function() {
		show($('#rsvp'), $(this));
	});
	$("#lookup").click(function() {
		lookup($('#code'));
	});
	$('#postal').keypress(function(e) {
		if (e.which == 13) {
			search();
		}
	});
});
var position = "in";
var current = $('#bridegroom');
var current_pill;

function toggle_sidebar() {
	if (position == "in") {
		$("#sidebar-wrapper").animate({
			"left": "+=470px"
		}, 500);
		position = "out";
	} else {
		$("#sidebar-wrapper").animate({
			"left": "-=470px"
		}, 500);
		position = "in";
	}
}

function hide_sidebar() {
	if (position == "out") {
		$("#sidebar-wrapper").animate({
			"left": "-=470px"
		}, 500);
		position = "in";
	}
}

function show_sidebar() {
	if (position == "in") {
		$("#sidebar-wrapper").animate({
			"left": "+=470px"
		}, 500);
		position = "out";
	}
}

function show(page, pill) {
	if (position == "in") {
		current.css('display', 'none');
		if (current_pill != null) {
			current_pill.removeClass('active');
		}
		pill.addClass('active');
		current_pill = pill;
		page.css('display', 'inherit');
		$("#sidebar-wrapper").animate({
			"left": "+=470px"
		}, 500);
		position = "out";
		current = page;
	} else {
		if (current_pill != null) {
			current_pill.removeClass('active');
		}
		if (current_pill.html() == pill.html()) {
			hide_sidebar();
		} else {
			pill.addClass('active');
			current_pill = pill;
			$("#sidebar-wrapper").animate({
				"left": "-=470px"
			}, 500, function() {
				current.css('display', 'none');
				page.css('display', 'inherit');
				$("#sidebar-wrapper").animate({
					"left": "+=470px"
				}, 500);
				current = page;
			});
		}
	}
}

function search() {
	var postal = $('#postal').val();
	$.ajax({
		type: 'POST',
		url: '/api/search/',
		data: {
			"postal": postal
		},
		dataType: 'json',
		success: function(json) {
			if (json.status == "ok") {
				$('#guestform').html(json.content);
			} else if (json.status == "error") {
				alert(json.error);
			} else if (json.status == "found") {
				window.location.reload();
			}
		}
	});
}

function pick(gid) {
	$.ajax({
		type: 'POST',
		url: '/api/pick/',
		data: {
			"gid": gid
		},
		dataType: 'json',
		success: function(json) {
			if (json.status == "ok") {
				window.location.reload();
			} else if (json.status == "error") {
				alert(json.error);
			}
		}
	});
}

function lookup(code) {
	$.ajax({
		type: 'POST',
		url: '/api/getcode/',
		data: {
			"code": code.val()
		},
		dataType: 'json',
		success: function(json) {
			if (json.status == "ok") {
				$.each(json.guests, function() {
					alert(this.first_name);
				});
			} else if (json.status == "error") alert(json.error);
		}
	});
}

function update_guest(id, gid, abutton) {
	abutton.button('loading');
	$.ajax({
		type: 'POST',
		url: '/api/updateguest/',
		data: id.serialize() + "&gid=" + gid,
		dataType: 'json',
		success: function(json) {
			abutton.removeClass('btn-primary').addClass('btn-success');
			abutton.button('complete');
		}
	});
}

function add_guest(id) {
	$.ajax({
		type: 'POST',
		url: '/api/addguest/',
		data: id.serialize(),
		dataType: 'json',
		success: function(json) {
			id.fadeOut().remove();
			$(json.item).appendTo('#guest-wrapper');
			if (json.remaining < 1) {
				$('#adguest').remove();
			}
		}
	});
}

function togglea(id) {
	if (id.html() == '+') {
		$('.accordion-toggle').html('+');
		id.html('-');
	} else {
		id.html('+');
	}
}