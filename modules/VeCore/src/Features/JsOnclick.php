<?php
class VeCore_JsOnclick extends Ve_Feature_Abstract{

    function _construct(){
        $this->setTitle('OnClick');
    }
    function init_once(){
        $this->getElement()->enqueue_js('js-onclick',dirname(__FILE__).'/../../view/js/features/js-onclick.js');
        $this->getElement()->ready('if (typeof ve_front !== "undefined"){ve_front.onclick.start();}');
    }

    function update($instance){
        if($instance && !empty($instance['onclick'])) {
            $link = $instance['onclick'];
            $href = $popup = $target = '';
            if ($link == 'post' && $instance['onclick_post']) {
                $href = get_permalink($instance['onclick_post']);
            } elseif ($link == 'custom') {
                $href = $instance['onclick_url'];
            } elseif ($link == 'popup') {
                $popup = $instance['onclick_popup'];
            }
            if(!empty($instance['onclick_target'])){
                $target = $instance['onclick_target'];
            }


            $data = array(
                'link' => $link,
                'href' => $href,
                'popup' => $popup,
                'target' => $target
            );
            foreach ($data as $k => $v) {
                $this->getElement()->attr('data-' . $k, esc_attr($v));
            }
            $this->getElement()->addClass('ve-js-onclick');
        }
    }
    function form($instance){
        $instance=shortcode_atts(array(
            'onclick'=>'',
            'onclick_post'=>'',
            'onclick_popup'=>'',
            'onclick_url'=>'',
            'onclick_target'=>''
        ),$instance);
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
        $link=$instance['onclick'];
        $link_post=$instance['onclick_post'];
        $link_popup=$instance['onclick_popup'];
        $link_custom=esc_attr($instance['onclick_url']);
        $link_target=$instance['onclick_target'];
        ?>
        <div class="ve_input_block">
            <label for="clink">
                Button link:
            </label>
            <select class="medium" id="clink" name="onclick">
                <?php foreach($button_links as $o_value=>$o_title){
                    $o_title=ucfirst($o_title);
                    printf('<option value="%s"%s>%s</option>',$o_value,selected($o_value,$link,false),$o_title);
                }?>
            </select>
        </div>

        <div class="ve_input_block" data-show-if="clink" data-show-value="post">
            <label>Select post or page:</label>
            <select id="clink_post" name="onclick_post">
                <?php
                if($link_post&&$post=get_post($link_post))
                    printf('<option value="%s" selected="selected">%s</option>',$link_post,$post->post_title);?>
            </select>
            <script type="text/javascript">
                jQuery("#clink_post").select2({
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
        <div class="ve_input_block" data-show-if="clink" data-show-value="popup">
            <label>Select popup:</label>
            <select id="clink_popup" name="onclick_popup">
                <?php
                if($link_popup&&$post=get_post($link_popup))
                    printf('<option value="%s" selected="selected">%s</option>',$link_post,$post->post_title);?>
            </select>
            <script type="text/javascript">
                jQuery("#clink_popup").select2({
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
                                type:'<?php echo $this->getElement()->getVeManager()->getPostManager()->post_type_popup;?>'
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
        <div class="ve_input_block" data-show-if="clink" data-show-value="custom">
            <label for="clink_url">Url:</label>
            <input type="text" class="medium" id="clink_url" name="onclick_url" value="<?php echo $link_custom;?>"/>
        </div>
        <div class="ve_input_block" data-show-if="clink" data-show-value='["custom","post"]'>
            <label for="clink_target">Link Target:</label>
            <select class="medium" name="onclick_target" id="clink_target">
                <?php foreach($link_targets as $o_value=>$o_title){

                    printf('<option value="%s"%s>%s</option>',$o_value,selected($o_value,$link_target,false),$o_title);
                }?>
            </select>
        </div>
    <?php
    }

}