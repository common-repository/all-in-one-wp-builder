var ve=ve||{};
(function(ve,$){
    ve.formParse={};
    var formParse=ve.formParse;
    formParse.init=function(){
        if(formParse.running){
            return false;
        }
        //console.log('parsing...');
        formParse.running=true;
        ve.add_filter('update_element',function(params,element){
            formParse.hasUpdate=false;
            if(element.get('id_base')=='ve_form'&&params.html_code){
                formParse.hasUpdate=true;
                formParse.updateForm(element,params.html_code,params);
                delete params.html_code;
            }
            return params;
        });
        ve.add_action('updated_element',function(element){
            if(element.get('id_base')=='ve_form'&&formParse.hasUpdate){
                ve.panel.reloadForm();
            }
        });
    };
    formParse.updateForm=function(form,html,params){
        var startIndex = html.indexOf('<form');
        var endIndex = html.indexOf('</form>') + 7;
        //console.log(html);
        //console.log(html.substring(startIndex, endIndex));
        html = html.substring(startIndex, endIndex);

        var $html=$(html);
        var formInfo=this.getFormInfo($html);
        $.extend(params,formInfo);
        ve.controller.delete_element(ve.getChildren(form),true);
        this.addFormInputs(form,$html);


    };
    formParse.addFormInputs=function(form,$html){
        var inputs=this.getFormInputs($html);
        var editor=new ve.Editor();
        var id_base;
        $.each(inputs,function(i,input){
            id_base='';
            if(input.tag=='input'){
                id_base='ve_form_input';
            }
            if(input.tag=='select'){
                id_base='ve_form_select';
            }
            if(input.tag=='textarea'){
                id_base='ve_form_textarea';
            }
            if(input.tag=='button'){
                id_base='ve_form_button';
            }
            editor.create({id_base:id_base,parent_id:form.get('id'),params:input.attributes});
        });
        editor.render();
        console.log(inputs);
    };
    formParse.getFormInfo=function($form){
        // Get attributes
        var formInfo={
            method:'',
            action:'',
            target:'',
            enctype:'',
            name:'',
            id:'',
            class:''
        };
        var form_new_info=this.getAttribs($form);
        $.extend(formInfo,form_new_info);
        return formInfo;
    };
    formParse.getAttribs=function(t){
        t=$(t);
        var a = {},
            r = t.get(0);
        if (r) {
            r = r.attributes;
            for (var i in r) {
                if(r.hasOwnProperty(i)) {
                    var p = r[i];
                    if (typeof p.nodeValue !== 'undefined') a[p.nodeName] = p.nodeValue;
                }
            }
        }
        return a;
    };
    formParse.getFormInputs=function($form){
        var inputs=[];
        $form.find(':input').each(function(){
            var tag=this.tagName.toLowerCase();
            var attributes=formParse.getAttribs(this);
            attributes.label=$form.find('label[for='+attributes.id+']').text();

            if(tag=='input'&&['submit','reset','button'].indexOf(attributes.type)!=-1){
                tag='button';
            }
            if(tag=='select'){
                attributes.value='';
                $(this).find('option').each(function(){
                    var $o=$(this);
                    var v=$o.attr('value');
                    var t=$o.text();
                    var s=$o.attr('selected')!== undefined;
                    var line=v+'|'+t+'|'+s;
                    attributes.value+=line+"\r\n";

                });
            }
            inputs.push({tag:tag,attributes:attributes});

        });
        return inputs;
    };
    formParse.init();
})(ve,jQuery);