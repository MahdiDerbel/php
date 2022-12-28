$(document).ready(function() {

	
if($(window).width()>980) {
	var menu = new TimelineMax({paused:true});
	menu.insert(TweenMax.fromTo('#menu-xs', 0.4, {x:'100%', force3D:true},{x:'0%'}));

	var scroll_header = new TimelineMax({paused:true});
	scroll_header.insert(TweenMax.fromTo('#scroll-header', 0.2, {y:'-100%', force3D:true},{y:'0%'}));

	

	var home_height = $('#home').outerHeight()/2;
	var over = false;
	$(window).on('scroll', function() {
		var offset = $(window).scrollTop();
		if(offset >= home_height && over == false){ alert() ;
				$('#scroll-header').css("display","block") ; 
			scroll_header.play();
			over = true;
		}else if(offset < home_height && over == true){
			$('#scroll-header').css("display","none") ; 
			scroll_header.reverse();
			over = false;
		}
	});

}

 });

