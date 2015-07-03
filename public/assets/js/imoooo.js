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

    $.ajax({
        type: "post",
        url:"/index.php?r=index/getImagesPath",
        data: 'card_id='+card_id+'&id='+id+'&closetypep='+closetypep,
        async:false,
        dataType: "json",
        cache:false,
        contentType:'text/html; charset=utf-8;',
        success: function(html){
            alert(html);
//            window.location.href= url+"?r=Housing/CloseType&type="+html.code+"&id="+id;
        }
    });
});