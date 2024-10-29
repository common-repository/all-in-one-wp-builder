/**
 * Created by Alt on 5/3/2015.
 */
var ve_front=ve_front||{};

(function(ve_front,$) {
    var VeJsOnclick = VeFront.extend({
        setup: function ($instance) {
            var ve_jsonclick=this;
            $instance.on('click',function(){
              ve_jsonclick.clickEvent($(this));
            });

        },
        clickEvent: function (element) {
            var link=element.data('link');
            var href=element.data('href');
            var target=element.data('target')||'_self';
            var popup=element.data('popup');
            if(!link){
                return ;
            }

            if(link=='popup'){
                popup&&ve_popup&&ve_popup.open(popup);
            }else{
                if(href){
                    var allow_open=true;
                    if(this.isIframe()){
                        if(target!='_blank'){
                            allow_open=false;
                        }
                    }

                    allow_open&&window.open(href,target);
                }
            }
        }

    });
    ve_front.onclick = new VeJsOnclick({el: '.ve-js-onclick'});
})(ve_front,jQuery);
