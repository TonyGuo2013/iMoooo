$(function(){
	$(".photo-wall li").mouseenter(function(){
		if($(this).find("dl").length!=0){
			$(this).find("img").animate({top:"-10px"},150);
		}
		$(this).find("dl.intr-s").animate({top:"50%"},150);
		$(this).find("dl.intr-x").animate({top:"0%"},150);
	}).mouseleave(function(){
		$(this).find("img").animate({top:"0px"},150);
		$(this).find("dl").animate({top:"100%"},150);
	});	
});