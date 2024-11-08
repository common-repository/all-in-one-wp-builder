<?php
class VeCore_VeFormButton extends Ve_Element implements VE_Element_Interface{
	/**
	 * @var VE_Post_Manager
	 */
	var $post_manager;

	/**
	 * @var VE_Popup_Manager
	 */
	var $popup_manager;
	function __construct(){
		$id_base='ve_form_button';
		$name='Form Button';
		$options=array(
			'title'=>'Form Button',
			'description'=>'Button description',
			'icon_class'=>"fa fa-caret-square-o-right",
			'container'=>false,
			'has_content'=>false,
			'group'=>'form',
			'defaults'=>array('value'=>'Click here'),

		);
		parent::__construct($id_base,$name,$options);
	}
	function init(){
		$this->support('CssEditor');
		//$this->post_manager=$this->getVeManager()->getPostManager();
		//$this->popup_manager=$this->getVeManager()->getPopupManager();
		$this->getVeManager()->getResourceManager()->addCss('el-button',dirname(__FILE__).'/../../view/css/elements/buttons.css');
		//$this->enqueue_js('el-button',dirname(__FILE__).'/../../view/js/elements/ve-button.js');
		//$this->ready('ve_front.button.start();');
	}

	function element($instance,$content=''){
		$instance=shortcode_atts(array(
			'icon'=>'',
			'icon_right'=>'',
			'class'=>'',
			'value'=>'',
			'style'=>'',
			'size'=>'',
			'bg_color'=>'#FF6D6B',
			'txt_color'=>'#fff',
			'shape'=>'',
			'link'=>'',
			'link_post'=>'',
			'link_popup'=>'',
			'link_url'=>'',
			'link_target'=>'',
			'align' => ''
		),$instance);
		$this->addClass($instance['class']);
		$btnClass=array('ve-button');
		$style=$instance['style'];
		$size=$instance['size'];
		$bgColor=$instance['bg_color'];
		$txtColor=$instance['txt_color'];
		$shape=$instance['shape'];
		if($style){
			$btnClass[]='ve-button-'.$style;
		}
		if($shape){
			$btnClass[]='ve-button-'.$shape;
		}
		if($size){
			$btnClass[]='ve-button-'.$size;
		}
//        if($color){
//            $btnClass[]='ve-button-'.$color;
//        }
		$btnClass[]=$instance['class'];
		$btnClass=join(' ',$btnClass);
		$link=$instance['link'];
		$href=$popup=$target='';
		if($link=='post'&&$instance['link_post']){
			$href=get_permalink($instance['link_post']);
		}elseif($link=='custom'){
			$href=$instance['link_url'];
		}elseif($link=='popup'){
			$popup=$instance['link_popup'];
		}
		$target=$instance['link_target'];

		$dataAttr=array();

		//Move padding inside
		$paddingNames = array('padding-top','padding-bottom','padding-left','padding-right');
		$paddingAttrs = array();
		foreach($paddingNames as $patt){
			if($padding=$this->css($patt)){

				$paddingAttrs[]=sprintf('%s:%s;',$patt,$padding);
				$this->css($patt,'');
			}
		}
		$paddingAttrs = esc_attr(join(' ',$paddingAttrs));
		$dataAttr=join(' ',$dataAttr);

		$icon='';
		$value_with_icon=$instance['value'];
		if($instance['icon']){
			$icon_class='ve-button-icon fa fa-'.$instance['icon'];
			$icon=sprintf('<i class="%s"></i>',$icon_class);
			if($instance['icon_right']){
				$value_with_icon=$value_with_icon.$icon;
			}else{
				$value_with_icon=$icon.$value_with_icon;
			}

		}
		printf('<button style="%5$s" class="ve_el-button %1$s" value="%2$s" %3$s>%6$s
</button>',$btnClass,$instance['value'],$dataAttr,$instance['align'], $paddingAttrs . '
background-color: '.$bgColor.'; color: '.$txtColor.';',
			$value_with_icon);
		if($popup&&$link=='popup'&&!ve_is_iframe()&&!ve_is_editor()) {
			//echo $this->popup_manager->getPopup($popup,array('open'=>''));
			//$this->popup_manager->popupScript();
		}
	}

	function form($instance,$content=''){
		$instance=shortcode_atts(array(
			'class'=>'',
			'value'=>'',
			'style'=>'',
			'color'=>'',
			'shape'=>'',
			'size'=>'',
			'bg_color'=>'#FF6D6B',
			'txt_color'=>'#ffffff',
			'icon'=>'',
			'icon_right'=>'',
			'link'=>'',
			'link_post'=>'',
			'link_popup'=>'',
			'link_url'=>'',
			'link_target'=>'',
			'align' => ''
		),$instance);

		$button_styles=array(
			''=>'Default',
			'3d'=>'3d',
			'raised'=>'raised',
			'glow'=>'glow',
			'wrap'=>'wrap',
		);
		$button_shapes=array(
			''=>'Default',
			'rounded'=>'rounded',
			'square'=>'square',
			'box'=>'box',
			'circle'=>'circle',

		);

		$button_sizes=array(
			''=>'Default',
			'tiny'=>'tiny',
			'small'=>'small',
			'large'=>'Large',
			'jumbo'=>'Large',
			'giant'=>'giant',
			'block'=>'Full',
		);
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
		$align=array(
			'left'=>'left',
			'right'=>'right',
			'center'=>'center'
		);
		$style=$instance['style'];
		$size=$instance['size'];
		$bgColor=$instance['bg_color'];
		$txtColor=$instance['txt_color'];
		$shape=$instance['shape'];
		$link=$instance['link'];
		$balign=$instance['align'];
		$link_post=$instance['link_post'];
		$link_popup=$instance['link_popup'];
		$link_custom=esc_attr($instance['link_url']);
		$link_target=$instance['link_target'];
		?>
		<div class="ve_input_block">
			<label for="<?php echo $this->get_field_id('value');?>">Text:</label>
			<input type="text" class="medium" value="<?php echo $instance['value'];?>" name="<?php echo $this->get_field_name('value');?>" id="<?php echo $this->get_field_id('value');?>">
		</div>

		<div class="ve_input_block">
			<label for="<?php $this->field_id('icon');?>">Icon:</label>
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
			<label><input name="<?php $this->field_name('icon_right');?>" value="1" type="checkbox"<?php checked($instance['icon_right']);?>> Right</label>
		</div>
		<!---->
		<!--        <div class="ve_input_block">-->
		<!--            <label for="--><?php //$this->field_id('style');?><!--">-->
		<!--                Button Style:-->
		<!--            </label>-->
		<!--            <select class="medium" id="--><?php //$this->field_id('style');?><!--" name="--><?php //$this->field_name('style');?><!--">-->
		<!--                --><?php //foreach($button_styles as $o_value=>$o_title){
//                    $o_title=ucfirst($o_title);
//                    printf('<option value="%s"%s>%s</option>',$o_value,selected($o_value,$style,false),$o_title);
//                }?>
		<!--            </select>-->
		<!--        </div>-->
		<!---->
		<!--        <div class="ve_input_block">-->
		<!--            <label for="--><?php //$this->field_id('shape');?><!--">-->
		<!--                Button Shape:-->
		<!--            </label>-->
		<!--            <select class="medium" id="--><?php //$this->field_id('shape');?><!--" name="--><?php //$this->field_name('shape');?><!--">-->
		<!--                --><?php //foreach($button_shapes as $o_value=>$o_title){
//                    $o_title=ucfirst($o_title);
//                    printf('<option value="%s"%s>%s</option>',$o_value,selected($o_value,$shape,false),$o_title);
//                }?>
		<!--            </select>-->
		<!--        </div>-->

		<div class="ve_input_block">
			<label for="<?php $this->field_id('bg_color');?>">
				Background color:
			</label>
			<div class="ve_col-sm-12 popup-solid-bg">
				<!-- color picker -->
				<div class="color-group">
					<input type="text" name="<?php $this->field_name('bg_color'); ?>" id="<?php $this->field_name('bg_color');?>" value="<?php echo $bgColor; ?>"
					       class="ve_color-control">
				</div>

			</div>
		</div>

		<div class="ve_input_block">
			<label for="<?php $this->field_id('txt_color');?>">
				Text color:
			</label>
			<div class="ve_col-sm-12 popup-solid-bg">
				<!-- color picker -->
				<div class="color-group">
					<input type="text" name="<?php $this->field_name('txt_color'); ?>" value="<?php
					echo ($txtColor);
					?>"
					       class="ve_color-control">
				</div>

			</div>
		</div>

		<div class="ve_input_block">
			<label for="<?php $this->field_id('size');?>">
				Button size:
			</label>
			<select class="medium" id="<?php $this->field_id('size');?>" name="<?php $this->field_name('size');?>">
				<?php foreach($button_sizes as $o_value=>$o_title){
					if ($o_value == 'tiny' || $o_value == 'small')
						continue;
					$o_title=ucfirst($o_title);
					printf('<option value="%s"%s>%s</option>',$o_value,selected($o_value,$size,false),$o_title);
				}?>
			</select>
		</div>
		<!--
        <div class="ve_input_block">
            <label for="<?php $this->field_id('link');?>">
                Button link:
            </label>
            <select class="medium" id="<?php $this->field_id('link');?>" name="<?php $this->field_name('link');?>">
                <?php foreach($button_links as $o_value=>$o_title){
			$o_title=ucfirst($o_title);
			printf('<option value="%s"%s>%s</option>',$o_value,selected($o_value,$link,false),$o_title);
		}?>
            </select>
        </div>

        <div class="ve_input_block" data-show-if="<?php $this->field_id('link');?>" data-show-value="post">
            <label>Select post or page:</label>
            <select id="<?php $this->field_id('link_post');?>" name="<?php $this->field_name('link_post');?>">
                <?php
		if($link_post&&$post=get_post($link_post))
			printf('<option value="%s" selected="selected">%s</option>',$link_post,$post->post_title);?>
            </select>
            <script type="text/javascript">
                jQuery("#<?php $this->field_id('link_post');?>").select2({
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
        <div class="ve_input_block" data-show-if="<?php $this->field_id('link');?>" data-show-value="popup">
            <label>Select popup:</label>
            <select id="<?php $this->field_id('link_popup');?>" name="<?php $this->field_name('link_popup');?>">
                <?php
		if($link_popup&&$post=get_post($link_popup))
			printf('<option value="%s" selected="selected">%s</option>',$link_post,$post->post_title);?>
            </select>
            <script type="text/javascript">
                jQuery("#<?php $this->field_id('link_popup');?>").select2({
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
        <div class="ve_input_block" data-show-if="<?php $this->field_id('link');?>" data-show-value="custom">
            <label for="<?php $this->field_id('link_url');?>">Url:</label>
            <input type="text" class="medium" id="<?php $this->field_id('link_url');?>" name="<?php $this->field_name('link_url');?>" value="<?php echo $link_custom;?>"/>
        </div>
        <div class="ve_input_block" data-show-if="<?php $this->field_id('link');?>" data-show-value='["custom","post"]'>
            <label for="<?php $this->field_id('link_target');?>">Link Target:</label>
            <select class="medium" name="<?php $this->field_name('link_target');?>" id="<?php $this->field_id('link_target');?>">
                <?php foreach($link_targets as $o_value=>$o_title){

			printf('<option value="%s"%s>%s</option>',$o_value,selected($o_value,$link_target,false),$o_title);
		}?>
            </select>
        </div>
        -->



		<p><label for="<?php echo $this->get_field_id('class'); ?>"><?php _e('Extra class:'); ?></label>
			<input class="medium" id="<?php echo $this->get_field_id('class'); ?>" name="<?php echo $this->get_field_name('class'); ?>" type="text" value="<?php echo esc_attr($instance['class']); ?>" /></p>

		<div class="ve_element_preview" style="right: 20px;position: absolute;top: 80px;width: auto;"></div>
		<?php
	}
}
