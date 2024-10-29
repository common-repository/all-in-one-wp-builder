<?php
/**
 * @var $this VE_Loader
 */
class _VeCore_VeFormElements{
    var $formElementDir;
    var $elementList=array(
        'VeFormInput',
        'VeFormSelect',
        'VeFormTextArea',
        'VeFormButton',
    );
    /**
     * @var Ve_Loader
     */
    var $loader;
    function __construct(VE_Loader $loader){
        $this->loader=$loader;
        $this->formElementDir=dirname(__FILE__).'/Form';
        $this->init();
    }
    function init(){
        $this->loadFiles();
        add_filter('ve_elements',array($this,'addElements'));
    }
    function loadFiles(){
        foreach($this->elementList as $formElement) {
            $file_to_load=$this->formElementDir.'/'.$formElement.'.php';
            $this->loader->load_file($file_to_load);
        }
    }
    function addElements($elements){
        $core_elements=$elements['VeCore'];
        $form_position=array_search('VeFormElements',$core_elements,true);
        if($form_position!==false){
            array_splice($core_elements,$form_position,1,$this->elementList);
            $elements['VeCore']=$core_elements;

        }

        return $elements;
    }
}

new _VeCore_VeFormElements($this);
