var ve=ve||{};
(function(ve,$){
    ve.css={};
    var css=ve.css;
    css.init=function(){
        ve.add_action('element_updated',function(element){
           css.buildCustomCss(element);
        });
        ve.add_filter('update_element',function(params){
            if(params&&params.custom_css_class&&!params.custom_css){
                delete params.custom_css_class;
            }
            return params;
        });
    };
    css.buildCustomCss=function(element){
        var custom_css=element.getParam('custom_css');
        var custom_css_class=element.getParam('custom_css_class');
        if(custom_css&&custom_css_class){
            custom_css='.'+custom_css_class+'{'+custom_css+'}';
            try {
                var sass = new Sass();
                sass.compile(custom_css, function (result) {
                    if (result.text) {
                        ve.frame_view.addElementCustomStyle(result.text,custom_css_class);
                    } else {
                        ve.frame_view.addElementCustomStyle(custom_css,custom_css_class);
                    }
                });
            }catch (e){
                ve.frame_view.addElementCustomStyle(custom_css,custom_css_class);
            }
        }

    };
    css.compileCss=function(element){

    };
    css.init();
})(ve,jQuery);