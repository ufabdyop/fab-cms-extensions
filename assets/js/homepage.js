    /**
     * create the sliding functionality of the services menu
     */
	$(document).ready(function(){
		$("#servicesmenu > ul > li").click(function(){
			if (!$(this).hasClass("current")){
                            $("#servicesmenu .current").removeClass("current"); 
                            $(this).addClass("current");	

                            $("#servicesmenu > ul > li > ul").hide(0,function() {$("#servicesmenu .current ul").show();});
                            
			}
		});	
	});

