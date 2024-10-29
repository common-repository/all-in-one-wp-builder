<?php
class VeCore_VeFormTextArea extends Ve_Element{
    function __construct(){
        $id_base='ve_form_textarea';
        $name='Form Text Area';
        $options=array(
            'title'=>'Form Text Area',
            'description'=>'Form Input description',
            'icon_class'=>"fa fa-newspaper-o",
            'container'=>false,
            'has_content'=>false,
            'group'=>'form',
            'defaults'=>array('placeholder'=>'input text here'),

        );
        parent::__construct($id_base,$name,$options);
    }
    function element($instance,$content=''){
        $instance=shortcode_atts(
            array(
                'id'=>'',
                'name'=>'',
                'value'=>'',
                'class'=>'',
                'rows'=>'',
                'cols'=>'',
                'label'=>'',
                'label_right'=>'',
            )
            ,$instance
        );
        $value=$instance['value'];
        $label=$instance['label'];
        $label_right=$instance['label_right'];
        unset($instance['label']);
        unset($instance['label_right']);
        unset($instance['value']);
        $Atts='';
        foreach($instance as $_name=>$_value){
            $Atts.=$this->html_attr($_name,$_value);
        }
        if($label&&!$label_right){
            printf('<label for="%s">%s</label>',$instance['id'],$label);
        }
        printf('<textarea%s>%s</textarea>',$Atts,esc_textarea($value));
        if($label&&$label_right){
            printf('<label for="%s">%s</label>',$instance['id'],$label);
        }
    }

    private function html_attr($name,$value){
        if($name&&$value)
            return sprintf(' %s="%s"',$name,esc_attr($value));
        return '';
    }

    function form($instance,$content=''){

        $instance=shortcode_atts(
            array(
                'id'=>'',
                'name'=>'',
                'value'=>'',
                'class'=>'',
                'rows'=>'',
                'cols'=>'',
                'label'=>'',
                'label_right'=>'',
            )
            ,$instance
        );

        ?>
        <div class="ve_input_block">
            <label for="<?php $this->field_id('label'); ?>"><?php _e('Label:'); ?></label>
            <input class="medium" id="<?php $this->field_id('label'); ?>" name="<?php $this->field_name('label'); ?>" type="text" value="<?php echo esc_attr($instance['label']); ?>" />
            <label><input name="<?php $this->field_name('label_right');?>" value="1" type="checkbox"<?php checked($instance['label_right']);?>> Right</label>
        </div>
        <div class="ve_input_block">
            <label for="<?php $this->field_id('rows'); ?>"><?php _e('Rows:'); ?></label>
            <input class="small" id="<?php $this->field_id('rows'); ?>" name="<?php $this->field_name('rows'); ?>" type="number" value="<?php echo esc_attr($instance['rows']); ?>" />
        </div>

        <div class="ve_input_block">
            <label for="<?php $this->field_id('cols'); ?>"><?php _e('Cols:'); ?></label>
            <input class="small" id="<?php $this->field_id('cols'); ?>" name="<?php $this->field_name('cols'); ?>" type="number" value="<?php echo esc_attr($instance['cols']); ?>" />
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
            <label for="<?php $this->field_id('value'); ?>"><?php _e('Value:'); ?></label>
            <input class="medium" id="<?php $this->field_id('value'); ?>" name="<?php $this->field_name('value'); ?>" type="text" value="<?php echo esc_attr($instance['value']); ?>" />
        </div>
        <div class="ve_input_block">
            <label for="<?php echo $this->get_field_id('class'); ?>"><?php _e('Extra class:'); ?></label>
            <input class="medium" id="<?php echo $this->get_field_id('class'); ?>" name="<?php echo $this->get_field_name('class'); ?>" type="text" value="<?php echo esc_attr($instance['class']); ?>" />
        </div>

        <?php
    }
}