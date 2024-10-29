<?php
class VeCore_VeIcon extends Ve_Element implements VE_Element_Interface
{
    function __construct()
    {
        $id_base = 've_icon';
        $name = 'Icon';
        $options = array(
            'title' => 'Icon',
            'description' => 'icon description',
            'icon_class' => 'fa fa-heartbeat',
            'container' => false,
            'has_content' => false,
            'defaults' => array(),

        );
        parent::__construct($id_base, $name, $options);
    }
    function init(){
//        $this->ready('ve_front.icon.start();');
        $this->support('CssEditor');
    }
    function element($instance,$content=''){
        $instance=shortcode_atts( array(
            'icon_name' => '',
            'icon_size' => '',
            'icon_color'=>'',

        ), $instance );
        $icon=$instance['icon_name'] == "" ? "heartbeat" : $instance['icon_name'];
        $size=$instance['icon_size'] == "" ? 20 : $instance['icon_size'];
        $color=$instance['icon_color'];

        echo '<i class="fa fa-'.$icon.'" style="color: '.$color.'; font-size: '.$size.'pt; max-width: 100% !important;"></i>';

    }
    function form($instance){
        $instance=shortcode_atts( array(
            'icon_name' => '',
            'icon_size' => '',
            'icon_color'=>'',
        ), $instance );

        ?>
        <div class="ve_col-xs-6">
            <div class="ve_col-xs-12">
                <label for="<?php echo $this->get_field_id('icon_name'); ?>"><?php _e('Icon: '); ?></label>
                <select id="<?php $this->field_id('icon_name');?>" name="<?php $this->field_name('icon_name');?>">
                    <?php $icons=get_awesome_icon_list();
                    $icons=$icons['filters'];
                    foreach($icons as $icon=>$filter){
                        ?>
                        <option value="<?php echo $icon;?>"<?php selected($icon,$instance['icon_name']);?>><?php echo $icon;?></option>
                        <?php
                    }
                    ?>

                </select>
            </div>

            <script type="application/javascript">
                (function($) {
                    var icons=<?php echo json_encode($icons);?>;
                    var last_search;
                    var matched=[];
                    var formatState=function (state) {
                        if (!state.id) {
                            return state.text;
                        }
                        var $state = $(
                            '<span><i class="fa fa-' + state.element.value.toLowerCase() + '"></i> ' + state.text + '</span>'
                        );
                        return $state;
                    };
                    $("#<?php $this->field_id('icon_name');?>").select2({

                        matcher: function (params, data) {
                            // If there are no search terms, return all of the data
                            if ($.trim(params.term) === '') {
                                return data;
                            }

                            // `params.term` should be the term that is used for searching
                            // `data.text` is the text that is displayed for the data object

                            if(params.term!=last_search) {//new search
                                matched=[];
                                $.each(icons, function (icon, filter) {
                                    if (filter.indexOf(params.term) > -1) {
                                        matched.push(icon);
                                    }
                                });
                                last_search=params.term;
                            }
                            if(matched.indexOf(data.text)>-1){
                                return data;
                            }


                            // Return `null` if the term should not be displayed
                            return null;
                        },
                        templateResult: formatState,
                        allowClear: true,
                        placeholder: "Select an icon",
                        templateSelection: formatState
                    });
                })(jQuery);
            </script>

            <div class="ve_col-xs-12">
                <label for="<?php echo $this->get_field_id('icon_color'); ?>"><?php _e('Icon color: '); ?></label>
                <div class="color-group">
                    <div class="color-group"><input  id="<?php $this->field_id('icon_color') ?>" type="text" name="icon_color" value="<?php echo $instance['icon_color'] ?>" class="ve_color-control"></div>
                </div>
            </div>

            <div class="ve_col-xs-12">
                <label for="<?php echo $this->get_field_id('icon_size'); ?>"><?php _e('Icon size(pt): '); ?></label>
                <input type="number" name="icon_size" style="max-width: 100%;" value="<?php echo $instance['icon_size']; ?>" />
            </div>

            <div class="ve_col-xs-12">
                <label for="<?php echo $this->get_field_id('class'); ?>"><?php _e('Extra class:'); ?></label>
                <input class="" id="<?php echo $this->get_field_id('class'); ?>" name="<?php echo $this->get_field_name('class'); ?>" type="text" value="<?php echo esc_attr($instance['class']); ?>" />
            </div>

        </div>
<!--        <div class="ve_col-xs-6">
<!--            --><?php //echo '<i class="fa fa-'.$instance['icon_name'].'" style="color:'.$instance['icon_color'].' ; font-size:'.$instance['icon_size'].'pt;"></i>' ?>
<!--        </div>-->


<?php

    }
}
