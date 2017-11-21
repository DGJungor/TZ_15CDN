/**
 * @author rock wang @ tzidc
 * 
 */
		/*
			why choose us
		*/
//polyFills
//Source: https://github.com/Alhadis/Snippets/blob/master/js/polyfills/IE8-child-elements.js
if(!("nextElementSibling" in document.documentElement)){
    Object.defineProperty(Element.prototype, "nextElementSibling", {
        get: function(){
            var e = this.nextSibling;
            while(e && 1 !== e.nodeType)
                e = e.nextSibling;
            return e;
        }
    });
}

// Source: https://github.com/Alhadis/Snippets/blob/master/js/polyfills/IE8-child-elements.js
if(!("firstElementChild" in document.documentElement)){
    Object.defineProperty(Element.prototype, "firstElementChild", {
        get: function(){
            for(var nodes = this.children, n, i = 0, l = nodes.length; i < l; ++i)
                if(n = nodes[i], 1 === n.nodeType) return n;
            return null;
        }
    });
}

$(function(){
	imgShift("imgs");

	$(".box li").mouseenter(function(){
		$(this).children("p").animate({
			"height":"200px"
		},500);
		//$(this).children("span").css(
		//	"color","#00B2EE"
		//).css("font-weight",600);
		$(this).children("div:even").animate({
			"width":"100%",
		},500).css("background","#00B2EE");
		$(this).children("div:odd").animate({
			"height":"100%",
		},500).css("background","#00B2EE");
	});
		
	$(".box li").mouseleave(function(){
		$(this).children("p").animate({
			"height":"0px"
		});
		//$(this).children("span").css(
		//	"color","grey"
		//).css("font-weight",400);
		$(this).children("div:even").animate({
			"width":"0%",
		},500).css("background","#00B2EE");
		$(this).children("div:odd").animate({
			"height":"0%",
		},500).css("background","#00B2EE");
	
	});


	//banner
	var bannerSlider = new Slider($('#banner_tabs'), {
		time: 5000,
		delay: 400,
		event: 'hover',
		auto: true,
		mode: 'fade',
		controller: $('#bannerCtrl'),
		activeControllerCls: 'active'
	});
	$('#banner_tabs .flex-prev').click(function() {
		bannerSlider.prev();
	});
	$('#banner_tabs .flex-next').click(function() {
		bannerSlider.next();
	});


	
});



function imgShift(id){
	var parrent = document.getElementById(id);
	var loop = createImgLoop(parrent,180,30,40,2);
	loop();
}

function createImgLoop(p,maxLenght,margin,time,stepPixel){
	var n = p.firstElementChild;
	function loopObj(n,maxLenght,margin,time,stepPixel){
		var node = n;
		var cpNode = n.cloneNode(true);
		var parent = n.parentNode;
		var step = stepPixel;
		var timeout = time;
		var maxL = - maxLenght;
		var marginL = margin;
		var shiftLength = marginL;
		function loop(){
			if (shiftLength > maxL){
				shiftLength -= stepPixel
				node.style.marginLeft = shiftLength + 'px';
				setTimeout(loop,timeout);
			}else{
				tempNode = node;
				node = node.nextElementSibling;
				shiftLength = marginL;
				cpNode.style.marginLeft = marginL + 'px';
				parent.appendChild(cpNode);
				parent.removeChild(tempNode);
				cpNode = node.cloneNode(true);
				setTimeout(loop,timeout);
			}
		}
		return loop;
	}
	o = new loopObj(n,maxLenght,margin,time,stepPixel);
	return o;
}


