<?php
class VeCore_VeUnOrderList extends Ve_Element implements VE_Element_Interface{
    function __construct(){
        $id_base='ve_ul';
        $name='Unordered list';
        $options=array(
            'title'=>'Order list Block',
            'description'=>'Row description',
            'icon_class'=>'fa fa-list',
            'container'=>false,
            'has_content'=>true,
            'defaults'=>array('content'=>"item 1\nitem 2"),

        );
        parent::__construct($id_base,$name,$options);
        $this->enablePreview();
    }
    function element($instance,$content=''){
        $instance=wp_parse_args($instance,array('class'=>''));


        printf('<ul style="list-style-type: none;" class="%s">',$instance['class']);
        $items = explode("\n", $content);
        $items = array_filter(array_map('trim',$items));
        $size = $instance['icon_size'] > 0 ? $instance['icon_size'] : 12;
        $icon = isset($instance['icon']) ? $instance['icon'] : 'check';
        foreach($items as $item){
            printf('<li><i style="font-size: '.$size.'pt;color:'.$instance['icon_color'].';" class="fa fa-'.$icon.'"></i> %s</li>',strip_tags($item, "<a><em><strong><b><font><h3><h2><h1><span><em><i>"));
        }
        echo '</ul>';
    }
    function form($instance,$content=''){
        $instance=wp_parse_args($instance,array('class'=>''));

        wp_editor($content,$this->get_field_id('content'),array(
            'textarea_name'=>$this->get_field_name('content'),
            'editor_class'=>'ve-html-editor',
            'textarea_rows'=>5,
        ));
        ?>
        <br>
        <div class="ve_col-xs-12">

            <div class="ve_col-xs-4">
                <label for="<?php echo $this->get_field_id('icon'); ?>"><?php _e('Icon: '); ?></label>
                <select id="<?php $this->field_id('icon');?>" name="<?php $this->field_name('icon');?>">
                    <?php $icons=get_awesome_icon_list();
                    $icons=$icons['filters'];
                    foreach($icons as $icon=>$filter){
                        ?>
                        <option value="<?php echo $icon;?>"<?php selected($icon,$instance['icon']);?>><?php echo $icon;?></option>
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
                    $("#<?php $this->field_id('icon');?>").select2({
                        width:120,
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

            <div class="ve_col-xs-4">
                <label for="<?php echo $this->get_field_id('icon_color'); ?>"><?php _e('Icon color: '); ?></label>
                <div class="color-group">
                    <div class="color-group"><input  id="<?php $this->field_id('icon_color') ?>" type="text" name="icon_color" value="<?php echo $instance['icon_color'] ?>" class="ve_color-control"></div>
                </div>
            </div>

            <div class="ve_col-xs-4">
                <label for="<?php echo $this->get_field_id('icon_size'); ?>"><?php _e('Icon size(pt): '); ?></label>
                <input type="number" name="icon_size" style="max-width: 100%;" value="<?php echo $instance['icon_size']; ?>" />
            </div>
            <div class="ve_col-xs-6">
                <label for="<?php echo $this->get_field_id('class'); ?>"><?php _e('Extra class:'); ?></label>
                <input class="" id="<?php echo $this->get_field_id('class'); ?>" name="<?php echo $this->get_field_name('class'); ?>" type="text" value="<?php echo esc_attr($instance['class']); ?>" />
            </div>
        </div>
        <?php
    }
}