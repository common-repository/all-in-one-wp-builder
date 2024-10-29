var ve_popup=ve_popup||{};
(function(popup,$){
    popup.init=function(){
        popup.setSelector();
        popup.setVars();
        popup.setEvents();
    };

    popup.setVars=function(){
        popup.$currentPopup=false;
        var ve_storage=$.initNamespaceStorage('vepu');
        popup.data= ve_storage.localStorage;
    };
    popup.setSelector=function(){
        popup.$popup=$('.ve-popup');
    };
    popup.setEvents=function(){
        popup.setStyles();
        popup.setOpen();
        $('body').on('click','.close-popup',function(e){
            e.preventDefault();
            var the_popup=$(this).closest('.ve-popup');
            popup.close(the_popup);
            return false;
        });
        $(window).on('resize',function(){
            console.log('resize');
            popup.setStyle(popup.$currentPopup);
            popup.adjustStyle(popup.$currentPopup);
        });
        popup.setDone();
    };
    popup.setOpen=function(){
        popup.$popup.each(function() {
            var $popup = $(this),
                data = $popup.data('popup');
            if(data.open){
                switch (data.open){
                    case 'open_on_mouse_out':
                        $(document).on('mouseleave',function(){popup.open_once($popup);});
                        break;
                    case 'open_with_delay':
                        var delay=parseInt(data.delay)*1000;
                        setTimeout(function(){popup.open_once($popup)},delay);
                        break;
                }
            }
        }
        );
    };
    popup.setDone=function(){
        $(document).on('click','.ve-popup-done',function(e){
            var $popup=$(this).closest('.ve-popup');
            var popup_id=$popup.data('popup-id');
            if(popup_id){
                popup.data.set('popup_'+popup_id+'_done',true);
            }

        });
    };
    popup.isDone=function(selector){
        if(!isNaN(selector)){//is number
            selector='#ve-popup-'+selector;
        }
        var $popup = $(selector);
        var popup_id=$popup.data('popup-id');
        return popup.data.get('popup_'+popup_id+'_done');
    };
    popup.setStyles=function(){
        popup.$popup.each(function(){
            popup.setStyle($(this));
        });
    };
    popup.setStyle=function($popup){
        if(!$popup){
          return;
        }
        var data=$popup.data('popup');

        if(!data){
            return ;
        }

        var offset={top:'',left:'',right:'',bottom:''};
        var margin={top:'',left:'',right:'',bottom:''};

        if(data.offset&&data.appearance!='center'){
            if(data.offset.top!==''){
                offset.top=data.offset.top;
            }
            if(data.offset.left!==''){
                offset.left=data.offset.left;
            }
            if(data.offset.right!==''){
                offset.right=data.offset.right;
            }
            if(data.offset.bottom!==''){
                offset.bottom=data.offset.bottom;
            }
        }

        $.each(margin,function(k,v){
            if(v!=='') {
                $popup.css('margin-' + k, v);
            }
        });
        if(data.size){
            if(data.size.width) {
                var use_full_witdh=false;
                if(!data.size.originWidth){
                    data.size.originWidth=data.size.width;
                }
                if($(window).width()<data.size.originWidth){
                    use_full_witdh=true;
                }
                if(data.size.width=='100%'||data.size.originWidth=='100%'||use_full_witdh){
                    data.size.width=$(window).width()+'px';
                    $popup.data('popup',data);
                    $popup.css('width',data.size.width);
                    $popup.css('max-width', data.size.width + 'px');
                }else {
                    $popup.css('max-width', data.size.width + 'px');
                }
            }
            data.size.height&&$popup.css('max-height',data.size.height);
        }
        $popup.addClass('ve_popup_' + data.position);
        popup.setBorderRadius($popup);
    };
    popup.setBorderRadius=function($popup){
        var rows=$popup.find('.ve_row'),
            wrapper=$popup.find('.ve-popup-wrapper'),
        $firstRow=rows.first(),
        $lastRow=rows.last();

        var top_left=$firstRow.css('border-top-left-radius'),
            top_right=$firstRow.css('border-top-right-radius'),
            bottom_left=$lastRow.css('border-bottom-left-radius'),
            bottom_right=$lastRow.css('border-bottom-right-radius');
        top_left&&wrapper.css('border-top-left-radius',top_left);
        top_right&&wrapper.css('border-top-right-radius',top_right);
        bottom_left&&wrapper.css('border-bottom-left-radius',bottom_left);
        bottom_right&&wrapper.css('border-bottom-right-radius',bottom_right);

    };


    popup.adjustStyle=function($popup){
        if(!$popup){
            return;
        }
        var data=$popup.data('popup'),
            width=parseInt(data.size.width)||$popup.outerWidth();

        if(!data){
            return ;
        }
        if(data.position == 'center') {
            $popup.css('margin-left', -width/ 2 + 'px');
            $popup.css('margin-top', -parseInt($popup.outerHeight()) / 2 + 'px');
        }
        if(data.position == 'center-top'||data.position=='center-bottom'){
            $popup.css('margin-left', -width/ 2 + 'px');
        }
        if(data.offset)
        {
            if(data.offset.top != "")
                $popup.css('margin-top', "+="  +parseInt(data.offset.top));
            if(data.offset.right != "")
                $popup.css('margin-right', "+="  +parseInt(data.offset.right)+ '');
            if(data.offset.left != "")
                $popup.css('margin-left', "+="  +parseInt(data.offset.left)+ '');
            if(data.offset.bottom != "")
                $popup.css('margin-bottom', "+="  +parseInt(data.offset.bottom)+ '');
        }
    };
    popup.open_once=function(selector){
        if(popup.showing)
            return false;
        var $the_popup=$(selector);
        if(!$the_popup.data('opened')){
            popup.open(selector);
        }
    };
    popup.open=function(selector,extraData){
        if(popup.showing)
            return false;
        if(!isNaN(selector)){//is number
            selector='#ve-popup-'+selector;
        }
        var $popup = $(selector);
        if($popup.length<1){
            console.error('could not open popup: '+selector);
            return false;
        }
        if(popup.isDone(selector)){//popup done, don't open again
            return false;
        }
        extraData=extraData||{};
        var data=$popup.data('popup'),
            popup_id=$popup.data('popup-id');
        if(extraData){
            _.extend(data,extraData);
        }
        if(data.inactive){
            var last_open=popup.data.get('last_open_'+popup_id);
            var inactive=data.inactive*86400000;
            var inactive_time=last_open+inactive-Date.now();
            if(inactive_time>0){
                console.info('popup is inactive!'+inactive_time);
                return false;
            }
        }
        this.setStyle($popup);
        popup.close();//close all other popup

        $popup.removeClass('ve-hide').data('opened',true).show();
        if(data.animation){
            var $animationPart=$popup.find('.ve-popup-wrapper');
            var animationClass='veani-'+data.animation+' veani-animated';
            $animationPart.addClass(animationClass).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
                $(this).removeClass(animationClass);
            });
        }
        popup.showing = true;
        popup.$currentPopup=$popup;
        popup.adjustStyle($popup);
        if(popup_id){
            popup.data.set('last_open_'+$popup.data('popup-id'),Date.now());
        }


    };

    popup.close=function(){
        popup.showing = false;
        popup.$popup.hide();
        popup.$currentPopup=false;
    };
    popup.init();
})(ve_popup,jQuery);