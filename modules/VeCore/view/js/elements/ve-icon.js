/**
 * Created by luis on 10/1/15.
 */
var ve_front=ve_front||{};

(function(ve_front,$) {
    var VeIcon = VeFront.extend({
        setup: function ($instance) {
            var ve_icon=this;
            $instance.on('click',function(){
                ve_icon.clickEvent($(this));

            });

        },
        clickEvent: function (button) {
            var icon_name=button.data('icon_name');
            var icon_size=button.data('icon_size');
            var icon_color=button.data('icon_color');
            // console.log("begin button");
            // console.log(button);
        },
        start: function(e){

        }

    });
    ve_front.icon = new VeIcon({el: '.ve_el-icon'});

})(ve_front,jQuery);