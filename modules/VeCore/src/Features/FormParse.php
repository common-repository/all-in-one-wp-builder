<?php
class VeCore_FormParse extends Ve_Feature_Abstract{

    function _construct(){
        $this->setTitle('HTML Code');
    }
    function init_once(){
        $resource=$this->getElement()->getVeManager()->getResourceManager();
        $this->enqueue_script('form-parse',ve_resource_url( dirname(__FILE__).'/../../view/js/features/form-parse.js' ));
    }
    function update($instance){

    }


    function form($instance) {
        $instance=shortcode_atts(array('form_html_code'=>'', 'html_code'),$instance);
        ?>
        <p class="ve_input_block">
            <label for="<?php echo $this->get_field_id('html_code');?>">Form html</label>
            <textarea name="<?php echo $this->get_field_name('html_code');?>" id="<?php echo $this->get_field_id('html_code');?>" class="" rows="10"></textarea>
        </p>
        <?php
    }

}