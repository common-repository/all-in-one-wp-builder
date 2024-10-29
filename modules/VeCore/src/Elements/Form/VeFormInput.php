<?php
class VeCore_VeFormInput extends Ve_Element{
    function __construct(){
        $id_base='ve_form_input';
        $name='Form Input';
        $options=array(
            'title'=>'Form Input',
            'description'=>'Form Input description',
            'icon_class'=>"fa fa-pencil-square-o",
            'container'=>false,
            'has_content'=>false,
            'group'=>'form',
            'defaults'=>array('placeholder'=>'an input'),

        );
        parent::__construct($id_base,$name,$options);
    }
    function element($instance,$content=''){

        $instance=shortcode_atts(
            array(
                'type'=>'text',
                'placeholder'=>'',
                'name'=>'',
                'value'=>'',
                'class'=>'',
                'id'=>'',
                'label'=>'',
                'label_right'=>''
            )
            ,$instance
        );
        $label=$instance['label'];
        if($label&&!$instance['id']){
            $instance['id']='ve-input-'.$instance['type'].'-'.uniqid ();
        }
        $label_right=$instance['label_right'];
        unset($instance['label']);
        unset($instance['label_right']);
        $Atts='';

        foreach($instance as $_name=>$_value){
            $Atts.=$this->html_attr($_name,$_value);
        }
        if($label&&!$label_right){
            printf('<label for="%s">%s</label>',$instance['id'],$label);
        }
        printf('<input%s/>',$Atts);
        if($label&&$label_right){
            printf('<label for="%s">%s</label>',$instance['id'],$label);
        }

    }
    function preview($instance,$content=''){

        if(isset($instance['type'])&&$instance['type']=='hidden'){
            $instance=shortcode_atts(
                array(
                    'name'=>'',
                    'value'=>'',
                )
                ,$instance
            );
            //$this->addClass('');
            printf('<span>Hidden input: %s=%s</span>',$instance['name'],$instance['value']);
        }else{
            $this->element($instance,$content);
        }
    }
    function getEditWrapperClass($instance){
        if(isset($instance['type'])&&$instance['type']=='hidden'){
            return 've-hidden-input';
        }
        return '';
    }
    private function html_attr($name,$value){
        if($name&&$value)
            return sprintf(' %s="%s"',$name,esc_attr($value));
        return '';
    }
    function form($instance,$content=''){
        $instance=shortcode_atts(array(
            'type'=>'text',
            'placeholder'=>'',
            'name'=>'',
            'value'=>'',
            'class'=>'',
            'id'=>'',
            'label'=>'',
            'label_right'=>''
        ),$instance);

        $input_types=array(
            'text'=>'Text',
            'radio'=>'Radio',
            'checkbox'=>'checkbox',
            'hidden'=>'hidden',
        );

        ?>
        <div class="ve_input_block">
            <label for="<?php $this->field_id('type');?>">Type</label>
            <select class="medium" id="<?php $this->field_id('type');?>" name="<?php $this->field_name('type');?>">
                <?php foreach($input_types as $o_value=>$o_title){
                    $o_title=ucfirst($o_title);
                    printf('<option value="%s"%s>%s</option>',$o_value,selected($o_value,$instance['type'],false),$o_title);
                }?>
            </select>
        </div>

        <div class="ve_input_block" data-show-if="<?php $this->field_id('type');?>" data-show-value="hidden" data-compare="!=">
            <label for="<?php $this->field_id('label'); ?>"><?php _e('Label:'); ?></label>
            <input class="medium" id="<?php $this->field_id('label'); ?>" name="<?php $this->field_name('label'); ?>" type="text" value="<?php echo esc_attr($instance['label']); ?>" />
            <label for="<?php $this->field_id('label_right');?>"><input id="<?php $this->field_id('label_right');?>" name="<?php $this->field_name('label_right');?>" value="1" type="checkbox"<?php checked($instance['label_right']);?>> Right</label>
            <script type="text/javascript">
                (function($){
                    var previous_label_right;
                    $('#<?php $this->field_id('type');?>').on('change',function(){
                        var value=$(this).val();
                        if(typeof previous_label_right=='undefined') {
                            if (['radio', 'checkbox'].indexOf(value) !== -1) {
                                $('#<?php $this->field_id('label_right');?>').prop('checked', 'checked');
                            } else {
                                $('#<?php $this->field_id('label_right');?>').prop('checked', false);
                            }
                        }
                    });
                    $('#<?php $this->field_id('label_right');?>').on('click',function(){
                        previous_label_right=$(this).val();
                    });

                })(jQuery);
            </script>
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
        <div class="ve_input_block" data-show-if="<?php $this->field_id('type');?>" data-show-value="text">
            <label for="<?php $this->field_id('placeholder'); ?>"><?php _e('Placeholder:'); ?></label>
            <input class="medium" id="<?php $this->field_id('placeholder'); ?>" name="<?php $this->field_name('placeholder'); ?>" type="text" value="<?php echo esc_attr($instance['placeholder']); ?>" />
        </div>


        <div class="ve_input_block">
            <label for="<?php echo $this->get_field_id('class'); ?>"><?php _e('Extra class:'); ?></label>
            <input class="medium" id="<?php echo $this->get_field_id('class'); ?>" name="<?php echo $this->get_field_name('class'); ?>" type="text" value="<?php echo esc_attr($instance['class']); ?>" />
        </div>

        <?php
    }
}