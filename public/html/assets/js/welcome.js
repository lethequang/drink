"use strict";
$(document).ready(function(){
	var header = $("#header");

	$(".navbar-toggle").on("click", function(){
		header.toggleClass("open");
	});

	$('#navbar > .nav > .dropdown').each(function() {
		$(this).on('click', function() {
			$(this).toggleClass('expand-menu');
			$('#navbar .nav .dropdown').not(this).removeClass('expand-menu');
		});
	});

});