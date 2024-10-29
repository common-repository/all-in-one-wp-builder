<?php
class VeCore_VeFormSelect extends Ve_Element{
    function __construct(){
        $id_base='ve_form_select';
        $name='Form Select';
        $options=array(
            'title'=>'Form Select',
            'description'=>'Form Input description',
            'icon_class'=>"fa fa-check-square-o",
            'container'=>false,
            'has_content'=>false,
            'group'=>'form',
            'defaults'=>array('placeholder'=>'a button'),

        );
        parent::__construct($id_base,$name,$options);
    }
    function element($instance,$content=''){
        $instance=shortcode_atts(
            array(
                'label'=>'',
                'label_right'=>'',
                'id'=>'',
                'name'=>'',
                'value'=>'',
                'class'=>'',
                'multiple'=>'',
            )
            ,$instance
        );
        $label=$instance['label'];
        $label_right=$instance['label_right'];
        unset($instance['label']);
        unset($instance['label_right']);
        $value=$instance['value'];
        unset($instance['value']);
        $option_lines=explode("\n",$value);
        $option_lines=array_filter($option_lines);
        $values='';
        foreach($option_lines as $line){
            $options=explode('|',$line);
            $o_selected='';
            if(count($options)==3){
                $o_value=$options[0];
                $o_title=$options[1];
                $options[2]=trim($options[2]);
                $o_selected=$options[2]&&$options[2]!='false';
            }elseif(count($options)==2){
                $o_value=$options[0];
                $o_title=$options[1];
            }else{
                $o_title=$o_value=$options[0];
            }
            if($o_selected){
                $o_selected=' selected="selected"';
            }
            $values.=sprintf('<option value="%s"%s>%s</option>',$o_value,$o_selected,$o_title);

        }

        $Atts='';

        foreach($instance as $_name=>$_value){
            $Atts.=$this->html_attr($_name,$_value);
        }
        if($label&&!$label_right){
            printf('<label for="%s">%s</label>',$instance['id'],$label);
        }
        printf('<select%s>%s</select>',$Atts,$values);
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
                'label'=>'',
                'label_right'=>'',
                'id'=>'',
                'name'=>'',
                'value'=>'',
                'class'=>'',
                'multiple'=>'',
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
            <label for="<?php $this->field_id('multiple'); ?>"><?php _e('Multiple:'); ?></label>
            <input type="checkbox" <?php checked($instance['multiple']);?> id="<?php $this->field_id('multiple'); ?>" value="1" name="<?php $this->field_name('multiple');?>">
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
            <label for="<?php $this->field_id('value'); ?>"><?php _e('Values:'); ?></label>
            <textarea class="" id="<?php $this->field_id('value'); ?>" name="<?php $this->field_name('value'); ?>"><?php echo esc_textarea($instance['value']);?></textarea>
            <div class="ve_description">Enter values each line with structure value|title|selected</div>
        </div>
        <div class="ve_input_block">
            <label for="<?php echo $this->get_field_id('class'); ?>"><?php _e('Extra class:'); ?></label>
            <input class="medium" id="<?php echo $this->get_field_id('class'); ?>" name="<?php echo $this->get_field_name('class'); ?>" type="text" value="<?php echo esc_attr($instance['class']); ?>" />
        </div>

        <?php
    }
}