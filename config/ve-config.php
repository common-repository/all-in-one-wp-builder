<?php

return array(
	'modules'=>array(
		'VeCore',
	),
	'view_manager'=>array(
		'template_map'=> include dirname(__FILE__) .'/template.map.php',
		'template_base_dir'=>dirname(__FILE__).'/../view/templates',
		'template_ext'=>'phtml',
	),
	'resources'=>array(
		'reset'=>array(
			'css'=>array(
				array('reset',dirname(__FILE__).'/../view/css/reset.css'),
			),
		),
		'bootstraps'=>array(
			'css'=>array(
				array('bootstrap',dirname(__FILE__).'/../view/css/bootstrap.min.css'),
				array('bootstrap-theme',dirname(__FILE__).'/../view/css/bootstrap-theme.min.css'),
			),
			'js'=>array(
//	            array('jquery','https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js'),
				array('bootstrap',dirname(__FILE__).'/../view/js/bootstrap.min.js','jquery'),
				array('ve_front',dirname(__FILE__).'/../view/js/ve_front.js',array('jquery','underscore')),

			),
		),
		'icon'=>array(
			'css'=>array(
				array('font-awesome',dirname(__FILE__).'/../view/libraries/font-awesome/css/font-awesome.min.css')
			),
			'eCss'=>array(
				array('font-awesome',dirname(__FILE__).'/../view/libraries/font-awesome/css/font-awesome.min.css')
			),

		),
		'front'=>array(
			'frontJs'=>array(
				//array('front',dirname(__FILE__).'/../view/js/ve_front.js','jquery'),
			),
			'frontCss'=>array(

			)
		),
		'editor'=>array(
			'eCss'=>array(
				//array('bootstrap',dirname(__FILE__).'/../view/css/bootstrap.min.css'),
				//array('bootstrap-theme',dirname(__FILE__).'/../view/css/bootstrap-theme.min.css'),
				array('ve_jquery_ui',dirname(__FILE__).'/../view/libraries/jquery-ui/jquery-ui.css'),
				array('select2',dirname(__FILE__).'/../view/libraries/select2/css/select2.min.css',array(),VE_VERSION),
				array('form_ui',dirname(__FILE__).'/../view/css/editor/form-ui.css'),
				array('editor',dirname(__FILE__).'/../view/css/editor/editor.css'),
//                array('ypure',dirname(__FILE__).'/../view/css/editor/pure.css'),

				array('tooltipster',dirname(__FILE__).'/../view/css/tooltipster.css'),

			),
			'eJs'=>array(
				array('select2',dirname(__FILE__).'/../view/libraries/select2/js/select2.min.js',array(),VE_VERSION),
				array('slimscroll-scroll',dirname(__FILE__).'/../view/libraries/scroller/jquery.slimscroll.min.js',array(),VE_VERSION),
				array('ve_phpjs',dirname(__FILE__).'/../view/libraries/phpjs/phpjs.js',array(),VE_VERSION),
				array('ve_jqueryserializeobject',dirname(__FILE__).'/../view/libraries/jquery.serialize-object.js',array(),VE_VERSION),
				array('sass',dirname(__FILE__).'/../view/libraries/sass/sass.js',array(),true),
				array('tooltipster',dirname(__FILE__).'/../view/js/jquery.tooltipster.min.js','jquery'),
				array('ve_define',dirname(__FILE__).'/../view/js/editor/ve_define.js',
					array(
						'jquery',
						'underscore',
						'backbone',
						'jquery-ui-draggable',
						'jquery-ui-droppable',
						'jquery-ui-dialog',
						'jquery-ui-tabs',
						//'ve_phpjs',
					),VE_VERSION,false),

				array('ve',dirname(__FILE__).'/../view/js/editor/ve.js',array('ve_define'),VE_VERSION,true),
				array('ve_command_controls',dirname(__FILE__).'/../view/js/editor/command_controls.js',array('ve_define'),VE_VERSION,true),
				array('ve_action_and_filter',dirname(__FILE__).'/../view/js/editor/default-actions-filters.js',array('ve_define'),VE_VERSION,true),
				array('ve_elements',dirname(__FILE__).'/../view/js/editor/elements.js',array('ve_define'),VE_VERSION,true),
				array('ve_elements_views',dirname(__FILE__).'/../view/js/editor/elements_views.js',array('ve_define'),VE_VERSION,true),
				array('ve_editor',dirname(__FILE__).'/../view/js/editor/editor.js',array('ve_define'),VE_VERSION,true),
				array('media_editor',dirname(__FILE__).'/../view/js/editor/media-editor.js',array('ve_define'),VE_VERSION,true),
				array('ve_editor_views',dirname(__FILE__).'/../view/js/editor/editor_views.js',array('ve_define'),VE_VERSION,true),
				array('ve_panel_views',dirname(__FILE__).'/../view/js/editor/panel.js',array('ve_define'),VE_VERSION,true),
				array('ve_topbar_views',dirname(__FILE__).'/../view/js/editor/topbar.js',array('ve_define'),VE_VERSION,true),
				array('ve_dialog',dirname(__FILE__).'/../view/js/editor/dialog.js',array('ve_define'),VE_VERSION,true),
				array('ve_custom_css',dirname(__FILE__).'/../view/js/editor/custom_css.js',array('ve_define'),VE_VERSION,true),
				array('ve_load',dirname(__FILE__).'/../view/js/editor/load.js',array('ve_define'),VE_VERSION,true),
				array('editor_ui',dirname(__FILE__).'/../view/js/editor/editor-ui.js',array('ve_define'),VE_VERSION,true),
				array('list_post',dirname(__FILE__).'/../view/js/editor/list-post.js',array('ve_define'),VE_VERSION,true),
			),
			'fCss'=>array(
				array('ve_iframe',dirname(__FILE__).'/../view/css/editor/iframe.css'),
				array('ve_jquery_ui',dirname(__FILE__).'/../view/libraries/jquery-ui/jquery-ui.css'),
				array('ve_menu_context',dirname(__FILE__).'/../view/libraries/context-menu/src/jquery.contextMenu.css'),
				array('font-awesome',"http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"),

			),
			'fJs'=>array(
				array('ve_menu_context',dirname(__FILE__).'/../view/libraries/context-menu/src/jquery.contextMenu.js',array('jquery-ui-position'),VE_VERSION,true),
				array('ve_iframe',dirname(__FILE__).'/../view/js/editor/iframe.js',array(
					'jquery-ui-draggable',
					'jquery-ui-droppable',
					'jquery-ui-sortable',
					'jquery-ui-resizable'),VE_VERSION,true),
			),
		),

		'page'=>array(
			'js'=>array(),
			'css'=>array(
				array('global',dirname(__FILE__).'/../view/css/global.css'),
				array('animate',dirname(__FILE__).'/../view/css/animate.css'),
				array('ve-style',dirname(__FILE__).'/../view/css/style.css'),
			),
			'eCss'=>array(
				array('global',dirname(__FILE__).'/../view/css/global.css'),
				array('animate',dirname(__FILE__).'/../view/css/animate.css'),
			),

		)
	)
);