$(function() {
	$("a.icon").bind("mouseenter mouseleave", function(e) {
		var self = $(this);
		$(".event-tooltip").find("h1").text($(this).find('img').attr("title"));
		if (!$(this).closest(".post-spotlight-event").length) {
			$(".event-tooltip").removeClass('spotlight');
			if (e.type == 'mouseenter') {	
				$(".event-tooltip").css("top", $(this).offset().top + 66).css("left", $(this).offset().left - 80);

				$(".event-tooltip").stop(true, true).fadeIn("slow");
			} else {
				$(".event-tooltip").stop(true, true).fadeOut("slow");
			}
		} else {
			$(".event-tooltip").addClass('spotlight');
			if (e.type == 'mouseenter') {
				$(".event-tooltip").css("top", $(this).offset().top).css("left", $(this).offset().left - 178);
				
				$(".event-tooltip").stop(true, true).fadeIn("slow");
			} else {
				$(".event-tooltip").stop(true, true).fadeOut("slow");
			}
		}
	});
});