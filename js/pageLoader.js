$(window).ready(function(){
	$(".pageLoader").hide();
});

window.onbeforeunload = function () { $('.pageLoader').show(); }