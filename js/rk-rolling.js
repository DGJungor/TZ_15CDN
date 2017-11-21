 /**
  * 翻滚吧，计数器
  * author : Rock Wang
  */
 ;(function($){
    function shift(o,a,b){
        if(a == b){
            return;
        }
        var offset = b * -20;
        $(o).animate({backgroundPositionY:offset})
    }
    function initView(roll,n){
        var kitys = roll.attr("data-kitys");
        var nums = n || roll.attr("data-nums");
        n += '';
        var length = kitys.length;
        var j = 0
        for(var i = 0; i < length; i+=1){
            if(kitys[i] == 'N'){
                var theli = $("<li class='f-format f-num'></li>");
                theli.css("background-position","0px " + nums[j]*(-20) + "px");
                j+= 1;
                roll.append(theli);
            }else if(kitys[i] == 'Y'){
                roll.append($("<li class='f-format f-yi'></li>"));
            }else if(kitys[i] == 'W'){
                roll.append($("<li class='f-format f-wan'></li>"));
            }
        }
    }
    function rolllll(obj,o,n,s){
        var self = $(obj);
        var e = o.e;
        var increase;
        var isRandom;
        var s = s || 1000;
        if(e){
            increase =  parseInt(Math.random()*Math.pow(10,e));
            isRandom = true;
        }else{
            increase =o.increase;
            isRandom = false;
        }
        var oldnums = n || self.attr("data-nums");
        oldnums += '';
        nums = parseInt(oldnums) + parseInt(increase) + '';
        initView(self,oldnums);
        var nObjects = self.children('.f-num');
        function r(objs,oNum,nNum,ins,b){
            oNum += '';
            nNum += '';
            if(nNum.length > oNum.length){
                return;
            }
            for(var i = 0;i <objs.length; i += 1){
                shift(objs[i],oNum[i],nNum[i]);
            }
            oNum = nNum;
            console.log(oNum);
            nNum = parseInt(oNum) + parseInt(ins) + '';
            console.log(nNum)
            if(b){
                ins = parseInt(Math.random()*Math.pow(10,e));
            }
            setTimeout(r,s,objs,oNum,nNum,ins,b);
        }
        r(nObjects,oldnums,nums,increase,isRandom);
    }
    $.fn.extend({
        rollingInTheDeep: function(o,n,s){
            var o = o;
            var n = n;
            var s = s;
            this.each(
                function(){
                    rolllll(this,o,n,s)
                }
                
            )
        }
    });
 })(jQuery);