<?php
class VeCore_VeForm extends Ve_Element{
    function __construct(){
        $id_base='ve_form';
        $name='Form';
        $options=array(
            'title'=>'VE Form',
            'description'=>'Form description',
            'icon_class'=>"fa fa-list-alt",
            'container'=>true,
            'container_element'=>true,//can contain element directly
            'lv'=>3,
        );
        parent::__construct($id_base,$name,$options);
    }
    function init(){
        $this->support('CssEditor');
        $this->support('FormParse');
        $this->getVeManager()->getResourceManager()->addCss('el-form',dirname(__FILE__).'/../../view/css/elements/form.css');
    }
    function element($instance,$content=''){
        $instance=shortcode_atts(
            array(
                'action'=>'',
                'method'=>'get',
                'name'=>'',
                'enctype'=>'',
                'target'=>'',
                'class'=>'',
                'id'=>'',
                'show_hidden_input'=>'',
            )
            ,$instance
        );
        $Atts='';
        foreach($instance as $name=>$value){
            $Atts.=$this->html_attr($name,$value);
        }
        if($instance['show_hidden_input']&&ve_element_editing()){
            $this->addClass('ve-show-hidden-inputs');
        }
        printf('<form%s>',$Atts);
        echo do_shortcode($content);
        echo '</form>';
    }
    private function html_attr($name,$value){
        if($name&&$value)
            return sprintf(' %s="%s"',$name,esc_attr($value));
        return '';
    }
    function form($instance,$content=''){
        $instance=shortcode_atts(
            array(
                'action'=>'',
                'method'=>'get',
                'name'=>'',
                'enctype'=>'',
                'target'=>'',
                'class'=>'',
                'id'=>'',
                'show_hidden_input'=>'',
            )
            ,$instance
        );
        $formMethods=array('get'=>'get','post'=>'post');
        $formTargets=array(
            ''=>'Default',
            '_blank'=>'New window or tab'
        );
        $formEnctypes=array(
                ''=>'Default',
                'multipart/form-data'=>'multipart/form-data',
            );

        ?>

        <div class="ve_input_block">
            <label for="<?php $this->field_id('method');?>">Method</label>
            <select class="medium" id="<?php $this->field_id('method');?>" name="<?php $this->field_name('method');?>">
                <?php foreach($formMethods as $o_value=>$o_title){
                    $o_title=ucfirst($o_title);

                    printf('<option value="%s"%s>%s</option>',$o_value,selected($o_value,$instance['method'],false),$o_title);
                }?>
            </select>

        </div>

        <div class="ve_input_block" data-show-if="<?php $this->field_id('method');?>" data-show-value="post">
            <label for="<?php $this->field_id('enctype');?>">Enctype</label>
            <select class="medium" id="<?php $this->field_id('enctype');?>" name="<?php $this->field_name('enctype');?>">
                <?php foreach($formEnctypes as $o_value=>$o_title){
                    $o_title=ucfirst($o_title);
                    printf('<option value="%s"%s>%s</option>',$o_value,selected($o_value,$instance['enctype'],false),$o_title);
                }?>
            </select>
        </div>

        <div class="ve_input_block">
            <label for="<?php $this->field_id('target');?>">Target</label>
            <select class="medium" id="<?php $this->field_id('target');?>" name="<?php $this->field_name('target');?>">
                <?php foreach($formTargets as $o_value=>$o_title){
                    $o_title=ucfirst($o_title);
                    printf('<option value="%s"%s>%s</option>',$o_value,selected($o_value,$instance['target'],false),$o_title);
                }?>
            </select>
        </div>

        <div class="ve_input_block">
            <label for="<?php $this->field_id('action'); ?>"><?php _e('Action:'); ?></label>
            <input class="medium" id="<?php $this->field_id('action'); ?>" name="<?php $this->field_name('action'); ?>" type="text" value="<?php echo esc_attr($instance['action']); ?>" />
        </div>

        <div class="ve_input_block">
            <label for="<?php $this->field_id('id'); ?>"><?php _e('ID:'); ?></label>
            <input class="medium" id="<?php $this->field_id('id'); ?>" name="<?php $this->field_name('id'); ?>" type="text" value="<?php echo esc_attr($instance['id']); ?>" />
        </div>

        <div class="ve_input_block">
            <label for="<?php $this->field_id('name'); ?>"><?php _e('Name:'); ?></label>
            <input class="medium" id="<?php $this->field_id('name'); ?>" name="<?php $this->field_name('name'); ?>" type="text" value="<?php echo esc_attr($instance['name']); ?>" />
        </div>

        <div class="ve_input_block">
            <label for="<?php $this->field_id('show_hidden_input'); ?>"><?php _e('Show Hidden Inputs:'); ?></label>
            <input class="medium" id="<?php $this->field_id('show_hidden_input'); ?>" name="<?php $this->field_name('show_hidden_input'); ?>" type="checkbox" value="1"<?php checked($instance['show_hidden_input']);?>/>
        </div>

        <p><label for="<?php echo $this->get_field_id('class'); ?>"><?php _e('Extra class:'); ?></label>
            <input class="medium" id="<?php echo $this->get_field_id('class'); ?>" name="<?php echo $this->get_field_name('class'); ?>" type="text" value="<?php echo esc_attr($instance['class']); ?>" /></p>
        <?php
    }
}