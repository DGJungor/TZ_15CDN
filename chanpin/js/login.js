$(function(){
    var href = window.location.href,
        referrer = document.referrer;
    $(function(){
    	$("#hideid").removeClass("cur");
    });
    
    $(".rnb-inner .chi-parent").hover(function() {
        //$('.chiqq').hide('slow');
        var className = this.className,
            width = '100px',
            height = 'auto';
        if( 'chi-parent ic6'==className ){
            width = "148px";
            height = '148px';
            $(this).parent().find('.sm').css('top','-100px');
        }else{
            $(this).parent().find('.sm').css('top','0');
        }
        $(this).addClass("cur");
        $(this).find(".sm").stop().animate({
            width: width,
            height: height
        }); 
    },function() {
        /*
        if( "DIV"==this.nodeName ){
            return;
        }
        */
        $(this).removeClass("cur");
        $(this).find(".sm").stop().animate({
            width: 0
        });
    });
    	
    
    var curElem;
    $(".rnb-inner .kf-chi li").click(function() {
        if(curElem){
            $(".curs").removeClass("curs");
            $(curElem).find(".chiqq").stop().slideUp();            
        }
       // $(curElem).removeClass("curs");
        $(this).addClass("curs");
        $(this).find(".chiqq").stop().slideDown();
        curElem = this;
    }/*,function() {
        $(this).removeClass("curs");
        $(this).find(".chiqq").stop().slideUp();
    }*/);
    $(function(){
    $(this).find(".one").stop().slideDown();
    $(".curs").addClass("curs");
    curElem = this;
});

    window.setOrderCount = function(){
        var cookies = document.cookie ? document.cookie.split('; ') : [],
            count = 0;
        for (var i = 0, l = cookies.length; i < l; i++) {
            var parts = cookies[i].split('='),
                name = parts.shift(),
                value = parts.join('=');
            
            if( 'order'==name ){
                var orderStr = decodeURIComponent(value),
                    orderArr = orderStr.split("////"),
                    length = orderArr.length;
                    
                if( orderStr && length ){
                    for( var i=0;i<length;i++ ){
                        var oArr = orderArr[i].split('|'),
                            number = oArr[7];
                        count += parseInt( number );
                    }
                }
                break;
            }
        }
        $("#order_count").html(count);
    }    
    
    try {
         if ($(window).width() >= 1440) {
            $(".rnb-inner .ic1").addClass("cur");
        }else {
            $(".rnb-inner .ic1").removeClass("cur");
        }    
    }catch (e){};

    setOrderCount();
    rit_bar();
    
    function rit_bar() {
        try {
            $(".ritght-nav-bar").css({
                height: $(document).height() + "px"
            });    
        }
        catch (e) {}     
    }
    
    function rit_bar() {
        try {
            $(".ritght-nav-bar").css({
                height: $(window).height() + "px"
            });   
        }
        catch (e) {}   
    }
});
function connectESQ(){
	$("#hideid").addClass("cur");
}