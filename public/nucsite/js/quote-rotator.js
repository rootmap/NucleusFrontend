$(function(){
	var items = (Math.floor(Math.random() * ($('#testimonials li').length)));
	$('#testimonials li').hide().eq(items).show();
	
  function next(){
		$('#testimonials li:visible').delay(5000).fadeOut('slow',function(){
			$(this).appendTo('#testimonials ul');
			$('#testimonials li:first').fadeIn('slow',next);
    });
   }
  next();

});

$(function(){
	var items = (Math.floor(Math.random() * ($('#testimonials-rotate-1 li').length)));
	$('#testimonials-rotate-1 li').hide().eq(items).show();
	
  function next(){
		$('#testimonials-rotate-1 li:visible').delay(10000).fadeOut('slow',function(){
			$(this).appendTo('#testimonials-rotate-1 ul');
			$('#testimonials-rotate-1 li:first').fadeIn('slow',next);
    });
   }
  next();

});

$(function(){
	var items = (Math.floor(Math.random() * ($('#testimonials-rotate-2 li').length)));
	$('#testimonials-rotate-2 li').hide().eq(items).show();
	
  function next(){
		$('#testimonials-rotate-2 li:visible').delay(10000).fadeOut('slow',function(){
			$(this).appendTo('#testimonials-rotate-2 ul');
			$('#testimonials-rotate-2 li:first').fadeIn('slow',next);
    });
   }
  next();

});