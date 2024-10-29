<?php

/**
 * Created by PhpStorm.
 * User: luis
 * Date: 12/6/15
 * Time: 7:06 AM
 */

class VeCore_OnClickAction extends Ve_Feature_Abstract{

    function _construct(){
        $this->setTitle('On Click');
    }
    function init_once(){
        add_action('wp_print_styles',array($this,'print_css'));
    }
    function print_css(){
        static $printed = false;
        if ( $printed ) {
            return;
        }
        $printed = true;
        $post_id=get_the_ID();
        $custom_css=get_post_meta($post_id,'_ve_element_custom_css',true);
        if($custom_css){
            ?>
            <style type="text/css" id="ve_element_custom_css">
                <?php echo $custom_css;?>
            </style>
            <?php
        }
    }
    function update($instance){
        if(!empty($instance['custom_css'])&&!empty($instance['custom_css_class'])){
            $this->getElement()->addClass($instance['custom_css_class']);
        }
    }
    function form($instance){
        $instance=shortcode_atts(array(
            'link'=>'',
            'link_post'=>'',
            'link_popup'=>'',
            'link_url'=>'',
            'link_target'=>'',
        ),$instance);

        $link=$instance['link'];
        $link_post=$instance['link_post'];
        $link_popup=$instance['link_popup'];
        $link_custom=esc_attr($instance['link_url']);
        $link_target=$instance['link_target'];
        $button_links=array(
            ''=>'None',
            'post'=>'Link to a post',
            'popup'=>'Open popup',
            'custom'=>'Custom Link',
        );
        $link_targets=array(
            ''=>'_self',
            '_blank'=>'_blank',
            '_parent'=>'_parent',
            '_top'=>'_top',
        );

        $button_links=array(
            ''=>'None',
            'post'=>'Link to a post',
            'popup'=>'Open popup',
            'custom'=>'Custom Link',
        );
        ?>


        

        <div class="ve_input_block">
            <label for="<?php $instance['link'];?>">
                Button link:
            </label>
            <select class="medium" id="<?php $instance['link'];?>" name="<?php $instance['link'];?>">
                <?php foreach($button_links as $o_value=>$o_title){
                    $o_title=ucfirst($o_title);
                    printf('<option value="%s"%s>%s</option>',$o_value,selected($o_value,$link,false),$o_title);
                }?>
            </select>
            
        </div>

        <div class="ve_input_block" data-show-if="<?php $instance['link'];?>" data-show-value="post">
            <label>Select post or page:</label>
            <select id="<?php $instance['link_post'];?>" name="<?php $instance['link_post'];?>">
                <?php
                if($link_post&&$post=get_post($link_post))
                    printf('<option value="%s" selected="selected">%s</option>',$link_post,$post->post_title);?>
            </select>
            <script type="text/javascript">
                jQuery("#<?php $instance['link_post'];?>").select2({
                    width:"360",
                    ajax: {
                        url: ajaxurl,
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                q: params.term, // search term
                                page: params.page,
                                action:'ve_suggest',
                                type:'post,page'
                            };
                        },
                        processResults: function (data, page) {
                            // parse the results into the format expected by Select2.
                            // since we are using custom formatting functions we do not need to
                            // alter the remote JSON data
                            return {
                                results: data
                            };
                        },
                        cache: true
                    },
                    minimumInputLength: 1



                });
            </script>
        </div>
        <div class="ve_input_block" data-show-if="<?php $instance['link'];?>" data-show-value="popup">
            <label>Select popup:</label>
            <select id="<?php $instance['link_popup'];?>" name="<?php $instance['link_popup'];?>">
                <?php
                if($link_popup&&$post=get_post($link_popup))
                    printf('<option value="%s" selected="selected">%s</option>',$link_post,$post->post_title);?>
            </select>
            <script type="text/javascript">
                jQuery("#<?php $instance['link_popup'];?>").select2({
                    width:"360",
                    ajax: {
                        url: ajaxurl,
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                q: params.term, // search term
                                page: params.page,
                                action:'ve_suggest',
                                type:'<?php echo $this->post_manager->post_type_popup;?>'
                            };
                        },
                        processResults: function (data, page) {
                            // parse the results into the format expected by Select2.
                            // since we are using custom formatting functions we do not need to
                            // alter the remote JSON data
                            return {
                                results: data
                            };
                        },
                        cache: true
                    },
                    minimumInputLength: 1



                });
            </script>
        </div>
        <div class="ve_input_block" data-show-if="<?php $instance['link'];?>" data-show-value="custom">
            <label for="<?php $instance['link_url'];?>">Url:</label>
            <input type="text" class="medium" id="<?php $instance['link_url'];?>" name="<?php $instance['link_url'];?>" value="<?php echo $link_custom;?>"/>
        </div>
        <div class="ve_input_block" data-show-if="<?php $instance['link'];?>" data-show-value='["custom","post"]'>
            <label for="<?php $instance['link_target'];?>">Link Target:</label>
            <select class="medium" name="<?php $instance['link_target'];?>" id="<?php $instance['link_target'];?>">
                <?php foreach($link_targets as $o_value=>$o_title){

                    printf('<option value="%s"%s>%s</option>',$o_value,selected($o_value,$link_target,false),$o_title);
                }?>
            </select>
        </div>

        <?php
    }
    function generate_class_name(){
        return 've_custom_'.time();
    }
}