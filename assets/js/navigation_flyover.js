        function show_this_menu_hide_others() {
            debug_log('show_this', $(this).html());
            if (!$(this).hasClass("current")){
                $("header nav .current").removeClass("current"); 
                $(this).parent().find('a, ul, li').addClass("current");
                $(this).chi
                $(this).addClass('current');
            } else {
                hide_this_menu($(this));
            }
            return false;
        }
        function do_nothing() {
            debug_log('nothing', $(this).html())
        }
        function hide_this_menu(some_element) {
            //if (some_element instanceof jQuery.Event) {
            if (some_element.originalEvent != undefined ) { //check for jquery event
                //are we on a sub element?
                if ($(some_element.toElement).hasClass('current')) {
                    return;
                }
                some_element = $(this);
            }
            debug_log('hide_this', some_element.html());
            some_element.parent().find('ul').removeClass("current");	
            some_element.removeClass('current');
        }
        function hide_others() {
            debug_log('hide_others', $(this).html())
            if (!$(this).hasClass("current")){
                $("header nav .current").removeClass("current"); 
            }
        }
        function debug_log(func, elem) {
            //$('#debug_window').show();
            var html = $('#debug_window').html();
            html += func + ":" + elem + '<br/>';
            $('#debug_window').html(html);
            var objDiv = document.getElementById("debug_window");
            objDiv.scrollTop = objDiv.scrollHeight;
        }

	$(document).ready(function(){
		$(".level1nav").click(show_this_menu_hide_others);	
		$(".level1nav").hover(hide_others, hide_this_menu);	
	});


