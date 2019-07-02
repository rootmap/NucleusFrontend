$(function() {
	$('.btn-recruiter').bind('click', function(e){
		e.preventDefault();
		if (!$('.recruiter-form').is(':visible')) {
			$('.recruiter-form').slideDown();
		} else {
			$('.recruiter-form').slideUp();
		}
	});
	
	$('#perks .grid_3').bind('mouseenter mouseleave', function(e) {
		if (e.type == 'mouseleave') {
			$(this).find('img').show().end().find('div.desc').hide();
		} else {
			$(this).find('div.desc').show().end().find('img').hide();
		}
	});
	
	$('.image-slide-left').slideshow({
		duration: 400,
		delay: 3000,
		selector: '> img',
		transition: 'push(left)',
		autoPlay: true
	});
	
	$('.image-slide-right').slideshow({
		duration: 400,
		delay: 3000,
		selector: '> img',
		transition: 'push(down)',
		autoPlay: true
	});
	
	$('.desc').each(function() { $(this).show(); $(this).css('margin-top', (187 - $(this).innerHeight()) / 2 + "px"); $(this).hide(); });
});