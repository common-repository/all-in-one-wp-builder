<?php
class VeCore_VeFacebookComment extends Ve_Element implements VE_Element_Interface
{
    function __construct()
    {
        $id_base = 've_facebook_comment';
        $name = 'FB comment';
        $options = array(
            'title' => 'FB comment',
            'description' => 'icon description',
            'icon_class' => 'fa fa-facebook-square',
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
	        'comment_url' => '',
	        'comment_width' => '',
	        'comment_count'=>'',

        ), $instance );
        $url=$instance['comment_url'] == "" ? "http://allinonewpbuilder.com/" : $instance['icon_name'];
        $width=$instance['comment_width'] == "" ? "100%" : $instance['comment_width'];
        $count=$instance['comment_count'];

//<div class="fb-comments" data-href="http://google.com/" data-width="900" data-numposts="5"></div>
	    echo '<div data-width="'.$width.'" class="fb-comments" data-href="'.$url.'" data-numposts="'.$count.'"></div>';
//        echo '<i class="fa fa-'.$icon.'" style="color: '.$color.'; font-size: '.$size.'pt; max-width: 100% !important;"></i>';

    }
    function form($instance){
        $instance=shortcode_atts( array(
            'comment_url' => '',
            'comment_width' => '',
            'comment_count'=>'',
        ), $instance );

        ?>
        <div class="ve_col-xs-6">
            <div class="ve_col-xs-12">
                <label for="<?php echo $this->get_field_id('comment_url'); ?>"><?php _e('Comment URL: '); ?></label>
                <input type="text" id="<?php $this->field_id('comment_url');?>" name="<?php $this->field_name('comment_url');?>" />

            </div>

            <div class="ve_col-xs-12">
                <label for="<?php echo $this->get_field_id('comment_width'); ?>"><?php _e('Comment box width: '); ?></label>
	            <input type="text" id="<?php $this->field_id('comment_width');?>" name="<?php $this->field_name('comment_width');?>" />
            </div>

            <div class="ve_col-xs-12">
                <label for="<?php echo $this->get_field_id('comment_count'); ?>"><?php _e('Number of comments: '); ?></label>
	            <input type="number" id="<?php $this->field_id('comment_count');?>" name="<?php $this->field_name('comment_count');?>" />
            </div>


        </div>
<!--        <div class="ve_col-xs-6">
<!--            --><?php //echo '<i class="fa fa-'.$instance['icon_name'].'" style="color:'.$instance['icon_color'].' ; font-size:'.$instance['icon_size'].'pt;"></i>' ?>
<!--        </div>-->


<?php

    }
}
